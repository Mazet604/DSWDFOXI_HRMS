<?php

namespace App\Http\Controllers;

use App\Models\EmpAddress;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Response;
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
                'Region' => $address->emp_region,
                'Province' => $address->emp_prov,
                'City' => $address->emp_city,
            ], 200);

        } catch (\Exception $e) {
            return response()->json(['error' => 'An error occurred while fetching the address'], 500);
        }
    }

    public function getRegions()
    {
        $regions = lib_region::get();
        return response()->json($regions);
    }

    public function getProvinces(Request $request)
    {
        $provinces = lib_province::where('reg_psgc', $request->reg_psgc)->get();
        return response()->json($provinces);
    }

    public function getCities(Request $request)
    {
        $cities = lib_city::where('prv_psgc', $request->prv_psgc)->get();
        return response()->json($cities);
    }
}
