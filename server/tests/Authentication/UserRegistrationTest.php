<?php

namespace Tests;

use Laravel\Lumen\Testing\DatabaseMigrations;
use Laravel\Lumen\Testing\DatabaseTransactions;

class UserRegistrationTest extends TestCase
{
    /**
     * @dataProvider userRegistrationDataProvider 
     */
    public function testIsRegistrationValid($inputValue, $expectedStatus, $expectedData = null)
    {
        $this->post('register', $inputValue, ['Accept' => 'application/json']);
        $this->seeStatusCode($expectedStatus);
        if(isset($expectedData)){
             $this->seeJson($expectedData);
        }
    }

    public function userRegistrationDataProvider()
    {
        return [
            "userInfoAreRequired" =>
            [
                "inputValue" => [
                    "name" => "John Kennedy",
                    "email" => "johnkennedy_".rand()."@gmail.com"
                ],
                "expectedStatus" => 422
            ],

            "userInfoShouldBeValid" =>
            [
                "inputValue" => [
                    "name" => "John Kennedy",
                    "email" => "johnkennedy_".rand()."@gmail.com",
                    "password" => "123456",
                    "password_confirmation" => "123456"
                ],
                "expectedStatus" => 201
            ],

            "userEmailIsAlreadyTaken" =>
            [
                "inputValue" => [
                    "name" => "John Kennedy",
                    "email" => "johnkennedy@gmail.com",
                    "password" => "123456",
                    "password_confirmation" => "123456"
                ],
                "expectedStatus" => 422,
                "expectedData" => [
                    "email" => ["The email has already been taken."],
                ]
            ],
            
            "userPasswordDoesNotMatch" =>
            [
                "inputValue" => [
                    "name" => "John Kennedy",
                    "email" => "johnkennedy@gmail.com",
                    "password" => "123456",
                    "password_confirmation" => "1234566"
                ],
                "expectedStatus" => 422,
                "expectedData" => [
                    "password" => ["The password confirmation does not match."],
                ]
            ],
           
        ];
    }
}
