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

    // User Controller routes
    Route::post('send-otp', 'UserController@sendOTP');
    Route::post('verify-otp', 'UserController@verifyOTP');
    Route::post('reset-password', 'UserController@resetPassword');
});

Route::group(['middleware' => 'auth:api', 'namespace' => 'API'], function(){

    // conversation routes here.
    Route::prefix('conversation')->group(function () {
        Route::post('/search-user', 'ConversationController@searchUser')->name('searchUser');
        Route::post('/send-message', 'ConversationController@sendMessage')->name('sendMessage');
        Route::post('/list', 'ConversationController@getConversationList')->name('getConversationList');
        Route::post('/get-chat', 'ConversationController@getConversationChat')->name('getConversationChat');
        Route::post('/is_read', 'ConversationController@checkreadMessage')->name('checkReadMessage');
        Route::post('/read_message', 'ConversationController@readMessage')->name('ReadMessage');
        Route::post('/delete', 'ConversationController@delete_conversation')->name('DeleteConversation');
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
    Route::post('/remove-shortlisted-applicants', 'EmployerController@removeShortListed');
    Route::post('/remove-savelisted-applicants', 'EmployerController@removeSaveListed');
    Route::post('/remove-appliedlisted-applicants', 'EmployerController@removeAppliedListed');
    Route::post('/move-to-applied-listed', 'EmployerController@moveToAppliedListed');
    
    // User Controller routes
    Route::post('upload-employer-profile-image', 'UserController@uploadProfileImage');
    Route::post('get-user-profile', 'UserController@getUserInfo');
    Route::post('update-user-info', 'UserController@updateUserInfo');
    Route::post('get-user-notification', 'UserController@getNotification');
    Route::post('read-user-notification', 'UserController@readNotification');
    Route::post('remove-user-notification', 'UserController@removeNotification');

    // EmployeeContrller 
    Route::post('/applied', 'EmployeeController@apply_job');
    Route::post('/applied-jobs-list', 'EmployeeController@applied_jobs_list');
    Route::post('/employee-add-experience', 'EmployeeController@add_experience');
    Route::post('/employee-remove-experience', 'EmployeeController@remove_experience');
    Route::post('/employee-get-experience', 'EmployeeController@get_experience');
    Route::post('/employee-search-job', 'EmployeeController@search_job');
    Route::post('/employee-delete-savedjob', 'EmployeeController@delete_saved_jobs');
    Route::post('/employee-delete-applied-job', 'EmployeeController@delete_applied_jobs');

    // JobController 
    Route::post('/all-job', 'JobController@all_job');
    Route::post('/employee-saved-job', 'JobController@employee_saved_job');
    Route::post('/employee-get-saved-job', 'JobController@employee_get_saved_job');
    Route::post('/post_job', 'JobController@post_job');
    Route::post('/update-job', 'JobController@update_job');
    Route::post('/remove-job', 'JobController@remove_job');

});