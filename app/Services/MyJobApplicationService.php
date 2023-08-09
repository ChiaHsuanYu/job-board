<?php

namespace App\Services;

use App\Http\Resources\JobResource;
use App\Models\Job;
use App\Models\JobApplication;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class MyJobApplicationService{

    private $jobService;
    private $jobModel;
    private $jobApplicationModel;

    public function __construct(Job $job,JobApplication $jobApplication,JobService $jobService){
        $this->jobModel = $job;
        $this->jobApplicationModel = $jobApplication;
        $this->jobService = $jobService;
    }

    // 新增職缺申請資料 by userId
    public function create_job_application_by_userid($job,$data,$file){
        $user = auth()->user();
        $path = $file->store('cvs', 'private');
        
        $result = $job->jobApplications()->create([
            'user_id' => $user->id,
            'expected_salary' => $data['expected_salary'],
            'cv_path' => $path
        ]);

        return $result;
    }

    // 取得應徵紀錄及對應的職缺資料 by userId
    public function get_job_application_by_userid(){
        // 取得操作使用者資料
        $user = auth()->user();
        // 取得應徵紀錄及對應的職缺資料 by user
        $application_orm = $user->jobApplications()->with([
                            'job' => function($query){
                                    $this->jobService->query_with_job($query);
                                }, 
                            'job.employer'
                        ]);
        return [
            'applications' => $application_orm->latest()->get(),
            'experience' => $this->jobModel::$experience,
            'category' => $this->jobModel::$category
        ];
    }

    // 刪除應徵紀錄 by id
    public function delete_data_by_id($id): bool{
        $result = $this->jobApplicationModel::withTrashed()->find($id)->delete();
        
        return $result;
    }
}