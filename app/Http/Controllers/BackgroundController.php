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
use App\Models\emp_father;
use App\Models\emp_mother;
use App\Models\emp_spouse;
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

    public function getFather()
    {
        try {
            $user = Auth::user(); // Get the currently authenticated user
            if (!$user) {
                return response()->json(['error' => 'User not authenticated'], 401);
            }

            $employee = Employee::where('empid', $user->empid)->first();
            if (!$employee) {
                return response()->json(['error' => 'Employee not found'], 404);
            }

            $emp_father = emp_father::where('emp_count', $employee->emp_count)->first(); 
            if (!$emp_father) {
                return response()->json(['error' => 'Father not found'], 404);
            }

            $fatherSurname = $emp_father->father_lname;
            $fatherFirstName = $emp_father->father_fname;
            $fatherMiddleName = $emp_father->father_mname;
            $fatherExtName = $emp_father->father_xname;
            return response()->json([
                'fatherSurname' => $fatherSurname, 
                'fatherFirstName' => $fatherFirstName, 
                'fatherMiddleName' => $fatherMiddleName,
                'fatherExtName' => $fatherExtName
            ]);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

    public function getMother()
    {
        try {
            $user = Auth::user(); // Get the currently authenticated user
            if (!$user) {
                return response()->json(['error' => 'User not authenticated'], 401);
            }

            $employee = Employee::where('empid', $user->empid)->first();
            if (!$employee) {
                return response()->json(['error' => 'Employee not found'], 404);
            }

            $emp_mother = emp_mother::where('emp_count', $employee->emp_count)->first(); 
            if (!$emp_mother) {
                return response()->json(['error' => 'Mother not found'], 404);
            }

            $motherSurname = $emp_mother->mother_lname;
            $motherFirstName = $emp_mother->mother_fname;
            $motherMiddleName = $emp_mother->mother_mname;
            $motherMaidenName = $emp_mother->maidenname;
            return response()->json([
                'motherSurname' => $motherSurname, 
                'motherFirstName' => $motherFirstName, 
                'motherMiddleName' => $motherMiddleName,
                'motherMaidenName' => $motherMaidenName
            ]);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

    public function getSpouse()
    {
        try {
            $user = Auth::user(); // Get the currently authenticated user
            if (!$user) {
                return response()->json(['error' => 'User not authenticated'], 401);
            }

            $employee = Employee::where('empid', $user->empid)->first();
            if (!$employee) {
                return response()->json(['error' => 'Employee not found'], 404);
            }

            $emp_spouse = emp_spouse::where('emp_count', $employee->emp_count)->first(); 
            if (!$emp_spouse) {
                return response()->json(['error' => 'Mother not found'], 404);
            }

            $spouseSurname = $emp_spouse->spouse_lname;
            $spouseFirstName = $emp_spouse->spouse_fname;
            $MiddleName = $emp_spouse->spouse_mname;
            $ExtName = $emp_spouse->spouse_xname;
            $Occupation = $emp_spouse->spouse_occup;
            $spouseBusinessName = $emp_spouse->spouse_office;
            $spouseBusinessAddress = $emp_spouse->spouse_busadd;
            $spouseTelNo = $emp_spouse->spouse_tel;
            return response()->json([
                'spouseSurname' => $spouseSurname, 
                'spouseFirstName' => $spouseFirstName, 
                'MiddleName' => $MiddleName,
                'ExtName' => $ExtName,
                'Occupation' => $Occupation, 
                'spouseBusinessName' => $spouseBusinessName, 
                'spouseBusinessAddress' => $spouseBusinessAddress,
                'spouseTelNo' => $spouseTelNo
            ]);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

    public function updateFamilyData(Request $request)
{
    try {
        $user = Auth::user(); // Get the currently authenticated user
        if (!$user) {
            return response()->json(['error' => 'User not authenticated'], 401);
        }

        $employee = Employee::where('empid', $user->empid)->first();
            if (!$employee) {
                return response()->json(['error' => 'Employee not found'], 404);
            }

        // Update Father details
        $father = emp_father::where('emp_count', $employee->emp_count)->first();
        if ($father) {
            $father->father_lname = $request->input('fatherSurname');
            $father->father_fname = $request->input('fatherFirstName');
            $father->father_mname = $request->input('fatherMiddleName');
            $father->father_xname = $request->input('fatherExtName');
            $father->save();
        }

        // Update Mother details
        $mother = emp_mother::where('emp_count', $employee->emp_count)->first();
        if ($mother) {
            $mother->maidenname = $request->input('motherMaidenName');
            $mother->mother_lname = $request->input('motherSurname');
            $mother->mother_fname = $request->input('motherFirstName');
            $mother->mother_mname = $request->input('motherMiddleName');
            $mother->save();
        }

        // Update Spouse details
        $spouse = emp_spouse::where('emp_count', $employee->emp_count)->first();
        if ($spouse) {
            $spouse->spouse_lname = $request->input('spouseSurname');
            $spouse->spouse_fname = $request->input('spouseFirstName');
            $spouse->spouse_mname = $request->input('spouseMiddleName');
            $spouse->spouse_xname = $request->input('spouseExtName');
            $spouse->spouse_occup = $request->input('spouseOccupation');
            $spouse->spouse_office = $request->input('spouseBusinessName');
            $spouse->spouse_busadd = $request->input('spouseBusinessAddress');
            $spouse->spouse_tel = $request->input('spouseTelNo');
            $spouse->save();
        }

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

        // Fetch the employee's record to get emp_count
        $employee = Employee::where('empid', $user->empid)->first();
        if (!$employee) {
            return response()->json(['error' => 'Employee not found'], 404);
        }

        $child = new emp_child();
        $child->emp_count = $employee->emp_count; 
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

        // Fetch the employee's record to get emp_count
        $employee = Employee::where('empid', $user->empid)->first();
        if (!$employee) {
            return response()->json(['error' => 'Employee not found'], 404);
        }

        // Fetch child data and transform it to include full name and age
        $childData = emp_child::where('emp_count', $employee->emp_count)
            ->select('child_fname', 'child_mname', 'child_lname', 'child_xname', 'child_dob')
            ->get()
            ->map(function($child) {
                $child_mname_initial = $child->child_mname ? substr($child->child_mname, 0, 1) . '.' : '';
                $fullName = trim("{$child->child_fname} {$child_mname_initial} {$child->child_lname} {$child->child_xname}");
                $age = \Carbon\Carbon::parse($child->child_dob)->age;
                return [
                    'full_name' => $fullName,
                    'age' => $age,
                ];
            });


        if ($childData->isEmpty()) {
            return response()->json(['error' => 'No child data found'], 404);
        }

        return response()->json($childData);
    } catch (\Exception $e) {
        return response()->json(['error' => $e->getMessage()], 500);
    }
}


}
