<?php

namespace App\Http\Controllers\Company;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request as HttpRequest;
use App\Repo\Contract;
use App\Repo\TeacherRepo;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Request;
use Illuminate\Support\Facades\Validator;
use Laracasts\Flash\Flash;

class CompanyController extends BackendController
{
    public function main(){
        return view('admin.company.main');
    }

    public function logout(){
        Auth::logout();

        Flash::info('您已成功登出');

        return redirect()->route('cpn.login');
    }

    public function editProfile(){

        $company = $this->COMPANY;
        $company_address_info = DB::table('loc_address')->where('address_id', $company->contact_address_id)->first();

        //地址部分
        $city_ids = DB::table('lookup_city')->lists('name', 'city_id');
        $district_ids = DB::table('lookup_district')->select('city_id', 'district_id', 'name')->get();
        $district_ids = collect($district_ids)->groupBy('city_id');

        $company_address_city_id = $company_address_info->city_id;
        $company_address_district_id = $company_address_info->district_id;
        $company_address = $company_address_info->address_1;

        //聯絡人部分
        $company_contact_employee = DB::table('cpn_company_employee')->where('company_employee_id', $company->create_company_employee_id)->first();

        //聯絡電話
        $contact_phone_info = DB::table('loc_phone')->where('phone_id', $company->contact_phone_id)->first();

        $data = compact('company', 'city_ids', 'district_ids', 'company_address_info',
            'company_address_city_id', 'company_address_district_id', 'company_address',
            'company_contact_employee', 'contact_phone_info');

        return view('admin.company.profile', $data);
    }

    public function updateProfile(){

        $request = Request::all();

        $company_name = $request['company_name'];
        $company_address_city_id = $request['company_address_city_id'];
        $company_address_district_id = $request['company_address_district_id'];
        $company_address = $request['company_address'];
        $company_contact_employee_surname = $request['company_contact_employee_surname'];
        $company_contact_employee_first_name = $request['company_contact_employee_first_name'];
        $company_contact_phone_number = $request['company_contact_phone_number'];
//        $description = $request['description'];

        DB::table('cpn_company')->where('company_id', $this->COMPANY->company_id)->update([
            'name' => $company_name,
            'updated_by' => $this->user_identity_info->user_id,
            'updated_at' => date('Y-m-d H:i:s')
        ]);

        DB::table('cpn_company_employee')->where('company_employee_id', $this->COMPANY->create_company_employee_id)->update([
            'surname' => $company_contact_employee_surname,
            'first_name' => $company_contact_employee_first_name,
            'updated_by' => $this->user_identity_info->user_id,
            'updated_at' => date('Y-m-d H:i:s')
        ]);

        $oldAddress = DB::table('loc_address')->where('address_id', $this->COMPANY->contact_address_id)->first();

        //判斷是否有更新地址訊息
        if(self::checkIsAddressUpdated($oldAddress, $company_address_city_id, $company_address_district_id, $company_address)){


            //新增loc address
            $company_city_info = DB::table('lookup_city')->where('city_id', $company_address_city_id)->first();
            $company_district_info = DB::table('lookup_district')->where('district_id', $company_address_district_id)->first();
            $new_contact_address_id = DB::table('loc_address')->insertGetId([
                'address_type_code_abbr' => 'CPN_CONTACT_ADDRESS',
                'city_id' => $company_city_info->city_id,
                'district_id' => $company_district_info->district_id,
                'city_name' => $company_city_info->name,
                'zipcode' => $company_district_info->zipcode,
                'district_name' => $company_district_info->name,
                'address_1' => $company_address,
                'created_by' => -1000,
                'created_at' =>  date('Y-m-d H:i:s'),
                'updated_by' => -1000,
                'updated_at' => date('Y-m-d H:i:s')
            ]);

            DB::table('cpn_company')->where('company_id', $this->COMPANY->company_id)->update([
                'contact_address_id' => $new_contact_address_id,
                'updated_by' => $this->user_identity_info->user_id,
                'updated_at' => date('Y-m-d H:i:s')
            ]);

        }

        $oldPhone = DB::table('loc_phone')->where('phone_id', $this->COMPANY->contact_phone_id)->first();

        //判斷是否有更新聯絡人電話
        if(self::checkIsPhoneUpdated($oldPhone, $company_contact_phone_number)){
            $new_contact_phone_id = DB::table('loc_phone')->insertGetId([
                'phone_type_code_abbr' => 'MOBILE',
                'phone_number' => $company_contact_phone_number,
                'created_by' => -1000,
                'created_at' =>  date('Y-m-d H:i:s'),
                'updated_by' => -1000,
                'updated_at' => date('Y-m-d H:i:s')
            ]);

            DB::table('cpn_company')->where('company_id', $this->COMPANY->company_id)->update([
                'contact_phone_id' => $new_contact_phone_id,
                'updated_by' => $this->user_identity_info->user_id,
                'updated_at' => date('Y-m-d H:i:s')
            ]);
        }

        \Session::flash('success', '更新成功！' );
        return redirect()->back();

    }

    private function checkIsAddressUpdated($oldAddress, $city_id, $district_id, $address){

        if($oldAddress->city_id != $city_id) return true;
        if($oldAddress->district_id != $district_id) return true;
        if(strcmp($oldAddress->address_1, $address) != 0) return true;

        return false;
    }

    private function checkIsPhoneUpdated($oldPhone, $phone_number){

        if($oldPhone->phone_number != $phone_number) return true;

        return false;
    }

}
