<?php
namespace App\Services;

use App\Models\User;
use Illuminate\Http\Response;
use App\Repositories\UserRepository;
use App\Repositories\ProfileRepository;
use Illuminate\Support\Facades\Hash;

class UserService
{
    protected $userRepository;
    protected $profileRepository;

    public function __construct(
        UserRepository $userRepository,
        ProfileRepository $profileRepository
    )
    {
        $this->userRepository = $userRepository;
        $this->profileRepository = $profileRepository;
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


   public function updateUserProfile(array $request, int $id)
   {
        $request['user_id'] = $id;
        $userProfile = $this->profileRepository->findByOrCreate('user_id', $id, $request);

        if(!is_null($userProfile)){
            return ['httpCode' => Response::HTTP_OK, 'data'=> $userProfile];
        }
   }
  

   private function uploadPicture()
   {
    
   }

   
}