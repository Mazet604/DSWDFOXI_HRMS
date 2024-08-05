<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\lib_region;
use App\Model\emp_address;
use App\Models\Employee;

class AddressController extends Controller
{

    public function getAddress(Request $request)
    {
        // Assuming $user is retrieved from the authenticated user
        $user = $request->user();

        $emp_address = EmpAddress::where('emp_count', $user->emp_count)->first(); // Fetch employee using empid
        $emp_acc = Employee::where('emp_count', $user->emp_count)->first();

        if (!$emp_address) {
            return response()->json(['error' => 'Address not found'], 404);
        }

        $selectedRegion = $emp_address->emp_region;
        return response()->json(['selectedRegion' => $selectedRegion]);
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
}
