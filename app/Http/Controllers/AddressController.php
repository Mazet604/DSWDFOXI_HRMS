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
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

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

    public function getEmployeeAddressData(Request $request)
{
    try {
        $demographic = $request->input('demographic');

        if ($demographic === 'region') {
            // Fetch and group data by region
            $employeeData = EmpAddress::select(
                DB::raw('TRIM(emp_address.emp_region) as emp_region'),
                DB::raw('TRIM(lib_regions.col_region) as region_name'),
                DB::raw('COUNT(emp_address.emp_region) as count')
            )
            ->leftJoin('lib_regions', 'emp_address.emp_region', '=', 'lib_regions.reg_psgc')
            ->groupBy(DB::raw('TRIM(emp_address.emp_region)'), DB::raw('TRIM(lib_regions.col_region)'))
            ->get();
        } elseif ($demographic === 'province') {
            // Fetch and group data by province
            $employeeData = EmpAddress::select(
                DB::raw('TRIM(emp_address.emp_prov) as emp_prov'),
                DB::raw('TRIM(lib_provinces.col_province) as province_name'),
                DB::raw('COUNT(emp_address.emp_prov) as count')
            )
            ->leftJoin('lib_provinces', 'emp_address.emp_prov', '=', 'lib_provinces.prv_psgc')
            ->groupBy(DB::raw('TRIM(emp_address.emp_prov)'), DB::raw('TRIM(lib_provinces.col_province)'))
            ->get();
        } elseif ($demographic === 'city') {
            // Fetch and group data by city
            $employeeData = EmpAddress::select(
                DB::raw('TRIM(emp_address.emp_city) as emp_city'),
                DB::raw('TRIM(lib_cities.col_citymuni) as city_name'),
                DB::raw('COUNT(emp_address.emp_city) as count')
            )
            ->leftJoin('lib_cities', 'emp_address.emp_city', '=', 'lib_cities.citmun_psgc')
            ->groupBy(DB::raw('TRIM(emp_address.emp_city)'), DB::raw('TRIM(lib_cities.col_citymuni)'))
            ->get();
        } else {
            // Default to fetching and grouping data by barangay
            $employeeData = EmpAddress::select(
                DB::raw('TRIM(emp_address.emp_brgy) as emp_brgy'),
                DB::raw('TRIM(lib_brgies.col_brgy) as barangay_name'),
                DB::raw('COUNT(emp_address.emp_brgy) as count')
            )
            ->leftJoin('lib_brgies', 'emp_address.emp_brgy', '=', 'lib_brgies.brgy_psgc')
            ->groupBy(DB::raw('TRIM(emp_address.emp_brgy)'), DB::raw('TRIM(lib_brgies.col_brgy)'))
            ->get();
        }

        return response()->json($employeeData, 200);
    } catch (\Exception $e) {
        Log::error('Error fetching employee address data: ' . $e->getMessage());
        return response()->json(['error' => 'Failed to fetch employee address data.'], 500);
    }
}




}
