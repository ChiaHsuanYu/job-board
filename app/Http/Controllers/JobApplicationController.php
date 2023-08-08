<?php

namespace App\Http\Controllers;

use App\Models\Job;
use App\Services\MyJobApplicationService;
use Illuminate\Http\Request;

// 職缺申請
class JobApplicationController extends Controller
{
    private $myJobApplicationService;

    public function __construct(MyJobApplicationService $myJobApplicationService){
        $this->myJobApplicationService = $myJobApplicationService;
    }

    /**
     * 顯示職缺申請頁面
     */
    public function create(Job $job)
    {
        $this->authorize('apply', $job);
        return view('job_application.create', [
            'job' => $job,
            'experience' => Job::$experience,
            'category' => Job::$category
        ]);
    }

    /**
     * 新增職缺申請資料
     */
    public function store(Job $job, Request $request)
    {
        $this->authorize('apply', $job);
        $validatedData = $request->validate([
            'expected_salary' => 'required|min:1|max:1000000',
            'cv' => 'required|file|mimes:pdf|max:3072'
        ]);
        $file = $request->file('cv');

        $result = $this->myJobApplicationService->create_job_application_by_userid($validatedData,$file);

        return redirect()->route('jobs.show')->with(
            $result ? 'success' :  'error',
            __($result ? 'Job application submitted.' : 'Job application store fail.')
        );
    }
}
