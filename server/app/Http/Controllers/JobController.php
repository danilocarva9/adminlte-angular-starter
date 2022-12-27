<?php

namespace App\Http\Controllers;



class JobController extends Controller
{


    public function getJobs()
    {
        $jobs = [
            'title' => 'teste',
            'description' => 'description of the job'
        ];
        return response()->json($jobs, 201);
    }
}
