<?php

namespace App\Traits;

use Illuminate\Http\JsonResponse;

trait ResponseAPI
{
    public function response_data($success , $data , $status , $message)
    {
        return response()->json([
            'success' => $success,
            'message' => $message,
            'data' => $data,
        ],$status);
    }

    public function success($data = [] , $status = 200 , $message = "success operation")
    {
        return $this->response_data(true , $data , $status , $message);
    }

    public function deleted($data = [] , $status = 200 , $message = "resource deleted successfully")
    {
        return $this->response_data(true , $data , $status , $message);
    }

    public function created($data = [] , $status = 201 , $message = "resource created successfully")
    {
        return $this->response_data(true , $data , $status , $message);
    }

    public function notFound($data = null , $status = 404 , $message = "resource not found!")
    {
        return $this->response_data(false , $data , $status , $message);
    }

    public function error($data = null , $status = 500 , $message = "error operation")
    {
        return $this->response_data(false , $data , $status , $message);
    }

    public function un_authenticat($data = null , $status = 401 , $message = "UnAuthenticated")
    {
        return $this->response_data(false , $data , $status , $message);
    }
}

