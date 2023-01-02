<?php
namespace App\Services;

use App\Repositories\RecoveryPasswordRepository;
use App\Repositories\UserRepository;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Hash;

class AuthService
{

    private $userRepository;

     /**
     * Create new service instance
     *
     * @return void
     */
    public function __construct(
        UserRepository $userRepository,
        RecoveryPasswordRepository $recoveryPasswordRepository
    )
    {
        $this->userRepository = $userRepository;
        $this->recoveryPasswordRepository = $recoveryPasswordRepository;
    }

   /**
     * Get a JWT via given credentials.
     *
     * @param  Request  $request
     * @return Response
     */
    public function login(array $request): Array
    {
        $credentials = [
            'email' => $request['email'],
            'password' => $request['password']
        ];
        //Attempt to login checking user info.
        $token = auth()->attempt($credentials);
        //If token found, proceed.
        if($token){
           return [
            'httpCode' => Response::HTTP_OK,
            'data'=> $this->buildTokenInfo($token)
           ];
        }
        //Returns unauthorized if credentials do not match
        return ["httpCode"=> Response::HTTP_UNAUTHORIZED, 
        "message" => "You have entered an invalid email or password."];
    }


    /**
     * Get a JWT via given credentials.
     *
     * @param  Request  $request
     * @return Response
     */
    public function forgotPassword(string $email): Array
    {
        $user = $this->userRepository->findBy([['email', $email, '=']]);

        if($user->recoveryPassword->is_active){
            return ["httpCode"=> Response::HTTP_UNPROCESSABLE_ENTITY, 
            "message" => "You already have requested to change your password, please check your inbox."];
        }
      
        if($user){
            $recoveryPassword = [
                'encryption' => Hash::make($user->id),
                'is_active' => true,
                'user_id' => $user->id
            ];
           
            //If recovery for the user does not exist, create new one.
            if(is_null($user->recoveryPassword)){
                $response = $this->recoveryPasswordRepository->create($recoveryPassword);
            }else{
                unset($recoveryPassword['user_id']);
                $response = $this->recoveryPasswordRepository->updateBy($recoveryPassword, $user->recoveryPassword->id);
            }
        }

        if(isset($response)){
            $emailBody = '';
            $urlPasswordBase64 = base64_encode($recoveryPassword['encryption']);
            //$emailResponse = $this->mailService->send($user['email'], $emailBody);
            $emailQueued = true;
        }
        if($emailQueued){
            return [ 'message' => "We've sent an email with instructions to recovery your password. = ".$urlPasswordBase64 ];
        }
    }


    /**
     * Recovery user password.
     *
     * @param  Request  $request
     * @return Response
     */
    public function recoveryPassword(array $request): Array
    {
        $recoveryPassword = $this->recoveryPasswordRepository->findBy([
            ['encryption', base64_decode($request['recoveryHash']), '='],
            ['is_active', true ]
        ]);

        if(!$recoveryPassword){
            return ["httpCode"=> Response::HTTP_UNPROCESSABLE_ENTITY, "message"=> "No requested recovery password for this user."];
        }
       
        $user = $this->userRepository->updateBy(['password' => Hash::make($request['password'])], $recoveryPassword->user->id);

        if($user){
            $recoveryPassword->is_active = false;
            $recoveryPassword->save();
        }
        return ["httpCode"=> Response::HTTP_OK, "message" => "Your password has been successfully changed."];
    }




    /**
     * Gets the token array structure
     *
     * @param string $token
     * @return array
     */
    public function buildTokenInfo(string $token): Array
    {
        return [
            'access_token' => $token,
            'token_type'   => 'bearer',
            'expires_in' => auth()->factory()->getTTL() * 60
        ];
    }

   
}