<?php
namespace App\Services;

use App\Models\User;
use Illuminate\Http\Response;
use App\Repositories\UserRepository;
use Illuminate\Support\Facades\Hash;

class UserService
{
    protected $userRepository;

    public function __construct(UserRepository $userRepository)
    {
        $this->userRepository = $userRepository;
    }


    public function find(int $id): Array
    {
        $user = $this->userRepository->findBy([['id', $id]]);
        if(!is_null($user)){
            return ['httpCode' => Response::HTTP_OK, 'data'=> $user];
        }
        return ["httpCode"=> Response::HTTP_NOT_FOUND, "message" => "User not found."];
    }


   public function create(array $request): User
   {
        $request = [
            'name' => $request['name'],
            'email' => $request['email'], 
            'password' => Hash::make($request['password'])
        ];
        return $this->userRepository->create($request);
   }


   public function update(int $ind, array $params)
   {

   }


  

   
}