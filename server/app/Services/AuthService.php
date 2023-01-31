<?php
namespace App\Services;

use App\Repositories\RecoveryPasswordRepository;
use App\Repositories\UserRepository;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Hash;
use App\Services\EmailService;

class AuthService
{

    private $userRepository;
    private $recoveryPasswordRepository;
    private $emailService;

     /**
     * Create new service instance
     *
     * @return void
     */
    public function __construct(
        UserRepository $userRepository,
        RecoveryPasswordRepository $recoveryPasswordRepository,
        EmailService $emailService
    )
    {
        $this->userRepository = $userRepository;
        $this->recoveryPasswordRepository = $recoveryPasswordRepository;
        $this->emailService = $emailService;
    }

   /**
     * Get a JWT via given credentials.
     *
     * @param  Request  $request
     * @return Response
     */
    public function login(array $credentials): Array
    {
        //Attempt to login checking user info.
        $token = auth()->attempt($credentials);
        //If token found, proceed.
        if($token){
           return [
            'httpCode' => Response::HTTP_OK,
            "message" => "You have successfully logged in.",
            'data'=> $this->buildTokenInfo($token)
           ];
        }
        //Returns unauthorized if credentials do not match
        return ["httpCode"=> Response::HTTP_UNAUTHORIZED, "message" => "You have entered an invalid email or password."];
    }


    /**
     * Forgot password.
     *
     * @param  Request  $request
     * @return Response
     */
    public function forgotPassword(string $email): Array
    {
        $user = $this->userRepository->findBy([['email', $email, '=']]);

        //If user's does not exist.
        if(is_null($user)) {
            return ["httpCode"=> Response::HTTP_NOT_FOUND, "message" => "User not found."];
        }
       
        $recoveryPassword = [
            'encryption' => Hash::make($user->id),
            'is_active' => true,
            'user_id' => $user->id
        ];

        //If user's recovery password does not exist, create one.
        if(is_null($user->recoveryPassword)){
            $this->recoveryPasswordRepository->create($recoveryPassword);
        }

        //If User's recovery password is not active, update it.
        if(isset($user->recoveryPassword)){
            if(!$user->recoveryPassword->IsActive()){
                unset($recoveryPassword['user_id']);
                $this->recoveryPasswordRepository->updateBy($recoveryPassword, $user->recoveryPassword->id);
            }
        }

        return $this->sendRecoveryPasswordEmail($user->email, $recoveryPassword['encryption']);
    }


    private function sendRecoveryPasswordEmail(string $email, $recoveryHash): Array
    {
        $urlRecoveryBase64 = base64_encode($recoveryHash);
        $subject = "Recovery password";
        $body = $urlRecoveryBase64;
        $this->emailService->handleRequest($email, $subject, $body);
        return ["httpCode"=> Response::HTTP_OK, "message" => "We've sent an email with instructions to recovery your password."];
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

        if(!is_null($user)){
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
            'expires_in' => auth()->factory()->getTTL() * 1
        ];
    }
   
}