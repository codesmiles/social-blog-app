<?php
//to get the data from the external api
namespace App\Http\Controllers\External;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use GuzzleHttp\Client; // <--- add this line

class ApiController extends Controller
{
    //// https://fakestoreapi.com/products

    public function index()
    {
        // this code is from the guzzle documentation
        $client = new Client();
        // $response = $client->request('GET', 'https://fakestoreapi.com/products');
        $response = $client->get('https://jsonplaceholder.typicode.com/posts');
        $data = $response->getBody()->getContents();
        $decodedData = json_decode($data, true);

        return $data;
    }
}
