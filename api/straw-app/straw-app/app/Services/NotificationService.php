<?php
namespace App\Services;
use App\RelUserNotificationToken;
use App\User;
use DB;
use Log;

class NotificationService {

    public function __construct() {

        DB::enableQueryLog();
    }

    public function isUserDeviceTokenUnique( $token ) {

        $cnt = RelUserNotificationToken::where( [
            ['token', '=', $token]
        ] )->count();
        return $cnt > 0 ? false : true;
    }

    public function isUserTokenExists( $userId, $type ) {

        $cnt = RelUserNotificationToken::where( [
            ['userId', '=', $userId],
            ['type', '=', $type],
        ] )->count();
        return $cnt > 0 ? true : false;
    }

    public function insertUserToken( $in_data ) {

        $data = RelUserNotificationToken::create($in_data);
        return $data;
    }

    public function updateUserData( $in_data ) {

        DB::table('rel_user_notification_tokens')->where( 'userId', $in_data['userId'] )->update($in_data);
        return $in_data['userId'];
    }

    public function getInsertedUserNotificationToken( $userId ) {

        return $result = DB::table('rel_user_notification_tokens AS runt')
                    ->leftJoin('users AS usr', 'runt.userId', '=', 'usr.id')
                    ->where( 'runt.userId', '=', $userId )
                    ->select(
                        'runt.id',
                        'runt.userId',
                        'runt.token AS deviceToken',
                        'runt.type AS deviceType',
                        'runt.status',
                        'usr.userName', 
                        'usr.universityEmail', 
                        'usr.gender', 
                        'usr.imageLink', 
                        'usr.studyingYear', 
                        'usr.branchId', 
                        'usr.status'
                    )
                    ->get();
    }

    public function getAllDeviceTokens( $userId = false ) {

        ini_set('max_execution_time', 0);

        if( $userId != false ) {

            // $result = RelUserNotificationToken::select('token')->where([
            //     ['userId', '!=', $userId]
            // ])->get(); 

            $result = DB::table('rel_user_notification_tokens AS runt')
                    ->leftJoin('user_notification_settings AS uns', 'runt.userId', '=', 'uns.userId')
                    ->select( 'runt.token AS token', 'uns.settings AS settings' )
                    ->where( [
                        ['runt.userId', '!=', $userId]
                    ] )
                    ->get();
            // print_r($result); die('die 1');

        } else {

            // $result = RelUserNotificationToken::select('token')->get(); 
            $result = DB::table('rel_user_notification_tokens AS runt')
                    ->leftJoin('user_notification_settings AS uns', 'runt.userId', '=', 'uns.userId')
                    ->select( 'runt.token AS token', 'uns.settings AS settings' )
                    // ->where( [
                    //     ['userId', '!=', $userId]
                    // ] )
                    ->get();
            // print_r($result); die('die 2');
        }
        ini_set('max_execution_time', 300);
        $ret = $result->toArray();
        return $ret;
    }

    public function getDeviceTokenByUserId( $userId ) {

        $result = RelUserNotificationToken::select('token')->where( 'userId', $userId )->get(); 
        return $result->toArray();
    }

    public function getNewPollReceivedInsertedUserNotificationTokenSettingsByPollId( $pollId ) {

        ini_set('max_execution_time', 0);
        $result = DB::table('polls AS poll')
                    ->leftJoin('user_notification_settings AS uns', 'poll.userId', '=', 'uns.userId')
                    ->leftJoin('rel_user_notification_tokens AS runt', 'poll.userId', '=', 'runt.userId')
                    ->leftJoin( 'users AS usr', 'poll.userId', '=', 'usr.id')
                    ->where( 'poll.id', '=', $pollId )
                    ->select(
                        'poll.id',
                        'poll.userId AS userId',
                        'poll.question',
                        'poll.imageLink',
                        'poll.allowComments',
                        'poll.status',
                        'uns.settings AS userNotificationSettings',
                        'runt.token AS deviceToken',
                        'usr.username AS pollCreatedBy'
                    )
                    ->get();
        ini_set('max_execution_time', 300);
        return $result;
    }

