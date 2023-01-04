<?php
namespace App\Services;

use App\Jobs\SendEmailJob;

class EmailService
{
    public function handleRequest(string $email, string $subject, string $body)
    {
        $emailComposition = [
            'to' => $email,
            'subject' => $subject,
            'body' => $body
        ];

        $job = (new SendEmailJob($emailComposition));
        dispatch($job);
    }
}