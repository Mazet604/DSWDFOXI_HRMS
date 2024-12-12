<?php

namespace App\Http\Controllers;


use App\Models\{
    education,
    EmpAcc, Employee, EmpAddress, emp_spouse, emp_father, emp_mother, emp_child, emp_learning, emp_eligibility, emp_org, emp_otherinfo, emp_recog, emp_reference, emp_skills, emp_voluntary, emp_work, gsisinfo, pagibiginfo, philhealthinfo, sssinfo, tininfo,
};
use Illuminate\Http\Request;
use PhpOffice\PhpSpreadsheet\IOFactory;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\DB;

class EmpAdminController extends Controller
{
    public function createAccount(Request $request)
{
    $request->validate([
        'empid' => 'required|unique:emp_acc,empid',
        'empmail' => 'required|email|unique:emp_acc,empmail',
        'empuser' => 'required|unique:emp_acc,empuser',
        'emppass' => 'required|min:6',
    ]);

    EmpAcc::create([
        'empid' => $request->empid,
        'empmail' => $request->empmail,
        'empuser' => $request->empuser,
        'emppass' => Hash::make($request->emppass),
        'user_type' => 0, // Default value for user_type
    ]);

    $lastEmpCount = DB::table('employee')->max('emp_count');
    $newEmpCount = $lastEmpCount ? $lastEmpCount + 1 : 1;

    // Save to employee table
    DB::table('employee')->insert([
        'emp_count' => $newEmpCount,
        'empid' => $request->empid,
        'emp_position' => $request->position,
        'created_at' => now(),
        'updated_at' => now(),
    ]);

    return response()->json(['message' => 'Account created successfully!']);
}

public function previewExcel(Request $request)
{
    $request->validate(['file' => 'required|mimes:xlsx,xls']);
    $file = $request->file('file');
    Log::info("Uploaded file path: " . $file->getRealPath());

    $spreadsheet = IOFactory::load($file->getRealPath());
    $sheet1 = $spreadsheet->getSheet(0);

    // Define the specific cells to extract
    $specificCells = [
        'sheet1' => [
            // Other specific cells
            'D11', 'D12', 'D10', 'E15', 'E16', 'F20', 'G25', 'H30', 'H31',
            'I35', 'I36', 'I37', 'I38', 'L50', 'M51', 'N52', 'O53',
            // Child-related cells (names in I37-I48 and DOB in M37-M48)
            'children_names' => range(37, 48),
        ],
        'sheet2' => [
            'B11', 'C12', 'D13', 'E20', 'F21', 'G22', 'H23',
        ],
        'sheet3' => [
            'B30', 'C31', 'D32', 'E40', 'F41', 'G42', 'H50', 'I60', 'J70', 'K71',
        ],
        'sheet4' => [
            'B80', 'C90', 'D91', 'E92',
        ],
    ];

    // Extract values for the specified cells
    $result = [];
    foreach ($specificCells as $sheetName => $cells) {
        $sheetIndex = (int)substr($sheetName, -1) - 1; // Convert "sheet1" to index 0
        if ($spreadsheet->getSheetCount() > $sheetIndex) {
            $sheet = $spreadsheet->getSheet($sheetIndex);
            $result[$sheetName] = [];
            foreach ($cells as $key => $cell) {
                if ($key === 'children_names') {
                    $result[$sheetName]['children'] = [];
                    foreach ($cell as $row) {
                        $childName = $sheet->getCell("I$row")->getValue();
                        $childDob = $sheet->getCell("M$row")->getValue();
                        if ($childName && $childDob) {
                            $result[$sheetName]['children'][] = [
                                'name' => $childName,
                                'dob' => $childDob,
                            ];
                        }
                    }
                } else {
                    $result[$sheetName][$cell] = $sheet->getCell($cell)->getValue();
                }
            }
        }
    }

    Log::info("Parsed Specific Excel Data:", $result);
    return response()->json($result);
}



