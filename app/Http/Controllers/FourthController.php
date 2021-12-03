<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class FourthController extends Controller
{
    public function check (Request $request)
    {
        return response()->json(['message'=>'success']);
    }

    public function login (Request $request) {
        //displays the token
        return response()->json(['message' => 'login is successful', 'token' => $request->token]);
    }

    public function destroy (Request $request) {
        //aquiring all necessary data
        $id = $request->query('product_id');
        $filePath = 'C:\xampp\htdocs\products_list2.json';
        $fileContent = file_get_contents($filePath);
        $jsonContent = json_decode($fileContent, true);
        //Destroying the product values
        unset($jsonContent[$id - 1]);
        //recreating the json file after deleting the product
        file_put_contents($filePath, json_encode(array_values($jsonContent)));
        return response()->json(['message' => 'deletion is successful']);
    }
}
