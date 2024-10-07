<?php

namespace App\Http\Controllers;


use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Response;
use App\Models\EmpAddress;
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
                'Barangay' => $address->emp_brgy,
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
        $provinces = lib_province::where('reg_psgc', $request->reg_psgc)
                                ->orderBy('col_province', 'asc')
                                ->get();
        return response()->json($provinces);
    }
    
    public function getCities(Request $request)
    {
        $cities = lib_city::where('prv_psgc', $request->prv_psgc)
                            ->orderBy('col_citymuni', 'asc')
                            ->get();
        return response()->json($cities);
    }
    
    public function getBarangays(Request $request)
    {
        $barangays = lib_brgy::where('citmun_psgc', $request->citmun_psgc)
                                ->orderBy('col_brgy', 'asc')
                                ->get();
        return response()->json($barangays);
    }

    public function getAllCities()
    {
        $cities = lib_city::all();
        return response()->json($cities);
    }

    public function updateAddress()
    {

        try {
            $user = Auth::user(); // Get the currently authenticated user
            if (!$user) {
                return response()->json(['error' => 'User not authenticated'], 401);
            }

            $employee = Employee::where('empid', $user->empid)->first(); // Fetch employee using empid
            $emp_acc = EmpAcc::where('empid', $user->empid)->first();
            if (!$employee || !$emp_acc) {
                return response()->json(['error' => 'Employee not found'], 404);
            }
    
            $emp_address = EmpAddress::where('emp_count', $employee->emp_count)->first(); // Fetch employee address using emp_count
            if (!$emp_address) {
                return response()->json(['error' => 'Employee address not found'], 404);
            }

            $emp_address2 = EmpAddress2::where('emp_count', $employee->emp_count)->first(); // Fetch employee address2 using emp_count
            if (!$emp_address2) {
                return response()->json(['error' => 'Employee address 2 not found'], 404);
            }

            //Update the address
            $emp_address->emp_region = $request->input('Region');
            $emp_address->emp_prov = $request->input('Province');
            $emp_address->emp_city = $request->input('City');
            $emp_address->emp_brgy = $request->input('Barangay');
            $emp_address->emp_house = $request->input('block');
            $emp_address->emp_subd = $request->input('villsub');
            $emp_address->emp_zip = $request->input('zipcode');

            $emp_address->save();
            
            return response()->json(['success' => 'Profile updated successfully']);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }


}
