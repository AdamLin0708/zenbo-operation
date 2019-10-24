<?php
/**
 * UCARER CONFIDENTIAL
 * Copyright 2015 優護平台股份有限公司 <http://www.ucarer.tw>
 * All Rights Reserved.
 */
namespace App\Repo;

use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Request;

class Contract
{


    public static function getCurrentU2BContract($company_register_flag){

        if($company_register_flag){
            $CURRENT_U2B_CONTRACT_VER = DB::table('sys_parameter')->where('key', 'CURRENT_U2B_REG_CONTRACT_VER')->first();
        } else {
            $CURRENT_U2B_CONTRACT_VER = DB::table('sys_parameter')->where('key', 'CURRENT_U2B_NO_REG_CONTRACT_VER')->first();
        }

        if(is_null($CURRENT_U2B_CONTRACT_VER)){
            return null;
        }

        $contract = self::getU2BContractByVersion($CURRENT_U2B_CONTRACT_VER->value, $company_register_flag);
        if(is_null($contract)){
            return null;
        }
        return $contract;
    }

    public static function getU2BContractByVersion($version, $company_register_flag){

        if($company_register_flag){
            $contract = DB::table('sys_contract_template_u2b')
                ->where('version', $version)
                ->where('u2b_contract_type_code_abbr', 'COMPANY_REGISTER')
                ->select('content', 'version', 'contract_template_u2b_id')->first();
        } else {
            $contract = DB::table('sys_contract_template_u2b')
                ->where('version', $version)
                ->where('u2b_contract_type_code_abbr', 'COMPANY_NO_REGISTER')
                ->select('content', 'version', 'contract_template_u2b_id')->first();
        }


        return $contract;
    }

    public static function getCurrentU2TContract(){
        $CURRENT_U2T_CONTRACT_VER = DB::table('sys_parameter')->where('key', 'CURRENT_U2T_CONTRACT_VER')->first();
        if(is_null($CURRENT_U2T_CONTRACT_VER)){
            return null;
        }

        $contract = self::getU2TContractByVersion($CURRENT_U2T_CONTRACT_VER->value);
        if(is_null($contract)){
            return null;
        }
        return $contract;
    }

    public static function getU2TContractByVersion($version){
        $contract = DB::table('sys_contract_template_u2t')->where('version', $version)
            ->select('content', 'version', 'contract_template_u2t_id')->first();
        return $contract;
    }


}