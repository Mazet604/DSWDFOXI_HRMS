<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Page 2</title>
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
            <tr><td>IV. CIVIL SERVICE ELIGIBILITY</td></tr>
            <tr>
              <th>27. CAREER SERVICE/ RA 1080 (BOARD/ BAR) UNDER 
                SPECIAL LAWS/ CES/ CSEE                                                    
                BARANGAY ELIGIBILITY / DRIVER'S LICENSE</th>
              <th>RATING (If Applicable)</th>
              <th>DATE OF 
                EXAMINATION / 
                CONFERMENT</th>
              <th> PLACE OF EXAMINATION / CONFERMENT</th>
              <th colspan="2"> LICENSE (if applicable)</th>
          </tr>
          <tr>
            <td></td> {{-- Empty cell to align with the LEVEL header --}}
            <td></td> {{-- Empty cell to align with the NAME OF SCHOOL header --}}
            <td></td> {{-- Label for "FROM" --}}
            <td></td>   {{-- Label for "TO" --}}
            <td>NUMBER</td> {{-- Empty cell to align with YEAR GRADUATED header --}}
            <td>Date of Validity</td> {{-- Empty cell to align with SCHOLARSHIP/ACADEMIC HONORS RECEIVED header --}}
        </tr>
        @php
            $emp_eli = App\Models\emp_eligibility::where('empid', $employee->empid)->get();
        @endphp
            @foreach($emp_eli as $emp_eligibility)
          <tr>
              <td>{{$emp_eligibility->eli_service ?? 'N/A'}}</td>
              <td>{{$emp_eligibility->eli_rating ?? 'N/A'}}</td>
              <td>{{$emp_eligibility->eli_doe ?? 'N/A'}}</td>
              <td>{{$emp_eligibility->eli_poe ?? 'N/A'}}</td>
              <td>{{$emp_eligibility->eli_license_no  ?? 'N/A'}}</td>
              <td>{{$emp_eligibility->eli_licen_valid  ?? 'N/A'}}</td>
          </tr>
          @endforeach
          <p style="color: red">(Continue on separate sheet if necessary)</p>
        </table>
        <table>
          <tr><td>V. Work Experience</td></tr> 
            <tr>
              <th colspan="2">28. INCLUSIVE DATES 
                (mm/dd/yyyy)</th>
              <th>POSITION TITLE (Write in full/Do not abbreviate)</th>
              <th>DEPARTMENT / AGENCY / OFFICE / COMPANY (Write in full/Do not abbreviate)</th>
              <th>MONTHLY SALARY</th>
              <th> SALARY/ JOB/  PAY GRADE (if applicable)& STEP (Format "00-0")/INCREMENT</th>
              <th>STATUS OF  APPOINTMENT</th>
              <th>GOV'T SERVICE (Yes/No)</th>
          </tr>
          <tr>
            <td>From</td>
            <td>To</td> 
            <td></td>
            <td></td>  
            <td></td> 
            <td></td> 
            <td></td>
        </tr>
        @php
            $emp_working = App\Models\emp_work::where('empid', $employee->empid)->get();
        @endphp
            @foreach($emp_working as $emp_work)
          <tr>
              <td>{{$emp_work->workfr ?? 'N/A'}}</td>
              <td>{{$emp_work->workto ?? 'N/A'}}</td>
              <td>{{$emp_work->work_pos ?? 'N/A'}}</td>
              <td>{{$emp_work->work_dept ?? 'N/A'}}</td>
              <td>{{$emp_work->work_salary  ?? 'N/A'}}</td>
              <td>{{$emp_work->work_salarygrade  ?? 'N/A'}}</td>
              <td>{{$emp_work->work_stat  ?? 'N/A'}}</td>
              <td>{{$emp_work->work_gov  ?? 'N/A'}}</td>
          </tr>
          @endforeach
          <p style="color: red">(Continue on separate sheet if necessary)</p>
          <tr>
              <td>SIGNATURE</td> <td></td>
              <td>DATE</td> <td>{{ date('F d, Y') }}</td>
            </tr>
          </table>
        </table>
    </div>
</body>
</html>
