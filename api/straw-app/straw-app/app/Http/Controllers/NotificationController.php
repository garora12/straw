<?php

namespace App\Http\Controllers;
use Validator;
use Illuminate\Http\Request;
use App\RelUserNotificationToken;
use App\Services\NotificationService;
use App\Services\UserService;

class NotificationController extends Controller
{
    /**
     * The request instance.
     *
     * @var \Illuminate\Http\Request
     */
    private $request;
    private $loggedInUser;

    /**
     * Create a new controller instance.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return void
     */
    public function __construct(Request $request, NotificationService $notificationService, UserService $UserService) {
        $this->request = $request;
        $this->loggedInUser = $this->request->auth;
        $this->notificationService = $notificationService;
        $this->userService = $UserService;
    }

    public function saveUserNotification() {

        $data = $this->request->input();
        $rules = [
            'token'       =>      'required',
            'type'       =>      'required'
        ];

        $validator = Validator::make( $data, $rules);
        if ( !$validator->passes()) {

            return response()->json([
                'message'   =>      'Some errors occured',
                'error'     =>      $validator->errors(),
                'errorArr'  =>      $validator->errors()->all(),
                'data'      =>      []
            ], 200);
        } 

        if( !$this->notificationService->isUserDeviceTokenUnique( $data['token'] ) ) {
            
            return response()->json([
                'message'   =>      'Some errors occured',
                'error'     =>      ['token' => 'Token must be unique'],
                'errorArr'  =>      ['Token must be unique'],
                'data'      =>      []
            ], 200);
        }

        $data['userId'] = $this->loggedInUser->id;
        if( $this->notificationService->isUserTokenExists( $data['userId'], $data['type'] ) ) {
            
            $result = $this->notificationService->updateUserData( $data );
            if( $result > 0 ) {

                return response()->json([
                    'message'   =>      'Record updated successfully.',
                    'error'     =>      [],
                    'errorArr'  =>      [],
                    'data'      =>      [
                        'UserNotificationToken'     =>  $this->notificationService->getInsertedUserNotificationToken( $data['userId'] )
                    ]
                ], 200);                
            } else {
                return response()->json([
                    'message'   =>      'Some errors occured',
                    'error'     =>      $result,
                    'error'     =>      [$result],
                    'data'      =>      []
                ], 200); 
            }
        } else {
            
            $result = $this->notificationService->insertUserToken( $data );
            if( $result->id > 0 ) {

                return response()->json([
                    'message'   =>      'Record inserted successfully.',
                    'error'     =>      [],
                    'errorArr'  =>      [],
                    'data'      =>      [
                        'UserNotificationToken'     =>  $this->notificationService->getInsertedUserNotificationToken( $data['userId'] )
                    ]
                ], 200);
            } else {

                return response()->json([
                    'message'   =>      'Some errors occured',
                    'error'     =>      $result,
                    'error'     =>      [$result],
                    'data'      =>      []
                ], 200);
            }
        }
    }

    public function getDeviceTokenByUserId() {

        $data = $this->request->input();
        $rules = [
            'userId'       =>      'required'
        ];

        $validator = Validator::make( $data, $rules);
        if ( !$validator->passes()) {

            return response()->json([
                'message'   =>      'Some errors occured',
                'error'     =>      $validator->errors(),
                'errorArr'  =>      $validator->errors()->all(),
                'data'      =>      []
            ], 200);
        } 

        if( $this->userService->isUserIdExistsData( $data['userId'] ) ) {

            return response()->json([
                'message'   =>      'Record found!',
                'error'     =>      [],
                'errorArr'  =>      [],
                'data'      =>      [
                    'UserNotificationToken'     =>  $this->notificationService->getInsertedUserNotificationToken( $data['userId'] )
                ]
            ], 200);
        } else {

            return response()->json([
                'message' => 'Invalid user id!',
                'error' => [ 'id' => 'Invalid user id!' ],
                'errorArr' => [ 'Invalid user id!' ],
                'data'  =>  $data,
            ], 200);            
        }
    }

    // original
    /* public function sendPushNotification() {

        define('SERVER_API_KEY', 'AIzaSyDMJqJA9h3QpXjH0cuINWSt3FslAOlUpbU');

        $outTokens = $this->notificationService->getAllDeviceTokens();
        $tokens = [];

        if( count($outTokens) < 1 ) {

            return response()->json([
                'message' => 'Tokens not found!',
                'error' => [ 'id' => 'Tokens not found!' ],
                'errorArr' => [ 'Tokens not found!' ],
                'data'  =>  []
            ], 200); 
        }

        foreach( $outTokens AS $key => $val ) {
            $tokens[] = $val['token'];
        }

        $header = [
            'Authorization: Key='. SERVER_API_KEY,
            'Content-Type: Application/json'
        ];
    
        $msg = [
            'title'	=>	'Testing notification',
            'body'	=>	'Testing notification from localhost',
            'icon'	=>	'storage/icon.png',
            'image'	=>	'storage/user.png'
        ];
        
        $payload = [
            'registration_ids' 	=> $tokens,
            'data'				=>	$msg
        ];

        $curl = curl_init();

        curl_setopt_array($curl, array(
        CURLOPT_URL => "https://fcm.googleapis.com/fcm/send",
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_CUSTOMREQUEST => "POST",
            CURLOPT_POSTFIELDS => json_encode($payload),
            CURLOPT_HTTPHEADER => $header,
        ));

        $response = curl_exec($curl);
        $err = curl_error($curl);

        curl_close($curl);

        if( $err ) {

            return response()->json([
                'message' => 'Notification error!',
                'error' => [],
                'errorArr' => [],
                'data'  =>  $err
            ], 200);
        } else {

            return response()->json([
                'message' => 'Notification sent!',
                'error' => [],
                'errorArr' => [],
                'data'  =>  json_decode($response)
            ], 200);
        }
    } */

    // for testing
    public function sendPushNotification() {

        $outTokens = $this->notificationService->getAllDeviceTokens();
        $tokens = [];

        if( count($outTokens) < 1 ) {

            return response()->json([
                'message' => 'Tokens not found!',
                'error' => [ 'id' => 'Tokens not found!' ],
                'errorArr' => [ 'Tokens not found!' ],
                'data'  =>  []
            ], 200); 
        }

        foreach( $outTokens AS $key => $val ) {
            $tokens[] = $val['token'];
        }

        $data = [
            'title'	            =>	'Testing notification',
            'body'	            =>	'Testing notification from localhost',
            'icon'	            =>	'images/icon.png',
            'image'	            =>	'user.png',
            'sound'             =>  'default',
            'badge'             =>  '1'
        ];

        $msg = [
            'data'              =>  $data,
            'notification'      =>  $data
        ];
        
        $res = $this->notificationService->sendPushNotification( $outTokens, $msg );
        if( $res['err'] ) {
            return response()->json([
                'message' => 'Notification error!',
                'error' => [],
                'errorArr' => [],
                'data'  =>  $res['data']
            ], 200);
        } else {
            return response()->json([
                'message' => 'Notification sent!',
                'error' => [],
                'errorArr' => [],
                'data'  =>  $res['data']
            ], 200);
        }
    }
}
