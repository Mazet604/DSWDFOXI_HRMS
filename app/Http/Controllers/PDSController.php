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
use Illuminate\Support\Facades\Auth;

class PDSController extends Controller
{
    public function downloadPDS()
    {
        $employee = Employee::where('empid', Auth::user()->empid)->first();
        $emp_acc = EmpAcc::where('empid', Auth::user()->empid)->first();
        $emp_address = EmpAddress::where('emp_count', $employee->emp_count)->first();
        $emp_address2 = EmpAddress::where('emp_count', $employee->emp_count)->first();

        $suffix = lib_suffix::where('lib1_count', $employee->emp_ext)->first();
        if ($suffix && ($suffix->lib1_suffix === '0' || strtolower($suffix->lib1_suffix) === 'none')) {
            $emp_ext = null;
        } else {
            $emp_ext = $suffix ? $suffix->lib1_suffix : $employee->emp_ext;
        }

        $sex = lib_sex::where('lib4_count', $employee->emp_sex)->first();

        if ($sex && ($sex->lib4_sex === '0' || strtolower($sex->lib4_sex) === 'none')) {
            $emp_sexes = null;
        } else {
            $emp_sexes = $sex ? $sex->lib4_sex : $employee->emp_sex;
        }

        $civstat = lib_civil_stat::where('lib3_count', $employee->emp_civ_stat)->first();

        if ($civstat && ($civstat->lib3_civil_stat === '0' || strtolower($civstat->lib3_civil_stat) === 'none')) {
            $emp_civstat = null;
        } else {
            $emp_civstat = $civstat ? $civstat->lib3_civil_stat : $employee->emp_civ_stat;
        }

        $blood = lib_blood_type::where('lib2_count', $employee->emp_blood_type)->first();

        if ($blood && ($blood->lib2_blood_type === '0' || strtolower($blood->lib2_blood_type) === 'none')) {
            $emp_bloods = null;
        } else {
            $emp_bloods = $blood ? $blood->lib2_blood_type : $employee->emp_blood_type;
        }


        $emp_mname_initial = $employee->emp_mname ? substr($employee->emp_mname, 0, 1) . '.' : '';

        $fullName = $employee->emp_lname . ', ' . $employee->emp_fname . ' ' . $emp_mname_initial . ' ' . $emp_ext;

        $profilePicturePath = public_path('storage/uploads/profile-pictures/' . $employee->empid . '_image.png');
        $profilePictureBase64 = file_exists($profilePicturePath) 
            ? 'data:image/png;base64,' . base64_encode(file_get_contents($profilePicturePath))
            : null;

        $pdf = new Dompdf();
        $pdf->loadHtml(view('pdf.pds', compact('employee', 'emp_address', 'emp_address2', 'emp_acc', 'fullName', 'profilePictureBase64', 'emp_sexes', 'emp_civstat', 'emp_bloods'))->render());
        $pdf->setPaper('A4', 'portrait');
        $pdf->render();

        return response()->streamDownload(function () use ($pdf) {
            echo $pdf->output();
        }, 'PDS.pdf');

    }
}

