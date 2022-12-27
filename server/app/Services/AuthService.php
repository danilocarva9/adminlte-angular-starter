<?php
namespace App\Services;

use Illuminate\Http\Response;

class AuthService
{

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
                'code' => Response::HTTP_OK,
                'status' => 'success',
                'message' => 'You have successfully logged in.',
                'data'=> $this->buildTokenInfo($token)
            ];
        }
        //Returns unauthorized if credentials do not match
        return [
            'code'=> Response::HTTP_UNAUTHORIZED,
            'status' => 'error',
            'message' => 'You have entered an invalid email or password.',
            'data' => null
        ];
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