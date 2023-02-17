<?php
//to get the data from the external api
namespace App\Http\Controllers\External;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\Http\Controllers\Controller;
use GuzzleHttp\Client; // <--- add this line

class ApiController extends Controller
{
    //// https://fakestoreapi.com/products

    public function index()
    {
        // this code is from the guzzle documentation
        $client = new Client();
        $response = $client->get('https://fakestoreapi.com/products');
        
        if(!$response->getStatusCode() == 200){
            return response()->json([
                "message" => "failed",
                "data" => null
            ],Response::HTTP_BAD_REQUEST);
        }

        $data = $response->getBody()->getContents();
        $decodedData = json_decode($data, true);

        return response()->json([
            "message" => "success",
            "data" => $decodedData
        ],Response::HTTP_OK);
    }
}
