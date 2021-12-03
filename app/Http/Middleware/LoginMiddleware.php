<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class LoginMiddleware
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
        //Getting the email and password from the request header
        $incoming_email = $request->header('email');
        $incoming_password = $request->header('password');
        //standard json file import/decode
        $filePath = 'C:\xampp\htdocs\users_list.json';
        $fileContent = file_get_contents($filePath);
        $jsonContent = json_decode($fileContent, true);
        try {
            if (!$incoming_email || !$incoming_password) //values are not input
                $error = true;
            //Browsing through the users list array
            foreach ($jsonContent as $users) {
                //checking if the password and email belong to the same user
                if (in_array($incoming_email, $users)  && in_array($incoming_password, $users)){
                    $error = false;
                    break;
                }
                else //if they're not belonging to any of the users, then at least 1 of them is invalid
                    $error = true;
            }
        } catch (\Exception $exception) {
            $error = true;
        }
        if ($error) { //if anything went wrong this message is displayed
            return response()->json(['message' => 'Email or Password are invalid']);
        }
        //creating the token from all the user info
        $jsonStr = base64_encode(json_encode($users));
        //sending the token to the controller via adding it to the request
        request()->token = $jsonStr;
        return $next($request);
    }
}
