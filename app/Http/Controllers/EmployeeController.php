<?php

namespace App\Http\Controllers;

use App\Models\EmpAcc;
use App\Models\lib_sex;
use App\Models\lib_civil_stat;
use App\Models\lib_blood_type;
use App\Models\lib_suffix;
use App\Models\Employee;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Auth;

class EmployeeController extends Controller
{
    public function getEmployee()
    {
        try {
            $user = Auth::user(); // Get the currently authenticated user
            if (!$user) {
                return response()->json(['error' => 'User not authenticated'], 401);
            }
    
            $employee = Employee::where('empid', $user->empid)->first(); // Fetch employee using empid
            if (!$employee) {
                return response()->json(['error' => 'Employee not found'], 404);
            }
    
            // Fetch the suffix from lib_suffixes table para dili number mugawas
            $suffix = lib_suffix::where('lib1_count', $employee->emp_ext)->first();
            if ($suffix && ($suffix->lib1_suffix === '0' || strtolower($suffix->lib1_suffix) === 'none')) {
                $emp_ext = null;
            } else {
                $emp_ext = $suffix ? $suffix->lib1_suffix : $employee->emp_ext;
            }
            
            // Only show the first character of emp_mname
            $emp_mname_initial = $employee->emp_mname ? substr($employee->emp_mname, 0, 1) . '.' : '';

            $fullName = $employee->emp_lname . ', ' . $employee->emp_fname . ' ' . $emp_mname_initial . ' ' . $emp_ext;
            $empPosition = $employee->emp_position;
            return response()->json(['fullName' => $fullName, 'empPosition' => $empPosition]);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

    public function getPersonalInfo()
{
    try {
        $user = Auth::user(); // Get the currently authenticated user
        if (!$user) {
            return response()->json(['error' => 'User not authenticated'], 401);
        }

        $employee = Employee::where('empid', $user->empid)->first(); // Fetch employee using empid
        $emp_acc = EmpAcc::where('empid', $user->empid)->first();
        if (!$employee) {
            return response()->json(['error' => 'Employee not found'], 404);
        }

        $empUser = $emp_acc->empuser;
        $empID = $emp_acc->empid;
        $firstName = $employee->emp_fname;
        $middleName = $employee->emp_mname;
        $lastName = $employee->emp_lname;
        $suffix = $employee->emp_ext;
        $citizenship = $employee->emp_citizen;
        $birthday = $employee->emp_dob;
        $placeOfBirth = $employee->emp_pob;
        $sex = $employee->emp_sex;
        $civilStatus = $employee->emp_civ_stat;
        $height = $employee->emp_height;
        $weight = $employee->emp_weight;
        $bloodType = $employee->emp_blood;

        return response()->json([
            'empUser' => $empUser,
            'empID' => $empID,
            'firstName' => $firstName,
            'middleName' => $middleName,
            'lastName' => $lastName,
            'suffix' => $suffix,
            'citizenship' => $citizenship,
            'birthday' => $birthday,
            'placeOfBirth' => $placeOfBirth,
            'sex' => $sex,
            'civilStatus' => $civilStatus,
            'height' => $height,
            'weight' => $weight,
            'bloodType' => $bloodType
        ]);
    } catch (\Exception $e) {
        return response()->json(['error' => $e->getMessage()], 500);
    }
}


    public function getSecurityandContact()
    {
        try {
            $user = Auth::user(); // Get the currently authenticated user
            if (!$user) {
                return response()->json(['error' => 'User not authenticated'], 401);
            }

            $employee = Employee::where('empid', $user->empid)->first(); // Fetch employee using empid
            $emp_acc= EmpAcc::where('empid', $user->empid)->first();
            if (!$employee) {
                return response()->json(['error' => 'Employee not found'], 404);
            }

            $mobilenum = $employee->emp_cnum;
            $telnum = $employee->emp_telnum;
            $emailadd = $emp_acc->empmail;
            return response()->json(['mobilenum' => $mobilenum, 'telnum' => $telnum, 'emailadd' => $emailadd
            ]);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

        public function updateProfile(Request $request)
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

            // Update the employee details
            $employee->emp_fname = $request->input('firstName');
            $employee->emp_mname = $request->input('middleName');
            $employee->emp_lname = $request->input('lastName');
            $employee->emp_ext = $request->input('suffix');
            $employee->emp_citizen = $request->input('citizenship');
            $employee->emp_dob = $request->input('birthday');
            $employee->emp_pob = $request->input('placeOfBirth');
            $employee->emp_sex = $request->input('sex');
            $employee->emp_civ_stat = $request->input('civilStatus');
            $employee->emp_height = $request->input('height');
            $employee->emp_weight = $request->input('weight');
            $employee->emp_blood = $request->input('bloodType');
            $employee->emp_cnum = $request->input('mobilenum');
            $employee->emp_telnum = $request->input('telnum');

            // Update the emp_acc details
            $emp_acc->empmail = $request->input('emailadd');

            // Save the updated information
            $employee->save();
            $emp_acc->save();

            return response()->json(['success' => 'Profile updated successfully']);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }


    public function getSexOptions()
    {
        try {
            $sexOptions = lib_sex::all(['lib4_count', 'lib4_sex']);
            return response()->json($sexOptions);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

    public function getCivilStatusOptions()
    {
        try {
            $civilStatusOptions = lib_sex::all(['lib3_count', 'lib3_civil_stat']);
            return response()->json($civilStatusOptions);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

    public function getBloodTypeOptions()
    {
        try {
            $bloodTypeOptions = lib_blood_type::all(['lib2_count', 'lib2_blood_type']);
            return response()->json($bloodTypeOptions);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

    public function ExtOptions()
    {
        try {
            $extOptions = lib_suffix::all(['lib1_count', 'lib1_suffix']);
            return response()->json($extOptions);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

    public function uploadProfilePicture(Request $request)
{
    $user = Auth::user();
    if (!$user) {
        return response()->json(['error' => 'User not authenticated'], 401);
    }

    try {
        // Validate the request
        $request->validate([
            'file' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048', // only allow image files
        ]);

        // Store the file
        if ($request->hasFile('file')) {
            $file = $request->file('file');
            $fileName =  $file->getClientOriginalName();
            $filePath = $file->storeAs('public/uploads/profile-pictures', $fileName);

            // Save the filename to the database
            $employee = Employee::where('empid', $user->empid)->first();
            if ($employee) {
                $employee->emp_pic = $fileName;
                $employee->save();
            } else {
                return response()->json(['error' => 'Employee not found'], 404);
            }

            // Return the file path or URL
            return response()->json(['url' => Storage::url($filePath)]);
        }

        return response()->json(['error' => 'File upload failed.'], 400);
    } catch (\Exception $e) {
        // Log the error
        \Log::error('File upload error: ' . $e->getMessage());
        return response()->json(['error' => 'Internal server error'], 500);
    }
}

        public function getProfilePicture()
        {
            $user = Auth::user();
            if (!$user) {
                return response()->json(['error' => 'User not authenticated'], 401);
            }

            // Fetch the employee record
            $employee = Employee::where('empid', $user->empid)->first();
            if ($employee && $employee->emp_pic) {
                // Path to the image
                $filePath = 'public/uploads/profile-pictures/' . $employee->emp_pic;

                // Check if the file exists
                if (Storage::exists($filePath)) {
                    // Generate the URL for the stored image
                    $profilePictureUrl = Storage::url($filePath);
                    return response()->json(['url' => $profilePictureUrl]);
                } else {
                    // File does not exist, return null
                    return response()->json(['url' => null, 'error' => 'Profile picture not found']);
                }
            } else {
                return response()->json(['url' => null, 'error' => 'No profile picture set']);
            }
        }




}
