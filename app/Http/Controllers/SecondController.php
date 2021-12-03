<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Mockery\Generator\StringManipulationGenerator;

class SecondController extends Controller
{
    public function addUsers() {
        //Adding users from query parameters into an array after CAPITALIZING them
        $users["name1"] =  strtoupper(request()->query('user_name1'));
        $users["name2"] =  strtoupper(request()->query('user_name2'));
        $users["name3"] =  strtoupper(request()->query('user_name3'));
        $users["name4"] =  strtoupper(request()->query('user_name4'));
        $users["name5"] =  strtoupper(request()->query('user_name5'));
        $newjson=json_encode($users); //turning the array into json form
        file_put_contents( "../../json_file3.json", $newjson); //Storing the array in a .json file
        foreach( $users as $key=>$value ) {
            echo "$key = $value <br />"; //printing the array values
        }
    }
    public function checkInfo(){
        //Checks if either the entered email OR phone number are valid
        $email=request()->query('email');
        $phone=request()->query('phone');
        $fileContent = file_get_contents('http://localhost:1234/json_file2.json'); //Loads the .json file with the stored values
        $jsonContent = json_decode($fileContent, true); //Reading and decoding the json form into a basic array
        foreach($jsonContent as $i){ //going through the objects in the array one by one
            if (in_array($email, $i) || in_array($phone, $i)) { //if the email OR phone are valid values
                return response()->json([ ['message' => 'Welcome ' . $i["name"] . '!'] // print a Welcome message
                ]);
            }
        }
        return response()->json(['entered values are invalid']); //if the values were not found in the array, then they're invalid.
    }
}