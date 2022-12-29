<?php

namespace App\Http\Controllers;

use App\Services\AuthService;
use App\Services\UserService;
use App\Http\Requests\UserStoreRequest;
use App\Http\Requests\Auth\AuthLoginRequest;
use App\Http\Requests\Auth\ForgotPasswordRequest;
use App\Http\Requests\Auth\RecoveryPasswordRequest;
use App\Http\Responses\ApiSuccessResponse;
use App\Http\Responses\ApiErrorResponse;
//use App\Http\Responses\ApiResponse;
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
        try {
            $credentials = $request->get(['email', 'password']);
            $response = $this->authService->login($credentials);
            return \ApiResponse::httpCode(200)->message('Succesful logged in.')->data($response)->success();
        } catch(Throwable $exception) {
            return new ApiErrorResponse(
                'An error occurred while performing the request.',
                $exception
            );
        }
    }


    /**
     * User forgot password.
     *
     * @param Request $request
     * @return Response
     */
    public function forgotPassword(ForgotPasswordRequest $request)
    {
        try {
            $email = $request->get('email');
            $response = $this->authService->forgotPassword($email);
            return \ApiResponse::success($response['message']);
        } catch(Throwable $exception) {
            return \ApiResponse::failed($exception);
        }
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
            return new ApiSuccessResponse(
                $response['code'],
                $response['content']
            );
        } catch(Throwable $exception) {
            return new ApiErrorResponse(
                'An error occurred while performing the request.',
                $exception
            );
        }
    }


}
