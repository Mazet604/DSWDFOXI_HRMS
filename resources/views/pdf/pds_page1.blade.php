<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Page 1</title>
    <style>
        .profile-picture {
            width: 150px;
            height: 150px;
            object-fit: cover;
        }
        body {
            font-family: Arial, sans-serif;
            font-size: 8px; /* Smaller font size */
            margin: 0;
            padding: 10px;
        }
        /* Table Styling */
        table {
            width: 100%;
          border-collapse: collapse; /* Remove spacing between table cells */
        }

        th, td {
            border: 1px solid black;
            padding: 5px;
            text-align: left;
        }

        /* Column Styling */
        td:first-child { /* Style the left column */
          width: 25%; /* Adjust width as needed */
        }

        td:nth-child(2) { /* Style the right column */
          width: 75%; /* Adjust width as needed */
        }

        /* Specific Field Styling */
        #surname, #first_name, #middle_name, #name_extension, #place_of_birth, #gsis_no, #pgbg_no, #ph_no, #sss_no, #tin_no, #agemp_no, #country, #street, #village, #barangay, #city_municipality, #province, #zip_code, #permanent_address, #permanent_street, #permanent_village, #permanent_barangay, #permanent_city_municipality, #permanent_province, #permanent_zip_code, #tel_no, #mob_no, #email_add {
          width: 100%; /* Make input fields fill the width of the cell */
        }

        /* Radio Button Styling */
        input[type="radio"] {
          margin-right: 5px; /* Add spacing between radio button and label */
        }

        /* Checkbox Styling */
        input[type="checkbox"] {
          margin-right: 5px; /* Add spacing between checkbox and label */
        }

        /* Additional Styling (Optional) */
        h1 { /* Style the heading */
            text-align: center;
            font-size: 24px;
            margin-bottom: 20px;
        }

        th {
            background-color: #f2f2f2;
        }
        h1, h2 {
            text-align: center;
            font-size: 12px; /* Smaller header font size */
            margin: 10px 0;
        }
        p {
            margin: 0 0 5px;
            font-size: 8px; /* Smaller font size for paragraphs */
        }
        label {
            display: block;
            font-size: 8px; /* Smaller font size for labels */
        }
        .first_part {
            width: 95%;
            margin: 0 auto;
            padding: 20px;
            border: 1px solid black;
            border-collapse: collapse;
        }
        .first_part h5, .first_part h7, .first_part h2 {
            text-align: center;
            margin: 0;
            padding: 5px 0;
        }
        .first_part h7 {
            font-size: 12px;
        }
        .first_part h2 {
            margin-bottom: 10px;
        }
        .container {
            width: 100%;
            margin: 0 auto;
            padding: 20px;
            box-sizing: border-box;
        }

        .references-table, .id-table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
        }

        .references-table th, .references-table td,
        .id-table th, .id-table td {
            border: 1px solid black;
            padding: 5px;
            text-align: left;
            vertical-align: top;
        }

        .references-table th {
            text-align: center;
        }

        .declaration {
            margin-bottom: 20px;
        }

        .id-table .photo-box {
            width: 120px;
            height: 150px;
            text-align: center;
            border: 1px solid black;
            vertical-align: top;
            padding: 20px;
        }

        .signature-box {
            text-align: left;
        }

        .signature-area {
            border: 1px solid black;
            height: 40px;
            margin-top: 5px;
        }

        .thumbmark-box {
            display: flex;
            align-items: center;
            margin-bottom: 20px;
        }

        .thumbmark-label {
            margin-right: 10px;
        }

        .thumbmark-area {
            border: 1px solid black;
            width: 120px;
            height: 100px;
        }

        .oath-box {
            text-align: left;
        }

        .oath-box p {
            margin-bottom: 20px;
        }

        .administering-oath {
            text-align: center;
            border-top: 1px solid black;
            margin-top: 40px;
            padding-top: 10px;
        }

    </style>
