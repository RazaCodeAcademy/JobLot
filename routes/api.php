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

// Route::middleware('auth:api')->get('/user', function (Request $request) {
//     return $request->user();
// });

Route::post('login', 'API\UserController@login');
Route::post('sign-up-employer', 'API\UserController@register');
Route::post('business-categories', 'API\EmployerController@businessCategories');
Route::post('states', 'API\EmployerController@states');

Route::group(['middleware' => 'auth:api'], function(){
    Route::post('logout', 'API\UserController@logout');
    Route::post('candidate_personal_detail', 'API\CandidateController@candidate_personal_detail');
    Route::post('/candidate_education_insert', 'API\CandidateController@candidate_education_insert')->name('candidate_education_insert');
    Route::post('/candidate_experience_insert', 'API\CandidateController@candidate_experience_insert')->name('candidate_experience_insert');
    Route::post('/editPersonalEducation', 'API\CandidateController@editPersonalEducation')->name('editPersonalEducation');
    Route::get('/candidate_education_list', 'API\CandidateController@candidate_education_list')->name('candidate_education_list');
    Route::get('/candidate_experience_list', 'API\CandidateController@candidate_experience_list')->name('candidate_experience_list');
    Route::get('/list_of_jobs', 'API\CandidateController@list_of_jobs')->name('list_of_jobs');
    Route::get('/get_single_job_info', 'API\CandidateController@get_single_job_info')->name('get_single_job_info');
    Route::post('/countries', 'API\CandidateController@countries')->name('countries');
    Route::post('/nationalities', 'API\CandidateController@nationalities')->name('nationalities');
    Route::post('/candidate_all_information', 'API\CandidateController@candidate_all_information');
    Route::post('/candidate_applied_vacancies', 'API\CandidateController@candidate_applied_vacancies');
    Route::post('/candidate_delete_applied_vacancies', 'API\CandidateController@candidate_delete_applied_vacancies');
    Route::post('/candidate_update_personal_information', 'API\CandidateController@candidate_update_personal_information');
    Route::post('/candidate_update_education', 'API\CandidateController@candidate_update_education');
    Route::post('/candidate_update_experience', 'API\CandidateController@candidate_update_experience');
    Route::post('/candidate_delete_education', 'API\CandidateController@candidate_delete_education');
    Route::post('/candidate_delete_experience', 'API\CandidateController@candidate_delete_experience');
    Route::post('/candidate_search_jobs', 'API\CandidateController@candidate_search_jobs');
    Route::post('/apply_job', 'API\CandidateController@apply_job');
    Route::post('/skills', 'API\CandidateController@skills')->name('skills');
    Route::post('/degree_list', 'API\CandidateController@degree_list');
    Route::post('/candidate_update_about', 'API\CandidateController@candidate_update_about');
    Route::post('/candidate_job_preference', 'API\CandidateController@candidate_job_preference');
    Route::post('/languages', 'API\CandidateController@languages');
    Route::post('/business_categories', 'API\CandidateController@business_categories');
});
