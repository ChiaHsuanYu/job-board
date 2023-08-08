<?php

namespace App\Http\Controllers;

use App\Services\MyJobApplicationService;
use Illuminate\Http\Request;

// 已被申請的職缺列表
class MyJobApplicationController extends Controller
{
    private $myJobApplicationService;

    public function __construct(MyJobApplicationService $myJobApplicationService){
        $this->myJobApplicationService = $myJobApplicationService;
    }
    /**
     * 顯示應徵紀錄 by userId
     */
    public function index()
    {
        $result = $this->myJobApplicationService->get_job_application_by_userid();
        return view('my_job_application.index', $result);
    }

    /**
     * 刪除應徵紀錄 by id
     */
    public function destroy($id)
    {
        $result = $this->myJobApplicationService->delete_data_by_id($id);
        
        return redirect()->back()->with(
            $result ? 'success' :  'Job application removed.',
            __($result ? 'Job application removed.' : 'Job application remove fail.')
        );
    }
}
