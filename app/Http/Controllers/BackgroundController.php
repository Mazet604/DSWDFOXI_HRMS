<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\education;
use App\Models\emp_org;
use App\Models\emp_reference;
use App\Models\emp_work;
use App\Models\emp_child;
use App\Models\emp_skills;
use App\Models\employee;
use App\Models\EmpFamily;

class BackgroundController extends Controller
{
    public function getEducationData()
    {
        try {
            $user = Auth::user(); // Get the currently authenticated user
            if (!$user) {
                return response()->json(['error' => 'User not authenticated'], 401);
            }

            // Select only the required columns
            $educationData = Education::where('empid', $user->empid)
                ->select(
                    'educ_level', 
                    'educ_school', 
                    'educ_degree', 
                    'educ_from', 
                    'educ_year_grad', 
                    'educ_academic_honor', 
                    'educ_hl_earned')
                ->get();

            if ($educationData->isEmpty()) {
                return response()->json(['error' => 'Data not found'], 404);
            }

            return response()->json($educationData);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }
    
    public function getOrganizationData()
    {
        try {
            $user = Auth::user(); // Get the currently authenticated user
            if (!$user) {
                return response()->json(['error' => 'User not authenticated'], 401);
            }

            // Select only the required columns
            $organizationData = emp_org::where('empid', $user->empid)
                ->select('org_name')
                ->get();

            if ($organizationData->isEmpty()) {
                return response()->json(['error' => 'Data not found'], 404);
            }

            return response()->json($organizationData);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

    public function getWorkExperienceData()
    {
        try {
            $user = Auth::user(); // Get the currently authenticated user
            if (!$user) {
                return response()->json(['error' => 'User not authenticated'], 401);
            }

            // Select only the required columns
            $workExperienceData = emp_work::where('empid', $user->empid)
                ->select(
                    'workfr',
                    'workto',
                    'work_pos',
                    'work_dept',
                    'work_salary',
                    'work_salarygrade',
                    'work_stat',
                    'work_gov')
                ->get();

            if ($workExperienceData->isEmpty()) {
                return response()->json(['error' => 'Data not found'], 404);
            }

            return response()->json($workExperienceData);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }
    
    public function getSkillsData()
    {
        try {
            $user = Auth::user(); // Get the currently authenticated user
            if (!$user) {
                return response()->json(['error' => 'User not authenticated'], 401);
            }

            // Select only the required columns
            $skillsData = emp_skills::where('empid', $user->empid)
                ->select('skill')
                ->get();

            if ($skillsData->isEmpty()) {
                return response()->json(['error' => 'Data not found'], 404);
            }

            return response()->json($skillsData);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

    public function getReferencesData()
    {
        try {
            $user = Auth::user(); // Get the currently authenticated user
            if (!$user) {
                return response()->json(['error' => 'User not authenticated'], 401);
            }

            // Select the required columns
            $referencesData = emp_reference::where('empid', $user->empid)
                ->select(
                    'ref_fname',
                    'ref_mname',
                    'ref_lname',
                    'ref_xname',
                    'ref_add',
                    'ref_cnum'
                )
                ->get();

            if ($referencesData->isEmpty()) {
                return response()->json(['error' => 'Data not found'], 404);
            }

            // Format the full name
            $formattedReferences = $referencesData->map(function($reference) {
                $reference->full_name = trim($reference->ref_fname . ' ' . 
                                            $reference->ref_mname . ' ' . 
                                            $reference->ref_lname . ' ' . 
                                            $reference->ref_xname);
                return $reference;
            });

            return response()->json($formattedReferences);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

    public function addEducationData(Request $request)
    {
        try {
            $user = Auth::user(); // Get the currently authenticated user
            if (!$user) {
                return response()->json(['error' => 'User not authenticated'], 401);
            }

            $education = new Education();
            $education->empid = $user->empid;
            $education->educ_level = $request->input('educ_level');
            $education->educ_school = $request->input('educ_school');
            $education->educ_degree = $request->input('educ_degree');
            $education->educ_from = $request->input('educ_from');
            $education->educ_hl_earned = $request->input('educ_hl_earned');
            $education->educ_year_grad = $request->input('educ_year_grad');
            $education->educ_academic_honor = $request->input('educ_academic_honor');
            $education->save();

            return response()->json($education, 201);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

    public function addOrganizationData(Request $request)
    {
        try {
            $user = Auth::user(); // Get the currently authenticated user
            if (!$user) {
                return response()->json(['error' => 'User not authenticated'], 401);
            }

            $organization = new emp_org();
            $organization->empid = $user->empid;
            $organization->org_name = $request->input('org_name');
            $organization->save();

            return response()->json($organization, 201);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

    public function addWorkExperienceData(Request $request)
    {
        try {
            $user = Auth::user(); // Get the currently authenticated user
            if (!$user) {
                return response()->json(['error' => 'User not authenticated'], 401);
            }

            $workExperience = new emp_work();
            $workExperience->empid = $user->empid;
            $workExperience->workfr = $request->input('workfr');
            $workExperience->workto = $request->input('workto');
            $workExperience->work_pos = $request->input('work_pos');
            $workExperience->work_dept = $request->input('work_dept');
            $workExperience->work_salary = $request->input('work_salary');
            $workExperience->work_salarygrade = $request->input('work_salarygrade');
            $workExperience->work_stat = $request->input('work_stat');
            $workExperience->work_gov = $request->input('work_gov');
            $workExperience->save();

            return response()->json($workExperience, 201);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

    public function addSkillData(Request $request)
    {
        try {
            $user = Auth::user(); // Get the currently authenticated user
            if (!$user) {
                return response()->json(['error' => 'User not authenticated'], 401);
            }

            $skill = new emp_skills();
            $skill->empid = $user->empid;
            $skill->skill = $request->input('skill');
            $skill->save();

            return response()->json($skill, 201);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

    public function addReferenceData(Request $request)
    {
        try {
            $user = Auth::user(); // Get the currently authenticated user
            if (!$user) {
                return response()->json(['error' => 'User not authenticated'], 401);
            }

            $reference = new emp_reference();
            $reference->empid = $user->empid;
            $reference->ref_fname = $request->input('ref_fname');
            $reference->ref_mname = $request->input('ref_mname');
            $reference->ref_lname = $request->input('ref_lname');
            $reference->ref_xname = $request->input('ref_xname');
            $reference->ref_add = $request->input('ref_add');
            $reference->ref_cnum = $request->input('ref_cnum');
            $reference->save();

            return response()->json($reference, 201);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

    private function getEmpCountFromEmpId($empid)
    {
        $employee = Employee::where('empid', $empid)->first();
        return $employee ? $employee->emp_count : null;
    }

    public function getFamilyData()
    {
        try {
            $user = Auth::user();
            if (!$user) {
                return response()->json(['error' => 'User not authenticated'], 401);
            }

            // Fetch the employee using empid to get the emp_count
            $employee = Employee::where('empid', $user->empid)->first();
            if (!$employee) {
                return response()->json(['error' => 'Employee not found'], 404);
            }

            // Fetch family data using emp_count
            $familyData = EmpFamily::getFamilyData($employee->emp_count);

            return response()->json($familyData);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

    public function updateFamilyData(Request $request)
    {
        try {
            $user = Auth::user();
            if (!$user) {
                return response()->json(['error' => 'User not authenticated'], 401);
            }

            // Fetch the employee using empid to get the emp_count
            $employee = Employee::where('empid', $user->empid)->first();
            if (!$employee) {
                return response()->json(['error' => 'Employee not found'], 404);
            }

            // Update family data using emp_count
            EmpFamily::updateFamilyData($employee->emp_count, $request->all());

            return response()->json(['success' => 'Family data updated successfully']);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

    public function addChildData(Request $request)
    {
        try {
            $user = Auth::user();
            if (!$user) {
                return response()->json(['error' => 'User not authenticated'], 401);
            }


            $employee = Employee::where('empid', $user->empid)->first();
            if (!$employee) {
                return response()->json(['error' => 'Employee not found'], 404);
            }

            // Get emp_count from empid
            $child = emp_child::where('emp_count', $employee->emp_count)->first();
            if (!$child) {
                return response()->json(['error' => 'Employee count not found'], 404);
            }

            $child->child_fname = $request->input('child_fname');
            $child->child_mname = $request->input('child_mname');
            $child->child_lname = $request->input('child_lname');
            $child->child_xname = $request->input('child_xname');
            $child->child_dob = $request->input('child_dob');
            $child->save();

            return response()->json($child, 201);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

    public function getChildData()
    {
        try {
            $user = Auth::user();
            if (!$user) {
                return response()->json(['error' => 'User not authenticated'], 401);
            }

            // Get emp_count from empid
            $emp_count = $this->getEmpCountFromEmpId($user->empid);
            if (!$emp_count) {
                return response()->json(['error' => 'Employee count not found'], 404);
            }

            $childData = emp_child::where('emp_count', $emp_count)
                ->select('child_fname', 'child_dob')
                ->get();

            if ($childData->isEmpty()) {
                return response()->json(['error' => 'Data not found'], 404);
            }

            return response()->json($childData);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }
}
