<?php

namespace App\Http\Controllers;

use App\Models\Employer;
use Illuminate\Http\Request;

class EmployerController extends Controller
{
    public function __construct(){
        $this->authorizeResource(Employer::class);
    }
    /**
     * 顯示新增雇主身分頁面
     */
    public function create()
    {
        return view('employer.create');
    }

    /**
     * 新增雇主身分
     */
    public function store(Request $request)
    {
        $validation = $request->validate([
            'company_name' => 'required|min:3|unique:employers,company_name'
        ]);
        auth()->user()->employer()->create( $validation );

        return redirect()->route('jobs.index')
            ->with('success', __('You employer account was created!') );
    }
}
