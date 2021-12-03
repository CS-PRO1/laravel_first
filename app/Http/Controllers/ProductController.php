<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ProductController extends Controller
{
    public function CreateProduct(Request $request)
    {
        //importing necessary inputs
        $name = $request->input('name');
        $description = $request->input('description');
        $price = $request->input('price');
        $brand = $request->input('brand');
        //Checking validty of inputs
        if (!$name || !$description || !$price || !$brand)
            return response()->json(['message' => 'invalid payload, all fields are required', 'data' => null], 400);
        
        //standard json import/decode
        $filePath = 'C:\xampp\htdocs\Products_list.json';
        $fileContent = file_get_contents($filePath);
        $jsonContent = json_decode($fileContent, true);
        //entering input values into an array
        $payload = [
            'name' => $name,
            'description' => $description,
            'price' => $price,
            'brand' => $brand
        ];
        // if json file is empty/doesn't exist then put the array directly into the json file (and create it if necessary)
        if (!$jsonContent || !is_array($jsonContent)) {
            $content = [$payload];
            file_put_contents($filePath, json_encode($content));
        } else {
            //else add the new values into the file (without erasing previous values)
            $jsonContent[] = $payload;
            file_put_contents($filePath, json_encode($jsonContent));
        }
        return response()->json(['message' => 'Product has been added successfully', 'data' => $payload]);
    }

    public function DeleteProductByID($productId)
    {
        //standard json import/decode
        $filePath = 'C:\xampp\htdocs\Products_list.json';
        $fileContent = file_get_contents($filePath);
        $jsonContent = json_decode($fileContent, true);

        //Checking that the requested ID is valid
        if ($productId <= 0 || $productId > count($jsonContent))
            return response()->json(['message' => 'Invalid ID'], 400);
        //Destroying the product values
        unset($jsonContent[$productId - 1]);
        //recreating the json file after deleting the product
        file_put_contents($filePath, json_encode(array_values($jsonContent)));
        return response()->json(['message' => 'Product has been deleted successfully']);
    }

    public function ListAllProducts()
    {
        //standard json import/decode
        $filePath = 'C:\xampp\htdocs\Products_list.json';
        $fileContent = file_get_contents($filePath);
        $jsonContent = json_decode($fileContent, true);
        return response()->json([
            'message' => 'Data retrieved successfully!',
            'data' => $jsonContent //Printing out all the product values
        ]);
    }
    
    public function UpdateNameByID($productId, Request $request)
    {
        $filePath = 'C:\xampp\htdocs\Products_list.json';
        $fileContent = file_get_contents($filePath);
        $jsonContent = json_decode($fileContent, true);
        //Checking that the requested ID is valid
        if ($productId <= 0 || $productId > count($jsonContent))
            return response()->json(['message' => 'Invalid ID'], 400);
        //importing necessary inputs
        $name = $request->input('name');
        //Checking validty of inputs
        if (!$name)
            return response()->json(['message' => 'invalid payload, name field is required', 'data' => null], 400);
        //Updating the product name
        $jsonContent[$productId - 1]['name']=$name;
        //Reintroducing the updated product into the json file
        file_put_contents($filePath, json_encode(array_values($jsonContent)));
        return response()->json([ 
        'message' => 'Data updated successfully!',
        'data' => $jsonContent[$productId - 1]]); //Printing out the new product data
        }
    }

