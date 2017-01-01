<?php
/**
 * Created by PhpStorm.
 * User: chaow
 * Date: 1/1/2017
 * Time: 6:07 PM
 */

namespace App\Soap;


use Artisaninweb\SoapWrapper\Service;
use Artisaninweb\SoapWrapper\SoapWrapper;

class AuthenSoapService
{

    /**
     * @var SoapWrapper
     */
    protected $soapWrapper;

    /**
     * AuthSoapWrapper constructor.
     */
    public function __construct()
    {

        $this->soapWrapper = new SoapWrapper();
        $this->soapWrapper->add("AuthenService", function ($service) {
            $service
                ->wsdl("https://ws.up.ac.th/mobile/AuthenService.asmx?WSDL")
                ->trace(true);
        });

        $this->soapWrapper->add("StaffService", function ($service) {
            $service
                ->wsdl("https://ws.up.ac.th/mobile/StaffService.asmx?WSDL")
                ->trace(true);
        });

        $this->soapWrapper->add("StudentService", function ($service) {
            $service
                ->wsdl("https://ws.up.ac.th/mobile/StudentService.asmx?WSDL")
                ->trace(true);
        });
    }

    public function getSoapWrapper()
    {
        return $this->soapWrapper;
    }

    public function getSID($username, $password)
    {

        $authResult = $this->getSoapWrapper()->call("AuthenService.login",
            [
                'Login' => [
                    'username' => base64_encode($username),
                    'password' => base64_encode($password),
                    'ProductName' => 'decaffair_student',
                ]
            ]
        );
        return $authResult->LoginResult;
    }

    public function getStaffInfo($sid)
    {
        return $this->getSoapWrapper()->call('StaffService.GetStaffInfo', [
            'GetStaffInfo' => [
                'sessionID' => $sid
            ]
        ])->GetStaffInfoResult;
    }

    public function getStudentInfo($sid)
    {
        return $this->getSoapWrapper()->call('StudentService.GetStudentInfo', [
            'GetStudentInfo' => [
                'sessionID' => $sid
            ]
        ])->GetStudentInfoResult;
    }

}