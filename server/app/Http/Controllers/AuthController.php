<?php

namespace App\Http\Controllers;

use App\Http\Requests\UserLoginRequest;
use App\Services\UserService;
use App\Services\AuthService;
use App\Http\Requests\UserStoreRequest;
use App\Http\Responses\ApiSuccessResponse;
use App\Http\Responses\ApiErrorResponse;
use Illuminate\Http\Response;
use Throwable;


class AuthController extends Controller
{

    protected $userService;
    protected $authService;

    /**
     * Create a new controller instance.
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
            $user = $this->userService->create($request->all());
            return new ApiSuccessResponse(
                $user,
                ['message' => 'User was created successfully'],
                Response::HTTP_CREATED
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
    public function login(UserLoginRequest $request)
    {
        try {
            $credentials = $request->get(['email', 'password']);
            $token = $this->authService->login($credentials);
            return new ApiSuccessResponse(
                $data,
                ['message' => 'Logged successfuly'],
                Response::HTTP_OK
            );
        } catch(Throwable $exception) {
            return new ApiErrorResponse(
                'An error occurred while trying to loggin',
                $exception
            );
        }
    }


    
}
