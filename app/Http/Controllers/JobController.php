<?php

namespace App\Http\Controllers;

use App\Models\Job;
use App\Services\JobService;

// 職缺列表
class JobController extends Controller
{
    private $jobService;

    public function __construct(JobService $jobService){
        $this->jobService = $jobService;
        // 各頁面(功能)的權限檢查
        $this->authorizeResource(Job::class, 'job', [
            'except' => ['index'],
        ]);
    }
    
    /**
     * 顯示職缺列表(條件查詢)
     */
    public function index()
    {
        $filters = request()->only(
            'search',
            'min_salary',
            'max_salary',
            'experience',
            'category'
        );
        $result = $this->jobService->get_jobs_for_filter($filters);
        return view('job.index', $result);
    }

    /**
     * 顯示特定職缺詳細資料 by id 
     */
    public function show(Job $job)
    {
        $result = $this->jobService->get_jobs_by_id($job);
        return view('job.show', $result);
    }
}
