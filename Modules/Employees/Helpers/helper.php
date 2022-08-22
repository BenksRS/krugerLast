<?php

use Illuminate\Support\Facades\Log;

// employees_check_comission
if ( !function_exists('employees_check_comission') ) {
    function employees_check_comission ($id)
    {
        Log::channel('commissions')->info("Start $id");


        Log::channel('commissions')->info("end $id");

    }
}

// comission_workers_rules
if ( !function_exists('comission_workers_rules') ) {
    function comission_workers_rules ($id)
    {


    }
}