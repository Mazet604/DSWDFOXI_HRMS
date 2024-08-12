<?php

namespace App\Http\Controllers;

use App\Models\EmpAddress;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\lib_region;
use App\Models\lib_province;
use App\Models\lib_city;
use App\Models\lib_brgy;
use App\Models\Employee;

class AddressController extends Controller
{

    public function getAddress()
    {
        try {
            // Get the currently authenticated user
            $user = Auth::user();
            if (!$user) {
                return response()->json(['error' => 'User not authenticated'], 401);
            }

            // Fetch employee using empid
            $employee = Employee::where('empid', $user->empid)->first();
            if (!$employee) {
                return response()->json(['error' => 'Employee not found'], 404);
            }

            // Fetch the address using emp_count
            $address = EmpAddress::where('emp_count', $employee->emp_count)->first();
            if (!$address) {
                return response()->json(['error' => 'Address not found'], 404);
            }

            // Return the region and province
            return response()->json([
                'zipcode' => $address->emp_zip,
                'block' => $address->emp_house,
                'villsub' => $address->emp_subd,
                'selectedRegion' => $address->emp_region,
                'selectedProvince' => $address->emp_prov,
            ], 200);

        } catch (\Exception $e) {
            return response()->json(['error' => 'An error occurred while fetching the address'], 500);
        }
    }

    public function getSelectedRegionOptions()
    {
        try {
            $selectedRegionOptions = lib_region::all(['psgc as value', 'col_region as label']);
            return response()->json($selectedRegionOptions);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }   

    public function getSelectedProvinceOptions()
    {
        try {
            $selectedProvinceOptions = lib_province::all(['psgc as value', 'col_province as label']);  
            return response()->json($selectedProvinceOptions);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }
}
