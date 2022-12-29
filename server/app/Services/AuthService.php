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

        //Attempt to login checking user info
        $token = auth()->attempt($credentials);
        
        //If token found, proceed
        if($token){
           return [
            'access_token' => $token,
            'token_type'   => 'bearer',
            'expires_in' => auth()->factory()->getTTL() * 60
           ];
        }
        //Returns unauthorized if credentials do not match
        return [
            'code'=> Response::HTTP_UNAUTHORIZED,
            'content' => [
                'status' => 'error',
                'message' => 'You have entered an invalid email or password.',
                'data' => null
            ]
        ];
    }


    /**
     * Get a JWT via given credentials.
     *
     * @param  Request  $request
     * @return Response
     */
    public function forgotPassword(string $email): Array
    {
        // Send if exits the user with this email
        // send email to the user with a link with HASH to the
        // recovery-password where the user is going to fill new password and save

        $user = $this->userRepository->findBy('email', $email);
       
        if(isset($user)){

            $recoveryPassword = [
                'encryption' => base64_encode(Hash::make($user['id'])),
                'is_active' => true,
                'user_id' => $user->id
            ];
            $response = $this->recoveryPasswordRepository->create($recoveryPassword);

            if(isset($response)){
                $emailBody = '';
                //$emailResponse = $this->mailService->send($user['email'], $emailBody);
                $emailResponse = true;
            }
            if($emailResponse){
                return [ 'message' => "We've sent an email with instructions to recovery your password." ];
            }
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
        $newPassword = [
            'password' => app('hash')->make($request['password'])
        ];

        $response = $this->userRepository->updateBy($newPassword, 37);

        if($response){
            return [
                'code'=> Response::HTTP_OK,
                'content' => [
                    'status' => 'success',
                    'message' => 'You have succesful.',
                    'data' => null
                ]
            ];
        }
       
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