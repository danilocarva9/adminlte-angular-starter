<?php
namespace App\Services;

use App\Repositories\User\UserRepository;

class AuthService
{
    protected $userRepository;

    public function __construct(UserRepository $userRepository)
    {
        $this->userRepository = $userRepository;
    }

   public function login($request)
   {
        $credentials = [
            'name' => $request['email'],
            'email' => $request['password']
        ];

        return $data = [
            'token' => 'dawdawdwakjdpiojPIOSJo92jpe2nemp2'
        ];
      
       // return $this->userRepository->create($user);
   }
   
}