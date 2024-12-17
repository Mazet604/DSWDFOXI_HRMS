<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
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
use App\Models\employee;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\DB;

class OtherInfoController extends Controller
{
    public function getCSEligibilityData(Request $request)
{
    try {
        $eli_count = $request->query('eli_count'); // If there is an eli_count parameter
        $empid = $request->query('empid') ?? Auth::user()->empid; // Use empid from request or authenticated user

        // Check for eli_count parameter
        if ($eli_count) {
            // Fetch specific eligibility data by `eli_count`
            $cseligibilityData = emp_eligibility::where('eli_count', $eli_count)->first();

            if (!$cseligibilityData) {
                return response()->json(['error' => 'Eligibility data not found'], 404);
            }

            return response()->json($cseligibilityData, 200);
        }

        // Check for empid parameter
        if ($empid) {
            // Fetch eligibility data by `empid`
            $cseligibilityData = emp_eligibility::where('empid', $empid)
                ->select(
                    'eli_count',
                    'eli_service',
                    'eli_rating',
                    'eli_doe',
                    'eli_poe',
                    'eli_license_no',
                    'eli_licen_valid'
                )
                ->get();

            if ($cseligibilityData->isEmpty()) {
                return response()->json([]); // Return empty array if no data found
            }

            return response()->json($cseligibilityData, 200);
        }

        // Return error if no valid parameter is provided
        return response()->json(['error' => 'No valid identifier provided'], 400);

    } catch (\Exception $e) {
        return response()->json(['error' => $e->getMessage()], 500);
    }
}


public function getVoluntaryWorkData(Request $request)
{
    try {
        $vol_count = $request->query('vol_count'); // If there is a vol_count parameter
        $empid = $request->query('empid') ?? Auth::user()->empid; // Use empid from request or authenticated user

        // Check for vol_count parameter
        if ($vol_count) {
            // Fetch specific voluntary work data by `vol_count`
            $voluntaryworkData = emp_voluntary::where('vol_count', $vol_count)->first();

            if (!$voluntaryworkData) {
                return response()->json(['error' => 'Voluntary work data not found'], 404);
            }

            return response()->json($voluntaryworkData, 200);
        }

        // Check for empid parameter
        if ($empid) {
            // Fetch voluntary work data by `empid`
            $voluntaryworkData = emp_voluntary::where('empid', $empid)
                ->select(
                    'vol_count',
                    'vol_name',
                    'vol_add',
                    'vol_fr',
                    'vol_to',
                    'vol_hrs',
                    'vol_pos'
                )
                ->get();

            if ($voluntaryworkData->isEmpty()) {
                return response()->json([]); // Return empty array if no data found
            }

            return response()->json($voluntaryworkData, 200);
        }

        // Return error if no valid parameter is provided
        return response()->json(['error' => 'No valid identifier provided'], 400);

    } catch (\Exception $e) {
        return response()->json(['error' => $e->getMessage()], 500);
    }
}


public function getLearndevData(Request $request)
{
    try {
        $learn_count = $request->query('learn_count'); // If there is a learn_count parameter
        $empid = $request->query('empid') ?? Auth::user()->empid; // Use empid from request or authenticated user

        // Check for learn_count parameter
        if ($learn_count) {
            // Fetch specific learning and development data by `learn_count`
            $learndevData = emp_learning::where('learn_count', $learn_count)->first();

            if (!$learndevData) {
                return response()->json(['error' => 'Learning and development data not found'], 404);
            }

            return response()->json($learndevData, 200);
        }

        // Check for empid parameter
        if ($empid) {
            // Fetch learning and development data by `empid`
            $learndevData = emp_learning::where('empid', $empid)
                ->select(
                    'learn_count',
                    'learn_title',
                    'learn_fr',
                    'learn_to',
                    'learn_hrs',
                    'learn_type',
                    'learn_con'
                )
                ->get();

            if ($learndevData->isEmpty()) {
                return response()->json([]); // Return empty array if no data found
            }

            return response()->json($learndevData, 200);
        }

        // Return error if no valid parameter is provided
        return response()->json(['error' => 'No valid identifier provided'], 400);

    } catch (\Exception $e) {
        return response()->json(['error' => $e->getMessage()], 500);
    }
}


public function getRecogdistData(Request $request)
{
    try {
        $recog_count = $request->query('recog_count'); // If there is a recog_count parameter
        $empid = $request->query('empid') ?? Auth::user()->empid; // Use empid from request or authenticated user

        // Check for recog_count parameter
        if ($recog_count) {
            // Fetch specific recognition and distribution data by `recog_count`
            $recogdistData = emp_recog::where('recog_count', $recog_count)->first();

            if (!$recogdistData) {
                return response()->json(['error' => 'Recognition data not found'], 404);
            }

            return response()->json($recogdistData, 200);
        }

        // Check for empid parameter
        if ($empid) {
            // Fetch recognition and distribution data by `empid`
            $recogdistData = emp_recog::where('empid', $empid)
                ->select('recog_count', 'recog_name')
                ->get();

            if ($recogdistData->isEmpty()) {
                return response()->json([]); // Return empty array if no data found
            }

            return response()->json($recogdistData, 200);
        }

        // Return error if no valid parameter is provided
        return response()->json(['error' => 'No valid identifier provided'], 400);

    } catch (\Exception $e) {
        return response()->json(['error' => $e->getMessage()], 500);
    }
}


public function getSSSId()
    {
        try {
            $user = Auth::user(); // Get the currently authenticated user
            if (!$user) {
                return response()->json(['error' => 'User not authenticated'], 401);
            }

            $sssinfo = sssinfo::where('empid', $user->empid)->first();
            if (!$sssinfo) {
                return response()->json(['error' => 'Mother not found'], 404);
            }

            $sssId = $sssinfo->sss_num;
            return response()->json(['sssId' => $sssId]);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

    public function getSSSIdAdmin(Request $request)
{
    try {
        // Get the currently authenticated user
        $user = Auth::user();
        if (!$user) {
            return response()->json(['error' => 'User not authenticated'], 401);
        }

        // Check if the request is from admin or user
        $sss_count = $request->query('sss_count'); // Admin-specific parameter
        $empid = $request->query('empid') ?? $user->empid; // Use empid from request or fallback to user's empid

        // Admin: Fetch by sss_count if provided
        if ($sss_count) {
            $sssinfo = sssinfo::where('sss_count', $sss_count)->first();

            if (!$sssinfo) {
                return response()->json(['error' => 'SSS data not found'], 404);
            }

            return response()->json(['sss_num' => $sssinfo->sss_num], 200);
        }

        // User: Fetch by empid
        if ($empid) {
            $sssinfo = sssinfo::where('empid', $empid)->first();

            if (!$sssinfo) {
                return response()->json(['error' => 'SSS data not found'], 404);
            }

            return response()->json(['sss_num' => $sssinfo->sss_num], 200);
        }

        // Return error if no valid parameter is provided
        return response()->json(['error' => 'No valid identifier provided'], 400);
    } catch (\Exception $e) {
        return response()->json(['error' => $e->getMessage()], 500);
    }
}




    public function getPagIbigId()
    {
        try {
            $user = Auth::user(); // Get the currently authenticated user
            if (!$user) {
                return response()->json(['error' => 'User not authenticated'], 401);
            }

            $pagibiginfo= pagibiginfo::where('empid', $user->empid)->first();
            if (!$pagibiginfo) {
                return response()->json(['error' => 'Employee not found'], 404);
            }

            $pagIbigId = $pagibiginfo->pgbg_id;
            return response()->json([ 'pagIbigId' => $pagIbigId]);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

    public function getPagIbigIdAdmin(Request $request)
{
    try {
        // Get the currently authenticated user
        $user = Auth::user();
        if (!$user) {
            return response()->json(['error' => 'User not authenticated'], 401);
        }

        // Check if the request is from admin or user
        $pgbg_count = $request->query('pgbg_count'); // Admin-specific parameter
        $empid = $request->query('empid') ?? $user->empid; // Use empid from request or fallback to user's empid

        // Admin: Fetch by pgbg_count if provided
        if ($pgbg_count) {
            $pagibiginfo = pagibiginfo::where('pgbg_count', $pgbg_count)->first();

            if (!$pagibiginfo) {
                return response()->json(['error' => 'Pag-IBIG data not found'], 404);
            }

            return response()->json(['pgbg_id' => $pagibiginfo->pgbg_id], 200);
        }

        // User: Fetch by empid
        if ($empid) {
            $pagibiginfo = pagibiginfo::where('empid', $empid)->first();

            if (!$pagibiginfo) {
                return response()->json(['error' => 'Pag-IBIG data not found'], 404);
            }

            return response()->json(['pgbg_id' => $pagibiginfo->pgbg_id], 200);
        }

        // Return error if no valid parameter is provided
        return response()->json(['error' => 'No valid identifier provided'], 400);
    } catch (\Exception $e) {
        return response()->json(['error' => $e->getMessage()], 500);
    }
}




    public function getGSISId()
    {
        try {
            $user = Auth::user(); // Get the currently authenticated user
            if (!$user) {
                return response()->json(['error' => 'User not authenticated'], 401);
            }

            $gsisinfo = gsisinfo::where('empid', $user->empid)->first();
            if (!$gsisinfo) {
                return response()->json(['error' => 'Employee not found'], 404);
            }

            $gsisId  = $gsisinfo->pb_no;
            return response()->json([ 'gsisId' => $gsisId]);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

    public function getGSISIdAdmin(Request $request)
{
    try {
        $user = Auth::user();
        if (!$user) {
            return response()->json(['error' => 'User not authenticated'], 401);
        }

        $gsis_count = $request->query('gsis_count');
        $empid = $request->query('empid') ?? $user->empid;

        if ($gsis_count) {
            $gsisinfo = gsisinfo::where('gsis_count', $gsis_count)->first();
            if (!$gsisinfo) {
                return response()->json(['error' => 'GSIS data not found'], 404);
            }
            return response()->json([
                'gsis_id' => $gsisinfo->pb_no, // Return pb_no
                'gsis_count' => $gsisinfo->gsis_count // Include count for debugging
            ], 200);
        }

        if ($empid) {
            $gsisinfo = gsisinfo::where('empid', $empid)->first();
            if (!$gsisinfo) {
                return response()->json(['error' => 'GSIS data not found'], 404);
            }
            return response()->json([
                'gsis_id' => $gsisinfo->pb_no, // Return pb_no
                'gsis_count' => $gsisinfo->gsis_count // Include count for debugging
            ], 200);
        }

        return response()->json(['error' => 'No valid identifier provided'], 400);
    } catch (\Exception $e) {
        return response()->json(['error' => $e->getMessage()], 500);
    }
}

    public function getPhilHealthId()
    {
        try {
            $user = Auth::user(); // Get the currently authenticated user
            if (!$user) {
                return response()->json(['error' => 'User not authenticated'], 401);
            }

            $philhealthinfo = philhealthinfo::where('empid', $user->empid)->first();
            if ( !$philhealthinfo) {
                return response()->json(['error' => 'Employee not found'], 404);
            }

            $philHealthId = $philhealthinfo->ph_lid;
            return response()->json(['philHealthId' => $philHealthId]);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

    public function getPhilHealthIdAdmin(Request $request)
    {
        try {
            $user = Auth::user();
            if (!$user) {
                return response()->json(['error' => 'User not authenticated'], 401);
            }

            $phl_count = $request->query('phl_count'); // Admin-specific parameter
            $empid = $request->query('empid') ?? $user->empid; // Use empid from request or fallback to user's empid

            // Admin: Fetch by phl_count if provided
            if ($phl_count) {
                $philhealthinfo = philhealthinfo::where('phl_count', $phl_count)->first();
                if (!$philhealthinfo) {
                    return response()->json(['error' => 'PhilHealth data not found'], 404);
                }
                return response()->json([
                    'ph_lid' => $philhealthinfo->ph_lid, // Return correct field name
                    'phl_count' => $philhealthinfo->phl_count // Include count for debugging
                ], 200);
            }

            // User: Fetch by empid
            if ($empid) {
                $philhealthinfo = philhealthinfo::where('empid', $empid)->first();
                if (!$philhealthinfo) {
                    return response()->json(['error' => 'PhilHealth data not found'], 404);
                }
                return response()->json([
                    'ph_lid' => $philhealthinfo->ph_lid, // Return correct field name
                    'phl_count' => $philhealthinfo->phl_count // Include count for debugging
                ], 200);
            }

            return response()->json(['error' => 'No valid identifier provided'], 400);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }




    public function getTINId()
    {
        try {
            $user = Auth::user(); // Get the currently authenticated user
            if (!$user) {
                return response()->json(['error' => 'User not authenticated'], 401);
            }

            $tininfo = tininfo::where('empid', $user->empid)->first();
            if (!$tininfo) {
                return response()->json(['error' => 'Employee not found'], 404);
            }

            $tinId = $tininfo->tin_id;
            return response()->json(['tinId' => $tinId]);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

    public function getTINIdAdmin(Request $request)
    {
        try {
            // Get the currently authenticated user
            $user = Auth::user();
            if (!$user) {
                return response()->json(['error' => 'User not authenticated'], 401);
            }

            // Check if the request is from admin or user
            $tin_count = $request->query('tin_count'); // Admin-specific parameter
            $empid = $request->query('empid') ?? $user->empid; // Use empid from request or fallback to user's empid

            // Admin: Fetch by tin_count if provided
            if ($tin_count) {
                $tininfo = tininfo::where('tin_count', $tin_count)->first();
                if (!$tininfo) {
                    return response()->json(['error' => 'TIN data not found'], 404);
                }
                return response()->json([
                    'tin_id' => $tininfo->tin_id, // Return tin_id
                    'tin_count' => $tininfo->tin_count // Include count for debugging
                ], 200);
            }

            // User: Fetch by empid
            if ($empid) {
                $tininfo = tininfo::where('empid', $empid)->first();
                if (!$tininfo) {
                    return response()->json(['error' => 'TIN data not found'], 404);
                }
                return response()->json([
                    'tin_id' => $tininfo->tin_id, // Return tin_id
                    'tin_count' => $tininfo->tin_count // Include count for debugging
                ], 200);
            }

            // Return error if no valid parameter is provided
            return response()->json(['error' => 'No valid identifier provided'], 400);

        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }


    public function updateGovIdData(Request $request)
    {
        // Start a transaction to ensure consistency
        DB::beginTransaction();

        try {
            $user = Auth::user(); // Get the currently authenticated user
            if (!$user) {
                return response()->json(['error' => 'User not authenticated'], 401);
            }

            $employee = Employee::where('empid', $user->empid)->first();
            if (!$employee) {
                return response()->json(['error' => 'Employee not found'], 404);
            }

            // Update or Create SSS details
            $SSS = sssinfo::firstOrNew(['empid' => $user->empid]);
            $SSS->sss_num = $request->input('sssId');
            $SSS->save();

            // Update or Create PagIbig details
            $pagibig = pagibiginfo::firstOrNew(['empid' => $user->empid]);
            $pagibig->pgbg_id = $request->input('pagIbigId');
            $pagibig->save();

            // Update or Create TIN details
            $tin = tininfo::firstOrNew(['empid' => $user->empid]);
            $tin->tin_id = $request->input('tinId');
            $tin->save();

            // Update or Create GSIS details
            $gsis = gsisinfo::firstOrNew(['empid' => $user->empid]);
            $gsis->pb_no = $request->input('gsisId');
            $gsis->save();

            // Update or Create PhilHealth details
            $philhealth = philhealthinfo::firstOrNew(['empid' => $user->empid]);
            $philhealth->ph_lid = $request->input('philHealthId');
            $philhealth->save();

            // Commit the transaction if all updates/creates succeed
            DB::commit();

            return response()->json(['success' => 'Data updated successfully']);

        } catch (\Exception $e) {
            // Roll back any changes on error
            DB::rollBack();

            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

    public function addCSEligibility(Request $request)
    {
        try {
            $user = Auth::user();
            if (!$user) {
                return response()->json(['error' => 'User not authenticated'], 401);
            }

            $eligibility = new emp_eligibility();
            $eligibility->empid = $user->empid;
            $eligibility->eli_service = $request->eli_service;
            $eligibility->eli_rating = $request->eli_rating;
            $eligibility->eli_doe = $request->eli_doe;
            $eligibility->eli_poe = $request->eli_poe;
            $eligibility->eli_license_no = $request->eli_license_no;
            $eligibility->eli_licen_valid = $request->eli_licen_valid;
            $eligibility->save();

            return response()->json($eligibility, 201);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

    public function addVoluntaryWork(Request $request)
    {
        try {
            $user = Auth::user();
            if (!$user) {
                return response()->json(['error' => 'User not authenticated'], 401);
            }

            $voluntary = new emp_voluntary();
            $voluntary->empid = $user->empid;
            $voluntary->vol_name = $request->vol_name;
            $voluntary->vol_add = $request->vol_add;
            $voluntary->vol_fr = $request->vol_fr;
            $voluntary->vol_to = $request->vol_to;
            $voluntary->vol_hrs = $request->vol_hrs;
            $voluntary->vol_pos = $request->vol_pos;
            $voluntary->save();

            return response()->json($voluntary, 201);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

    public function addLearndev(Request $request)
    {
        try {
            $user = Auth::user();
            if (!$user) {
                return response()->json(['error' => 'User not authenticated'], 401);
            }

            $learndev = new emp_learning();
            $learndev->empid = $user->empid;
            $learndev->learn_title = $request->learn_title;
            $learndev->learn_fr = $request->learn_fr;
            $learndev->learn_to = $request->learn_to;
            $learndev->learn_hrs = $request->learn_hrs;
            $learndev->learn_type = $request->learn_type;
            $learndev->learn_con = $request->learn_con;
            $learndev->save();

            return response()->json($learndev, 201);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

    public function addRecogdist(Request $request)
    {
        try {
            $user = Auth::user();
            if (!$user) {
                return response()->json(['error' => 'User not authenticated'], 401);
            }

            $recogdist = new emp_recog();
            $recogdist->empid = $user->empid;
            $recogdist->recog_name = $request->recog_name;
            $recogdist->save();

            return response()->json($recogdist, 201);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

    public function updateCSEligibilityData(Request $request)
{
    try {
        $user = Auth::user();
        if (!$user) {
            return response()->json(['error' => 'User not authenticated'], 401);
        }

        $eligibility = emp_eligibility::where('eli_count', $request->input('eli_count'))->first();
        if (!$eligibility) {
            return response()->json(['error' => 'CS ELigibility data not found'], 404);
        }

        $eligibility->eli_service = $request->input('eli_service');
        $eligibility->eli_rating = $request->input('eli_rating');
        $eligibility->eli_doe = $request->input('eli_doe');
        $eligibility->eli_poe = $request->input('eli_poe');
        $eligibility->eli_license_no = $request->input('eli_license_no');
        $eligibility->eli_licen_valid = $request->input('eli_licen_valid');
        $eligibility->save();

        return response()->json(['success' => 'CS ELigibility data updated successfully']);
    } catch (\Exception $e) {
        return response()->json(['error' => $e->getMessage()], 500);
    }
}

    public function updateVoluntaryWorkData(Request $request)
{
    try {
        $user = Auth::user();
        if (!$user) {
            return response()->json(['error' => 'User not authenticated'], 401);
        }

        $voluntary = emp_voluntary::where('vol_count', $request->input('vol_count'))->first();
        if (!$voluntary) {
            return response()->json(['error' => 'Voluntary Work data not found'], 404);
        }

        $voluntary->vol_name = $request->input('vol_name');
        $voluntary->vol_add = $request->input('vol_add');
        $voluntary->vol_fr = $request->input('vol_fr');
        $voluntary->vol_to = $request->input('vol_to');
        $voluntary->vol_hrs = $request->input('vol_hrs');
        $voluntary->vol_pos = $request->input('vol_pos');
        $voluntary->save();

        return response()->json(['success' => 'Voluntary Work data updated successfully']);
    } catch (\Exception $e) {
        return response()->json(['error' => $e->getMessage()], 500);
    }
}

    public function updateLearnDevData(Request $request)
{
    try {
        $user = Auth::user();
        if (!$user) {
            return response()->json(['error' => 'User not authenticated'], 401);
        }

        $learning = emp_learning::where('learn_count', $request->input('learn_count'))->first();
        if (!$learning) {
            return response()->json(['error' => 'Learning And Development data not found'], 404);
        }

        $learning->learn_title = $request->input('learn_title');
        $learning->learn_fr = $request->input('learn_fr');
        $learning->learn_to = $request->input('learn_to');
        $learning->learn_hrs = $request->input('learn_hrs');
        $learning->learn_type = $request->input('learn_type');
        $learning->learn_con = $request->input('learn_con');
        $learning->save();

        return response()->json(['success' => 'Learning And Development data updated successfully']);
    } catch (\Exception $e) {
        return response()->json(['error' => $e->getMessage()], 500);
    }
}

    public function updateRecogDistData(Request $request)
{
    try {
        $user = Auth::user();
        if (!$user) {
            return response()->json(['error' => 'User not authenticated'], 401);
        }

        $recognition = emp_recog::where('recog_count', $request->input('recog_count'))->first();
        if (!$recognition) {
            return response()->json(['error' => 'Recognition & Distinction data not found'], 404);
        }

        $recognition->recog_name = $request->input('recog_name');
        $recognition->save();

        return response()->json(['success' => 'Recognition & Distinction data updated successfully']);
    } catch (\Exception $e) {
        return response()->json(['error' => $e->getMessage()], 500);
    }
}


public function getOtherInfoData()
    {
        try {
            $user = Auth::user(); // Get the currently authenticated user
            if (!$user) {
                return response()->json(['error' => 'User not authenticated'], 401);
            }

            // Fetch the "Other Information" data for the authenticated user
            $otherInfoData = emp_otherinfo::where('empid', $user->empid)
                ->select(
                    'other_count','other_34a', 'other_34b', 'other_34bif', 'other_35a', 'other_35aif',
                    'other_35b', 'other_35bif', 'other_35bfiled', 'other_35stat', 'other_36',
                    'other_36if', 'other_37', 'other_37if', 'other_38a', 'other_38aif',
                    'other_38b', 'other_39', 'other_39if', 'other_40a', 'other_40aif',
                    'other_40b', 'other_40bif', 'other_40c', 'other_40cif'
                )
                ->first();

            if (!$otherInfoData) {
                return response()->json(['error' => 'Other Information data not found'], 404);
            }

            return response()->json($otherInfoData);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

    // Update the "Other Information" data
    public function updateOtherInfoData(Request $request)
{
    try {
        $user = Auth::user(); // Get the currently authenticated user
        if (!$user) {
            return response()->json(['error' => 'User not authenticated'], 401);
        }

        // Find the existing otherInfo record
        $otherInfo = emp_otherinfo::where('empid', $user->empid)->first();

        if (!$otherInfo) {
            // If no otherInfo is found, create a new one and set other_count to 1
            $otherInfo = new emp_otherinfo();
            $otherInfo->empid = $user->empid;
        }

        // Update the columns with the new data from the request
        $otherInfo->other_34a = $request->input('other_34a');
        $otherInfo->other_34b = $request->input('other_34b');
        $otherInfo->other_34bif = $request->input('other_34bif');
        $otherInfo->other_35a = $request->input('other_35a');
        $otherInfo->other_35aif = $request->input('other_35aif');
        $otherInfo->other_35b = $request->input('other_35b');
        $otherInfo->other_35bif = $request->input('other_35bif');
        $otherInfo->other_35bfiled = $request->input('other_35bfiled');
        $otherInfo->other_35stat = $request->input('other_35stat');
        $otherInfo->other_36 = $request->input('other_36');
        $otherInfo->other_36if = $request->input('other_36if');
        $otherInfo->other_37 = $request->input('other_37');
        $otherInfo->other_37if = $request->input('other_37if');
        $otherInfo->other_38a = $request->input('other_38a');
        $otherInfo->other_38aif = $request->input('other_38aif');
        $otherInfo->other_38b = $request->input('other_38b');
        $otherInfo->other_39 = $request->input('other_39');
        $otherInfo->other_39if = $request->input('other_39if');
        $otherInfo->other_40a = $request->input('other_40a');
        $otherInfo->other_40aif = $request->input('other_40aif');
        $otherInfo->other_40b = $request->input('other_40b');
        $otherInfo->other_40bif = $request->input('other_40bif');
        $otherInfo->other_40c = $request->input('other_40c');
        $otherInfo->other_40cif = $request->input('other_40cif');

        // Save the updated otherInfo object
        $otherInfo->save();

        return response()->json(['success' => 'Other Information data updated successfully']);
    } catch (\Exception $e) {
        return response()->json(['error' => $e->getMessage()], 500);
    }
}



}


