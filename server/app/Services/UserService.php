<?php
namespace App\Services;

use App\Models\User;
use App\Repositories\User\UserRepository;

class UserService
{
    protected $userRepository;

    public function __construct(UserRepository $userRepository)
    {
        $this->userRepository = $userRepository;
    }

   public function create($request): User
   {
        $user = [
            'name' => $request['name'],
            'email' => $request['email'], 
            'password' => app('hash')->make($request['password'])
        ];
        return $this->userRepository->create($user);
   }
   
}