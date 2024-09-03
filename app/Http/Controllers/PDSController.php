<?php

namespace App\Http\Controllers;


use Dompdf\Dompdf;
use App\Models\EmpAcc;
use App\Models\Employee;
use App\Models\EmpAddress;
use App\Models\EmpAddress2;
use App\Models\lib_suffix;
use App\Models\lib_sex;
use App\Models\lib_civil_stat;
use App\Models\lib_blood_type;
use App\Models\lib_region;
use App\Models\lib_province;
use App\Models\lib_city;
use App\Models\lib_brgy;
use App\Models\education;
use App\Models\emp_org;
use App\Models\emp_reference;
use App\Models\emp_work;
use App\Models\emp_child;
use App\Models\emp_skills;
use App\Models\emp_father;
use App\Models\emp_mother;
use App\Models\emp_spouse;
use App\Models\EmpFamily;
use App\Models\emp_eligibility;
use App\Models\emp_voluntary;
use App\Models\emp_learning;
use App\Models\emp_recog;
use App\Models\emp_otherinfo;
use App\Models\sssinfo;
use App\Models\pagibiginfo;
use App\Models\gsisinfo;
use App\Models\tininfo;
use App\Models\philhealthinfo;
use Illuminate\Support\Facades\Auth;

class PDSController extends Controller
{
    public function downloadPDS()
    {
        $employee = Employee::where('empid', Auth::user()->empid)->first();
        $emp_acc = EmpAcc::where('empid', Auth::user()->empid)->first();
        $emp_address = EmpAddress::where('emp_count', $employee->emp_count)->first();
        $emp_address2 = EmpAddress::where('emp_count', $employee->emp_count)->first();
        $emp_spouse = emp_spouse::where('emp_count', $employee->emp_count)->first();
        $emp_father = emp_father::where('emp_count', $employee->emp_count)->first();
        $emp_mother = emp_mother::where('emp_count', $employee->emp_count)->first();
        $emp_child = emp_child::where('emp_count', $employee->emp_count)->first();
        $education = education::where('empid', Auth::user()->empid)->first();
        $emp_eligibility = emp_eligibility::where('empid', Auth::user()->empid)->first();
        $emp_work = emp_work::where('empid', Auth::user()->empid)->first();
        $emp_voluntary = emp_voluntary::where('empid', Auth::user()->empid)->first();
        $emp_learning = emp_learning::where('empid', Auth::user()->empid)->first();
        $emp_skills = emp_skills::where('empid', Auth::user()->empid)->first();
        $emp_org = emp_org::where('empid', Auth::user()->empid)->first();
        $emp_recog = emp_recog::where('empid', Auth::user()->empid)->first();
        $emp_otherinfo = emp_otherinfo::where('empid', Auth::user()->empid)->first();
        $emp_reference = emp_reference::where('empid', Auth::user()->empid)->first();

        $profilePicturePath = public_path('storage/uploads/profile-pictures/' . $employee->empid . '_image.png');
        $profilePictureBase64 = file_exists($profilePicturePath) 
            ? 'data:image/png;base64,' . base64_encode(file_get_contents($profilePicturePath))
            : null;

        $profilePicturePath = public_path('storage/uploads/profile-pictures/' . $employee->empid . '_image.png');
        $profilePictureBase64 = file_exists($profilePicturePath) 
            ? 'data:image/png;base64,' . base64_encode(file_get_contents($profilePicturePath))
            : null;

        $suffix = lib_suffix::where('lib1_count', $employee->emp_ext)->first();
        if ($suffix && ($suffix->lib1_suffix === '0' || strtolower($suffix->lib1_suffix) === 'none')) {
            $emp_ext = null;
        } else {
            $emp_ext = $suffix ? $suffix->lib1_suffix : $employee->emp_ext;
        }
        $emp_mname_initial = $employee->emp_mname ? substr($employee->emp_mname, 0, 1) . '.' : '';
        $fullName = $employee->emp_lname . ', ' . $employee->emp_fname . ' ' . $emp_mname_initial . ' ' . $emp_ext;
        $emp_mname_initial = $employee->emp_mname ? substr($employee->emp_mname, 0, 1) . '.' : '';
        $fullName = $employee->emp_lname . ', ' . $employee->emp_fname . ' ' . $emp_mname_initial . ' ' . $emp_ext;

        $sex = lib_sex::where('lib4_count', $employee->emp_sex)->first();
        if ($sex && ($sex->lib4_sex === '0' || strtolower($sex->lib4_sex) === 'none')) {
            $emp_sexes = null;
        } else {
            $emp_sexes = $sex ? $sex->lib4_sex : $employee->emp_sex;
        }

        $civstat = lib_civil_stat::where('lib3_count', $employee->emp_civ_stat)->first();
        if ($civstat && ($civstat->lib3_civil_stat === '0' || strtolower($civstat->lib3_civil_stat) === 'none')) {
            $emp_civstats = null;
            $emp_civstats = null;
        } else {
            $emp_civstats = $civstat ? $civstat->lib3_civil_stat : $employee->emp_civ_stat;
            $emp_civstats = $civstat ? $civstat->lib3_civil_stat : $employee->emp_civ_stat;
        }

        // Fetch the blood type based on the numeric identifier stored in the employee table
        $blood = lib_blood_type::where('lib2_count', $employee->emp_blood)->first(); // Use emp_blood
        // Fetch the blood type based on the numeric identifier stored in the employee table
        $blood = lib_blood_type::where('lib2_count', $employee->emp_blood)->first(); // Use emp_blood

        if ($blood && ($blood->lib2_blood_type === '0' || strtolower($blood->lib2_blood_type) === 'none')) {
            $emp_bloods = null;
        } else {
            $emp_bloods = $blood ? $blood->lib2_blood_type : null; // Only use the blood type if it exists, otherwise set to null
        }


        $brgy = lib_brgy::where('brgy_psgc', $emp_address->emp_brgy)->first();
        if ($brgy && ($brgy->col_brgy === '0' || strtolower($brgy->col_brgy) === 'none')) {
            $emp_brgies = null;
        } else {
            $emp_brgies = $brgy ? $brgy->col_brgy : $employee->emp_address;
        }

        $city = lib_city::where('citmun_psgc', $emp_address->emp_city)->first();
        if ($city && ($city->col_citymuni === '0' || strtolower($city->col_citymuni) === 'none')) {
            $emp_cities = null;
        } else {
            $emp_cities = $city ? $city->col_citymuni : $employee->emp_address;
        }

        $prov = lib_province::where('prv_psgc', $emp_address->emp_prov)->first();
        if ($prov && ($prov->col_province === '0' || strtolower($prov->col_province) === 'none')) {
            $emp_provinces = null;
        } else {
            $emp_provinces = $prov ? $prov->col_province : $employee->emp_address;
        }

        $reg = lib_region::where('reg_psgc', $emp_address->emp_region)->first();
        if ($reg && ($reg->col_region === '0' || strtolower($reg->col_region) === 'none')) {
            $emp_region = null;
        } else {
            $emp_region = $reg ? $reg->col_region : $employee->emp_address;
        }
        $address = $emp_region
        . ', ' .$emp_provinces
        . ', ' .$emp_cities
        . ', ' .$emp_brgies
        . ' ' .$emp_address->emp_house
        . ' ' .$emp_address->emp_subd
        . ', ' .$emp_address->emp_zip;
        
        
        $child_mname_initial = $emp_child->child_mname ? substr($emp_child->child_mname, 0, 1) . '.' : '';
        $fullchildName = $emp_child->child_fname . ' ' . 
                         $child_mname_initial . ' ' . 
                         $emp_child->child_lname . ' ' . 
                         $emp_child->child_xname;
        

        $pdf = new Dompdf();
        $pdf->loadHtml(view('pdf.pds', compact('employee', 'address', 'emp_address2', 'emp_acc', 'fullName', 
        'profilePictureBase64', 'emp_sexes', 'emp_civstats', 'emp_bloods', 'emp_provinces', 'emp_cities', 'emp_brgies',
         'emp_address', 'emp_spouse', 'emp_father', 'emp_mother', 'education', 'emp_eligibility', 'emp_work', 'emp_voluntary',
         'emp_learning', 'emp_otherinfo', 'emp_child', 'child_mname_initial', 'emp_skills', 'emp_org', 'emp_recog', 'emp_reference'))->render());
        $pdf->setPaper('legal', 'portrait');
        $pdf->render();

        return response()->streamDownload(function () use ($pdf) {
            echo $pdf->output();
        }, 'PDS.pdf');

    }
}