<?php
namespace App\Http\Controllers;
trait ApiResponse
{
    public function Response($data='', $message = '',$status )
    {

        return response()->json([
            'message' => $message,
            'data' => $data,
        ], $status);
    }
}