<?php
ini_set( 'display_errors', 1 ); error_reporting( E_ALL );
/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It is a breeze. Simply tell Lumen the URIs it should respond to
| and give it the Closure to call when that URI is requested.
|
*/

use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\Artisan;

$router->group(['middleware' => 'CorsMiddleware'], function($router) {

    $router->options(
        '/{any:.*}', 
        [
            'middleware' => ['CorsMiddleware'], 
            function (){ 
                return response(['status' => 'success']); 
            }
        ]
    );
    
    $router->get('/', function () use ($router) {
        return $router->app->version();
    });

    $router->get('/clear-cache', function() use ($router) {
        $exitCode = Artisan::call('cache:clear');
        return response(['status' => 'success', 'exitCode' => $exitCode]); 
    });
    
    // $router->get('laravel-send-email', [
    //     'uses' => 'EmailController@sendEMail'
    // ]);
    
    $router->post('forgot/password', [
        'uses' => 'UserController@forgotPassword'
    ]);
    
    $router->get('verifyForgotPasswordToken', [
        'uses' => 'UserController@verifyForgotPasswordToken'
    ]);

    $router->get('pushNotification', [
        'uses' => 'OpenController@loadPushNotificationView'
    ]);

    $router->get('pollEnded', [
        'uses' => 'PollController@pollEnded'
    ]);
    
    $router->post( 'resetPassword', [
        'uses' => 'UserController@resetPassword'
    ]);
    
    $router->post( 'auth/login', [
        'uses' => 'AuthController@authenticate'
    ]);
    
    $router->get( 'signup/data', [
        'uses' => 'OpenController@getSignUpData'
    ] );

    $router->get( 'decode/token', [
        'uses' => 'OpenController@decodeToken'
    ] );
    
    $router->post( 'signup', [
        'uses' => 'UserController@insertUser'
    ] );

    $router->get('poll/share/{slug}', [
        'uses' => 'PollController@sharePoll'
    ]);

    $router->get('storage/polls/{filename}', function ($filename) {
        $path = storage_path('polls/' . $filename);
    
        if (!File::exists($path)) {
            // abort(404);
            return 'file not found';
        } 
    
        $file = File::get($path);
        $type = File::mimeType($path);
    
        $response = response($file)->header('Content-Type',$type);
    
        return $response;
    });

    $router->get('images/{filename}', function ($filename) {
        $path = storage_path('images/' . $filename);
    
        if (!File::exists($path)) {
            // abort(404);
            return 'file not found';
        } 
    
        $file = File::get($path);
        $type = File::mimeType($path);
    
        $response = response($file)->header('Content-Type',$type);
    
        return $response;
    });
    
    $router->get('storage/{filename}', function ($filename) {
        $path = storage_path('images/' . $filename);
    
        if (!File::exists($path)) {
            // abort(404);
            return 'file not found';
        } 
    
        $file = File::get($path);
        $type = File::mimeType($path);
    
        $response = response($file)->header('Content-Type',$type);
    
        return $response;
    });

    $router->group([
        'prefix' => 'dashboard',
    ],
    function () use ($router) {

        $router->get('/totalUsers', [
            'uses' => 'UserController@getAllUsersCount'
        ]);

        $router->get('/totalPolls', [
            'uses' => 'PollController@getAllPollsCount'
        ]);

        $router->get('/totalLivePolls', [
            'uses' => 'PollController@getLivePollsCount'
        ]);

        $router->get('/totalVotedPolls', [
            'uses' => 'PollController@countPollsVotedDashboard'
        ]);
    }
    );
    
    $router->group([
            'prefix' => 'users',
        ], 
        function () use ($router) {
    
            $router->get('/universityEmailExists', [
                'uses' => 'UserController@isEmailExists'
            ]);
            
            $router->get('/userNameExists', [
                'uses' => 'UserController@isUserNameExists'
            ]);
        }
    );
    
    // Admin group
    $router->group(
        [
            'prefix' => 'admin',
            'middleware' => 'jwt.auth',
        ], 
        function () use ($router) {
    
            $router->get('/', function() {
                return 'admin';
            });
    
            // Users group
            $router->group( 
                [
                    'prefix' => 'users'
                ], 
                function() use ($router) {
    
                    $router->get('/universityEmailExists', [
                        'uses' => 'UserController@isEmailExists'
                    ]);
                
                    $router->get('/userNameExists', [
                        'uses' => 'UserController@isUserNameExists'
                    ]);

                    $router->post('/logout', [
                        'uses' => 'AuthController@logOut'
                    ]);
                    
                    $router->get('/{id}', [
                        'uses' => 'UserController@getUserById'
                    ]);
                
                    $router->get('/', [
                        'uses' => 'UserController@getAllUsers'
                    ]);
                
                    $router->post('/', [
                        'uses' => 'UserController@insertUser'
                    ]);
    
                    $router->post('/profilePic', [
                        'uses' => 'UserController@changeProfilePic'
                    ]);
    
                    $router->put('/', [
                        'uses' => 'UserController@updateUser'
                    ]);
    
                    $router->patch('/',[
                        'uses' => 'UserController@patchUser'
                    ]);
    
                    $router->delete('/', [
                        'uses' => 'UserController@softDeleteUser'
                    ]);
    
                    $router->delete('/hard', [
                        'uses' => 'UserController@hardDeleteUser'
                    ]);
                }
            );
    
            // Polls group
            $router->group(
                [
                    'prefix' => 'polls'
                ], 
                function() use ($router) {
                    
                    $router->get('/getPollsByUserId', [
                        'uses' => 'PollController@getPollsByUserId'
                    ]);

                    $router->get('/myLivePolls', [
                        'uses' => 'PollController@getMyLivePolls'
                    ]);

                    $router->get('/myPolls', [
                        'uses' => 'PollController@getMyPolls'
                    ]);

                    $router->get('/getLivePolls', [
                        'uses' => 'PollController@getLivePolls'
                    ]);

                    $router->get('/getVotedPolls', [
                        'uses' => 'PollController@getVotedPolls'
                    ]);

                    $router->get('/getPollsVotedByMe', [
                        'uses' => 'PollController@getPollsVotedByMe'
                    ]);

                    $router->post('/rePublish', [
                        'uses' => 'PollController@rePublishPoll'
                    ]);                    

                    $router->post('/changePollPic', [
                        'uses' => 'PollController@changePollPic'
                    ]);

                    $router->get('/getUserStats', [
                        'uses' => 'PollController@getUserStats'
                    ]);

                    $router->delete('/deletePollImageByPollId', [
                        'uses' => 'PollController@deletePollImageByPollId'
                    ]);

                    $router->delete('/hard', [
                        'uses' => 'PollController@hardDeletePoll'
                    ]);
    
                    $router->get('/{id}', [
                        'uses' => 'PollController@getPollById'
                    ]);
                
                    $router->get('/', [
                        'uses' => 'PollController@getAllPolls'
                    ]);
    
                    $router->post('/', [
                        'uses' => 'PollController@insertPoll'
                    ]);
    
                    $router->put('/', [
                        'uses' => 'PollController@updatePoll'
                    ]);
    
                    $router->patch('/',[
                        'uses' => 'PollController@patchPoll'
                    ]);
    
                    $router->delete('/', [
                        'uses' => 'PollController@softDeletePoll'
                    ]);
                }
            );

            // Votes group
            $router->group(
                [
                    'prefix' => 'votes'
                ], 
                function() use ($router) {

                    $router->get('/', [
                        'uses' => 'PollController@countPollVotesByPollId'
                    ]);
    
                    $router->post('/', [
                        'uses' => 'PollController@insertPollVote'
                    ]);
                }
            );

            // Comments group
            $router->group(
                [
                    'prefix' => 'comments'
                ], 
                function() use ($router) {

                    $router->get('/getPollCommentsByPollId', [
                        'uses' => 'PollController@getPollCommentsByPollId'
                    ]);
                    
                    $router->get('/likes', [
                        'uses' => 'PollController@insertCommentLikeDislike'
                    ]);

                    $router->post('/likes', [
                        'uses' => 'PollController@insertCommentLikeDislike'
                    ]);

                    $router->post('/', [
                        'uses' => 'PollController@insertPollComment'
                    ]);
                }
            );

            // notifications group
            $router->group(
                [
                    'prefix' => 'notification'
                ], 
                function() use ($router) {

                    $router->post('/saveUserNotification', [
                        'uses' => 'NotificationController@saveUserNotification'
                    ]);

                    $router->get('/getDeviceTokenByUserId', [
                        'uses' => 'NotificationController@getDeviceTokenByUserId'
                    ]);

                    $router->get('/sendPushNotification', [
                        'uses' => 'NotificationController@sendPushNotification'
                    ]);

                    $router->get('/pollEnded', [
                        'uses' => 'PollController@pollEnded'
                    ]);

                    $router->post( '/settings', [
                        'uses' => 'UserController@saveUserNotificationSettings'
                    ] );

                    $router->get( '/settings', [
                        'uses' => 'UserController@getInsertedUserNotificationSettings'
                    ] );
                }
            );
        }
    );
});