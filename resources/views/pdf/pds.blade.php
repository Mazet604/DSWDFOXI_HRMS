<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>PDS</title>
    <style>
        .profile-picture {
            width: 150px;
            height: 150px;
            object-fit: cover;
        }
    </style>
</head>
<body>
    <h1>Personal Data Sheet</h1>
    @if ($profilePictureBase64)
    <img src="{{ $profilePictureBase64 }}" alt="Profile Picture" class="profile-picture">
    @else
        <p>No Profile Picture Available</p>
    @endif
    <p>Name: {{ $fullName }}</p>
    <p>Position: {{ $employee->emp_position }}</p>
    <p>Birthday: {{ $employee->emp_dob }}</p>
    <p>Place of Birth: {{ $employee->emp_pob }}</p>
    <p>Sex: {{ $emp_sexes }}</p>
    <p>Civil Status: {{ $emp_civstat }}</p>
    <p>Height: {{ $employee->emp_height }}</p>
    <p>Weight: {{ $employee->emp_weight }}</p>
    <p>Blood Type: {{ $emp_bloods }}</p>
    <p>Mobile Number: {{ $employee->emp_cnum }}</p>
    <p>Telephone Number: {{ $employee->emp_telnum }}</p>
    <p>Email Address: {{ $emp_acc->empmail }}</p>

    <h2>Address</h2>
    <p>Permanent Address: {{ $emp_address->emp_region
        . ', ' .$emp_address->emp_prov
        . ', ' .$emp_address->emp_city
        . ', ' .$emp_address->emp_brgy
        . ' ' .$emp_address->emp_house
        . ' ' .$emp_address->emp_subd
        . ', ' .$emp_address->emp_zip }}</p>

    <p>Current Address: {{ $emp_address2->emp_region2
        . ', ' .$emp_address2->emp_prov2
        . ', ' .$emp_address2->emp_city2
        . ', ' .$emp_address2->emp_brgy2
        . ' ' .$emp_address2->emp_house2
        . ' ' .$emp_address2->emp_subd2
        . ', ' .$emp_address2->emp_zip2  }}</p>

</body>
</html>
