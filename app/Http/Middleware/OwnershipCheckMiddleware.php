<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class OwnershipCheckMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {
        $error = false;
        //Checking if the token is present in the header
        if (!$request->hasHeader('USER-TOKEN'))
            $error = true;
        //aquiring all necessary data
        $token = $request->header('USER-TOKEN');
        $id = $request->query('product_id');
        $filePath = 'C:\xampp\htdocs\products_list2.json';
        $fileContent = file_get_contents($filePath);
        $jsonContent = json_decode($fileContent, true);
        //Checking if the entered product id is valid
        if ($id <= 0 || $id > count($jsonContent))
            return response()->json(['message' => 'Invalid ID'], 400);
        try {
            //decoding the entered token
            $jsonStr = base64_decode($token);
            $jsonPayload = json_decode($jsonStr, true);
            //Checking if the token was invalid
            if (!$jsonPayload)
                $error = true;
            //Checking if an email value was present in the token
            if (!isset($jsonPayload['email']))
                $error = true;
            //Checking if the email from the token is the owner of the product
            if (($jsonPayload['email'] != $jsonContent[$id - 1]['owner']))
                $error = true;
        } catch (\Exception $exception) {
            $error = true;
        }

        if ($error) //if anything went wrong this message is displayed
            return response()->json(['message' => 'Invalid token'], 401);
        //if the check was successful the controller code is activated and proceeds to delete the product
        return $next($request);
    }
}
