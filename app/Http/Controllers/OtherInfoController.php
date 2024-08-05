<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\emp_eligibility;
use App\Models\emp_voluntary;
use App\Models\emp_learning;
use App\Models\emp_recog;
use App\Models\sssinfo;
use App\Models\pagibiginfo;
use App\Models\gsisinfo;
use App\Models\tininfo;
use App\Models\philhealthinfo;

class OtherInfoController extends Controller
{
    public function getCSEligibilityData()
    {
        try {
            $user = Auth::user(); // Get the currently authenticated user
            if (!$user) {
                return response()->json(['error' => 'User not authenticated'], 401);
            }

            // Select only the required columns
            $cseligibilityData = emp_eligibility::where('empid', $user->empid)
                ->select(
                    'eli_service',
                    'eli_rating',
                    'eli_doe',
                    'eli_poe',
                    'eli_license_no',
                    'eli_licen_valid'
                )
                ->get();

            if ($cseligibilityData->isEmpty()) {
                return response()->json(['error' => 'Data not found'], 404);
            }

            return response()->json($cseligibilityData);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

    public function getVoluntaryWorkData()
    {
        try {
            $user = Auth::user(); // Get the currently authenticated user
            if (!$user) {
                return response()->json(['error' => 'User not authenticated'], 401);
            }

            // Select only the required columns
            $voluntaryworkData = emp_voluntary::where('empid', $user->empid)
                ->select(
                    'vol_name',
                    'vol_add',
                    'vol_fr',
                    'vol_to',
                    'vol_hrs',
                    'vol_pos'
                )
                ->get();

            if ($voluntaryworkData->isEmpty()) {
                return response()->json(['error' => 'Data not found'], 404);
            }

            return response()->json($voluntaryworkData);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

    public function getLearndevData()
    {
        try {
            $user = Auth::user(); // Get the currently authenticated user
            if (!$user) {
                return response()->json(['error' => 'User not authenticated'], 401);
            }

            // Select only the required columns
            $learndevData = emp_learning::where('empid', $user->empid)
                ->select(
                    'learn_title',
                    'learn_fr',
                    'learn_to',
                    'learn_hrs',
                    'learn_type',
                    'learn_con'
                )
                ->get();

            if ($learndevData->isEmpty()) {
                return response()->json(['error' => 'Data not found'], 404);
            }

            return response()->json($learndevData);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

    public function getRecogdistData()
    {
        try {
            $user = Auth::user(); // Get the currently authenticated user
            if (!$user) {
                return response()->json(['error' => 'User not authenticated'], 401);
            }

            // Select only the required columns
            $recogdistData = emp_recog::where('empid', $user->empid)
                ->select('recog_name')
                ->get();

            if ($recogdistData->isEmpty()) {
                return response()->json(['error' => 'Data not found'], 404);
            }

            return response()->json($recogdistData);
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

            $sssinfo = sssinfo::where('empid', $user->empid)->first(); // Fetch employee using empid
            if (!$sssinfo) {
                return response()->json(['error' => 'Employee not found'], 404);
            }

            $sssId = $sssinfo->sss_num;
            return response()->json(['sssId' => $sssId]);
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

    public function getGSISId()
    {
        try {
            $user = Auth::user(); // Get the currently authenticated user
            if (!$user) {
                return response()->json(['error' => 'User not authenticated'], 401);
            }

            $gsisinfo = gsisinfo::where('empid', $user->empid)->first();
            if ( !$gsisinfo) {
                return response()->json(['error' => 'Employee not found'], 404);
            }

            $gsisId  = $gsisinfo->pb_no;
            return response()->json([ 'gsisId' => $gsisId]);
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

}
