<?php

namespace App\Http\Controllers\ml;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\DB;

class ClaimController extends Controller
{


    public function index($id)
    {

        $cattle_info = auth()->user()->cattleRegister()->where('id', $id)->first();

        if ($cattle_info != null) {
            return view("farmer.admin-content.claim.index", compact('cattle_info'));
        } else {
            return "Invalid request";
        }
    }

    public function claim()
    {
        return view("farmer.admin-content.claim.claim");
    }

    public function store(Request $request)
    {
        $inputs = \request()->validate([
            'muzzle_of_cow' => 'required|mimes:jpeg,jpg,png',
            'muzzle_token' => 'required',
            'cattle_id' => 'required',
        ]);


        if (request('muzzle_of_cow')) {
            $inputs['muzzle_of_cow'] = \request('muzzle_of_cow')->store('images');
        }


        //        ------------------------------- API DATA ---------------------------------

        // Additional parameters to send to the API
        $options = 'claim';

        // API endpoint URL
        $apiUrl = "http://13.232.34.224/cattle_identification";

        $basename = $inputs['muzzle_token'];
        $basename = $catl_id = $inputs['cattle_id'];


        try {
            $response = Http::attach(
                'image',
                file_get_contents(storage_path('app/public/' . $inputs['muzzle_of_cow'])),
                basename($basename) // File name to use in the request
            )->post($apiUrl, ['options' => $options]);


            if ($response->status() == 200) {

                $apiResponse = $response->json('output');
                //print($apiResponse);
                //print($basename);
                //die();

                if ($apiResponse != "Failed") {
                    auth()->user()->insurance_claimed()->create($inputs);
                    $results = DB::select('SELECT * FROM cattle_registrations WHERE cattle_r_id = ?', [$apiResponse]);

                    // $claim_info = auth()->user()->cattleRegister()->where('cattle_r_id', $apiResponse)->first();
                    // dd($results);
                    // print($apiResponse);
                    // print($claim_info);
                    // die();

                    // session()->flash("claim_success", "Claim action matched successfully");
                    return view("farmer.admin-content.claim.claim_result", compact('results'));
                } elseif ($apiResponse == "Failed") {
                    session()->flash("claim_failed", "Claim action unaccepted");
                    return back();
                } else {
                    session()->flash("error", "Server error");
                }
            } else {
                // Handle API error, e.g., log or throw an exception
                // You can access the response content with $response->body()
                // and the status code with $response->status()
                return "Error";
            }
        } catch (Exception $e) {
            // Handle exceptions, e.g., connection issues or timeouts
            // Log or rethrow the exception as needed
            return "Catch Exception";
        }
        //        ------------------------------- API DATA ---------------------------------


        return back();
    }
}
