<?php
namespace App\Http\Controllers;
use Validator;
use App\User;
use App\RelUserNotificationToken;
use Firebase\JWT\JWT;
use Illuminate\Http\Request;
use Firebase\JWT\ExpiredException;
use Illuminate\Support\Facades\Hash;
use Laravel\Lumen\Routing\Controller as BaseController;

use App\Services\UserService;

class AuthController extends BaseController {
    
    /**
     * The request instance.
     *
     * @var \Illuminate\Http\Request
     */
    private $request;
    /**
     * Create a new controller instance.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return void
     */
    public function __construct(Request $request, UserService $UserService) {
        $this->request = $request;
        $this->userService = $UserService;
    }
    /**
     * Create a new token.
     * 
     * @param  \App\User   $user
     * 8760 hours for a year
     * 24 hours for a day
     * @return string
     */
    protected function jwt(User $user) {
        $payload = [
            'iss' => "lumen-jwt", // Issuer of the token
            'sub' => $user->id, // Subject of the token
            'iat' => time(), // Time when JWT was issued. 
            'exp' => time() + 60*60*8760 // Expiration time
        ];
        
        // As you can see we are passing `JWT_SECRET` as the second parameter that will 
        // be used to decode the token in the future.
        return JWT::encode($payload, env('JWT_SECRET'));
    } 
    /**
     * Authenticate a user and return the token if the provided credentials are correct.
     * 
     * @param  \App\User   $user 
     * @return mixed
     */
    public function authenticate(User $user) {
        
        $flag = 0;
        $rules = ['password'  => 'required'];
        $data = $this->request->input();

        if( isset( $data['universityEmail'] ) ) {

            $flag = 1;
            $rules['universityEmail'] = 'required|email';
        } else if( isset( $data['userName'] ) ) {

            $flag = 1;
            $rules['userName'] = 'required';
        }
        
        if( !$flag ) {

            return response()->json([
                'message'   =>      'Some errors occured',
                'error' =>          isset( $data['universityEmail'] ) ? [ 'universityEmail' => 'Email does not exist.'] : [ 'userName' => 'User name not exist.'],
                'errorArr'  =>      isset( $data['universityEmail'] ) ? ['Email does not exist.'] : ['User name not exist.'],
                'data'      =>      []
            ], 200);
        }

        $validator = Validator::make( $data, $rules);
        if ( !$validator->passes()) {

            // $messages = $validator->errors();
            // $messages->has('universityEmail');
            // print_r($validator->errors()->first('userName'));

            // TODO Handle your error
            return response()->json([
                'message'   =>      'Some errors occured',
                'error'     =>      $validator->errors(),
                'errorArr'  =>      $validator->errors()->all(),
                'data'      =>      []
            ], 200);
        } 
        
        $Userflag = '';
        // Find the user by email
        if( isset( $data['universityEmail'] ) ) {

            $Userflag = 'universityEmail';
            $user = User::where( [
                ['universityEmail', $this->request->input('universityEmail')],
                ['status', 'OPEN']
            ] )->first();
        } else {

            $Userflag = 'userName';
            $user = User::where([
                ['userName', $this->request->input('userName')],
                ['status', 'OPEN']
            ] )->first();
        }
        if (!$user) {
            // You wil probably have some sort of helpers or whatever
            // to make sure that you have the same response format for
            // differents kind of responses. But let's return the 
            // below respose for now.
            return response()->json([
                'message' => 'Some errors occured!',
                'error' => $Userflag == 'universityEmail' ? [ 'universityEmail' => 'Email does not exist.'] : [ 'userName' => 'User name not exist.'],
                'errorArr'  =>      $Userflag == 'universityEmail' ? ['Email does not exist.'] : ['User name not exist.'],
                'data'  =>  []
            ], 200);
        }
        // Verify the password and generate the token
        if (Hash::check($this->request->input('password'), $user->password)) {
            return response()->json(
                [
                    'message' => 'Token generated successfully!',
                    'error' => [],
                    'errorArr' => [],
                    'data'  =>  [
                        'token' => $this->jwt($user),
                        'user' => $this->userService->getSignedInUserData( $user->id )
                    ],
                ], 200);
        }
        // Bad Request response
        return response()->json([
            'error' => ['emailPassword' => 'Invalid Credentials.'],
            'errorArr' => ['Invalid Credentials.']
        ], 200);
    }

    public function logOut() {

        $loggedInUser = $this->request->auth->id;
        $result = RelUserNotificationToken::where( 'userId', $loggedInUser )->delete();
        if( $result ) {

            return response()->json([
                'message' => 'Logged out successfully!',
                'error' => [],
                'errorArr' => [],
                'data'  =>  [],
            ], 200);
        } else {

            return response()->json([
                'message' => 'Unable to logout!',
                'error' => [ 'id' => 'Unable to logout!'],
                'errorArr' => ['Unable to logout!'],
                'data'  =>  [],
            ], 200);
        }
    }
}