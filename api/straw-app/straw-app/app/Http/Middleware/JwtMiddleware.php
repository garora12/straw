<?php

namespace App\Http\Middleware;
use Closure;
use Exception;
use App\User;
use Firebase\JWT\JWT;
use Firebase\JWT\ExpiredException;
use DB;
use App\Services\UserService;


class JwtMiddleware {

    public function __construct( UserService $UserService ) {
        $this->userService = $UserService;
    }

    public function handle($request, Closure $next, $guard = null) {
        // DB::connection()->enableQueryLog();

        $token = $request->header('Token');
        
        if(!$token) {
            // Unauthorized response if token not there
            return response()->json([
                'message' => 'Token error!',
                'error' => ['tokenError' => 'Token not provided.'],
                'errorErr' => ['Token not provided.'],
                'data'  =>  [],
            ], 200);
        }
        try {
            $credentials = JWT::decode($token, env('JWT_SECRET'), ['HS256']);
        } catch(ExpiredException $e) {
            return response()->json([
                'message' => 'Session expired. Provided token is expired.!',
                'error' => ['tokenError' => 'Session expired. Provided token is expired!'],
                'errorArr' => ['Session expired. Provided token is expired.!'],
                'data'  =>  [],
            ], 200);
        } catch(Exception $e) {
            return response()->json([
                'message' => 'An error while decoding token!',
                'error' => ['tokenError' => 'An error while decoding token!'],
                'errorArr' => ['An error while decoding token!'],
                'data'  =>  [],
            ], 200);
        }
        // $user = User::find($credentials->sub);
        $user = $this->userService->getSignedInUserData( $credentials->sub );
        // if( $user !== NULL ) {
        if( $user ) {

            if( $user['status'] == 'BLOCKED' ) {

                return response()->json([
                    'message' => 'An error while fetching user against token!',
                    'error' => ['tokenError' => 'User is blocked by admin!'],
                    'errorArr' => ['User is blocked by admin!'],
                    'data'  =>  [],
                ], 200);
            } else {

                // Now let's put the user in the request class so that you can grab it from there
                $request->auth = (object)$user;
                return $next($request);
            }
        } else {

            return response()->json([
                'message' => 'An error while fetching user against token!',
                'error' => ['tokenError' => 'An error while fetching user against token!'],
                'errorArr' => ['An error while fetching user against token!'],
                'data'  =>  [],
            ], 200);
        }
    }
}