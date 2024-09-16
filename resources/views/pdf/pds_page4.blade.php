<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Page 4</title>
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
        <table>
            <tr>
              <td> 34. Are you related by consanguinity or affinity to the appointing or recommending authority, or to the chief of bureau or office or to the person who has immediate supervision over you in the Office, Bureau or Department where you will be appointed,
                <br><br>
              a. within the third degree?
              <br><br>
              b. within the fourth degree (for Local Government Unit - Career Employees)?
              </td>
              <td>
                <br><br>
                <input type="checkbox" id="yes" name="related" value="yes" {{ strtolower($emp_otherinfo->other_34a) == 'yes' ? 'checked' : '' }} readonly> Yes
                <input type="checkbox" id="no" name="related" value="no" {{ strtolower($emp_otherinfo->other_34a) == 'no' ? 'checked' : '' }} readonly> No
                <br>
                <input type="checkbox" id="yes" name="related" value="yes" {{ strtolower($emp_otherinfo->other_34b) == 'yes' ? 'checked' : '' }} readonly> Yes
                <input type="checkbox" id="no" name="related" value="no" {{ strtolower($emp_otherinfo->other_34b) == 'no' ? 'checked' : '' }} readonly> No
                <br>
                <p>If YES, give details:</p>
                <p style="text-decoration: underline;">{{$emp_otherinfo->other_34bif  ?? 'N/A'}}</p>
              </td>
            </tr>
            <tr>
              <td>
                  35. a. Have you ever been found guilty of any administrative offense?
                  <br><br>
                  If YES, give details:
                  <br><br>
                  b. Have you been criminally charged before any court?
                  <br><br>
                  If YES, give details:
                  <br><br>
                  Date Filed:
                  <br><br>
                  Status of Case/s:
              </td>
              <td>
                  <input type="checkbox" id="yes_admin_offense" name="admin_offense" value="yes" {{ strtolower($emp_otherinfo->other_35a) == 'yes' ? 'checked' : '' }} readonly> Yes
                  <input type="checkbox" id="no_admin_offense" name="admin_offense" value="no" {{ strtolower($emp_otherinfo->other_35a) == 'no' ? 'checked' : '' }} readonly> No
                  <br>
                  <textarea name="admin_offense_details" rows="3" cols="30" readonly>{{ $emp_otherinfo->other_35aif ?? 'N/A' }}</textarea>
                  <br>
                  <input type="checkbox" id="yes_criminal_charge" name="criminal_charge" value="yes" {{ strtolower($emp_otherinfo->other_35b) == 'yes' ? 'checked' : '' }} readonly> Yes
                  <input type="checkbox" id="no_criminal_charge" name="criminal_charge" value="no" {{ strtolower($emp_otherinfo->other_35b) == 'no' ? 'checked' : '' }} readonly> No
                  <br>
                  <textarea name="criminal_charge_details" rows="3" cols="30" readonly>{{ $emp_otherinfo->other_35bif ?? 'N/A' }}</textarea>
                  <br>
                  Date Filed: <input type="text" name="date_filed" value="{{ $emp_otherinfo->other_35bfiled ?? 'N/A' }}" readonly>
                  <br>
                  Status of Case/s: <input type="text" name="case_status" value="{{ $emp_otherinfo->other_35stat ?? 'N/A' }}" readonly>
              </td>
          </tr>
          
          <tr>
              <td>
                  36. Have you ever been convicted of any crime or violation of any law, decree, ordinance or regulation by any court or tribunal?
                  <br><br>
                  If YES, give details:
              </td>
              <td>
                  <input type="checkbox" id="yes_convicted" name="convicted" value="yes" {{ strtolower($emp_otherinfo->other_36) == 'yes' ? 'checked' : '' }} readonly> Yes
                  <input type="checkbox" id="no_convicted" name="convicted" value="no" {{ strtolower($emp_otherinfo->other_36) == 'no' ? 'checked' : '' }} readonly> No
                  <br>
                  <textarea name="convicted_details" rows="3" cols="30" readonly>{{ $emp_otherinfo->other_36if ?? 'N/A' }}</textarea>
              </td>
          </tr>
          
          <tr>
              <td>
                  37. Have you ever been separated from the service in any of the following modes: resignation, retirement, dropped from the rolls, dismissal, termination, end of term, finished contract or phased out (abolition) in the public or private sector?
                  <br><br>
                  If YES, give details:
              </td>
              <td>
                  <input type="checkbox" id="yes_separated" name="separated" value="yes" {{ strtolower($emp_otherinfo->other_37) == 'yes' ? 'checked' : '' }} readonly> Yes
                  <input type="checkbox" id="no_separated" name="separated" value="no" {{ strtolower($emp_otherinfo->other_37) == 'no' ? 'checked' : '' }} readonly> No
                  <br>
                  <textarea name="separated_details" rows="3" cols="30" readonly>{{ $emp_otherinfo->other_37if ?? 'N/A' }}</textarea>
              </td>
          </tr>
          
          <tr>
              <td>
                  38. a. Have you ever been a candidate in a national or local election held within the last year (except Barangay election)?
                  <br><br>
                  b. Have you resigned from the government service during the three (3)-month period before the last election to promote/actively campaign for a national or local candidate?
                  <br><br>
                  If YES, give details:
              </td>
              <td>
                  <input type="checkbox" id="yes_election_candidate" name="election_candidate" value="yes" {{ strtolower($emp_otherinfo->other_38a) == 'yes' ? 'checked' : '' }} readonly> Yes
                  <input type="checkbox" id="no_election_candidate" name="election_candidate" value="no" {{ strtolower($emp_otherinfo->other_38a) == 'no' ? 'checked' : '' }} readonly> No
                  <br>
                  <input type="checkbox" id="yes_resigned_campaign" name="resigned_campaign" value="yes" {{ strtolower($emp_otherinfo->other_38b) == 'yes' ? 'checked' : '' }} readonly> Yes
                  <input type="checkbox" id="no_resigned_campaign" name="resigned_campaign" value="no" {{ strtolower($emp_otherinfo->other_38b) == 'no' ? 'checked' : '' }} readonly> No
                  <br>
                  <textarea name="election_candidate_details" rows="3" cols="30" readonly>{{ $emp_otherinfo->other_38aif ?? 'N/A' }}</textarea>
                  <br>
                  <textarea name="resigned_campaign_details" rows="3" cols="30" readonly>{{ $emp_otherinfo->other_38bif ?? 'N/A' }}</textarea>
              </td>
          </tr>
          
          <tr>
              <td>
                  39. Have you acquired the status of an immigrant or permanent resident of another country?
                  <br><br>
                  If YES, give details (country):
              </td>
              <td>
                  <input type="checkbox" id="yes_immigrant" name="immigrant" value="yes" {{ strtolower($emp_otherinfo->other_39) == 'yes' ? 'checked' : '' }} readonly> Yes
                  <input type="checkbox" id="no_immigrant" name="immigrant" value="no" {{ strtolower($emp_otherinfo->other_39) == 'no' ? 'checked' : '' }} readonly> No
                  <br>
                  <input type="text" name="immigrant_country" value="{{ $emp_otherinfo->other_39if ?? 'N/A' }}" readonly>
              </td>
          </tr>
          
          <tr>
              <td>
                  40. Pursuant to: (a) Indigenous People's Act (RA 8371); (b) Magna Carta for Disabled Persons (RA 7277); and (c) Solo Parents Welfare Act of 2000 (RA 8972), please answer the following items:
                  <br><br>
                  a. Are you a member of any indigenous group?
                  <br><br>
                  b. Are you a person with disability?
                  <br><br>
                  c. Are you a solo parent?
                  <br><br>
                  If YES, please specify:
              </td>
              <td>
                  <input type="checkbox" id="yes_indigenous" name="indigenous" value="yes" {{ strtolower($emp_otherinfo->other_40a) == 'yes' ? 'checked' : '' }} readonly> Yes
                  <input type="checkbox" id="no_indigenous" name="indigenous" value="no" {{ strtolower($emp_otherinfo->other_40a) == 'no' ? 'checked' : '' }} readonly> No
                  <br>
                  <input type="checkbox" id="yes_disability" name="disability" value="yes" {{ strtolower($emp_otherinfo->other_40b) == 'yes' ? 'checked' : '' }} readonly> Yes
                  <input type="checkbox" id="no_disability" name="disability" value="no" {{ strtolower($emp_otherinfo->other_40b) == 'no' ? 'checked' : '' }} readonly> No
                  <br>
                  <input type="checkbox" id="yes_solo_parent" name="solo_parent" value="yes" {{ strtolower($emp_otherinfo->other_40c) == 'yes' ? 'checked' : '' }} readonly> Yes
                  <input type="checkbox" id="no_solo_parent" name="solo_parent" value="no" {{ strtolower($emp_otherinfo->other_40c) == 'no' ? 'checked' : '' }} readonly> No
                  <br>
                  <textarea name="indigenous_details" rows="3" cols="30" readonly>{{ $emp_otherinfo->other_40aif ?? 'N/A' }}</textarea>
                  <br>
                  <textarea name="disability_details" rows="3" cols="30" readonly>{{ $emp_otherinfo->other_40bif ?? 'N/A' }}</textarea>
                  <br>
                  <textarea name="solo_parent_details" rows="3" cols="30" readonly>{{ $emp_otherinfo->other_40cif ?? 'N/A' }}</textarea>
              </td>
          </tr>
          <tr>
              <td>41. REFERENCES (Person not related by consanguinity or affinity to applicant /appointee)</td>
          </tr>
          <tr>
              <td>NAME</td>
              <td>ADDRESS </td>
              <td>TEL. NO.</td>
          </tr>
          @php
        $references = App\Models\emp_reference::where('empid', $employee->empid)->get();
        @endphp
        @foreach($references as $emp_reference)
            <tr>
                <td>{{$emp_reference->ref_fname . ' ' . 
                  $emp_reference->ref_mname . ' ' . 
                  $emp_reference->ref_lname . ' ' . 
                  $emp_reference->ref_xname ?? 'N/A'}}</td>
                <td>{{$emp_reference->ref_add ?? 'N/A'}}</td>
                <td>{{$emp_reference->ref_cnum ?? 'N/A'}}</td>
            </tr>
          @endforeach
          <td>
          <div class="declaration">
              <p>42. I declare under oath that I have personally accomplished this Personal Data Sheet which is a true, correct and complete statement pursuant to the provisions of pertinent laws, rules and regulations of the Republic of the Philippines. I authorize the agency head/authorized representative to verify/validate the contents stated herein. I agree that any misrepresentation made in this document and its attachments shall cause the filing of administrative/criminal cases against me.</p>
          </div>
          </td>
  
          <table class="id-table">
              <tr>
                  <td colspan="2">Government Issued ID (i.e.Passport, GSIS, SSS, PRC, Driver’s License, etc.)<br>PLEASE INDICATE ID Number and Date of Issuance</td>
                  <td rowspan="3" class="photo-box">
                  @if ($profilePictureBase64)
                  <img src="{{ $profilePictureBase64 }}" alt="Profile Picture" class="profile-picture">
                  @else
                      <p>No Profile Picture Available</p>
                  @endif
                  </td>
              </tr>
              <tr>
                  <td>IDLicense/Passport No. :</td>
                  <td>Date/Place of Issuance :</td>
              </tr>
              <tr>
                  <td colspan="2" class="signature-box">
                      <div>Signature (Sign inside the box)</div>
                      <div class="signature-area"></div>
                  </td>
              </tr>
          </table>
          <td>
          <div class="thumbmark-box">
              <div class="thumbmark-label">Right Thumbmark</div>
              <div class="thumbmark-area"></div>
          </div>
  
          <div class="oath-box">
              <p>SUBSCRIBED AND SWORN to before me this ________________ affiant exhibiting his/her validly issued government ID as indicated above.</p>
              <div class="administering-oath">
                  <div>Person Administering Oath</div>
              </div>
          </div>
      </div>
      </td>
          </table>
    </div>
</body>
</html>
