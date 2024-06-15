<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class FormController extends Controller
{
    public function index()
    {
        return view('index');
    }

    public function submit(Request $request)
    {
        // validate


        $context = $request->input('context');
        $inputFile = $request->file('inputFile');
        $forecastPeriod = $request->input('forecastPeriod');

        //prepare the file and other inputs for sending to flask server
        $response = Http::attach(
            'inputFile',
            file_get_contents($inputFile),
            $inputFile->getClientOriginalName()
        )->post('http://127.0.0.1:5000/submit', ['context' => $context, 'forecastPeriod' => $forecastPeriod]);


        /**
         * In order to simplify this project, 
         * the flask server will just return a json response. 
         * We don't have to store the file into the storage->public directory, 
         * because there is no return file to begin with. 
         * * */

        //the return type is json. 

        $data = $response->json();

        $acf_lag = $data['acf_lag'];
        $mse = $data['mse'];
        $mpe = $data['mpe'];
        $outsample_forecast = $data['outsample_forecast'];
        $text_result = $data['text_result'];



        // foreach ($outsample_forecast as $point) {
        //     $dates[] = date('Y-m-d', strtotime($point['index']));
        //     $values[] = $point['Value']; // Assuming 'Value' is the numeric value
        // }

        foreach ($outsample_forecast as $point) {
            $dates[] = $point['index'];
            $values[] = $point['Value']; // Assuming 'Value' is the numeric value
        }





        // Pass data to the view
        return view('result', compact('dates', 'values', 'acf_lag', 'mse', 'mpe', 'text_result', 'context'));
    }


}
