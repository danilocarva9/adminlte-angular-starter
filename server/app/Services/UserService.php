<?php
namespace App\Services;

use App\Models\User;
use Illuminate\Http\Response;
use App\Repositories\UserRepository;
use App\Repositories\ProfileRepository;
use App\Services\UploadService;
use Illuminate\Support\Facades\Hash;

class UserService
{
    protected $userRepository;
    protected $profileRepository;
    protected $uploadService;

    public function __construct(
        UserRepository $userRepository,
        ProfileRepository $profileRepository,
        UploadService $uploadService
    )
    {
        $this->userRepository = $userRepository;
        $this->profileRepository = $profileRepository;
        $this->uploadService = $uploadService;
    }

    public function find(int $id): Array
    {
        $user = $this->userRepository->findBy([['id', $id]]);
        if(!is_null($user)){
            return ['httpCode' => Response::HTTP_OK, 'data'=> $user, $user->profile];
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

   public function updateUserProfile($request)
   {
        $user = $this->userRepository->findBy([['id', $request['user_id'], '=']]);
        $user->name = $request['name'];
        $user->save();

        $profile = [
            'role' => $request['role'], 
            'description' => $request['description']
        ];
        if(isset($request['picture'])){
            $profile['picture'] = $this->uploadService->uploadPicture($request['picture']);
        }
        $user->profile->fill($profile);
        $user->profile->save();

        if(!is_null($user)){
            return ['httpCode' => Response::HTTP_OK, 'data'=> $user];
        }
   }

}