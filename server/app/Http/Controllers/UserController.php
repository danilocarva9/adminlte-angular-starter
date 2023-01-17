<?php

namespace App\Http\Controllers;

use App\Services\AuthService;
use App\Services\UserService;
use App\Http\Requests\UserStoreRequest;
use App\Http\Requests\Auth\AuthLoginRequest;
use App\Http\Requests\Auth\ForgotPasswordRequest;
use App\Http\Requests\Auth\RecoveryPasswordRequest;
use Illuminate\Http\Response;
use Throwable;
use Illuminate\Http\Request;

class UserController extends Controller
{

    // protected $userService;

    // /**
    //  * Create new controller instance
    //  *
    //  * @return void
    //  */
    // public function __construct(
    //     UserService $userService
    // )
    // {
    //     $this->userService = $userService;
    // }

    public function getUserProfileById(Request $request, int $id)
    {
        return \ApiResponse::success($id);
    }

}
