<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

// roles
// 1. 

Route::get('/', function () {
    return view('welcome');
})->name('welcome');

/*
|--------------------------------------------------------------------------
| Admin Routes
|--------------------------------------------------------------------------
*/

Route::prefix('admin')->group(function (){
    Route::get('/', 'Backend\AuthController@login')->name('adminLogin');
    Route::post('/admin-login', 'Backend\AuthController@loginPost')->name('adminLoginPost');

    Route::middleware(['admin'])->group(function () {
        Route::get('dashboard', 'Backend\DashboardController@dashboard')->name('adminDashboard');
        Route::post('filterCountry', 'Backend\DashboardController@filterCountry')->name('filterCountryDashboard');
        Route::post('profile-update', 'Backend\AuthController@adminUpdateProfile')->name('adminUpdateProfile');

        Route::group(['prefix' => 'countries'], function () {
            Route::get('/', 'Backend\CountryController@listCountries')->name('listCountries');
            Route::get('/create', 'Backend\CountryController@createCountry')->name('createCountry');
            Route::post('/store', 'Backend\CountryController@storeCountry')->name('storeCountry');
            Route::get('/edit/{id}', 'Backend\CountryController@editCountry')->name('editCountry');
            Route::post('/update', 'Backend\CountryController@updateCountry')->name('updateCountry');
            Route::post('/delete', 'Backend\CountryController@deleteCountry')->name('deleteCountry');
        });

        Route::group(['prefix' => 'cities'], function () {
            Route::get('/', 'Backend\CityController@listCities')->name('listCities');
            Route::get('/create', 'Backend\CityController@createCity')->name('createCity');
            Route::post('/store', 'Backend\CityController@storeCity')->name('storeCity');
            Route::get('/edit/{id}', 'Backend\CityController@editCity')->name('editCity');
            Route::post('/update', 'Backend\CityController@updateCity')->name('updateCity');
            Route::post('/delete', 'Backend\CityController@deleteCity')->name('deleteCity');
        });

        Route::group(['prefix' => 'candidates'], function () {
            Route::get('/', 'Backend\CandidateController@list')->name('listCandidate');
        });

        Route::group(['prefix' => 'statistics'], function () {
            Route::get('/', 'Backend\StatisticController@list')->name('listStatistics');
            Route::post('filterCountry', 'Backend\StatisticController@filterCountry')->name('filterCountry');
        });

        Route::group(['prefix' => 'employee-business-categories'], function () {
            Route::get('/', 'Backend\EmployeeBusinessCategoryController@listCategories')->name('listCategories');
            Route::get('/create', 'Backend\EmployeeBusinessCategoryController@createCategory')->name('createCategory');
            Route::post('/store', 'Backend\EmployeeBusinessCategoryController@storeCategory')->name('storeCategory');
            Route::get('/edit/{id}', 'Backend\EmployeeBusinessCategoryController@editCategory')->name('editCategory');
            Route::post('/update', 'Backend\EmployeeBusinessCategoryController@updateCategory')->name('updateCategory');
            Route::post('/delete', 'Backend\EmployeeBusinessCategoryController@deleteCategory')->name('deleteCategory');
        });

        Route::group(['prefix' => 'candidate-job-locations'], function () {
            Route::get('/', 'Backend\JobCandidateLocationController@listLocations')->name('listLocations');
            Route::get('/create', 'Backend\JobCandidateLocationController@createLocation')->name('createLocation');
            Route::post('/store', 'Backend\JobCandidateLocationController@storeLocation')->name('storeLocation');
            Route::get('/edit/{id}', 'Backend\JobCandidateLocationController@editLocation')->name('editLocation');
            Route::post('/update', 'Backend\JobCandidateLocationController@updateLocation')->name('updateLocation');
            Route::post('/delete', 'Backend\JobCandidateLocationController@deleteLocation')->name('deleteLocation');
        });

        Route::group(['prefix' => 'job-career-levels'], function () {
            Route::get('/', 'Backend\JobCareerLevelController@listCareerLevels')->name('listCareerLevels');
            Route::get('/create', 'Backend\JobCareerLevelController@createCareerLevel')->name('createCareerLevel');
            Route::post('/store', 'Backend\JobCareerLevelController@storeCareerLevel')->name('storeCareerLevel');
            Route::get('/edit/{id}', 'Backend\JobCareerLevelController@editCareerLevel')->name('editCareerLevel');
            Route::post('/update', 'Backend\JobCareerLevelController@updateCareerLevel')->name('updateCareerLevel');
            Route::post('/delete', 'Backend\JobCareerLevelController@deleteCareerLevel')->name('deleteCareerLevel');
        });

        Route::group(['prefix' => 'job-qualifications'], function () {
            Route::get('/', 'Backend\JobQualificationController@listQualifications')->name('listQualifications');
            Route::get('/create', 'Backend\JobQualificationController@createQualification')->name('createQualification');
            Route::post('/store', 'Backend\JobQualificationController@storeQualification')->name('storeQualification');
            Route::get('/edit/{id}', 'Backend\JobQualificationController@editQualification')->name('editQualification');
            Route::post('/update', 'Backend\JobQualificationController@updateQualification')->name('updateQualification');
            Route::post('/delete', 'Backend\JobQualificationController@deleteQualification')->name('deleteQualification');
        });

        Route::group(['prefix' => 'job-salary-ranges'], function () {
            Route::get('/', 'Backend\JobSalaryRangeController@listSalaryRanges')->name('listSalaryRanges');
            Route::get('/create', 'Backend\JobSalaryRangeController@createSalaryRange')->name('createSalaryRange');
            Route::post('/store', 'Backend\JobSalaryRangeController@storeSalaryRange')->name('storeSalaryRange');
            Route::get('/edit/{id}', 'Backend\JobSalaryRangeController@editSalaryRange')->name('editSalaryRange');
            Route::post('/update', 'Backend\JobSalaryRangeController@updateSalaryRange')->name('updateSalaryRange');
            Route::post('/delete', 'Backend\JobSalaryRangeController@deleteSalaryRange')->name('deleteSalaryRange');
        });

        Route::group(['prefix' => 'job-types'], function () {
            Route::get('/', 'Backend\JobTypeController@listJobTypes')->name('listJobTypes');
            Route::get('/create', 'Backend\JobTypeController@createJobType')->name('createJobType');
            Route::post('/store', 'Backend\JobTypeController@storeJobType')->name('storeJobType');
            Route::get('/edit/{id}', 'Backend\JobTypeController@editJobType')->name('editJobType');
            Route::post('/update', 'Backend\JobTypeController@updateJobType')->name('updateJobType');
            Route::post('/delete', 'Backend\JobTypeController@deleteJobType')->name('deleteJobType');
        });

        Route::group(['prefix' => 'languages'], function () {
            Route::get('/', 'Backend\LanguageController@listLanguages')->name('listLanguages');
            Route::get('/create', 'Backend\LanguageController@createLanguage')->name('createLanguage');
            Route::post('/store', 'Backend\LanguageController@storeLanguage')->name('storeLanguage');
            Route::get('/edit/{id}', 'Backend\LanguageController@editLanguage')->name('editLanguage');
            Route::post('/update', 'Backend\LanguageController@updateLanguage')->name('updateLanguage');
            Route::post('/delete', 'Backend\LanguageController@deleteLanguage')->name('deleteLanguage');
        });

        Route::group(['prefix' => 'nationalities'], function () {
            Route::get('/', 'Backend\NationalityController@listNationalities')->name('listNationalities');
            Route::get('/create', 'Backend\NationalityController@createNationality')->name('createNationality');
            Route::post('/store', 'Backend\NationalityController@storeNationality')->name('storeNationality');
            Route::get('/edit/{id}', 'Backend\NationalityController@editNationality')->name('editNationality');
            Route::post('/update', 'Backend\NationalityController@updateNationality')->name('updateNationality');
            Route::post('/delete', 'Backend\NationalityController@deleteNationality')->name('deleteNationality');
        });

        Route::group(['prefix' => 'job-skills'], function () {
            Route::get('/', 'Backend\SkillController@listJobSkills')->name('listJobSkills');
            Route::get('/create', 'Backend\SkillController@createJobSkill')->name('createJobSkill');
            Route::post('/store', 'Backend\SkillController@storeJobSkill')->name('storeJobSkill');
            Route::get('/edit/{id}', 'Backend\SkillController@editJobSkill')->name('editJobSkill');
            Route::post('/update', 'Backend\SkillController@updateJobSkill')->name('updateJobSkill');
            Route::post('/delete', 'Backend\SkillController@deleteJobSkill')->name('deleteJobSkill');
        });

        Route::group(['prefix' => 'manage-users'], function () {
            Route::get('/', 'Backend\UserController@listUsers')->name('listUsers');
            Route::get('/create', 'Backend\UserController@createUser')->name('createUser');
            Route::post('/store', 'Backend\UserController@storeUser')->name('storeUser');
            Route::get('/edit/{id}', 'Backend\UserController@editUser')->name('editUser');
            Route::get('/view/{id}', 'Backend\UserController@viewUser')->name('viewUser');
            Route::post('/update', 'Backend\UserController@updateUser')->name('updateUser');
            Route::post('/delete', 'Backend\UserController@deleteUser')->name('deleteUser');
        });

        Route::group(['prefix' => 'manage-packages'], function () {
            Route::get('/', 'Backend\PackageController@list')->name('listPackages');
            Route::get('/create', 'Backend\PackageController@create')->name('createPackage');
            Route::post('/store', 'Backend\PackageController@store')->name('storePackage');
            Route::get('/edit/{id}', 'Backend\PackageController@edit')->name('editPackage');
            Route::get('/view/{id}', 'Backend\PackageController@view')->name('viewPackage');
            Route::post('/update/{id}', 'Backend\PackageController@update')->name('updatePackage');
            Route::post('/delete', 'Backend\PackageController@delete')->name('deletePackage');
        });

        Route::group(['prefix' => 'manage-advertisement'], function () {
            Route::get('/', 'Backend\AdvertiseController@list')->name('listAdvertise');
            Route::get('/create', 'Backend\AdvertiseController@create')->name('createAdvertise');
            Route::post('/store', 'Backend\AdvertiseController@store')->name('storeAdvertise');
            Route::get('/edit/{id}', 'Backend\AdvertiseController@edit')->name('editAdvertise');
            Route::get('/view/{id}', 'Backend\AdvertiseController@view')->name('viewAdvertise');
            Route::post('/update/{id}', 'Backend\AdvertiseController@update')->name('updateAdvertise');
            Route::post('/delete', 'Backend\AdvertiseController@delete')->name('deleteAdvertise');
            Route::post('/delete/image', 'Backend\AdvertiseController@deleteImage')->name('deleteAdvertiseImage');
            Route::post('/status', 'Backend\AdvertiseController@status')->name('statusAdvertise');
        });

        Route::group(['prefix' => 'manage-job-approval'], function () {
            Route::get('/list', 'Backend\JobApprovalController@list')->name('listJobApproval');
            Route::post('/job/status', 'Backend\JobApprovalController@status')->name('jobStatus');
            Route::get('/job-detail/{id}', 'Backend\JobApprovalController@job_details')->name('employerJobDetail');
        });

        Route::group(['prefix' => 'financial'], function () {
            Route::get('/list', 'Backend\FinancialController@list')->name('listFinancial');
        //  Route::post('/job/status', 'Backend\FinancialController@status')->name('jobStatus');
            Route::post('filterCountry', 'Backend\FinancialController@filterCountry')->name('filterCountryFinancial');
        });

    });
});

