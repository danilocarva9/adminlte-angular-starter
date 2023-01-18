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

    protected $userService;

    /**
     * Create new controller instance
     *
     * @return void
     */
    public function __construct(
        UserService $userService
    )
    {
        $this->userService = $userService;
    }

    public function findById(Request $request, int $id)
    {
        $response = $this->userService->find($id);
        if($response['httpCode'] == Response::HTTP_OK){
            return \ApiResponse::httpCode($response['httpCode'])->data($response['data'])->success();
        }
        return \ApiResponse::httpCode($response['httpCode'])->message($response['message'])->failed();
    }


    public function findByIdAndUpdate()
    {

       // $this->userService->update()

    }

}
