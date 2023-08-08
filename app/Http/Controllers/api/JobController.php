<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use App\Models\Job;
use App\Services\JobService;
use App\Services\MyJobService;
use Illuminate\Http\Request;

class JobController extends Controller
{
    protected $jobService;
    protected $myJobService;


    public function __construct(JobService $jobService,MyJobService $myJobService){
        $this->jobService = $jobService;
        $this->myJobService = $myJobService;
        // 各頁面(功能)的權限檢查
        // $this->authorizeResource(Job::class, 'job', [
        //     'except' => ['index'],
        // ]);
        
    }

    // 覆蓋預設的resourceAbilityMap函數
    // protected function resourceAbilityMap(){
    //     return [
    //         'index'      => 'viewAnyEmployer',
    //     ];
    // }

    /**
     * 取得職缺列表(條件查詢)
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
        return response()->json([
            'status' => 1,
            'data' => $result
        ]);
    }


    /**
     * 顯示特定職缺詳細資料 by id 
     */
    public function show(Request $request)
    {
        $request->validate([
            'id' => 'required|int',
        ]);
        // 取得特定職缺資料
        $job = $this->myJobService->get_job_by_id($request->id);
        // 取得該職缺資料的所有相關資料
        $result = $this->jobService->get_jobs_by_id($job);

        return response()->json([
            'status' => 1,
            'data' => $result
        ]);
    }
}