    public function getNewPollReceivedByPollIdExceptUser( $pollId, $userId ) {

        ini_set('max_execution_time', 0);
        $result = DB::table('polls AS poll')
                    ->leftJoin('user_notification_settings AS uns', 'poll.userId', '=', 'uns.userId')
                    ->leftJoin('rel_user_notification_tokens AS runt', 'poll.userId', '=', 'runt.userId')
                    ->leftJoin( 'users AS usr', 'poll.userId', '=', 'usr.id')
                    ->where( [
                        // ['poll.id', '=', $pollId],
                        ['runt.userId', '!=', $userId]
                    ] )
                    ->select(
                        'poll.id',
                        'poll.userId AS userId',
                        'poll.question',
                        'poll.imageLink',
                        'poll.allowComments',
                        'poll.status',
                        'uns.settings AS userNotificationSettings',
                        'runt.token AS deviceToken',
                        'usr.username AS pollCreatedBy'
                    )
                    ->get();
        ini_set('max_execution_time', 300);
        return $result;
    }

    public function getVoteReceivedOnUserPollInsertedUserNotificationTokenSettingsByPollId(  $pollId) {

        ini_set('max_execution_time', 0);
        $result = DB::table('polls AS poll')
                    ->leftJoin('user_notification_settings AS uns', 'poll.userId', '=', 'uns.userId')
                    ->leftJoin('rel_user_notification_tokens AS runt', 'poll.userId', '=', 'runt.userId')
                    ->leftJoin( 'users AS usrPoll', 'poll.userId', '=', 'usrPoll.id')
                    ->leftJoin('rel_poll_votes AS rpv', 'poll.id', '=', 'rpv.pollId')
                    ->leftJoin( 'users AS usrVoted', 'rpv.userId', '=', 'usrVoted.id')
                    ->where( 'poll.id', '=', $pollId )
                    ->select(
                        'poll.id',
                        'poll.userId AS userId',
                        'poll.question',
                        'poll.imageLink',
                        'poll.allowComments',
                        'poll.status',
                        'uns.settings AS userNotificationSettings',
                        'runt.token AS deviceToken',
                        'usrPoll.username AS pollCreatedBy',
                        'usrVoted.username AS pollVotedBy'
                    )
                    ->orderBy( 'rpv.id', 'desc' )
                    ->get();
        return $result;
    }

    /**
     * 
     * Cron job implementation
     * crontab -l
     * crontab -e
     * add below command( command is outside of this comment block ) *(slash)5 * * * * wget https://straw.blackcatzinc.com/straw-app/pollEnded
     * ctrl + x
     * save and exit
    */
    public function getPollEndedInsertedUserNotificationTokenSettings() {

        // date("Y-m-d h:i:s")
        // $currentDateTime = date("Y-m-d");
        // $day_before = date( 'Y-m-d', strtotime( $currentDateTime . ' -1 day' ) );

        $currentDateTime = date("Y-m-d h:i:s");
        $oneDayBeforeTime = date( 'Y-m-d h:i:s', strtotime( $currentDateTime . ' -1 day' ) );
        $min_diff = date( 'Y-m-d h:i:s', strtotime( $oneDayBeforeTime . ' -5 minutes' ) );

        ini_set('max_execution_time', 0);
        $result = DB::table('polls AS poll')
                    ->leftJoin('user_notification_settings AS uns', 'poll.userId', '=', 'uns.userId')
                    ->leftJoin('rel_user_notification_tokens AS runt', 'poll.userId', '=', 'runt.userId')
                    ->leftJoin( 'users AS usr', 'poll.userId', '=', 'usr.id')
                    // ->where( 'poll.id', '=', $pollId )
                    ->where([
                        // [ 'poll.published_at', '>=', $day_before ],
                        // [ 'poll.published_at', '<=', $currentDateTime ]

                        [ 'poll.published_at', '>=', $min_diff ],
                        [ 'poll.published_at', '<=', $oneDayBeforeTime ]
                    ])
                    ->select(
                        'poll.id',
                        'poll.userId AS userId',
                        'poll.question',
                        'poll.imageLink',
                        'poll.allowComments',
                        'poll.status',
                        'uns.settings AS userNotificationSettings',
                        'runt.token AS deviceToken',
                        'usr.username AS pollCreatedBy'
                    )
                    ->get();
        
        Log::info('Log starts for poll Ended');        
        $queries    = DB::getQueryLog();
        $lastQuery = end($queries);
        
        Log::info('Log query for poll Ended');              
        Log::info($lastQuery);

        Log::info('Log result for poll Ended');              
        Log::info($result);
        Log::info('Log ends for poll Ended');              

        ini_set('max_execution_time', 300);
        return $result;
    }

