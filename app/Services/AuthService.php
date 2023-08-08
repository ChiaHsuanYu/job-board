<?php

namespace App\Services;

use App\Models\User;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Hash;

class AuthService{

    private $userModel;

    public function __construct(User $user){
        $this->userModel = $user;
    }

    // 登入
    public function login($request){
        DB::enableQueryLog();
        // 檢查使用者帳號
        $user = User::where('email',$request->email)->first();
        // 檢查使用者密碼
        $result = [
            'status' => 0, 
            'msg' => 'The provided credentials are incorrect.'
        ];
        if(!$user){
            return $result;
        }
        if(!Hash::check($request->password, $user->password)){
            return $result;
        }
        // 創建token
        $user->token = $user->createToken('api-token')->plainTextToken;
        Log::notice(print_r(DB::getQueryLog(), true));

        return [
            'status' => 1,
            'data' => $user
        ];
    }

    // 登出
    public function logout($request){
        $del_result = $request->user()->tokens()->delete();

        if($del_result){
            $result = [
                'status' => 1,
                'msg' => 'Logged out successfully'
            ];
        }else{
            $result = [
                'status' => 0,
                'msg' => 'Log out fail'
            ];
        }
        return $result;
    }
}