<?php
namespace App\Services;

use App\Models\User;
use Illuminate\Http\Response;
use App\Repositories\User\UserRepository;

class UserService
{
    protected $userRepository;

    public function __construct(UserRepository $userRepository)
    {
        $this->userRepository = $userRepository;
    }

   public function create(array $request): Array
   {
        $request = [
            'name' => $request['name'],
            'email' => $request['email'], 
            'password' => app('hash')->make($request['password'])
        ];

        $user = $this->userRepository->create($request);

        return [
            'code' => Response::HTTP_CREATED,
            'content' => [
                'status' => 'success',
                'message' => 'Your account was created successfuly.',
                'data'=> $user
            ]
        ];
   }

   
}