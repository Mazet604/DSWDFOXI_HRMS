<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Page 3</title>
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
            <tr><td>VI. VOLUNTARY WORK OR INVOLVEMENT IN CIVIC / NON-GOVERNMENT / PEOPLE / VOLUNTARY ORGANIZATION/S</td></tr>
            <tr>
              <th> 29. NAME & ADDRESS OF ORGANIZATION (Write in full)</th>
              <th colspan="2">INCLUSIVE DATES (mm/dd/yyyy)</th>
              <th>NUMBER OF HOURS</th>
              <th>POSITION / NATURE OF WORK</th>
          </tr>
          <tr>
            <td></td> {{-- Empty cell to align with the LEVEL header --}}
            <td>FROM</td> {{-- Empty cell to align with the NAME OF SCHOOL header --}}
            <td>TO</td> {{-- Label for "FROM" --}}
            <td></td>   {{-- Label for "TO" --}}
            <td></td> {{-- Empty cell to align with YEAR GRADUATED header --}}
        </tr>
        @php
            $emp_vol = App\Models\emp_voluntary::where('empid', $employee->empid)->get();
        @endphp
            @foreach($emp_vol as $emp_voluntary)
          <tr>
              <td>{{ ($emp_voluntary->vol_name ?? 'N/A') }} <br> {{($emp_voluntary->vol_add ?? 'N/A') }}</td>
              <td>{{$emp_voluntary->vol_fr ?? 'N/A'}}</td>
              <td>{{$emp_voluntary->vol_to ?? 'N/A'}}</td>
              <td>{{$emp_voluntary->vol_hrs ?? 'N/A'}}</td>
              <td>{{$emp_voluntary->vol_pos  ?? 'N/A'}}</td>
          </tr>
          @endforeach
          <p style="color: red">(Continue on separate sheet if necessary)</p>
        </table>
        <table>
          <tr><td>VII. LEARNING AND DEVELOPMENT (L&D) INTERVENTIONS/TRAINING PROGRAMS ATTENDED</td></tr> 
            <tr>
              <th>30. TITLE OF LEARNING AND DEVELOPMENT INTERVENTIONS/TRAINING PROGRAMS (Write in full)</th>
              <th colspan="2">INCLUSIVE DATES (mm/dd/yyyy)</th>
              <th>NUMBER OF HOURS</th>
              <th>Type of LD (Managerial/ Supervisory/Technical/etc)</th>
              <th>CONDUCTED/ SPONSORED BY (Write in full)</th>
          </tr>
          <tr>
            
            <td></td>
            <td>From</td>
            <td>To</td> 
            <td></td>  
            <td></td>
            <td></td>
        </tr>
        @php
            $emp_learndev = App\Models\emp_learning::where('empid', $employee->empid)->get();
        @endphp
            @foreach($emp_learndev as $emp_learning)
          <tr>
              <td>{{$emp_learning->learn_title ?? 'N/A'}}</td>
              <td>{{$emp_learning->learn_fr ?? 'N/A'}}</td>
              <td>{{$emp_learning->learn_to ?? 'N/A'}}</td>
              <td>{{$emp_learning->learn_hrs ?? 'N/A'}}</td>
              <td>{{$emp_learning->learn_type  ?? 'N/A'}}</td>
              <td>{{$emp_learning->learn_con  ?? 'N/A'}}</td>
          </tr>
          @endforeach
          <tr><td>VIII.  OTHER INFORMATION</td></tr> 
          <tr>
            <th colspan="2"> 31. SPECIAL SKILLS and HOBBIES NON-ACADEMIC DISTINCTIONS / RECOGNITION                                                                                                                                              
             (Write in full)</th>
            <th>33. MEMBERSHIP IN ASSOCIATION/ORGANIZATION (Write in full)</th>
        </tr>
              @php
              $emp_skill = App\Models\emp_skills::where('empid', $employee->empid)->get();
              $emp_organization = App\Models\emp_org::where('empid', $employee->empid)->get();
              $emp_recognition = App\Models\emp_recog::where('empid', $employee->empid)->get();
              $max_count = max($emp_skill->count(), $emp_organization->count(), $emp_recognition->count());
          @endphp
          
          @for ($i = 0; $i < $max_count; $i++)
              <tr>
                  <td>{{ $emp_skill[$i]->skill ?? 'N/A' }}</td>
                  <td>{{ $emp_recognition[$i]->recog_name ?? 'N/A' }}</td>
                  <td>{{ $emp_organization[$i]->org_name ?? 'N/A' }}</td>
              </tr>
          @endfor  
        <p style="color: red">(Continue on separate sheet if necessary)</p>
        <tr>
          <td>SIGNATURE</td> <td></td>
          <td>DATE</td> <td>{{ date('F d, Y') }}</td>
        </tr>
          </table>
    </div>
</body>
</html>