</head>
<body>
    <div class="container">
    <div class="first_part">
        <h5>CS Form No. 212</h5>
        <h7>Revised 2017</h7>
        <h2>PERSONAL DATA SHEET</h2>
        <p class="warning">WARNING: Any misrepresentation made in the Personal Data Sheet and the Work Experience Sheet shall cause the filing of administrative/criminal case/s against the person concerned.</p>
        <p class="read-guide">READ THE ATTACHED GUIDE TO FILLING OUT THE PERSONAL DATA SHEET (PDS) BEFORE ACCOMPLISHING THE PDS FORM.</p>
        <p class="instruction">Print legibly. Tick appropriate boxes ( ) and use separate sheet if necessary. Indicate N/A if not applicable. DO NOT ABBREVIATE.</p>
        <div class="col">
          <label for="surname">1. CS ID No</label>
          <input type="text" name="surname" id="surname" readonly />
          <p class="instruction"> (Do not fill up. For CSC use only)</p>
      </div>
      </div>
      <table>
        <tr><td>I. PERSONAL INFORMATION</td></tr>
        <tr>
          <td>2. SURNAME</td>
          <td>{{ $employee->emp_lname ?? 'N/A' }}</td>
      </tr>      
      <tr>
          <td>FIRST NAME</td>
          <td>{{ $employee->emp_fname ?? 'N/A' }}</td>
      </tr>
      <tr>
          <td>MIDDLE NAME</td>
          <td>{{ $employee->emp_mname ?? 'N/A' }}</td>
      </tr>
      <tr>
          <td>NAME EXTENSION (JR., SR)</td>
          <td>{{ $employee->emp_xname ?? 'N/A' }}</td>
      </tr>
      <tr>
          <td>3. DATE OF BIRTH (mm/dd/yyyy)</td>
          <td>{{$employee->emp_dob ?? 'N/A'}}</td>
      </tr>
      <tr>
          <td>4. PLACE OF BIRTH</td>
          <td>{{$employee->emp_pob ?? 'N/A'}}</td>
      </tr>
      <tr>
          <td>5. SEX</td>
          <td>
              <input type="radio" id="male" name="sex" value="male" {{ strtolower($emp_sexes) == 'male' ? 'checked' : '' }} readonly> Male
              <input type="radio" id="female" name="sex" value="female" {{ strtolower($emp_sexes) == 'female' ? 'checked' : '' }} readonly> Female
          </td>
      </tr>
      <tr>
          <td>6. CIVIL STATUS</td>
          <td>
              <input type="checkbox" id="single" name="civil_status" value="single" {{ strtolower($emp_civstats) == 'single' ? 'checked' : '' }} readonly> Single
              <input type="checkbox" id="married" name="civil_status" value="married" {{ strtolower($emp_civstats) == 'married' ? 'checked' : '' }} readonly> Married
              <input type="checkbox" id="widowed" name="civil_status" value="widowed" {{ strtolower($emp_civstats) == 'widowed' ? 'checked' : '' }} readonly> Widowed
              <input type="checkbox" id="separated" name="civil_status" value="separated" {{ strtolower($emp_civstats) == 'separated' ? 'checked' : '' }} readonly> Separated
              <input type="checkbox" id="other" name="civil_status" value="other" {{ !in_array(strtolower($emp_civstats), ['single', 'married', 'widowed', 'separated']) ? 'checked' : '' }} readonly> Other/s:
              {{ !in_array(strtolower($emp_civstats), ['single', 'married', 'widowed', 'separated']) ? $emp_civstats : '' ?? 'N/A'}}
          </td>
      </tr>
      <tr>
          <td>7. HEIGHT (m)</td>
          <td>{{$employee->emp_height ?? 'N/A'}}</td>
      </tr>
      <tr>
          <td>8. WEIGHT (kg)</td>
          <td>{{$employee->emp_weight ?? 'N/A'}}</td>
      </tr>
      <tr>
          <td>9. BLOOD TYPE</td>
          <td>{{$emp_bloods ?? 'N/A'}}</td>
      </tr>
      <tr>
          <td>10. GSIS ID NO.</td>
          <td>{{$employee->emp_height ?? 'N/A'}}</td>
      </tr>
      <tr>
          <td>11. PAG-IBIG ID NO.</td>
          <td>{{$employee->emp_height ?? 'N/A'}}</td>
      </tr>
      <tr>
          <td>12. PHILHEALTH ID NO.</td>
          <td>{{$employee->emp_height ?? 'N/A'}}</td>
      </tr>
      <tr>
          <td>13. SSS ID NO.</td>
          <td>{{$employee->emp_height ?? 'N/A'}}</td>
      </tr>
      <tr>
          <td>14. TIN ID NO.</td>
          <td>{{$employee->emp_height ?? 'N/A'}}</td>
      </tr>
      <tr>
          <td>15. AGENCY EMPLOYEE NO.</td>
          <td>{{$employee->emp_agency ?? 'N/A'}}</td>
      </tr>
      <tr>
          <td>16. CITIZENSHIP</td>
          <td>
              <input type="radio" id="filipino" name="citizenship" value="filipino"> Filipino
              <input type="radio" id="dual_citizenship" name="citizenship" value="dual_citizenship"> Dual Citizenship
              <p>If holder of dual citizenship, please indicate details.</p>
              <input type="checkbox" id="by_birth" name="dual_citizenship_details" value="by_birth"> by birth
              <input type="checkbox" id="by_naturalization" name="dual_citizenship_details" value="by_naturalization"> by naturalization
              <label for="country">Pls. indicate country:</label>
              <input type="text" id="country" name="country" />
          </td>
      </tr>
      <tr>
        <td>17. RESIDENTIAL ADDRESS</td>
        <td>
            <table style="width: 100%; border-collapse: collapse;">
                <tr>
                    <td><strong>House/Block/Lot No. Street</strong></td>
                    <td>{{$emp_address->emp_house ?? 'N/A'}}</td>
                </tr>
                <tr>
                    <td><strong>Subdivision/Village</strong></td>
                    <td>{{$emp_address->emp_subd ?? 'N/A'}}</td>
                </tr>
                <tr>
                    <td><strong>Barangay</strong></td>
                    <td>{{$emp_brgies ?? 'N/A'}}</td>
                </tr>
                <tr>
                    <td><strong>City/Municipality</strong></td>
                    <td>{{$emp_cities ?? 'N/A'}}</td>
                </tr>
                <tr>
                    <td><strong>Province</strong></td>
                    <td>{{$emp_provinces ?? 'N/A'}}</td>
                </tr>
                <tr>
                    <td><strong>ZIP CODE</strong></td>
                    <td>{{$emp_address->emp_zip ?? 'N/A'}}</td>
                </tr>
        </td>
    </tr>
    
      <tr>
          <td>18. PERMANENT ADDRESS</td>
          <td>
              <input type="text" id="permanent_address" name="permanent_address" /><br />
              <label for="permanent_street">House/Block/Lot No. Street</label>
              <input type="text" id="permanent_street" name="permanent_street" /><br />
              <label for="permanent_village">Subdivision/Village</label>
              <input type="text" id="permanent_village" name="permanent_village" /><br />
              <label for="permanent_barangay">Barangay</label>
              <input type="text" id="permanent_barangay" name="permanent_barangay" /><br />
              <label for="permanent_city_municipality">City/Municipality</label>
              <input type="text" id="permanent_city_municipality" name="permanent_city_municipality" /><br />
              <label for="permanent_province">Province</label>
              <input type="text" id="permanent_province" name="permanent_province" /><br />
              <label for="permanent_zip_code">ZIP CODE</label>
              <input type="text" id="permanent_zip_code" name="permanent_zip_code" />
          </td>
      </tr>
      <tr>
          <td>19. TELEPHONE NO.</td>
          <td>{{$employee->emp_telnum ?? 'N/A'}}</td>
      </tr>
      <tr>
          <td>20. MOBILE NO.</td>
          <td>{{$employee->emp_cnum ?? 'N/A'}}</td>
      </tr>
      <tr>
          <td>21. E-MAIL ADDRESS (if any)</td>
          <td>{{$emp_acc->empmail ?? 'N/A'}}</td>
      </tr>
      </table>
      <table>
      <tr><td>II. FAMILY BACKGROUND</td></tr>
            <tr>
                <td>22. SPOUSE'S SURNAME</td>
                <td>{{$emp_spouse->spouse_lname ?? 'N/A'}}</td>
            </tr>
            <tr>
                <td>FIRST NAME</td>
                <td>{{$emp_spouse->spouse_fname ?? 'N/A'}}</td>
            </tr>
            <tr>
                <td>MIDDLE NAME</td>
                <td>{{$emp_spouse->spouse_mname ?? 'N/A'}}</td>
            </tr>
            <tr>
                <td>OCCUPATION</td>
                <td>{{$emp_spouse->spouse_occup ?? 'N/A'}}</td>
            </tr>
            <tr>
                <td>EMPLOYER/BUSINESS NAME</td>
                <td>{{$emp_spouse->spouse_office ?? 'N/A'}}</td>
            </tr>
            <tr>
                <td>BUSINESS ADDRESS</td>
                <td>{{$emp_spouse->spouse_busadd ?? 'N/A'}}</td>
            </tr>
            <tr>
                <td>TELEPHONE NO.</td>
                <td>{{$emp_spouse->spouse_tel ?? 'N/A'}}</td>
            </tr>
            <tr>
                <td>24. FATHER'S SURNAME</td>
                <td>{{$emp_father->father_lname ?? 'N/A'}}</td>
            </tr>
            <tr>
                <td>FIRST NAME</td>
                <td>{{$emp_father->father_fname ?? 'N/A'}}</td>
            </tr>
            <tr>
                <td>MIDDLE NAME</td>
                <td>{{$emp_father->father_mname ?? 'N/A'}}</td>
            </tr>
            <tr>
                <td>25. MOTHER'S MAIDEN NAME</td>
            </tr>
            <tr>
                <td>SURNAME</td>
                <td>{{$emp_mother->mother_lname ?? 'N/A'}}</td>
            </tr>
            <tr>
                <td>FIRST NAME</td>
                <td>{{$emp_mother->mother_fname ?? 'N/A'}}</td>
            </tr>
            <tr>
                <td>MIDDLE NAME</td>
                <td>{{$emp_mother->mother_mname ?? 'N/A'}}</td>
            </tr>

            <tr>
                <td>23. NAME of CHILDREN  (Write full name and list all)</td>
                <td> DATE OF BIRTH (mm/dd/yyyy) </td>
            </tr>
            @php
          $childs = App\Models\emp_child::where('emp_count', $employee->emp_count)->get();
          @endphp
          @foreach($childs as $emp_child)
              <tr>
                  <td>{{$emp_child->child_fname . ' ' . 
                    $child_mname_initial . ' ' . 
                    $emp_child->child_lname . ' ' . 
                    $emp_child->child_xname ?? 'N/A'}}</td>
                  <td>{{$emp_child->child_dob ?? 'N/A'}}</td>
              </tr>
            @endforeach
      </table>
      <table>
            <tr><td>III. EDUCATIONAL BACKGROUND</td></tr>
          <tr>
              <th>LEVEL</th>
              <th>NAME OF SCHOOL (Write in full)</th>
              <th colspan="2">PERIOD OF ATTENDANCE</th>
              <th>HIGHEST LEVEL/ UNITS EARNED</th>
              <th>YEAR GRADUATED</th>
              <th>SCHOLARSHIP/ACADEMIC HONORS RECEIVED</th>
          </tr>
          <tr>
            <td></td> {{-- Empty cell to align with the LEVEL header --}}
            <td></td> {{-- Empty cell to align with the NAME OF SCHOOL header --}}
            <td>FROM</td> {{-- Label for "FROM" --}}
            <td>TO</td>   {{-- Label for "TO" --}}
            <td></td> {{-- Empty cell to align with YEAR GRADUATED header --}}
            <td></td> {{-- Empty cell to align with SCHOLARSHIP/ACADEMIC HONORS RECEIVED header --}}
        </tr>
          @php
          $educations = App\Models\Education::where('empid', $employee->empid)->get();
          @endphp
          @foreach($educations as $education)
              @if($education->educ_level == 1)
              <tr>
                  <td>ELEMENTARY</td>
                  <td>{{$education->educ_school ?? 'N/A'}}</td>
                  <td>{{$education->educ_from ?? 'N/A'}}</td>
                  <td>{{$education->educ_year_grad ?? 'N/A'}}</td>
                  <td>{{$education->educ_hl_earned ?? 'N/A'}}</td>
                  <td>{{$education->educ_year_grad ?? 'N/A'}}</td>
                  <td>{{$education->educ_academic_honor ?? 'N/A'}}</td>
              </tr>
              @elseif($education->educ_level == 2)
              <tr>
                  <td>SECONDARY</td>
                  <td>{{$education->educ_school ?? 'N/A'}}</td>
                  <td>
                      From: {{$education->educ_from ?? 'N/A'}} To: {{$education->educ_year_grad ?? 'N/A'}}
                  </td>
                  <td>{{$education->educ_hl_earned ?? 'N/A'}}</td>
                  <td>{{$education->educ_year_grad ?? 'N/A'}}</td>
                  <td>{{$education->educ_academic_honor ?? 'N/A'}}</td>
              </tr>
              @elseif(in_array($education->educ_level, [7, 8, 9]))
              <tr>
                  <td>VOCATIONAL / TRADE COURSE</td>
                  <td>{{$education->educ_school ?? 'N/A'}}</td>
                  <td>
                      From: {{$education->educ_from ?? 'N/A'}} To: {{$education->educ_year_grad ?? 'N/A'}}
                  </td>
                  <td>{{$education->educ_hl_earned ?? 'N/A'}}</td>
                  <td>{{$education->educ_year_grad ?? 'N/A'}}</td>
                  <td>{{$education->educ_academic_honor ?? 'N/A'}}</td>
              </tr>
              @elseif(in_array($education->educ_level, [3, 4]))
              <tr>
                  <td>COLLEGE</td>
                  <td>{{$education->educ_school ?? 'N/A'}}</td>
                  <td>
                      From: {{$education->educ_from ?? 'N/A'}} To: {{$education->educ_year_grad ?? 'N/A'}}
                  </td>
                  <td>{{$education->educ_hl_earned ?? 'N/A'}}</td>
                  <td>{{$education->educ_year_grad ?? 'N/A'}}</td>
                  <td>{{$education->educ_academic_honor ?? 'N/A'}}</td>
              </tr>
              @elseif(in_array($education->educ_level, [5, 6]))
              <tr>
                  <td>GRADUATE STUDIES</td>
                  <td>{{$education->educ_school ?? 'N/A'}}</td>
                  <td>
                      From: {{$education->educ_from ?? 'N/A'}} To: {{$education->educ_year_grad ?? 'N/A'}}
                  </td>
                  <td>{{$education->educ_hl_earned ?? 'N/A'}}</td>
                  <td>{{$education->educ_year_grad ?? 'N/A'}}</td>
                  <td>{{$education->educ_academic_honor ?? 'N/A'}}</td>
              </tr>
              @endif
          @endforeach
          <p style="color: red">(Continue on separate sheet if necessary)</p>
          <tr>
            <td>SIGNATURE</td> <td></td>
            <td>DATE</td> <td>{{ date('F d, Y') }}</td>
          </tr>
      </table>
    </div>
</body>
</html>
