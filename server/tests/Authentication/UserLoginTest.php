<?php

namespace Tests;

use Laravel\Lumen\Testing\DatabaseMigrations;
use Laravel\Lumen\Testing\DatabaseTransactions;

class UserLoginTest extends TestCase
{
    /**
     * @dataProvider userLoginDataProvider 
     */
    public function testIsLoginValid($inputValue, $expectedStatus, $expectedData = null)
    {
        $this->post('login', $inputValue, ['Accept' => 'application/json']);
        $this->seeStatusCode($expectedStatus);
        if(isset($expectedData)){
             $this->seeJson($expectedData);
        }
    }

    public function userLoginDataProvider()
    {
        return [
            "userInfoShouldBeRequired" =>
            [
                "inputValue" => [],
                "expectedStatus" => 422,
                "expectedData" => [
                    "email" => ["The email field is required."],
                    "password" => ["The password field is required."]
                ]
            ],

            "userInfoShouldBeValid" =>
            [
                "inputValue" => [
                    "email" => "johnkennedy@gmail.com",
                    "password" => "123456"
                ],
                "expectedStatus" => 200
            ],

            "userInfoShouldNotBeValid" =>
            [
                "inputValue" => [
                    "email" => "johnkennedy@gmail.com",
                    "password" => "1234561"
                ],
                "expectedStatus" => 401,
                "expectedData" => [
                    "error" => "You have entered an invalid email or password."
                ]
            ],
        ];
    }
}
