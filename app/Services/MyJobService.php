<?php

namespace App\Services;

use App\Http\Resources\JobResource;
use App\Models\Job;
use App\Models\JobApplication;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class MyJobService{

    private $jobModel;

    public function __construct(Job $job){
        $this->jobModel = $job;
    }

    // 取得所有職缺資料 by userId,employerId
    public function get_job_by_employerId(){
        // 取得操作使用者資料
        $user = auth()->user();
        // 取得應徵紀錄及對應的職缺資料 by user
        $jobs = $user->employer
                ->jobs()->with(['employer', 'jobApplications', 'jobApplications.user'])
                ->withTrashed()
                ->orderBy('deleted_at', 'ASC')
                ->orderBy('created_at', 'DESC')
                ->get();
        return [
            'jobs' => $jobs,
            'experience' => $this->jobModel::$experience,
            'category' => $this->jobModel::$category
        ];
    }

    // 建立職缺資料 by employerId
    public function create_job_by_employerId($data){
        $user = auth()->user();
        $result = $user->employer->jobs()->create($data);
        return $result;
    }

    // 取得特定職缺資料 by id
    public function get_job_by_id($id){
        return $this->jobModel::withTrashed()->find($id);
    }

    // 修改職缺資料 by id
    public function update_job_by_id($job,$data){
        $result = $job->update($data);
        return $result;
    }

    // 刪除應徵紀錄 by id
    public function delete_data_by_id($job): bool{
        $result = $job->delete();
        return $result;
    }

    // 恢復已刪除資料 by id
    public function restore_data_by_id($job): bool{
        $result = $job->restore();
        return $result;
    }
    
}