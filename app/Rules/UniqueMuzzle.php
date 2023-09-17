<?php

namespace App\Rules;

use Illuminate\Contracts\Validation\Rule;
use Illuminate\Support\Facades\Http;

class UniqueMuzzle implements Rule
{
    public $message;
    /**
     * Create a new rule instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Determine if the validation rule passes.
     *
     * @param  string  $attribute
     * @param  mixed  $value
     * @return bool
     */
    public function passes($attribute, $value)
    {
        $image = request()->file('face_of_cow');
        if(!$image)
        {
            $this->message = 'Image not found';
            return false;
        }
        $response = Http::attach('image', file_get_contents($image), $image->getClientOriginalName())
        ->post('http://13.127.204.155/cattle_identification', [
            'options' => 'registration',
        ]);

        // Check for errors
        if ($response->failed()) {
            // Handle the error
            $this->message = 'HTTP Error: ' . $response->status();
            return false;
        } else {
            // Decode the JSON response
            $responseData = json_decode($response->body(), true);

            // Check if the "output" key exists and has the value "Success"
            if (isset($responseData['output']) && $responseData['output'] === 'Success') {
                // Success response
                return true;
            } else {
                // Handle other responses
                $this->message = 'API Response: Not Success';
                return false;
            }
        }
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        return  $this->message;
        // return 'The muzzle already exist.';
    }
}
