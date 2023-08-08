<?php

namespace App\Services;

use App\Http\Resources\JobResource;
use App\Models\Job;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class JobService{

    private $jobModel;

    public function __construct(Job $job){
        $this->jobModel = $job;
    }

    // 取得職缺列表(條件查詢)
    public function get_jobs_for_filter($filters){
        DB::enableQueryLog();

        $jobs = $this->jobModel->with('employer')->filter($filters);
        $result = [
            'jobs' => JobResource::collection($jobs->paginate(10)),
            'count' => $jobs->count(),
            'experience' => $this->jobModel::$experience,
            'category' => $this->jobModel::$category
        ];

        Log::notice(print_r(DB::getQueryLog(), true));
        return $result;
    }

    // 取得特定職缺詳細資料 by id 
    public function get_jobs_by_id($job){
        DB::enableQueryLog();

        $job = $job->load([
            'employer.jobs' => function ($query) use ($job){
                    $query->where('id', '!=', $job->id);
                }
            ]
        );
        $result = [
            'job' => $job,
            'experience' => $this->jobModel::$experience,
            'category' => $this->jobModel::$category
        ];

        Log::notice(print_r(DB::getQueryLog(), true));
        return $result;
    }

    // 取得所有職缺資料 by userId,jobApplicationsId
    public function query_with_job($query){
        $result = $query->withCount('jobApplications')
                ->withAvg('jobApplications', 'expected_salary')
                ->withTrashed();
                
        return $result;
    }
}