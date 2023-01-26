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

   public function updateUserProfile(array $request)
   {
        $user = $this->userRepository->findBy([['id', $request['user_id'], '=']]);
        $user->name = $request['name'];
        $user->save();
     
        $profile = [
            'role' => $request['role'], 
            'description' => $request['description'],
            'picture' => $this->uploadPicture($request['picture'])
        ];
        $user->profile->fill($profile);
        $user->profile->save();

        if(!is_null($user)){
            return ['httpCode' => Response::HTTP_OK, 'data'=> $user];
        }
   }

   private function uploadPicture($picture = null)
   {
        return 'picturename4.jpg';
   }
   
}