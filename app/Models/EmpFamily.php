<?php

namespace App\Models;

class EmpFamily
{
    // Fetch family data based on the user count
    public static function getFamilyData($emp_count)
    {
        $father = EmpFather::where('emp_count', $emp_count)->first();
        $mother = EmpMother::where('emp_count', $emp_count)->first();
        $spouse = EmpSpouse::where('emp_count', $emp_count)->first();

        return [
            'father' => $father,
            'mother' => $mother,
            'spouse' => $spouse,
        ];
    }

    // Update family data based on the user count
    public static function updateFamilyData($emp_count, $data)
    {
        if ($father = EmpFather::where('emp_count', $emp_count)->first()) {
            $father->update([
                'father_lname' => $data['father_lname'],
                'father_fname' => $data['father_fname'],
                'father_mname' => $data['father_mname'],
                'father_xname' => $data['father_xname'],
            ]);
        }

        if ($mother = EmpMother::where('emp_count', $emp_count)->first()) {
            $mother->update([
                'maidenname' => $data['maidenname'],
                'mother_lname' => $data['mother_lname'],
                'mother_fname' => $data['mother_fname'],
                'mother_mname' => $data['mother_mname'],
            ]);
        }

        if ($spouse = EmpSpouse::where('emp_count', $emp_count)->first()) {
            $spouse->update([
                'spouse_lname' => $data['spouse_lname'],
                'spouse_fname' => $data['spouse_fname'],
                'spouse_mname' => $data['spouse_mname'],
                'spouse_xname' => $data['spouse_xname'],
                'spouse_occup' => $data['spouse_occup'],
                'spouse_office' => $data['spouse_office'],
                'spouse_busadd' => $data['spouse_busadd'],
                'spouse_tel' => $data['spouse_tel'],
            ]);
        }
    }
}
