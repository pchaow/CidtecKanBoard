<?php

namespace App\Http\Controllers\Auth;

use App\Soap\AuthenSoapService;
use App\Models\User;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\Request;
use Validator;
use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\RegistersUsers;

class RegisterController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Register Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles the registration of new users as well as their
    | validation and creation. By default this controller uses a trait to
    | provide this functionality without requiring any additional code.
    |
    */

    use RegistersUsers;

    /**
     * Where to redirect users after login / registration.
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
        $this->middleware('guest');
    }

    /**
     * Get a validator for an incoming registration request.
     *
     * @param  array $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function validator(array $data)
    {
        return Validator::make($data, [
            'name' => 'required|max:255',
            'email' => 'required|email|max:255|unique:users',
            'password' => 'required|min:6|confirmed',
        ]);
    }

    protected function validatorUP(array $data)
    {
        return Validator::make($data, [
            'username' => 'required|max:255|unique:users,username',
            'password' => 'required|min:6',
        ]);
    }

    /**
     * Create a new user instance after a valid registration.
     *
     * @param  array $data
     * @return User
     */
    protected function create(array $data)
    {
        return User::create([
            'name' => $data['name'],
            'email' => $data['email'],
            'password' => bcrypt($data['password']),
        ]);
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

        return $user;
    }

    public function registerUP(Request $request)
    {
        $this->validatorUP($request->all())->validate();
        $service = new AuthenSoapService();
        $sid = $service->getSID($request->get('username'), $request->get('password'));

        if ($sid) {
            $studentInfo = $service->getStudentInfo($sid);
            $staffInfo = $service->getStaffInfo($sid);

            $staffInfoProfile = $staffInfo;
            if ($staffInfo->CitizenID) {
                $staffInfoProfile->name = $staffInfo->FirstName_TH . " " . $staffInfo->LastName_TH;
                event(new Registered($user = $this->createUP([
                    "name" => $staffInfoProfile->name,
                    "username" => $request->get('username'),
                    "profiles" => $staffInfoProfile
                ])));

                $this->guard()->login($user);

                return $this->registered($request, $user)
                    ?: redirect($this->redirectPath());
            }
        }

    }
}