    public function sendPushNotification( $outTokens, $msg ) {

        $tokens = [];

        if( count($outTokens) < 1 ) {

            return response()->json([
                'message' => 'Tokens not found!',
                'error' => [ 'id' => 'Tokens not found!' ],
                'errorArr' => [ 'Tokens not found!' ],
                'data'  =>  []
            ], 200); 
        }

        ini_set('max_execution_time', 0);
        foreach( $outTokens AS $key => $val ) {
            $type = gettype( $val );
            if( $type == "object" ) {
                $tokens[] = $val->token;
            } else {
                $tokens[] = $val['token'];
            }
//             if( is_array( $val['token'] ) ) {
// die('if');
//                 $tokens[] = $val['token'];
//             } else {
// die('else');
//                 $tokens[] = $val->token;
//             }
        }

        $header = [
            'Authorization: Key='. SERVER_API_KEY,
            'Content-Type: Application/json'
        ];

        $apns = [
            'headers'       =>  [
                'apns-priority' =>  '10',
            ],
            'payload'       =>  [
                'aps'       =>  [
                    'sound' => 'default',
                ]
            ],
        ];
        
        /**
         * data for web
         * notification for iphone message
         * apns for iphone sound - vibration
         *  */ 
        $payload = [
            "registration_ids" 	=> $tokens,
            "data"				=>	$msg['data'],
            "notification"      =>  $msg['notification'],
            "apns"              =>  $apns
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
        ini_set('max_execution_time', 300);

        if( $err ) {
            return [
                'err' => 1,
                'data'  =>  $err
            ];
        } else {
            return [
                'err' => 0,
                'data' => json_decode($response),
                'tokens' => $tokens
            ];
        }
    }

    public function getDeviceTokensByPollId( $pollId ) {

        ini_set('max_execution_time', 0);
        $result = DB::table('users AS usr')
                        ->join('rel_user_notification_tokens AS runt', 'usr.id', '=', 'runt.userId')
                        ->Join('polls AS poll', 'usr.id', '=', 'poll.userId')
                        ->Join('rel_poll_branches AS rpb', 'usr.branchId', '=', 'rpb.branchId')
                        ->Join('rel_poll_genders AS rpg', 'usr.gender', '=', 'rpg.gender')
                        ->Join('rel_poll_years AS rpy', 'usr.studyingYear', '=', 'rpy.year')
                        ->Join('rel_user_countries AS ruc', 'usr.id', '=', 'ruc.userId')
                        ->Join('rel_poll_countries AS rpc', 'ruc.countryId', '=', 'rpc.countryId')
                        ->Join('rel_user_groups AS rug', 'usr.id', '=', 'rug.userId')
                        ->Join('rel_poll_groups AS rpgrp', 'rug.groupId', '=', 'rpgrp.groupId')
                        ->where( 'poll.id', '=', $pollId )
                        ->select(
                            'usr.id AS userId', 
                            'runt.token AS token' 
                        )
                        ->groupBy('usr.id')
                        ->groupBy('runt.token')
                        ->orderBy('usr.id')
                        ->get();
        ini_set('max_execution_time', 300);
        return $result;

        /*
        $qry = `SELECT 
                    usr.id AS userId, 
                    runt.token AS token 
                    
                    FROM users AS usr 
                    
                    INNER JOIN rel_user_notification_tokens AS runt 
                    ON usr.id = runt.userId 
                    
                    INNER JOIN polls AS poll 
                    ON usr.id = poll.userId 
                    
                    INNER JOIN rel_poll_branches AS rpb 
                    ON usr.branchId = rpb.branchId 
                    
                    INNER JOIN rel_poll_genders AS rpg 
                    ON usr.gender = rpg.gender 
                    
                    INNER JOIN rel_poll_years AS rpy 
                    ON usr.studyingYear = rpy.year 
                    
                    INNER JOIN rel_user_countries AS ruc 
                    ON usr.id = ruc.userId 
                    
                    INNER JOIN rel_poll_countries AS rpc 
                    ON ruc.countryId = rpc.countryId 
                    
                    INNER JOIN rel_user_groups AS rug 
                    ON usr.id = rug.userId 
                    
                    INNER JOIN rel_poll_groups AS rpgrp  
                    ON rug.groupId = rpgrp.groupId 
                    
                    WHERE poll.id = $pollId 
                    
                    GROUP BY usr.id 
                    ORDER BY usr.id `; */
    }

    public function newPollReceived( $pollId, $poll ) {

        $result = $this->getNewPollReceivedByPollIdExceptUser( $pollId, $poll['userId'] );
        $cnt = count((array)$result);
        if( isset( $result[0] ) && $cnt ) {
            
            $notificationSettings = json_decode( $result[0]->userNotificationSettings);
            if( 
                !empty( $notificationSettings ) && 
                isset( $notificationSettings->newPollReceived ) && 
                $notificationSettings->newPollReceived > 0  
            ) {
                
                $user = User::where( 'id', $poll['userId'] )->get()->first();
                $data = [
                    'title'	            =>	 "You've received a new Poll!",
                    // 'title'	            =>	$user['userName'] . ' created a new poll',
                    // 'title'	            =>	'Youâ€™ve been sent a Poll!',
                    // 'body'	            =>	$poll['question'],
                    // 'icon'	            =>	'images/icon.png',
                    // 'image'	            =>	'user.png',
                    'sound'             =>  'default',
                    'badge'             =>  '1',
                    'notificationFor'   => 'POLL_CREATED'
                ];

                $msg = [
                    'data'              =>  $data,
                    'notification'      =>  $data
                ];

                $out_data = $this->getAllDeviceTokens( $poll['userId'] );
                if( count( $out_data ) ) {

                    $tokens = [];
                    foreach( $out_data AS $key => $val ) {

                        $settings = json_decode( $val->settings );
                        if( 
                            !empty( $settings ) && 
                            isset( $settings->newPollReceived ) && 
                            $settings->newPollReceived > 0 
                        ) {
                           
                            $tokens[]['token'] = $val->token;
                        }
                    }
                    // $res = $this->sendPushNotification( $out_data, $msg );
                    $res = $this->sendPushNotification( $tokens, $msg );
                    return $res;
                } else {
                    return [
                        'err' => 1,
                        'date' => 'Tokens not found.'
                    ];
                }
            } else {
                return [
                    'err' => 1,
                    'date' => 'Poll received notifications are restricted by user.'
                ];
            }
        } else {
            return [
                'err' => 1,
                'date' => 'Settings not found.'
            ];
        }
    }

    public function newPollSent( $loggedInUser ) {

        $fcmNotificationToken  = isset( $loggedInUser->fcmNotificationToken ) && !empty( $loggedInUser->fcmNotificationToken ) ? $loggedInUser->fcmNotificationToken : '';
        $userNotificationSettings = isset( $loggedInUser->userNotificationSettings ) && !empty( $loggedInUser->userNotificationSettings ) ? $loggedInUser->userNotificationSettings : '';
        // print_r($userNotificationSettings); die;
        // if( isset( $userNotificationSettings->newPollReceived ) ) {

            // if( 
            //     !empty( $notificationSettings ) && 
            //     isset( $notificationSettings->newPollReceived ) && 
            //     $notificationSettings->newPollReceived > 0  
            // ) {
            
                $data = [
                    'title'	            =>	'You’ve been sent a Poll!',
                    // 'body'	            =>	$poll['question'],
                    // 'icon'	            =>	'images/icon.png',
                    // 'image'	            =>	'user.png',
                    'sound'             =>  'default',
                    'badge'             =>  '1',
                    'notificationFor'   => 'POLL_SENT'
                ];
        
                $msg = [
                    'data'              =>  $data,
                    'notification'      =>  $data
                ];
                
                if( !empty( $fcmNotificationToken ) ) {
                    
                    $res = $this->sendPushNotification( [['token' => $fcmNotificationToken]], $msg );
                    return $res;
                } else {
                    return [
                        'err' => 1,
                        'data' => 'Tokens not found.'
                    ];
                }
    
            // } else {
            //     return [
            //         'err' => 1,
            //         'data' => 'Poll sent notification is restricted by user.'
            //     ];
            // }
        // } else {

        //     return [
        //         'err' => 1,
        //         'data' => 'New poll received setting is not set.'
        //     ];
        // }
    }
    
    public function voteReceivedOnUserPoll( $pollId, $userId, $voteStatus ) {

        $result = $this->getVoteReceivedOnUserPollInsertedUserNotificationTokenSettingsByPollId( $pollId );
        $cnt = count((array)$result);
        if( isset( $result[0] ) && $cnt ) {

            $notificationSettings = json_decode( $result[0]->userNotificationSettings);
            if( 
                !empty( $notificationSettings ) && 
                isset( $notificationSettings->pollVoteReceived ) && 
                $notificationSettings->pollVoteReceived > 0  
            ) {
                
                $msgBody = $voteStatus == 'YES' ? 'upvoted' : 'downvoted';

                $data = [
                    'title'	            =>	'Your Poll received its first vote',
                    // 'body'	            =>	$result[0]->pollVotedBy . ' is '. $msgBody .' your poll.',
                    // 'icon'	            =>	'images/icon.png',
                    // 'image'	            =>	'user.png',
                    'sound'             =>  'default',
                    'badge'             =>  '1'
                ];

                $msg = [
                    'data'              =>  $data,
                    'notification'      =>  $data
                ];

                $outTokens = $this->getDeviceTokenByUserId( $userId );
                $res = $this->sendPushNotification( $outTokens, $msg );
                return $res;
            } else {
                return [
                    'err' => 1,
                    'date' => 'Votes notifications are restricted by user.'
                ];
            }
        } else {
            return [
                'err' => 1,
                'date' => 'Settings not found.'
            ];
        }
    }

    public function commentReceivedOnUserPoll( $pollId, $userId, $comment, $userName ) {

        $result = $this->getNewPollReceivedInsertedUserNotificationTokenSettingsByPollId( $pollId );
        $cnt = count((array)$result);
        if( isset( $result[0] ) && $cnt ) {
            
            $notificationSettings = json_decode( $result[0]->userNotificationSettings);
            if( 
                !empty( $notificationSettings ) && 
                isset( $notificationSettings->pollCommentReceived ) && 
                $notificationSettings->pollCommentReceived > 0 
            ) {
                
                $isLiked = $comment == 'YES' ? 'liked' : 'disliked';
                $data = [
                    // 'title'	            =>	$userName .' '. $isLiked .' your poll.',
                    // 'body'	            =>	$comment,
                    'title'	            =>	'Your Poll received a new comment',
                    // 'icon'	            =>	'images/icon.png',
                    // 'image'	            =>	'user.png',
                    'sound'             =>  'default',
                    'badge'             =>  '1'
                ];

                $msg = [
                    'data'              =>  $data,
                    'notification'      =>  $data
                ];
        
                $outTokens = $this->getDeviceTokenByUserId( $userId );
                $res = $this->sendPushNotification( $outTokens, $msg );
                return $res;
            } else {
                return [
                    'err' => 1,
                    'date' => 'Comments notifications are restricted by user.'
                ];
            }
        } else {
            return [
                'err' => 1,
                'date' => 'Settings not found.'
            ];
        }
    }

    /* public function pollEndedOld() {

        ini_set('max_execution_time', 0);
        $result = $this->getPollEndedInsertedUserNotificationTokenSettings();
        $cnt = count((array)$result);
        if( isset( $result ) && $cnt ) {
            
            $tokens = [];
            foreach( $result AS $key => $value ) {

                $notificationSettings = json_decode( $value->userNotificationSettings);
                if( $notificationSettings->pollEnded > 0 ) {

                    $tokens[] = [
                        'token' => $value->deviceToken
                    ];
                }
            }
            
            if( count( $tokens ) > 0 ) {

                $data = [
                    'title'	            =>	        'Your Poll has ended',
                    // 'body'	            =>	        'Your Poll has ended',
                    // 'icon'	            =>	        'images/icon.png',
                    // 'image'	            =>	        'user.png',
                    'sound'             =>          'default',
                    'badge'             =>          '1'
                ];

                $msg = [
                    'data'              =>  $data,
                    'notification'      =>  $data
                ];

                $res = $this->sendPushNotification( $tokens, $msg );
                ini_set('max_execution_time', 300);
                return $res;
            }
        } else {
            ini_set('max_execution_time', 300);
            return [
                'err' => 1,
                'date' => 'Settings not found.'
            ];
        }
    } */

    public function pollEnded() {

        ini_set('max_execution_time', 0);
        $result = $this->getPollEndedInsertedUserNotificationTokenSettings();
        $cnt = count((array)$result);
        if( isset( $result ) && $cnt ) {
            
            $tokens = [];
            $res = [];
            foreach( $result AS $key => $value ) {
                                    
                $notificationSettings = json_decode( $value->userNotificationSettings);
                if( 
                    !empty( $notificationSettings ) && 
                    isset( $notificationSettings->pollEnded ) && 
                    $notificationSettings->pollEnded > 0  
                ) {

                    $tokens[]['token'] = $value->deviceToken;

                    $data = [
                        'title'	            =>	        'Your Poll has ended',
                        'body'	            =>	        $value->question,
                        // 'icon'	            =>	        'images/icon.png',
                        // 'image'	            =>	        'user.png',
                        'sound'             =>          'default',
                        'badge'             =>          '1'
                    ];
    
                    $msg = [
                        'data'              =>  $data,
                        'notification'      =>  $data
                    ];
    
                    $res[] = $this->sendPushNotification( $tokens, $msg );
                }                
            }

            ini_set('max_execution_time', 300);
            return $res;
        } else {
            ini_set('max_execution_time', 300);
            return [
                'err' => 1,
                'date' => 'Settings not found.'
            ];
        }
    }
}
?>
