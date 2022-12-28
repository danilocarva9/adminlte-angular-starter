<?php

namespace App\Http\Responses;

use Illuminate\Contracts\Support\Responsable;
use Illuminate\Http\Response;

class ApiSuccessResponse implements Responsable
{
    /**
     * @param  int  $code
     * @param array $content
     * @param  array  $headers
     */
    public function __construct(
        private int $code = Response::HTTP_OK,
        private array $content,
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
              $this->content,
            ],
            $this->code,
            $this->headers
        );
    }
}
