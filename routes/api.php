<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

// public api routes
Route::namespace('API')->group(function () {
    Route::post('login', 'UserController@login');
    Route::post('sign-up-employer', 'UserController@registerEmployer');
    Route::post('business-categories', 'EmployerController@businessCategories');
    Route::post('states', 'EmployerController@states');

    // Employee Controller routes
    Route::post('/register-employee', 'UserController@register_employee');

});

Route::group(['middleware' => 'auth:api', 'namespace' => 'API'], function(){

    // conversation routes here.
    Route::prefix('conversation')->group(function () {
        Route::post('/search-user', 'ConversationController@searchUser')->name('searchUser');
        Route::post('/send-message', 'ConversationController@sendMessage')->name('sendMessage');
        Route::post('/list', 'ConversationController@getConversationList')->name('getConversationList');
        Route::post('/get-chat', 'ConversationController@getConversationChat')->name('getConversationChat');
    }); 
    
    // Employer Controller routes
    Route::post('/job-list', 'EmployerController@jobList');
    Route::post('/latest-job', 'EmployerController@latestJobs');
    Route::post('/selected-job', 'EmployerController@selectedJobs');
    Route::post('/applied-job', 'EmployerController@appliedJobs');
    Route::post('/single-job-applicant-list', 'EmployerController@singleJobAplicantList');
    Route::post('/filter-applicants', 'EmployerController@filter_applicants');
    Route::post('/search-applicants', 'EmployerController@search_applicants');
    Route::post('/add-to-short-list-applicants', 'EmployerController@addToShortListEmployee');
    Route::post('/add-to-saved-list-applicants', 'EmployerController@addToSaveListEmployee');
    Route::post('/short-listed-applicants', 'EmployerController@shortListed');
    Route::post('/saved-listed-applicants', 'EmployerController@savedListed');

    Route::post('/post_job', 'EmployerController@postJob');
    
    // User Controller routes
    Route::post('upload-employer-profile-image', 'UserController@uploadProfileImage');
    Route::post('get-user-info', 'UserController@getUserInfo');
    Route::post('update-user-info', 'UserController@updateUserInfo');
    Route::post('get-user-notification', 'UserController@getNotification');
    Route::post('read-user-notification', 'UserController@readNotification');

    // EmployeeContrller 
    Route::post('/applied', 'EmployeeController@apply_job');
    Route::post('/applied-jobs-list', 'EmployeeController@applied_jobs_list');
    Route::post('/employee-add-experience', 'EmployeeController@add_experience');
    Route::post('/employee-get-experience', 'EmployeeController@get_experience');


    // JobController 
    Route::post('/all-job', 'JobController@all_job');
    Route::post('/employee-saved-job', 'JobController@employee_saved_job');
    Route::post('/employee-get-saved-job', 'JobController@employee_get_saved_job');


    // Route::post('/job-list', 'API\EmployerController@list_of_jobs')->name('list_of_jobs');

    // Route::post('logout', 'API\UserController@logout');
    // Route::post('candidate_personal_detail', 'API\CandidateController@candidate_personal_detail');
    // Route::post('/candidate_education_insert', 'API\CandidateController@candidate_education_insert')->name('candidate_education_insert');
    // Route::post('/candidate_experience_insert', 'API\CandidateController@candidate_experience_insert')->name('candidate_experience_insert');
    // Route::post('/editPersonalEducation', 'API\CandidateController@editPersonalEducation')->name('editPersonalEducation');
    // Route::get('/candidate_education_list', 'API\CandidateController@candidate_education_list')->name('candidate_education_list');
    // Route::get('/candidate_experience_list', 'API\CandidateController@candidate_experience_list')->name('candidate_experience_list');
    // Route::get('/get_single_job_info', 'API\CandidateController@get_single_job_info')->name('get_single_job_info');
    // Route::post('/countries', 'API\CandidateController@countries')->name('countries');
    // Route::post('/nationalities', 'API\CandidateController@nationalities')->name('nationalities');
    // Route::post('/candidate_all_information', 'API\CandidateController@candidate_all_information');
    // Route::post('/candidate_applied_vacancies', 'API\CandidateController@candidate_applied_vacancies');
    // Route::post('/candidate_delete_applied_vacancies', 'API\CandidateController@candidate_delete_applied_vacancies');
    // Route::post('/candidate_update_personal_information', 'API\CandidateController@candidate_update_personal_information');
    // Route::post('/candidate_update_education', 'API\CandidateController@candidate_update_education');
    // Route::post('/candidate_update_experience', 'API\CandidateController@candidate_update_experience');
    // Route::post('/candidate_delete_education', 'API\CandidateController@candidate_delete_education');
    // Route::post('/candidate_delete_experience', 'API\CandidateController@candidate_delete_experience');
    // Route::post('/candidate_search_jobs', 'API\CandidateController@candidate_search_jobs');
    // Route::post('/apply_job', 'API\CandidateController@apply_job');
    // Route::post('/skills', 'API\CandidateController@skills')->name('skills');
    // Route::post('/degree_list', 'API\CandidateController@degree_list');
    // Route::post('/candidate_update_about', 'API\CandidateController@candidate_update_about');
    // Route::post('/candidate_job_preference', 'API\CandidateController@candidate_job_preference');
    // Route::post('/languages', 'API\CandidateController@languages');
    // Route::post('/business_categories', 'API\CandidateController@business_categories');
});