    public function confirmUpload(Request $request)
    {
        $data = $request->input('data');
        if (!$data) {
            return response()->json(['message' => 'No data to save.'], 400);
        }

        Log::info('Data to be saved:', $data['sheet1']);

        // Retrieve the empid from the most recently created account
        $latestAccount = EmpAcc::latest()->first();
        if (!$latestAccount) {
            return response()->json(['message' => 'No account found. Please create an account first.'], 400);
        }
        $empid = $latestAccount->empid;

         // Check if the required keys exist in sheet1
        if (!isset($data['sheet1']['A1'], $data['sheet1']['D11'], $data['sheet1']['D12'], $data['sheet1']['D10'])) {
            return response()->json(['message' => 'Missing required data in sheet1.'], 400);
        }

        // Map specific cells for Employee Info, Address, Spouse, Parents, and Children
        $sheet1 = $data['sheet1'];
        Employee::create([
            'empid' => $empid,
            'emp_fname' => $sheet1['D11'],
            'emp_mname' => $sheet1['D12'],
            'emp_lname' => $sheet1['D10'],
            'emp_ext' => $sheet1['M11'],
            'emp_dob' => $sheet1['D13'],
            'emp_pob' => $sheet1['D15'],
            'emp_sex' => $sheet1['D16'],
            'emp_blood' => $sheet1['D25'],
            'emp_height' => $sheet1['D22'],
            'emp_weight' => $sheet1['D24'],
            'emp_civ_stat' => $sheet1['D17'],
            'emp_citizen' => $sheet1['J13'],
            'emp_cnum' => $sheet1['I33'],
            'emp_telnum' => $sheet1['I32'],
        ]);

        // EmpAddress::create([
        //     'empid' => $empid,
        //     'address' => $sheet1['L50'],
        //     'city' => $sheet1['M51'],
        //     'province' => $sheet1['N52'],
        //     'zipcode' => $sheet1['O53'],
        // ]);

        emp_spouse::create([
            'empid' => $empid,
            'spouse_fname' => $sheet1['D37'],
            'spouse_lname' => $sheet1['D36'],
            'spouse_mname' => $sheet1['D38'],
            'spouse_xname' => $sheet1['G37'],
            'spouse_occup' => $sheet1['D39'],
            'spouse_office' => $sheet1['D40'],
            'spouse_busadd' => $sheet1['D41'],
            'spouse_tel' => $sheet1['D42'],
        ]);

        emp_father::create([
            'empid' => $empid,
            'father_fname' => $sheet1['D44'],
            'father_lname' => $sheet1['D43'],
            'father_mname' => $sheet1['D45'],
            'father_xname' => $sheet1['G44'],
        ]);

        emp_mother::create([
            'empid' => $empid,
            'mother_fname' => $sheet1['D48'],
            'mother_lname' => $sheet1['D47'],
            'mother_mname' => $sheet1['D49'],
            'maidenname' => $sheet1['D46'],
        ]);

        if (isset($data['sheet1']['children'])) {
            foreach ($data['sheet1']['children'] as $child) {
                // Normalize name into first, middle, last, and extension
                $nameParts = preg_split('/\s+/', $child['name']);
                $child_fname = $nameParts[0] ?? null;
                $child_mname = count($nameParts) > 2 ? $nameParts[1] : null; // Assume middle name exists if 3+ parts
                $child_lname = count($nameParts) > 2 ? $nameParts[2] : ($nameParts[1] ?? null); // Last part as last name
                $child_xname = count($nameParts) > 3 ? $nameParts[3] : null; // Fourth part as extension, if exists

                emp_child::create([
                    'empid' => $empid,
                    'child_fname' => $child_fname,
                    'child_mname' => $child_mname,
                    'child_lname' => $child_lname,
                    'child_xname' => $child_xname,
                    'child_dob' => $child['dob'],
                ]);
            }
        };

        education::create([
            'empid' => $empid,
            'educ_level' => $sheet1['D54'],
            'educ_school' => $sheet1['D54'],
            'educ_degree' => $sheet1['G54'],
            'educ_from' => $sheet1['J54'],
            'educ_year_grad' => $sheet1['M54'],
            'educ_academic_honor' => $sheet1['N54'],
            'educ_hl_earned' => $sheet1['L54'],
        ]);

        // Map specific cells for Eligibility and Work
        $sheet2 = $data['sheet2'];
        emp_eligibility::create([
            'empid' => $empid,
            'eli_service' => $sheet2['B11'],
            'eli_rating' => $sheet2['C12'],
            'eli_date' => $sheet2['D13'],
        ]);

        emp_work::create([
            'empid' => $empid,
            'work_company' => $sheet2['E20'],
            'work_position' => $sheet2['F21'],
            'work_from' => $sheet2['G22'],
            'work_to' => $sheet2['H23'],
        ]);

        // Map specific cells for Voluntary, Learning, Skills, Recognition, and Org
        $sheet3 = $data['sheet3'];
        emp_voluntary::create([
            'empid' => $empid,
            'vol_name' => $sheet3['B30'],
            'vol_address' => $sheet3['C31'],
            'vol_hours' => $sheet3['D32'],
        ]);

        emp_learning::create([
            'empid' => $empid,
            'learn_title' => $sheet3['E40'],
            'learn_hours' => $sheet3['F41'],
            'learn_date' => $sheet3['G42'],
        ]);

        emp_skills::create([
            'empid' => $empid,
            'skill' => $sheet3['H50'],
        ]);

        emp_recog::create([
            'empid' => $empid,
            'recog_name' => $sheet3['I60'],
        ]);

        emp_org::create([
            'empid' => $empid,
            'org_name' => $sheet3['J70'],
            'org_position' => $sheet3['K71'],
        ]);

        // Map specific cells for Other Info and References
        $sheet4 = $data['sheet4'];
        emp_otherinfo::create([
            'empid' => $empid,
            'other_info' => $sheet4['B80'],
        ]);

        emp_reference::create([
            'empid' => $empid,
            'ref_fname' => $sheet4['C90'],
            'ref_lname' => $sheet4['D91'],
            'ref_contact' => $sheet4['E92'],
        ]);

        return response()->json(['message' => 'Data saved successfully!']);
    }


}
