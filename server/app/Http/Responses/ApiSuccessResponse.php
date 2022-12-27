<?php

namespace App\Http\Responses;

use Illuminate\Contracts\Support\Responsable;
use Illuminate\Http\Response;

class ApiSuccessResponse implements Responsable
{
    /**
     * @param  int  $code
     * @param string $status
     * @param  mixed  $message
     * @param  mixed  $data
     * @param  array  $headers
     */
    public function __construct(
        private int $code = Response::HTTP_OK,
        private string $status = 'success',
        private mixed $message = null,
        private mixed $data = null,
        private array $headers = []
    ) {}

    /**
     * @param  $request
     * @return \Symfony\Component\HttpFoundation\Response|void
     */
    public function toResponse($request)
    {
        return response()->json(
            [
                'status' => $this->status,
                'message'=> $this->message,
                'data' => $this->data,
            ],
            $this->code,
            $this->headers
        );
    }
}
