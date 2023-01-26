<?php

namespace App\Http\Controllers;

use App\Services\UserService;
use App\Http\Requests\UserUpdateRequest;
use Illuminate\Http\Response;
use Illuminate\Http\Request;
use Throwable;

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


    public function updateUserProfile(UserUpdateRequest $request)
    {
        if(isset($_FILES['picture'])){
            $request->add('picture', $_FILES['picture']);
        }
        try {
            $response = $this->userService->updateUserProfile($request->all());
            return \ApiResponse::httpCode($response['httpCode'])->data($response['data'])->success();
        } catch(Throwable $exception) {
            return \ApiResponse::failed($exception);
        }
       
    }

}