/*
|--------------------------------------------------------------------------
| SubAdmin Routes
|--------------------------------------------------------------------------
*/

Route::prefix('sub-admin')->group(function (){

    Route::middleware(['subAdmin'])->group(function () {
        Route::get('dashboard', 'Backend\SubAdminController@dashboard')->name('subAdminDashboard');
        Route::post('profile-update', 'Backend\AuthController@subAdminUpdateProfile')->name('subAdminUpdateProfile');

        Route::group(['prefix' => 'manage-users'], function () {
            Route::get('/', 'Backend\SubAdminController@listUsers')->name('subAdminListUsers');
            Route::get('/create', 'Backend\SubAdminController@createUser')->name('subAdminCreateUser');
            Route::post('/store', 'Backend\SubAdminController@storeUser')->name('subAdminStoreUser');
            Route::get('/edit/{id}', 'Backend\SubAdminController@editUser')->name('subAdminEditUser');
            Route::get('/view/{id}', 'Backend\SubAdminController@viewUser')->name('subAdminViewUser');
            Route::post('/update', 'Backend\SubAdminController@updateUser')->name('subAdminUpdateUser');
            Route::post('/delete', 'Backend\SubAdminController@deleteUser')->name('subAdminDeleteUser');
        });

        Route::group(['prefix' => 'candidates'], function () {
            Route::get('/', 'Backend\SubAdminController@candidateList')->name('subAdminListCandidate');
        });

        Route::group(['prefix' => 'manage-job-approval'], function () {
            Route::get('/list', 'Backend\SubAdminController@jobApprovalList')->name('subAdminListJobApproval');
            Route::post('/job/status', 'Backend\SubAdminController@jobApprovalStatus')->name('subAdminJobStatus');
            Route::get('/job-details/{id}', 'Backend\SubAdminController@job_details')->name('employerJobDetailSubAdmin');
        });

        Route::group(['prefix' => 'financial'], function () {
            Route::get('/list', 'Backend\SubAdminController@financialList')->name('subAdminListFinancial');
//            Route::post('/job/status', 'Backend\SubAdminController@financialStatus')->name('subAdminJobStatus');
        });

        Route::group(['prefix' => 'statistics'], function () {
            Route::get('/', 'Backend\SubAdminController@statisticsList')->name('subAdminListStatistics');
//            Route::post('filterCountry', 'Backend\SubAdminController@filterCountry')->name('filterCountry');
        });

        Route::group(['prefix' => 'manage-advertisement'], function () {
            Route::get('/', 'Backend\SubAdminController@advertiseList')->name('subAdminListAdvertise');
            Route::get('/create', 'Backend\SubAdminController@advertiseCreate')->name('subAdminCreateAdvertise');
            Route::post('/store', 'Backend\SubAdminController@advertiseStore')->name('subAdminStoreAdvertise');
            Route::get('/edit/{id}', 'Backend\SubAdminController@advertiseEdit')->name('subAdminEditAdvertise');
            Route::get('/view/{id}', 'Backend\SubAdminController@advertiseView')->name('subAdminViewAdvertise');
            Route::post('/update/{id}', 'Backend\SubAdminController@advertiseUpdate')->name('subAdminUpdateAdvertise');
            Route::post('/delete', 'Backend\SubAdminController@advertiseDelete')->name('subAdminDeleteAdvertise');
            Route::post('/delete/image', 'Backend\SubAdminController@advertiseDeleteImage')->name('subAdminDeleteAdvertiseImage');
            Route::post('/status', 'Backend\SubAdminController@adevertiseStatus')->name('subAdminStatusAdvertise');
        });

    });

});


Auth::routes(['login'=>true]);

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
