<?php

namespace App\Http\Controllers;

use App\Http\Requests\JobRequest;
use App\Models\Job;
use App\Services\MyJobService;
use Illuminate\Http\Request;

// 我發布的職缺列表
class MyJobController extends Controller
{
    private $myJobService;
    private $jobModel;

    public function __construct(Job $job,MyJobService $myJobService){
        $this->jobModel = $job;
        $this->myJobService = $myJobService;
        // 各頁面(功能)的權限檢查
        $this->authorizeResource(Job::class, 'job');
    }

    // 覆蓋預設的resourceAbilityMap函數
    protected function resourceAbilityMap(){
        return [
            'index'      => 'viewAnyEmployer',
            'create'     => 'create',
            'store'      => 'create',
        ];
    }

    /**
     * 顯示發布的職缺列表 by userId
     */
    public function index()
    {
        $result = $this->myJobService->get_job_by_employerId();

        return view('my_job.index', $result);
    }

    /**
     * 顯示新增職缺資料頁面
     */
    public function create()
    {
        return view('my_job.create',[
            'experience' => $this->jobModel::$experience,
            'category' => $this->jobModel::$category
        ]); 
    }

    /**
     * 新增職缺資料
     */
    public function store(JobRequest $request)
    {
        $result = $this->myJobService->create_job_by_employerId($request->validated());

        return redirect()->route('my-jobs.index')->with(
            $result ? 'success' :  'error',
            __($result ? 'Job created successfully.' : 'Job create fail.')
        );
    }

    /**
     * 顯示修改職缺資料頁面 & 取得特定職缺資料 by id
     */
    public function edit(Job $myJob)
    {
        $this->authorize('update', $myJob);
        return view('my_job.edit',[
            'job' => $myJob,
            'experience' => $this->jobModel::$experience,
            'category' => $this->jobModel::$category
        ]);
    }

    /**
     * 更新職缺資料 by id
     */
    public function update(JobRequest $request, string $id)
    {
        $myJob = $this->myJobService->get_job_by_id($id);
        $this->authorize('update', $myJob);

        $data = $request->validated();
        $result = $this->myJobService->update_job_by_id($myJob,$data);


        return redirect()->route('my-jobs.index')->with(
            $result ? 'success' :  'error',
            __($result ? 'Job updated successfully.' : 'Job update fail.')
        );
    }

    /**
     * 刪除職缺資料 by id
     */
    public function destroy($id)
    {
        $myJob = $this->myJobService->get_job_by_id($id);
        $this->authorize('delete', $myJob);

        $result = $this->myJobService->delete_data_by_id($myJob);
       
        return redirect()->route('my-jobs.index')->with(
            $result ? 'success' :  'error',
            __($result ? 'Job deleted.' : 'Job delete fail.')
        );
    }

    // 恢復已刪除資料 by id
    public function restore(string $id)
    {
        $myJob = $this->myJobService->get_job_by_id($id);
        $this->authorize('restore', $myJob);

        $result = $this->myJobService->restore_data_by_id($myJob);
        
        return redirect()->route('my-jobs.index')->with(
            $result ? 'success' :  'error',
            __($result ? 'Job restored.' : 'Job restore fail.')
        );
    }
}
