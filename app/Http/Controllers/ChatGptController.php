<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Http\JsonResponse;

class ChatGptController extends Controller
{
     public function index(Request $request){

        $search = $request->title;
  
        $data = Http::withHeaders([
                    'Content-Type' => 'application/json',
                    'Authorization' => 'Bearer '.env('OPENAI_API_KEY'),
                  ])
                  ->post("https://api.openai.com/v1/chat/completions", [
                    "model" => "gpt-3.5-turbo",
                    'messages' => [
                        [
                           "role" => "user",
                           "content" => $search
                       ]
                    ],
                    'temperature' => 0.5,
                    "max_tokens" => 200,
                    "top_p" => 1.0,
                    "frequency_penalty" => 0.52,
                    "presence_penalty" => 0.5,
                    "stop" => ["11."],
                  ])
                  ->json();
  
            $message =" Here is you can map key status true in array of object.
            
            array = array.map(item => {
                return {
                  ...item,
                  status: true
                };
              });";

            //   NOTE:replace $message with $data['choices'][0]['message'] 
               
        return response()->json($message, 200, array(), JSON_PRETTY_PRINT);
        
    }
}
