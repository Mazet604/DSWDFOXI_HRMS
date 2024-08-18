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
    public function updateAddress(Request $request)
    {
        $user = Auth::user();
        if (!$user) {
            return response()->json(['error' => 'User not authenticated'], 401);
        }

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

            $emp_address->emp_house=$request->input('block');
            $emp_address->emp_subd=$request->input('villsub');
            $emp_address->emp_zip=$request->input('zipcode');

            $emp_address->save();

            return response()->json(['success'=> 'Address updated successfully']);
    }

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
            ], 200);

        } catch (\Exception $e) {
            return response()->json(['error' => 'An error occurred while fetching the address'], 500);
        }
    }

    public function getRegions()
    {
        try {
            $regions = lib_region::all();
            return response()->json($regions, 200);
        } catch (\Exception $e) {
            return response()->json(['error' => 'An error occurred while fetching regions'], 500);
        }
    }

    public function getProvincesByRegion($regionId)
    {
        try {
            $provinces = lib_province::where('reg_psgc', $regionId)->get();
            return response()->json($provinces, 200);
        } catch (\Exception $e) {
            return response()->json(['error' => 'An error occurred while fetching provinces'], 500);
        }
    }
}
