<?php

namespace App\Http\Middleware;

use Closure;

use DB;
use View;
use Auth;

class CommonMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        if(Auth::check()){
            $userId = Auth::user()->id;
            
            $profilePercentage = 0;

            $candidateAbout = DB::table('candidate_abouts')
            ->where('user_id', $userId)
            ->first();

            if(!empty($candidateAbout) || $candidateAbout != null){
                $profilePercentage = $profilePercentage + 10;
            }

            $candidateProfile = DB::table('candidate_profiles')
            ->where('user_id', $userId)
            ->first();

            if(!empty($candidateProfile) || $candidateProfile != null){
                $profilePercentage = $profilePercentage + 10;
            }

            $candidatePersonalInformation = DB::table('candidate_personal_informations')
            ->where('user_id', $userId)
            ->first();

            if(!empty($candidatePersonalInformation) || $candidatePersonalInformation != null){
                $profilePercentage = $profilePercentage + 20;
            }

            $candidateEducations = DB::table('candidate_educations')
            ->where('user_id', $userId)
            ->get();

            if(count($candidateEducations)>0){
                $profilePercentage = $profilePercentage + 10;
            }

            $candidateExperiences = DB::table('candidate_experiences')
            ->where('user_id', $userId)
            ->get();

            if(count($candidateExperiences)>0){
                $profilePercentage = $profilePercentage + 10;
            }

            $candidatePortfolios = DB::table('candidate_portfolios')
            ->where('user_id', $userId)
            ->get();

            if(count($candidatePortfolios)>0){
                $profilePercentage = $profilePercentage + 10;
            }

            $candidateProSkills = DB::table('candidate_professional_skills')
            ->where('user_id', $userId)
            ->get();

            if(count($candidateProSkills)>0){
                $profilePercentage = $profilePercentage + 10;
            }

            $candidateSkills = DB::table('candidate_skills')
            ->where('user_id', $userId)
            ->get();

            if(count($candidateSkills)>0){
                $profilePercentage = $profilePercentage + 10;
            }

            $candidateSpecialQualification = DB::table('candidate_special_qualifications')
            ->where('user_id', $userId)
            ->get();

            if(count($candidateSpecialQualification)>0){
                $profilePercentage = $profilePercentage + 10;
            }

        }
        else{
            $profilePercentage = 0;
        }
     
        View::share('profilePercentage', $profilePercentage);
        
        return $next($request);
    }
}
