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

class AuthController extends Controller
{

    protected $userService;
    protected $authService;

    /**
     * Create new controller instance
     *
     * @return void
     */
    public function __construct(
        UserService $userService,
        AuthService $authService
    )
    {
        $this->userService = $userService;
        $this->authService = $authService;
    }

    /**
     * Register new user.
     *
     * @param Request $request
     * @return Response
     */
    public function register(UserStoreRequest $request)
    {
        try {
            $response = $this->userService->create($request->all());
            return \ApiResponse::created($response);
        } catch(Throwable $exception) {
            return \ApiResponse::failed($exception);
        }
    }

    /**
     * User login.
     *
     * @param Request $request
     * @return Response
     */
    public function login(AuthLoginRequest $request)
    {
        $response = $this->authService->login($request->get(['email', 'password']));
        if($response['httpCode'] == Response::HTTP_OK){
            return \ApiResponse::httpCode($response['httpCode'])->message($response['message'])->data($response['data'])->success();
        }
        return \ApiResponse::httpCode($response['httpCode'])->message($response['message'])->failed();
    }


    /**
     * User forgot password.
     *
     * @param Request $request
     * @return Response
     */
    public function forgotPassword(ForgotPasswordRequest $request)
    {
        
        $response = $this->authService->forgotPassword($request->get('email'));
        if($response['httpCode'] == Response::HTTP_OK){
            return \ApiResponse::success($response['message']);
        }
        return \ApiResponse::httpCode($response['httpCode'])->message($response['message'])->failed();
    }

     /**
     * User recovery password.
     *
     * @param Request $request
     * @return Response
     */
    public function recoveryPassword(RecoveryPasswordRequest $request)
    {
        try {
            $response = $this->authService->recoveryPassword($request->all());
            if($response['httpCode'] == Response::HTTP_OK){
                return \ApiResponse::success($response['message']);
            }
            return \ApiResponse::httpCode($response['httpCode'])->message($response['message'])->failed();
        } catch(Throwable $exception) {
            return \ApiResponse::failed($exception);
        }
    }


}
