<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\lib_region;
use App\Models\lib_province;
use App\Models\lib_city;
use App\Models\lib_brgy;
use App\Model\EmpAddress;
use App\Models\employee;

class AddressController extends Controller
{

    public function getAddress(Request $request)
    {
        // Assuming $user is retrieved from the authenticated user
        $user = $request->user();
    
        // Log the emp_count value
        \Log::info('User emp_count: ' . $user->emp_count);
    
        // Fetch employee using user ID
        $employee = employee::where('emp_count', $user->emp_count)->first();
    
        if (!$employee) {
            \Log::error('Employee not found for emp_count: ' . $user->emp_count);
            return response()->json(['error' => 'Employee not found'], 404);
        }
    
        // Fetch emp_address using emp_count
        $emp_address = EmpAddress::where('emp_count', $employee->emp_count)->first();
    
        if (!$emp_address) {
            return response()->json(['error' => 'Address not found'], 404);
        }
    
        return response()->json([
            'selectedRegion' => $emp_address->emp_region,
            'selectedProvince' => $emp_address->emp_prov,
            'selectedCity' => $emp_address->emp_city,
            'selectedBarangay' => $emp_address->emp_brgy,
        ]);
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

    /*public function getSelectedCityOptions()
    {
        try {
            $selectedCityOptions = lib_city::all(['psgc as value', 'col_citymuni as label']);
            return response()->json($selectedCityOptions);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

    /*public function getSelectedBarangayOptions()
    {
        try {
            $selectedBarangayOptions = lib_brgy::all(['psgc as value', 'col_brgy as label']);
            return response()->json($selectedBarangayOptions);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }*/
}
