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
    return Inertia::render('Auth/OTP', [
        'context' => request()->get('context', 'login'),  // Default context is 'login'
        'otpSent' => request()->get('otpSent', false)    // Pass otpSent flag
    ]);
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
    Route::patch('/updateProfile', [EmployeeController::class, 'updateProfile']);
    Route::get('/emp_acc/empuser', [EmpAccController::class, 'getCreds']);
    Route::get('/dropdown/sex-options', [DropDownControllers::class, 'getSexOptions']);
    Route::get('/dropdown/civilstatus-options', [DropDownControllers::class, 'getCivilStatusOptions']);
    Route::get('/dropdown/bloodtype-options', [DropDownControllers::class, 'getBloodTypeOptions']);
    Route::get('/dropdown/ext-options', [DropDownControllers::class, 'getExtOptions']);
    Route::post('/upload-profile-picture', [EmployeeController::class, 'uploadProfilePicture']);
    Route::get('/get-profile-picture', [EmployeeController::class, 'getProfilePicture']);

    Route::get('/employee/Address', [AddressController::class, 'getAddress']);
    Route::patch('/updateAddress', [AddressController::class, 'updateAddress']);

    Route::get('/regions', [AddressController::class, 'getRegions']);
    Route::get('/provinces/{regionId}', [AddressController::class, 'getProvincesByRegion']);

    Route::get('/emp_father/Father', [BackgroundController::class, 'getFather']);
    Route::get('/emp_mother/Mother', [BackgroundController::class, 'getMother']);
    Route::get('/emp_spouse/Spouse', [BackgroundController::class, 'getSpouse']);
    Route::patch('/EmpFamily/updateFamilyData', [BackgroundController::class, 'updateFamilyData']);
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
    Route::get('/emp_child/ChildData', [BackgroundController::class, 'getChildData']);
    Route::post('/emp_child/AddChildData', [BackgroundController::class, 'addChildData']);

    Route::post('/emp_child/UpdateChildData', [BackgroundController::class, 'updateChildData']);
    Route::post('/education/UpdateEducationData', [BackgroundController::class, 'updateEducationData']);
    Route::post('/emp_org/UpdateOrganizationData', [BackgroundController::class, 'updateOrganizationData']);
    Route::post('/emp_work/UpdateWorkExperienceData', [BackgroundController::class, 'updateWorkExperienceData']);
    Route::post('/emp_skills/UpdateSkillsData', [BackgroundController::class, 'updateSkillsData']);
    Route::post('/emp_reference/UpdateReferencesData', [BackgroundController::class, 'updateReferencesData']);


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
