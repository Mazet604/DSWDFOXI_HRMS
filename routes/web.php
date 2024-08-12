<?php

use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Session;
use Inertia\Inertia;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\Auth\AuthenticatedSessionController;
use App\Http\Controllers\OTPController;
use App\Helpers\EmailHelper;
use App\Http\Controllers\BackgroundController;
use App\Http\Controllers\OtherInfoController;
use App\Http\Controllers\EmployeeController;
use App\Http\Controllers\EmpAccController;
use App\Http\Controllers\DropDownControllers;
use App\Http\Controllers\AddressController;


Route::get('/', function () {
    return Inertia::render('Login', [
        'canLogin' => Route::has('login'),
        'canRegister' => Route::has('register'),
        'laravelVersion' => Application::VERSION,
        'phpVersion' => PHP_VERSION,
    ]);
})->name('login');

Route::post('login', [AuthenticatedSessionController::class, 'store'])->name('login');

Route::get('otp', function () {
    return Inertia::render('Auth/OTP');
})->name('otp.form');

Route::post('send-otp', [AuthenticatedSessionController::class, 'sendOtp'])->name('otp.send');
Route::post('otp', [OTPController::class, 'verifyOTP'])->name('otp.verify');

Route::middleware('auth')->group(function () {
    Route::get('/dashboard', function () {
        if (!Session::get('otp_verified')) {
            return redirect()->route('otp.form');
        }
        return Inertia::render('Dashboard');
    })->name('dashboard');

    Route::get('/background', function () {
        if (!Session::get('otp_verified')) {
            return redirect()->route('otp.form');
        }
        return Inertia::render('Background');
    })->name('background');

    Route::get('/otherinfo', function () {
        if (!Session::get('otp_verified')) {
            return redirect()->route('otp.form');
        }
        return Inertia::render('OtherInfo');
    })->name('otherinfo');

    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    //new
    Route::get('/employee/fullname', [EmployeeController::class, 'getEmployee']);
    Route::get('/employee/PersonalInfo', [EmployeeController::class, 'getPersonalInfo']);
    Route::get('/employee/SecurityandContact', [EmployeeController::class, 'getSecurityandContact']);
    Route::patch('/employee/updateProfile', [EmployeeController::class, 'updateProfile']);
    Route::get('/emp_acc/empuser', [EmpAccController::class, 'getCreds']);
    Route::get('/emp_acc/empuser', [EmpAccController::class, 'getCreds']);
    Route::get('/dropdown/sex-options', [DropDownControllers::class, 'getSexOptions']);
    Route::get('/dropdown/civilstatus-options', [DropDownControllers::class, 'getCivilStatusOptions']);
    Route::get('/dropdown/bloodtype-options', [DropDownControllers::class, 'getBloodTypeOptions']);
    Route::get('/dropdown/ext-options', [DropDownControllers::class, 'getExtOptions']);

    Route::get('/employee/Address', [AddressController::class, 'getAddress']);
    Route::get('/employee/selectedregion-options', [AddressController::class, 'getSelectedRegionOptions']);
    Route::get('/employee/selectedprovince-options', [AddressController::class, 'getSelectedProvinceOptions']);
    /*Route::get('/emp_address/selectedcity-options', [AddressController::class, 'getSelectedCityOptions']);
    Route::get('/emp_address/selectedbarangay-options', [AddressController::class, 'getSelectedBarangayOptions']);*/

    Route::get('/education/EducationData', [BackgroundController::class, 'getEducationData']);
    Route::post('/education/AddEducationData', [BackgroundController::class, 'addEducationData']);
    Route::get('/emp_org/OrganizationData', [BackgroundController::class, 'getOrganizationData']);
    Route::post('/emp_org/AddOrganizationData', [BackgroundController::class, 'addOrganizationData']);
    Route::get('/emp_work/WorkExperienceData', [BackgroundController::class, 'getWorkExperienceData']);
    Route::post('/emp_work/AddWorkExperienceData', [BackgroundController::class, 'addWorkExperienceData']);
    Route::get('/emp_skills/SkillsData', [BackgroundController::class, 'getSkillsData']);
    Route::post('/emp_skills/AddSkillData', [BackgroundController::class, 'addSkillData']);
    Route::get('/emp_reference/ReferencesData', [BackgroundController::class, 'getReferencesData']);
    Route::post('/emp_reference/AddReferenceData', [BackgroundController::class, 'addReferenceData']);
    Route::get('/family-data', [BackgroundController::class, 'getFamilyData']);
    Route::post('/emp_family/UpdateFamilyData', [BackgroundController::class, 'updateFamilyData']);
    Route::get('/emp_child/ChildData', [BackgroundController::class, 'getChildData']);
    Route::post('/emp_child/AddChildData', [BackgroundController::class, 'addChildData']);


    Route::get('/emp_eligibility/CSEligibilityData', [OtherInfoController::class, 'getCSEligibilityData']);
    Route::get('/emp_voluntary/VoluntaryWorkData', [OtherInfoController::class, 'getVoluntaryWorkData']);
    Route::get('/emp_learning/LearndevData', [OtherInfoController::class, 'getLearndevData']);
    Route::get('/emp_recog/RecogdistData', [OtherInfoController::class, 'getRecogdistData']);
    Route::get('/sssId/SSSId', [OtherInfoController::class, 'getSSSId']);
    Route::get('/pagIbigId/PagIbigId', [OtherInfoController::class, 'getPagIbigId']);
    Route::get('/gsisId/GSISId', [OtherInfoController::class, 'getGSISId']);
    Route::get('/philHealthId/PhilHealthId', [OtherInfoController::class, 'getPhilHealthId']);
    Route::get('/tinId/TINId', [OtherInfoController::class, 'getTINId']);
    Route::post('/emp_eligibility/AddCSEligibility', [OtherInfoController::class, 'addCSEligibility']);
    Route::post('/emp_voluntary/AddVoluntaryWork', [OtherInfoController::class, 'addVoluntaryWork']);
    Route::post('/emp_learning/AddLearndev', [OtherInfoController::class, 'addLearndev']);
    Route::post('/emp_recog/AddRecogdist', [OtherInfoController::class, 'addRecogdist']);



});

require __DIR__.'/auth.php';

Route::get('/test-email', function () {
    $otp = EmailHelper::generateOTP();
    EmailHelper::sendOTPEmail('your-email@example.com', $otp);
    return 'Test email sent';
});
