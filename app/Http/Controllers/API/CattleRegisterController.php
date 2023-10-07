<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;
use App\Models\CattleRegistration;
use App\Rules\UniqueMuzzle;
use Illuminate\Support\Facades\Http;

class CattleRegisterController extends Controller
{
    public function apistore(Request $request)
    {

        $validator = Validator::make($request->all(), [
            'cattle_name' => ['required'],
            'cattle_breed' => ['required'],
            'age' => ['required'],
            'cattle_color' => ['required'],
            'weight' => ['required'],
            'cattle_type' => ['required'],

            'sum_insured' => ['required'],
            'bank_name_insured' => ['required'],
            'bank_account_no' => ['required'],
            'cattle_r_id' => ['required', 'unique:cattle_registrations'],
            'user_id' => ['required'],


            'nid_front' => ['required', 'mimes:jpeg,jpg,png'],
            'nid_back' => ['required', 'mimes:jpeg,jpg,png'],
            'chairman_certificate' => ['required', 'mimes:jpeg,jpg,png'],
            

            'muzzle_of_cow' => ['required', 'mimes:jpeg,jpg,png'],
            'left_side' => ['required', 'mimes:jpeg,jpg,png'],
            'right_side' => ['required', 'mimes:jpeg,jpg,png'],
            'special_marks' => ['required', 'mimes:jpeg,jpg,png'],
            'cow_with_owner' => ['required', 'mimes:jpeg,jpg,png'],
            'loan_investment' => ['required', 'mimes:jpeg,jpg,png,pdf,txt'],

        ]);


        if ($validator->fails()) {
            $response = [
                'success' => false,
                'message' => $validator->errors()
            ];
            return response()->json($response, 400);
        }

        // $targetDirectory = "../storage/app/public/images/"; // Specify your target directory


        // Handle image upload
        // $nid_front = $request->file('nid_front');
        // $nid_front_file_name = $nid_front->getClientOriginalName();
        // $targetFilePath = $targetDirectory . $nid_front_file_name;
        // move_uploaded_file($_FILES["nid_front"]["tmp_name"], $targetFilePath);


        $targetDirectory = "../storage/app/public/images/"; // Specify your target directory
        $randomNumber = rand(100000, 999999);
        

        $nid_front_originalFileName = basename($_FILES["nid_front"]["name"]);
        $nid_front_fileExtension = pathinfo($nid_front_originalFileName, PATHINFO_EXTENSION);
        $nid_front_newFileName = $randomNumber . '.' . $nid_front_fileExtension;
        $nid_front_targetFilePath = $targetDirectory . $nid_front_newFileName;
        move_uploaded_file($_FILES["nid_front"]["tmp_name"], $nid_front_targetFilePath);


        
        $nid_back_originalFileName = basename($_FILES["nid_back"]["name"]);
        $nid_back_fileExtension = pathinfo($nid_back_originalFileName, PATHINFO_EXTENSION);
        $nid_back_newFileName = $randomNumber . '.' . $nid_back_fileExtension;
        $nid_back_targetFilePath = $targetDirectory . $nid_back_newFileName;
        move_uploaded_file($_FILES["nid_back"]["tmp_name"], $nid_back_targetFilePath);


        
        $chairman_certificate_originalFileName = basename($_FILES["chairman_certificate"]["name"]);
        $chairman_certificate_fileExtension = pathinfo($chairman_certificate_originalFileName, PATHINFO_EXTENSION);
        $chairman_certificate_newFileName = $randomNumber . '.' . $chairman_certificate_fileExtension;
        $chairman_certificate_targetFilePath = $targetDirectory . $chairman_certificate_newFileName;
        move_uploaded_file($_FILES["chairman_certificate"]["tmp_name"], $chairman_certificate_targetFilePath);




        $muzzle_of_cow = $request->file('muzzle_of_cow');
        $muzzle_of_cow_newFileName = $muzzle_of_cow->getClientOriginalName();
        $muzzle_of_cow_targetFilePath = $targetDirectory . $muzzle_of_cow_newFileName;
        move_uploaded_file($_FILES["muzzle_of_cow"]["tmp_name"], $muzzle_of_cow_targetFilePath);


        
        $left_side_originalFileName = basename($_FILES["left_side"]["name"]);
        $left_side_fileExtension = pathinfo($left_side_originalFileName, PATHINFO_EXTENSION);
        $left_side_newFileName = $randomNumber . '.' . $left_side_fileExtension;
        $left_side_targetFilePath = $targetDirectory . $left_side_newFileName;
        move_uploaded_file($_FILES["left_side"]["tmp_name"], $left_side_targetFilePath);


        
        $right_side_originalFileName = basename($_FILES["right_side"]["name"]);
        $right_side_fileExtension = pathinfo($right_side_originalFileName, PATHINFO_EXTENSION);
        $right_side_newFileName = $randomNumber . '.' . $right_side_fileExtension;
        $right_side_targetFilePath = $targetDirectory . $right_side_newFileName;
        move_uploaded_file($_FILES["right_side"]["tmp_name"], $right_side_targetFilePath);


        
        $special_marks_originalFileName = basename($_FILES["special_marks"]["name"]);
        $special_marks_fileExtension = pathinfo($special_marks_originalFileName, PATHINFO_EXTENSION);
        $special_marks_newFileName = $randomNumber . '.' . $special_marks_fileExtension;
        $special_marks_targetFilePath = $targetDirectory . $special_marks_newFileName;
        move_uploaded_file($_FILES["special_marks"]["tmp_name"], $special_marks_targetFilePath);


        
        $cow_with_owner_originalFileName = basename($_FILES["cow_with_owner"]["name"]);
        $cow_with_owner_fileExtension = pathinfo($cow_with_owner_originalFileName, PATHINFO_EXTENSION);
        $cow_with_owner_newFileName = $randomNumber . '.' . $cow_with_owner_fileExtension;
        $cow_with_owner_targetFilePath = $targetDirectory . $cow_with_owner_newFileName;
        move_uploaded_file($_FILES["cow_with_owner"]["tmp_name"], $cow_with_owner_targetFilePath);


        
        $loan_investment_originalFileName = basename($_FILES["loan_investment"]["name"]);
        $loan_investment_fileExtension = pathinfo($loan_investment_originalFileName, PATHINFO_EXTENSION);
        $loan_investment_newFileName = $randomNumber . '.' . $loan_investment_fileExtension;
        $loan_investment_targetFilePath = $targetDirectory . $loan_investment_newFileName;
        move_uploaded_file($_FILES["loan_investment"]["tmp_name"], $loan_investment_targetFilePath);

        


        // $input = $request->all();
        $addcattle = CattleRegistration::create([
            'cattle_name' => $request->input('cattle_name'),
            'cattle_breed' => $request->input('cattle_breed'),
            'age' => $request->input('age'),
            'cattle_color' => $request->input('cattle_color'),
            'weight' => $request->input('weight'),
            'cattle_type' => $request->input('cattle_type'),
            'sum_insured' => $request->input('sum_insured'),
            'bank_name_insured' => $request->input('bank_name_insured'),
            'bank_account_no' => $request->input('bank_account_no'),
            'cattle_r_id' => $request->input('cattle_r_id'),
            'user_id' => $request->input('user_id'),
            

            'nid_front' => $nid_front_newFileName,
            'nid_back' => $nid_back_newFileName,
            'chairman_certificate' => $chairman_certificate_newFileName,
            

            'muzzle_of_cow' => $muzzle_of_cow_newFileName,
            'left_side' => $left_side_newFileName,
            'right_side' => $right_side_newFileName,
            'special_marks' => $special_marks_newFileName,
            'cow_with_owner' => $cow_with_owner_newFileName,
            'loan_investment' => $loan_investment_newFileName
        ]);

        // $success['cattle_name'] = $addcattle->cattle_name;

        $response = [
            'success' => true,
            'message' => 'Cattle registration successfully'
        ];

        return response()->json($response, 200);
    }
}
