<?php

namespace App\Http\Controllers;

use App\Services\AuthService;
use App\Services\UserService;
use App\Http\Requests\UserStoreRequest;
use App\Http\Requests\AuthLoginRequest;
use App\Http\Responses\ApiSuccessResponse;
use App\Http\Responses\ApiErrorResponse;
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
            return new ApiSuccessResponse(
                $response['code'],
                $response['status'],
                $response['message'],
                $response['data']
            );
        } catch(Throwable $exception) {
            return new ApiErrorResponse(
                'An error occurred while trying to create the user',
                $exception
            );
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
            return new ApiSuccessResponse(
                $response['code'],
                $response['status'],
                $response['message'],
                $response['data']
            );
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
    public function forgotPassword()
    {

    }


     /**
     * User recovery password.
     *
     * @param Request $request
     * @return Response
     */
    public function recoveryPassword()
    {

    }


}
