<?php

namespace App\Logic;


use App\Http\Resources\UserAfasApiResource;
use App\User;

class ApiEmployee extends ApiAfas
{
    /**
     * ApiEmployee constructor.
     */
    public function __construct()
    {
        parent::__construct(
            env('AFAS_BASE_URL'),
            env('AFAS_TOKEN_EMPLOYEES')
        );

        $this->prepare(ApiEmployee::class, 'GET', 'QV_Medewerkers_2', 1000, 0);
    }

    /**
     * @param $apiObject
     * @return User
     */
    public function object($apiObject)
    {

        $inDate = str_replace(['T', 'Z'], " ", $apiObject->Indienst_dienstjaren);
        $outDate = isset($apiObject->Datum_uit_dienst) ? str_replace(['T', 'Z'], " ", $apiObject->Datum_uit_dienst) : null;

        $employee = new User();
        $employee->employee_id = $apiObject->Medewerker;
        $employee->name = $apiObject->Naam;
        $employee->email = $apiObject->{'E-mail_werk'};
        $employee->into_service = $inDate;
        $employee->out_service = $outDate;
        $employee->role_id = 2;

        return $employee;
    }
}