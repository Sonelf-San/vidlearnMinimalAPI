<?php


namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AuthenticationController extends Controller
{

    public function login(Request $request){
        $input = $request->all();
        $valid = Validator::make($input, [
            'email' => 'required|string|email|max:255',
            'password' => 'required|string|min:6',
        ]);
        if($valid->fails()){
            return response()->json($valid->errors());
        }
        if(Auth::guard('student')->attempt(['email' => $input['email'], 'password' => $input['password']])){
            $student = Auth::guard('student')->user();
            $token = $student->createToken('api-token', ['student'])->plainTextToken;
            $response = [
                'student-info' => $student,
                'token' => $token
            ];
            return response($response, 201);
        }
        else
        {
            $response = [
                'message' => 'Invalid email or password',
                'status' => 401
            ];
            return response($response);
        }
    }

    public function studentDetails(){
        $student = Auth::user();
        return response()->json(['student-info' => $student]);
    }

    public function logout(Request $request){
        $request->user()->currentAccessToken()->delete();
        return response()->json(['message' => 'Successfully logged out']);
    }

//    public function logout(Request $request)
//    {
//        $request->user()->token()->revoke();
//        return response()->json([
//            'message' => 'Successfully logged out'
//        ]);
//    }
















    public function profile(Request $request){
        $user = $request->user();
        $dir = storage_path().'/app/public/';
        $path = $dir.$user->profile;
        $image = file_get_contents($path);
        $base64 = base64_encode($image);
        $user['profile'] = $base64;
        return response()->json(['success' => 200, 'user' => $user]);
    }


    public function register(Request $request)
    {
        $validator = Validator::make($request->all(),
            [
                'name' => 'required',
                'phone' => 'required',
            ]);

        if ($validator->fails()) {
            return response()->json(['success' => 400, 'message' => $validator->errors()->first()], 200);
        }


        $user = User::where(['phone'=> $request->phone])->first();
        if(!isset($user)){

            $faker = \Faker\Factory::create();
            $storage_path =  storage_path('app/public/user/profile');
            \File::isDirectory($storage_path) or \File::makeDirectory($storage_path, 0777, true, true);
            $input = $request->all();
            do{
                $input['email'] = strtolower(explode(' ',$request->name)[0]).rand(1,1000);
            }while(User::where('email',$input['email'])->count() != 0);
            $input['password'] = "NOT SET";
            $user = User::create($input);
            $user = User::find($user->id);
            $dir = storage_path().'/app/public/';
            $path = $user->profile != null?$dir.$user->profile:public_path().'/assets/images/default.png';
            $image = file_get_contents($path);
            $base64 = base64_encode($image);
            $user['profile'] = $base64;
            $user['token'] = $user->createToken(env('app_name', ""))->accessToken;

            return response()->json(['success' => 200, 'message'=>'Account Created Successfully', 'user' => $user], 200);
        }else{
            $data["success"] = "200";
            $data["message"] = "Successful";
            Auth::guard('api')->check($user);
            $dir = storage_path().'/app/public/';
            $path = $user->profile != null?$dir.$user->profile:public_path().'/assets/images/default.png';
            $image = file_get_contents($path);
            $base64 = base64_encode($image);
            $user->profile = $base64;
            $data['user'] =$user;
            $user['token'] = $user->createToken(env('app_name', ""))->accessToken;
            return response()->json($data,  200);
        }

    }

//    public function logout(Request $request)
//    {
//        $request->user()->token()->revoke();
//        return response()->json([
//            'message' => 'Successfully logged out'
//        ]);
//    }

    public function updateProfile(Request $request)
    {   $uploadDirectory =  storage_path().'/app/public/user/profile';
        $validator = Validator::make($request->all(),
            ['file' => 'required|image|mimes:jpeg,png,jpg,gif,jpg']);

        if ($validator->fails()) {
            return response()->json(['success' => 400, 'message' => $validator->errors()->first()], 200);
        }

        $user = $request->user();
        $imageName = $user->profile;
        Image::make($request->file('file')
            ->move($uploadDirectory, $imageName))
            ->fit(500, 500)
            ->save();

        $data = file_get_contents($uploadDirectory.$imageName);
        $imageData = base64_encode( $data);
        $base64 = $imageData;
        $json["success"] = "200";
        $json["message"] = "Profile Updated Successfully";
        $json["photo"] = "$base64";
        $user->save();

        return response()->json($json, 200);
    }

    public function updateProfileInfo(Request $request){
        $validator = Validator::make($request->all(),
            [
                'firstname' => 'required',
                'lastname' => 'required',
            ]);

        if ($validator->fails()) {
            return response()->json(['success' => 500, 'message' => $validator->errors()->first()], 200);
        }

        $user = $request->user();
        $user->firstname = $request->firstname;
        $user->lastname = $request->lastname;
        $user->bio = $request->bio;
        $user->save();
        return response()->json(['success' => 200, 'message' => "Profile updated successfully"], 200);
    }


    public function changePassword(Request $request)
    {
        $validator = Validator::make($request->all(),
            ['password' => 'required',
                'old_password' => 'required'
            ]);
        if ($validator->fails()) {
            return response()->json(['success' => 400, 'message' => $validator->errors()->first()], 200);
        }
        $user = $request->user();
        if(!Hash::check($request->old_password , $user->password)){
            return response()->json([
                'success' => '400',
                'message' => "The old password you entered is not correct"
            ]);
        }

        $user = $request->user();
        $user->password = Hash::make($request->password);
        $user->save();
        return response()->json(['success' => 200, 'message' => "Password updated successfully"], 200);
    }


    public function passwordReset(Request $request)
    {
        return response()->json(['success' => 200, 'message' => "A password reset email has being sent to you"], 200);
    }

    public function updateFBToken(Request $request){
        $validator = Validator::make($request->all(),
            ['token' => 'required']);
        if ($validator->fails()) {
            return response()->json(['success' => 500, 'message' => $validator->errors()->first()], 200);
        }
        $request->user()->changeToken($request->token);
        return response()->json(['success' => 200, 'message' => "Update successfully"], 200);
    }

}
