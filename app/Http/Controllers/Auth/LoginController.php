<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\Role;
use App\Models\User;
use App\Soap\AuthenSoapService;
use Illuminate\Auth\Events\Registered;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Validator;


class LoginController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles authenticating users for the application and
    | redirecting them to your home screen. The controller uses a trait
    | to conveniently provide its functionality to your applications.
    |
    */

    use AuthenticatesUsers;

    /**
     * Where to redirect users after login.
     *
     * @var string
     */
    protected $redirectTo = '/home';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest', ['except' => 'logout']);
    }

    protected function attemptLoginUsername(Request $request)
    {
        return $this->guard()->attempt(
            [
                'username' => $request->get('email'),
                'password' => $request->get('password')
            ], $request->has('remember')
        );
    }

    public function login(Request $request)
    {
        $this->validateLogin($request);

        // If the class is using the ThrottlesLogins trait, we can automatically throttle
        // the login attempts for this application. We'll key this by the username and
        // the IP address of the client making these requests into this application.
        if ($this->hasTooManyLoginAttempts($request)) {
            $this->fireLockoutEvent($request);
            return $this->sendLockoutResponse($request);
        }

        if ($this->attempLoginUP($request)) {
            return $this->sendLoginResponse($request);
        }

        // If the login attempt was unsuccessful we will increment the number of attempts
        // to login and redirect the user back to the login form. Of course, when this
        // user surpasses their maximum number of attempts they will get locked out.
        $this->incrementLoginAttempts($request);

        return $this->sendFailedLoginResponse($request);
    }

    public function attempLoginUP(Request $request)
    {

        $service = new AuthenSoapService();

        $login = $request->all();
        $username = $login['email'];
        $password = $login['password'];

        $sid = $service->getSID($username, $password);

        if ($sid == "") {
            return false;
        } else {
            $staffInfoResult = $service->getStaffInfo($sid);
            $studentInfoResult = $service->getStudentInfo($sid);

            $service->getLogOff($sid);

            if ($staffInfoResult->CitizenID) {
                $user = User::where('username', '=', $username)->first();
                if ($user) {
                    Auth::login($user);
                    return true;
                } else {

                    return $this->registerUP($request, $username, $password);
                }
            }


            if ($studentInfoResult->CitizenID) {
                $user = User::where('username', '=', $username)->first();
                if ($user) {
                    Auth::login($user);
                    return true;
                } else {

                    return $this->registerUP($request, $username, $password);
                }
            }
        }
        return false;
    }

    protected function createUP(array $data)
    {
        $user = User::create([
            'name' => $data['name'],
            'username' => $data['username'],
            'email' => $data['username'] . '@up.ac.th',
        ]);
        $user->profiles = json_encode([
                "UP" => $data['profiles']
            ]
        );
        $user->save();

        $userRole = Role::where('name', '=', 'user')->first();
        $user->attachRole($userRole);

        return $user;
    }

    public function registerUP(Request $request, $username, $password)
    {
        $service = new AuthenSoapService();
        $sid = $service->getSID($username, $password);

        if ($sid) {
            $studentInfo = $service->getStudentInfo($sid);
            $staffInfo = $service->getStaffInfo($sid);

            if ($staffInfo->CitizenID) {
                $staffInfo->name = $staffInfo->FirstName_TH . " " . $staffInfo->LastName_TH;
                $user = $this->createUP([
                    "name" => $staffInfo->name,
                    "username" => $username,
                    "profiles" => $staffInfo
                ]);
                event(new Registered($user));

                Auth::login($user);


                $service->getLogOff($sid);
                return true;

            } else if ($studentInfo->CitizenID) {

                $studentInfo->name = $studentInfo->FirstName_TH . " " . $studentInfo->LastName_TH;
                $user = $this->createUP([
                    "name" => $studentInfo->name,
                    "username" => $username,
                    "profiles" => $staffInfo
                ]);
                event(new Registered($user));

                Auth::login($user);

                $service->getLogOff($sid);

                return true;
            }
        }
        return false;
    }


}
