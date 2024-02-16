<?php

namespace App\Http\Controllers;

use Validator;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Laravel\Passport\TokenRepository;
use Laravel\Passport\RefreshTokenRepository;

class PassportController extends Controller
{
    /**
     * Register user.
     *
     * @return json
     */

 public function showall()
    {
        $users = User::all()->where('role', 'admin');
        if ($users == "") {
            return response()->json([
                'success' => true,
                'message' => 'Users Not Found Done.',
                // 'data' => $Items

            ], 404);
        } else {
            return response()->json([
                'success' => true,
                'message' => 'Users Fetch Successfully Done.',
                'data' => $users

            ], 200);
        }
    }


    public function showallclients()
{
    $users = User::all()->where('role', 'customer');

    if (!$users->isEmpty()) {
        $userCount = $users->count(); // Get the count of users

        return response()->json([
            'success' => true,
            'message' => 'Users Fetch Successfully Done.',
            'data' => [
                'user_count' => $userCount,
                'users' => $users
            ]
        ], 200);
        
    } else {
        return response()->json([
            'success' => false,
            'message' => 'Users Not Found.',
            
        ], 404);
    }
}

  public function register(Request $request)
    {
        $input = $request->only(['fullname', 'email', 'password', 'confirm_password', 'role','gender']);

        $validate_data = [
            'fullname' => 'required|string',
            'email' => 'required|email|unique:users',
            'password' => 'required|min:8',
            'confirm_password' => 'same:password|required',
            'role'  => 'required',
            'gender'  => 'required',
              
        ];

        $validator = Validator::make($input, $validate_data);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Please see errors parameter for all errors.',
                'errors' => $validator->errors()
            ]);
        }

        $user = User::create([
            'fullname' => $input['fullname'],
            'email' => $input['email'],
            'password' => Hash::make($input['password']),
            'confirm_password' => Hash::make($input['confirm_password']),
            'role'  => $input['role'],
            'gender'  => $input['gender'],
            
           
        ]);

        return response()->json([
            'success' => true,
            'message' => 'User registered succesfully, Use Login method to receive token.'
        ], 200);
    }

 
    /**
     * Login user.
     *
     * @return json
     */
    public function login(Request $request)
    {
        $input = $request->only(['email', 'password']);

        $validate_data = [
            'email' => 'required|email',
            'password' => 'required|min:8',
        ];

        $validator = Validator::make($input, $validate_data);
        
        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Please see errors parameter for all errors.',
                'errors' => $validator->errors()
            ]);
        }

        // authentication attempt
        if (auth()->attempt($input)) {
            $token = auth()->user()->createToken('passport_token')->accessToken;
            
            return response()->json([
                'success' => true,
                'message' => 'User login succesfully, Use token to authenticate.',
                'data' => auth()->user(),
                'token' => $token,
                
                
            ], 200);
        } else {
            return response()->json([
                'success' => false,
                'message' => 'User authentication failed.'
            ], 401);
        }
    }


public function show($id)
    {
        $user = User::where('id', $id)->where('role','Customer')->get();

        if ($user->isEmpty()) {
            return response()->json([
                'success' => false,
                'message' => 'User Details Not Found'
            ], 404);
        }
        return response()->json([
            'success' => true,
            'message' => 'User Details Found',
            'data' => $user
        ], 200);
    }

public function getpermissions($id)
    {
        $user = User::where('id', $id)->where('role','Customer')->get();

        if ($user->isEmpty()) {
            return response()->json([
                'success' => false,
                'message' => 'User Details Not Found'
            ], 404);
        }
        return response()->json([
            'success' => true,
            'message' => 'User Details Found',
            'data' => $user
        ], 200);
    }




     public function update_permissions(Request $request, $id)
    {

        $sales = new User();
        $sales = User::find($id);
        if ($sales) {
            $sales->isinventory = $request->isinventory;
            $sales->isprofile = $request->isprofile;
            $sales->islowstock = $request->islowstock;
            $sales->save();

            return response()->json([
                'success' => true,
                'message' => ' Permission Assign Successfully Done.'
            ], 200);
        }
        
         return response()->json([
                'success' => true,
                'message' => ' Permissions Not Updated.'
            ], 404);

}

     public function update_users(Request $request, $id)
    {

        $sales = new User();
        $sales = User::find($id);

        if ($sales) {
            $sales->fullname = $request->fullname;
            $sales->email = $request->email;
            $sales->password = Hash::make($request->password);
            $sales->confirm_password = Hash::make($request->confirm_password);
            $sales->role = $request->role;
            $sales->gender = $request->gender;


            $sales->save();

            return response()->json([
                'success' => true,
                'message' => ' Given Details Updated Successfully.'
            ], 200);
        }
    }

    /**
     * Access method to authenticate.
     *
     * @return json
     */
    public function userDetail()
    {
        
        if (!auth()->check()) {
        return response()->json([
            'success' => false,
            'message' => 'User not authenticated.',
        ], 401); // 401 Unauthorized
    }
    
        return response()->json([
            'success' => true,
            'message' => 'Data fetched successfully.',
            'data' => auth()->user()
        ], 200);
    }

    /**
     * Logout user.
     *
     * @return json
     */
    public function logout()
    {
        $access_token = auth()->user()->token();

        // logout from only current device
        $tokenRepository = app(TokenRepository::class);
        $tokenRepository->revokeAccessToken($access_token->id);

        // use this method to logout from all devices
        // $refreshTokenRepository = app(RefreshTokenRepository::class);
        // $refreshTokenRepository->revokeRefreshTokensByAccessTokenId($$access_token->id);

        return response()->json([
            'success' => true,
            'message' => 'User logout successfully.'
        ], 200);
    }

    
 public function destroy_pricing($id)
{
    // Use the User model to retrieve the user
    $delete_Pricing = User::find($id);

    // Check if the user with the given ID exists
    if (!$delete_Pricing) {
        return response()->json([
            'success' => false,
            'message' => 'User not found.',
        ], 404);
    }

    // Delete the user
    $delete_Pricing->delete();

    return response()->json([
        'success' => true,
        'message' => 'User ' . $id . ' removed successfully.',
    ], 200);
}


 public function show_single_user(Request $request, $id)
    {
        $pricing = User::where('id', $id)->get();
        // $ids = $request->input('ids', []); // via injected instance of Request
        // $items1 = items::whereIn('id', explode(',', $id))->get();
        // $items1 = items::whereIn('id', explode(',', $id->$request->get()));

        if ($pricing->isEmpty()) {
            return response()->json([
                'success' => false,
                'message' => 'User Details Not Found'
            ], 404);
        }

        return response()->json([
            'success' => true,
            'message' => 'User Details Found',
            'data' => $pricing
        ], 200);
    }


}