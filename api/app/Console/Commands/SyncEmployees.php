<?php

namespace App\Console\Commands;

use App\Logic\ApiEmployee;
use App\User;
use Illuminate\Console\Command;

class SyncEmployees extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'sync:employees';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Sync all employees from AFAS.';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $apiEmployees = new ApiEmployee();

        $emails = [];

//        dd($apiEmployees->get());

        foreach ($apiEmployees->get() as $employee) {

            if(empty($employee->{"E-mail_werk"})){
                continue;
            }

            if(in_array($employee->{"E-mail_werk"},$emails)){
                continue;
            }
            else {
                $emails[] = $employee->{"E-mail_werk"};
            }

            $user = User::where('email', $employee->{"E-mail_werk"})->first();

            if(!isset($user)) {
                continue;
            }


            $user->afas_id = $employee->Medewerker;

            $lastname = $employee->Voorvoegsel ? $employee->Voorvoegsel . " " . $employee->Achternaam : $employee->Achternaam;


            $user->name = $employee->Naam;
            $user->first_name = $employee->Voornaam;
            $user->last_name = $lastname;

//            dd($user);
            $user->save();
//            ProcessEmployee::dispatch($employee);
        }
    }
}
