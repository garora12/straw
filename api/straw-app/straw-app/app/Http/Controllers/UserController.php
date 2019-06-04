<?php

namespace App\Http\Controllers;
use Validator;
use App\User;
use App\RelUserGroup;
use Firebase\JWT\JWT;
use Illuminate\Http\Request;
use Firebase\JWT\ExpiredException;
use Illuminate\Support\Facades\Hash;
use Laravel\Lumen\Routing\Controller as BaseController;

use Illuminate\Support\Facades\Mail;
use Redirect,Response,DB,Config;

use App\Services\UserService;
use App\Services\UserNotificationSettingService;
use App\Services\UserPointsService;

class UserController extends BaseController {

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
    public function __construct(Request $request, UserService $UserService, UserNotificationSettingService $UserNotificationSettingService, UserPointsService $UserPointsService) {
        $this->request = $request;
        $this->loggedInUser = $this->request->auth;
        $this->userService = $UserService;
        $this->userPointsService = $UserPointsService;
        $this->userNotificationSettingService = $UserNotificationSettingService;
    }

    public function getAllUsersCount() {

        $in_data = [];
        return response()->json([
            'message' => 'Records found!',
            'error' => [],
            'errorArr' => [],
            'cnt' => $this->userService->getAllUsersDataCount( $in_data )
        ], 200);
    }

    public function getAllUsers() {

        $in_data = $this->request->input();
        $in_data = [
            'offset'    =>  isset($in_data['offset']) ? $in_data['offset'] : 0,
            'limit'     =>  isset($in_data['limit']) ? $in_data['limit'] : 10,
            'search'    =>  isset($in_data['search']) ? $in_data['search'] : ''
        ];
        $users = $this->userService->getAllUsersData( $in_data );
        if( count( $users ) ) {

            return response()->json([
                'message' => 'Records found!',
                'error' => [],
                'errorArr' => [],
                'data'  =>  $users,
                'cnt' => $this->userService->getAllUsersDataCount( $in_data )
            ], 200);
        } else {

            return response()->json([
                'message' => 'Record not found!',
                'error' => [],
                'errorArr' => ['Record not found!'],
                'data'  =>  $users,
            ], 200);
        }
    }

    public function getUserById( $in_id ) {
        
        $data = [ 'id' => $in_id ];
        $rules = [ 'id'        =>  'required|numeric|min:1' ];

        $validator = Validator::make( $data, $rules);
        if ( !$validator->passes()) {

            // TODO Handle your error
            return response()->json([
                'message'   =>      'Some errors occured',
                'error'     =>      $validator->errors(),
                'errorArr'  =>      $validator->errors()->all(),
                'data'      =>      []
            ], 200);
        } 

        $id = intval($in_id);
        $user = $this->userService->getSignedInUserData( $id );
        $cnt = count((array)$user);
        if( $cnt ) {

            return response()->json([
                'message' => 'Records found!',
                'error' => [],
                'errorArr'  =>  [],
                'data'  =>  $user,
            ], 200);
        } else {

            return response()->json([
                'message' => 'Record not found!',
                'error' => ['Record not found!'],
                'errorArr'  =>  ['Record not found!'],
                'data'  =>  $user,
            ], 200);
        }
    }

    public function isUserNameExists() {

        $data = $this->request->input();
        $rules = ['userName' => 'required'];

        if( isset( $data['id'] ) ) {
            $rules['id'] = 'required|numeric|min:1';
        }

        $validator = Validator::make( $data, $rules);
        if ( !$validator->passes()) {

            // TODO Handle your error
            return response()->json([
                'message'   =>      'Some errors occured',
                'error'     =>      $validator->errors(),
                'errorArr'  =>      $validator->errors()->all(),
                'data'      =>      []
            ], 200);
        } 

        $data['id'] = isset( $data['id'] ) ? intval( $data['id'] ) : false;
        if( $this->userService->isUserNameExistsData( $data['userName'], $data['id'] ) ) {

            return response()->json([
                'message'   =>      'Some errors occured',
                'error'     =>      [ "userName" => "User name(". $data['userName'] .") exists already!"],
                'errorArr'  =>      ["User name(". $data['userName'] .") exists already!"],
                'data'      =>      []
            ], 200);
        } else {

            return response()->json([
                'message'   =>      'Username is available',
                'error'     =>      [],
                'errorArr'     =>      [],
                'data'      =>      []
            ], 200);
        }
    }

    public function isEmailExists() {

        $data = $this->request->input();
        $rules = [ 'universityEmail' => 'required|email' ];
        
        if( isset( $data['id'] ) ) {
            $rules['id'] = 'required|numeric|min:1';
        }

        $validator = Validator::make( $data, $rules);
        if ( !$validator->passes()) {

            // TODO Handle your error
            return response()->json([
                'message'   =>      'Some errors occured',
                'error'     =>      $validator->errors(),
                'errorArr'  =>      $validator->errors()->all(),
                'data'      =>      []
            ], 200);
        } 

        $data['id'] = isset( $data['id'] ) ? intval( $data['id'] ) : false;
        if( $this->userService->isEmailExistsData( $data['universityEmail'], $data['id'] ) ) {

            return response()->json([
                'message'   =>      'Some errors occured',
                'error'     =>      [ "universityEmail" => "University email(". $data['universityEmail'] .") exists already!"],
                'errorArr'  =>      ["University email(". $data['universityEmail'] .") exists already!"],
                'data'      =>      []
            ], 200);
        } else {

            return response()->json([
                'message'   =>      'Email is available',
                'error'     =>      [],
                'errorArr'     =>      [],
                'data'      =>      []
            ], 200);
        }
    }

    public function insertUser() {

        $data = $this->request->input();        
        $rules = [
            'password'              =>      'required',
            'userName'              =>      'required',
            'universityEmail'       =>      'required|email',
            'gender'                =>      'required',
            'studyingYear'          =>      'required|numeric|min:1|max:4',
            'branchId'              =>      'required|numeric|min:1',
            'countryIds'            =>      'required',
            'groupIds'              =>      'required'
        ];

        $validator = Validator::make( $data, $rules);
        if ( !$validator->passes()) {

            // TODO Handle your error
            return response()->json([
                'message'   =>      'Some errors occured',
                'error'     =>      $validator->errors(),
                'errorArr'  =>      $validator->errors()->all(),
                'data'      =>      []
            ], 200);
        } 

        $in_email = $data['universityEmail'];
        $in_emailArr = explode( '@', $in_email );
        $checkEmail = $in_emailArr[1];
        $allowedDomain = [
            'ucl.ac.uk',
            'co.uk'
        ];

        if( !in_array( $checkEmail, $allowedDomain ) ) {

            return response()->json([
                'message'   =>      'Some errors occured',
                'error'     =>      ["universityEmail" => "Email with ucl.ac.uk and co.uk is allowed!"],
                'errorArr'  =>      ["Email with ucl.ac.uk and co.uk is allowed!"],
                'data'      =>      []
            ], 200);
        }
        
        $strGroupIds = $data['groupIds'];
        unset($data['groupIds']);
        $strCountryIds = $data['countryIds'];
        unset($data['countryIds']);

        $groupIds = explode( ',', $strGroupIds );
        $countryIds = explode( ',', $strCountryIds );
        
        if( !is_array( $groupIds ) || (count( $groupIds ) < 1) ) {

            return response()->json([
                'message'   =>      'Some errors occured',
                'error'     =>      ["groupIds" => "Groups not provided!"],
                'errorArr'  =>      ["Groups not selected!"],
                'data'      =>      []
            ], 200);
        }

        if( !is_array( $countryIds ) || (count( $countryIds ) < 1) ) {

            return response()->json([
                'message'   =>      'Some errors occured',
                'error'     =>      ["countryIds" => "Countries not provided!"],
                'errorArr'  =>      ["Countries not selected!"],
                'data'      =>      []
            ], 200);
        }

        if( $this->userService->isUserNameExistsData( $data['userName'] ) ) {

            return response()->json([
                'message'   =>      'Some errors occured',
                'error'     =>      ["userName" => "User name(". $data['userName'] .") exists already!"],
                'errorArr'  =>      ["User name(". $data['userName'] .") exists already!"],
                'data'      =>      []
            ], 200);
        }
        
        if( $this->userService->isEmailExistsData( $data['universityEmail'] ) ) {

            return response()->json([
                'message'   =>      'Some errors occured',
                'error'     =>      [ "universityEmail" => "University email(". $data['universityEmail'] .") exists already!"],
                'errorArr'     =>      ["University email(". $data['universityEmail'] .") exists already!"],
                'data'      =>      []
            ], 200);
        }

        if( $this->request->file('imageLink') ) {

            $image = $this->request->file('imageLink');
            $input['imagename'] = time().'.'.$image->getClientOriginalExtension();
            $destinationPath = storage_path('images');
            $image->move($destinationPath, $input['imagename']);

            $data['imageLink'] = $input['imagename'];
        } 

        $data['password'] = Hash::make($data['password']);
        $result = $this->userService->insertUserData( $data );
        if( $result->id > 0 ) {
            
            $user = $this->userService->getUserByIdData( $result->id );
            $cnt = count((array)$user);
            if( $cnt ) {
                
                $this->userService->insertUserGroups( $user->id, $groupIds );
                $this->userService->insertUserCountries( $user->id, $countryIds );
                $in_data = [
                    'userId' => $user->id,
                    'type' => 'IPHONE',
                    'settings' => '{"newPollReceived":"1","pollVoteReceived":"1","pollCommentReceived":"1","pollEnded":"1"}'
                ];
                $this->userNotificationSettingService->insertUserNotificationSettings( $in_data );
                $this->userPointsService->insertUserPoints([
                    'pollId' => 0,
                    'userId' => $user->id,
                    'transactionFor' => 'SIGNUP'
                ]);

                $payload = [
                    'iss' => "lumen-jwt", // Issuer of the token
                    'sub' => $user->id, // Subject of the token
                    'iat' => time(), // Time when JWT was issued. 
                    'exp' => time() + 60*60 // Expiration time
                ];
                
                return response()->json([
                    'message'   =>      'Record inserted successfully.',
                    'error'     =>      [],
                    'errorArr'  =>      [],
                    'data'      =>      [
                        'user'     =>      $this->userService->getSignedInUserData( $user->id ),
                        'token'     =>      JWT::encode($payload, env('JWT_SECRET'))
                    ]
                ], 200);
            } else {

                return response()->json([
                    'message' => 'Record saved but not retrieved!',
                    'error' => ['Record saved but not retrieved!'],
                    'errorArr' => ['Record saved but not retrieved!'],
                    'data'  =>  [],
                ], 200);
            }
        } else {

            return response()->json([
                'message'   =>      'Some errors occured',
                'error'     =>      $result,
                'error'     =>      [$result],
                'data'      =>      []
            ], 200);
        }
    }

    public function updateUser() {
        
        $oldUserData;
        $data = $this->request->input();
        $rules = [
            'id'                    =>      'required|numeric|min:1',
            'userName'              =>      'required',
            'universityEmail'       =>      'required|email',
            'gender'                =>      'required',
            'studyingYear'          =>      'required|numeric|min:1|max:4',
            'branchId'              =>      'required|numeric|min:1',
            'countryIds'            =>      'required',
            'groupIds'              =>      'required'
        ];

        isset($data['password']) ? $rules['password']  = 'required' : '';
        $validator = Validator::make( $data, $rules);
        if ( !$validator->passes()) {

            // TODO Handle your error
            return response()->json([
                'message'   =>      'Some errors occured',
                'error'     =>      $validator->errors(),
                'errorArr'  =>      $validator->errors()->all(),
                'data'      =>      []
            ], 200);
        } 

        $in_email = $data['universityEmail'];
        $in_emailArr = explode( '@', $in_email );
        $checkEmail = $in_emailArr[1];
        $allowedDomain = [
            'ucl.ac.uk',
            'co.uk'
        ];

        if( !in_array( $checkEmail, $allowedDomain ) ) {

            return response()->json([
                'message'   =>      'Some errors occured',
                'error'     =>      ["universityEmail" => "Email with ucl.ac.uk and co.uk is allowed!"],
                'errorArr'  =>      ["Email with ucl.ac.uk and co.uk is allowed!"],
                'data'      =>      []
            ], 200);
        }

        $strGroupIds = $data['groupIds'];
        unset($data['groupIds']);
        $strCountryIds = $data['countryIds'];
        unset($data['countryIds']);

        $groupIds = explode( ',', $strGroupIds );
        $countryIds = explode( ',', $strCountryIds );
        
        if( !is_array( $groupIds ) || (count( $groupIds ) < 1) ) {

            return response()->json([
                'message'   =>      'Some errors occured',
                'error'     =>      ["groupIds" => "Groups not provided!"],
                'errorArr'  =>      ["Groups not selected!"],
                'data'      =>      []
            ], 200);
        }

        if( !is_array( $countryIds ) || (count( $countryIds ) < 1) ) {

            return response()->json([
                'message'   =>      'Some errors occured',
                'error'     =>      ["countryIds" => "Countries not provided!"],
                'errorArr'  =>      ["Countries not selected!"],
                'data'      =>      []
            ], 200);
        }

        $id = intval( $data['id'] );
        $user = $this->userService->isUserIdExistsData( $id );
        if( !$user ) {

            return response()->json([
                'message' => 'Invalid user id!',
                'error' => [ 'id' => 'Invalid user id!' ],
                'errorArr' => [ 'Invalid user id!' ],
                'data'  =>  $user,
            ], 200);
        } 

        $oldUserData = $this->userService->getUserByIdData( $id );
        $cnt = count((array)$oldUserData);
        if( !$cnt ) {

            return response()->json([
                'message' => 'Record not found!',
                'error' => [],
                'errorArr' => [],
                'data'  =>  $user,
            ], 200);
        }

        if( $this->userService->isUserNameExistsData( $data['userName'], $id ) ) {

            return response()->json([
                'message'   =>      'Some errors occured',
                'error'     =>      [ "userName" => "User name(". $data['userName'] .") exists already!"],
                'errorArr'     =>      ["User name(". $data['userName'] .") exists already!"],
                'data'      =>      []
            ], 200);
        }
        
        if( $this->userService->isEmailExistsData( $data['universityEmail'], $id ) ) {

            return response()->json([
                'message'   =>      'Some errors occured',
                'error'     =>      [ "universityEmail" => "University email(". $data['universityEmail'] .") exists already!"],
                'errorArr'     =>     ["University email(". $data['universityEmail'] .") exists already!"],
                'data'      =>      []
            ], 200);
        }

        $data['password'] = isset($data['password']) ? Hash::make($data['password']) : $oldUserData['password'];
        $id = $this->userService->updateUserData( $data );
        if( $id > 0 ) {

            $user = $this->userService->getUserByIdData( $id );
            $cnt = count((array)$user);
            if( $cnt ) {

                $this->userService->insertUserGroups( $id, $groupIds );
                $this->userService->insertUserCountries( $id, $countryIds );

                return response()->json([
                    'message'   =>      'Record updated successfully.',
                    'error'     =>      [],
                    'errorArr'     =>      [],
                    'data'      =>      [
                        'user'     =>      $this->userService->getSignedInUserData( $user->id ),
                    ]
                ], 200);
            } else {

                return response()->json([
                    'message' => 'Record saved but not retrieved!',
                    'error' => [],
                    'errorArr'     =>      [],
                    'data'  =>  [],
                ], 200);
            }
        } else {

            return response()->json([
                'message'   =>      'No data to update the record.',
                'error'     =>      ['No data to update the record.'],
                'errorArr'     =>      ['No data to update the record.'],
                'data'      =>      []
            ], 200);
        }
    }

    public function patchUser() {

        $data = $this->request->input();
        $rules = ['id' => 'required|numeric|min:1'];

        if( count( $data ) <= 0 ) {

            return response()->json([
                'message'   =>      'Some errors occured',
                'error'     =>      ['No key provided to patch.'],
                'errorArr'     =>      ['No key provided to patch.'],
                'data'      =>      []
            ], 200);
        } else if(  isset( $data['id'] ) && count( $data ) <= 1 ) {

            return response()->json([
                'message'   =>      'Some errors occured',
                'error'     =>      ['Data not provided to patch.'],
                'errorArr'     =>      ['Data not provided to patch.'],
                'data'      =>      []
            ], 200);
        }

        isset($data['password']) ? $rules['password']  = 'required' : '';
        isset($data['userName']) ? $rules['userName']  = 'required' : '';
        isset($data['universityEmail']) ? $rules['universityEmail']  = 'required' : '';
        isset($data['gender']) ? $rules['gender']  = 'required' : '';
        isset($data['studyingYear']) ? $rules['studyingYear']  = 'required|numeric|min:1|max:4' : '';
        isset($data['branchId']) ? $rules['branchId']  = 'required|numeric|min:1' : '';
        isset($data['countryIds']) ? $rules['countryIds']  = 'required' : '';
        isset($data['groupIds']) ? $rules['groupIds']  = 'required' : '';

        $validator = Validator::make( $data, $rules);
        if ( !$validator->passes()) {

            // TODO Handle your error
            return response()->json([
                'message'   =>      'Some errors occured',
                'error'     =>      $validator->errors(),
                'errorArr'  =>      $validator->errors()->all(),
                'data'      =>      []
            ], 200);
        } 

        if( isset($data['universityEmail']) ) {

            $in_email = $data['universityEmail'];
            $in_emailArr = explode( '@', $in_email );
            $checkEmail = $in_emailArr[1];
            $allowedDomain = [
                'ucl.ac.uk',
                'co.uk'
            ];
    
            if( !in_array( $checkEmail, $allowedDomain ) ) {
    
                return response()->json([
                    'message'   =>      'Some errors occured',
                    'error'     =>      ["universityEmail" => "Email with ucl.ac.uk and co.uk is allowed!"],
                    'errorArr'  =>      ["Email with ucl.ac.uk and co.uk is allowed!"],
                    'data'      =>      []
                ], 200);
            }
        }

        if( isset($data['groupIds']) ) {

            $strGroupIds = $data['groupIds'];
            unset($data['groupIds']);
            $groupIds = explode( ',', $strGroupIds );

            if( !is_array( $groupIds ) || (count( $groupIds ) < 1) ) {

                return response()->json([
                    'message'   =>      'Some errors occured',
                    'error'     =>      ["groupIds" => "Groups not provided!"],
                    'errorArr'  =>      ["Groups not selected!"],
                    'data'      =>      []
                ], 200);
            }
        }

        if( isset($data['countryIds']) ) {

            $strCountryIds = $data['countryIds'];
            unset($data['countryIds']);
            $countryIds = explode( ',', $strCountryIds );
            
            if( !is_array( $countryIds ) || (count( $countryIds ) < 1) ) {
    
                return response()->json([
                    'message'   =>      'Some errors occured',
                    'error'     =>      ["countryIds" => "Countries not provided!"],
                    'errorArr'  =>      ["Countries not selected!"],
                    'data'      =>      []
                ], 200);
            }
        }

        $id = intval( $data['id'] );
        $user = $this->userService->isUserIdExistsData( $id );
        if( !$user ) {

            return response()->json([
                'message' => 'Invalid user id!',
                'error' => [ 'id' => 'Invalid user id!' ],
                'errorArr' => [ 'Invalid user id!' ],
                'data'  =>  $user,
            ], 200);
        } 

        $oldUserData = $this->userService->getUserByIdData( $id );
        $cnt = count((array)$oldUserData);
        if( !$cnt ) {

            return response()->json([
                'message' => 'Record not found!',
                'error' => [],
                'errorArr' => [],
                'data'  =>  $user,
            ], 200);
        }

        if( isset($data['userName']) && $this->userService->isUserNameExistsData( $data['userName'], $id ) ) {

            return response()->json([
                'message'   =>      'Some errors occured',
                'error'     =>      [ "userName" => "User name(". $data['userName'] .") exists already!"],
                'errorArr'     =>   [ "User name(". $data['userName'] .") exists already!"],
                'data'      =>      []
            ], 200);
        }
        
        if( isset($data['universityEmail']) && $this->userService->isEmailExistsData( $data['universityEmail'], $id ) ) {

            return response()->json([
                'message'   =>      'Some errors occured',
                'error'     =>      ["universityEmail" => "University email(". $data['universityEmail'] .") exists already!"],
                'errorArr'     =>   ["University email(". $data['universityEmail'] .") exists already!"],
                'data'      =>      []
            ], 200);
        }

        $in_data = [
            'id' => $oldUserData['id'],
            'userName' => isset($data['userName']) ? $data['userName'] : $oldUserData['userName'],
            'universityEmail' => isset($data['universityEmail']) ? $data['universityEmail'] : $oldUserData['universityEmail'],
            'password' => isset($data['password']) ? Hash::make($data['password']) : $oldUserData['password'],
            'gender' => isset($data['gender']) ? $data['gender'] : $oldUserData['gender'],
            'studyingYear' => isset($data['studyingYear']) ? $data['studyingYear'] : $oldUserData['studyingYear'],
            'branchId' => isset($data['branchId']) ? $data['branchId'] : $oldUserData['branchId'],
            'status' => isset($data['status']) ? $data['status'] : $oldUserData['status']
        ];

        $result = $this->userService->updateUserData( $in_data );
        if( $result > 0 ) {

            $user = $this->userService->getUserByIdData( $data['id'] );
            $cnt = count((array)$user);
            if( $cnt ) {

                isset( $groupIds ) ? $this->userService->insertUserGroups( $id, $groupIds ) : '';
                isset( $countryIds ) ? $this->userService->insertUserCountries( $id, $countryIds ) : '';
                
                return response()->json([
                    'message'   =>      'Record updated successfully.',
                    'error'     =>      [],
                    'errorArr'     =>      [],
                    'data'      =>      [
                        'user'     =>      $this->userService->getSignedInUserData( $user->id )
                    ]
                ], 200);
            } else {

                return response()->json([
                    'message' => 'Record saved but not retrieved!',
                    'error' => [],
                    'errorArr' => [],
                    'data'  =>  [],
                ], 200);
            }
        } else {

            return response()->json([
                'message'   =>      'No data to update the record.',
                'error'     =>      [],
                'errorArr'     =>      [],
                'data'      =>      []
            ], 200);
        }
    }

    public function changeProfilePic() {

        $data = $this->request->input();
        $rules = [
            'id'                    =>      'required|numeric|min:1',
        ];
        $validator = Validator::make( $data, $rules);
        if ( !$validator->passes()) {

            // TODO Handle your error
            return response()->json([
                'message'   =>      'Some errors occured',
                'error'     =>      $validator->errors(),
                'errorArr'  =>      $validator->errors()->all(),
                'data'      =>      []
            ], 200);
        } 

        $id = intval( $data['id'] );
        $user = $this->userService->isUserIdExistsData( $id );
        if( !$user ) {

            return response()->json([
                'message' => 'Invalid user id!',
                'error' => [ 'id' => 'Invalid user id!' ],
                'errorArr' => [ 'Invalid user id!' ],
                'data'  =>  $user,
            ], 200);
        } 

        $oldUserData = $this->userService->getUserByIdData( $id );
        $cnt = count((array)$oldUserData);
        if( !$cnt ) {

            return response()->json([
                'message' => 'Record not found!',
                'error' => [],
                'errorArr' => [],
                'data'  =>  $user,
            ], 200);
        }

        if( $this->request->file('imageLink') ) {

            $image = $this->request->file('imageLink');
            $input['imagename'] = time().'.'.$image->getClientOriginalExtension();
            $destinationPath = storage_path('/images');
            $image->move($destinationPath, $input['imagename']);
            
            $data['imageLink'] = $input['imagename'];
        } else {

            return response()->json([
                'message'   =>      'Some errors occured',
                'error'     =>      [ 'imageLink' => 'Kindly upload image.' ],
                'errorArr'  =>      ['Kindly upload image.'],
                'data'      =>      []
            ], 200);
        }

        $in_data = [
            'id' => $oldUserData['id'],
            'userName' => isset($data['userName']) ? $data['userName'] : $oldUserData['userName'],
            'universityEmail' => isset($data['universityEmail']) ? $data['universityEmail'] : $oldUserData['universityEmail'],
            'password' => isset($data['password']) ? Hash::make($data['password']) : $oldUserData['password'],
            'gender' => isset($data['gender']) ? $data['gender'] : $oldUserData['gender'],
            'studyingYear' => isset($data['studyingYear']) ? $data['studyingYear'] : $oldUserData['studyingYear'],
            'branchId' => isset($data['branchId']) ? $data['branchId'] : $oldUserData['branchId'],
            'status' => isset($data['status']) ? $data['status'] : $oldUserData['status'],
            'imageLink' => $data['imageLink']
        ];

        $result = $this->userService->updateUserData( $in_data );
        if( $result > 0 ) {

            $user = $this->userService->getUserByIdData( $data['id'] );
            $cnt = count((array)$user);
            if( $cnt ) {
                
                return response()->json([
                    'message'   =>      'Record updated successfully.',
                    'error'     =>      [],
                    'errorArr'     =>      [],
                    'data'      =>      [
                        'user'     =>      $this->userService->getSignedInUserData( $user->id ),
                    ]
                ], 200);
            } else {

                return response()->json([
                    'message' => 'Record saved but not retrieved!',
                    'error' => [],
                    'errorArr' => [],
                    'data'  =>  [],
                ], 200);
            }
        } else {

            return response()->json([
                'message'   =>      'No data to update the record.',
                'error'     =>      [],
                'errorArr'     =>      [],
                'data'      =>      []
            ], 200);
        }
    }

    public function softDeleteUser() {
        
        $data = $this->request->input();
        $rules = [ 'id'        =>  'required|numeric|min:1' ];

        $validator = Validator::make( $data, $rules);
        if ( !$validator->passes()) {

            // TODO Handle your error
            return response()->json([
                'message'   =>      'Some errors occured',
                'error'     =>      $validator->errors(),
                'errorArr'  =>      $validator->errors()->all(),
                'data'      =>      []
            ], 200);
        } 

        $id = intval( $data['id'] );
        $user = $this->userService->isUserIdExistsData( $id );
        if( !$user ) {

            return response()->json([
                'message' => 'Invalid user id!',
                'error' => [ 'id' => 'Invalid user id!' ],
                'errorArr' => ['Invalid user id!'],
                'data'  =>  [],
            ], 200);
        } 

        $oldUserData = $this->userService->getUserByIdData( $id );
        $cnt = count((array)$oldUserData);
        if( !$cnt ) {

            return response()->json([
                'message' => 'Record not found!',
                'error' => [],
                'errorArr' => [],
                'data'  =>  $oldUserData,
            ], 200);
        }

        $in_data = [
            'id' => $oldUserData['id'],
            'userName' => $oldUserData['userName'],
            'universityEmail' => $oldUserData['universityEmail'],
            'password' => $oldUserData['password'],
            'gender' => $oldUserData['gender'],
            'studyingYear' => $oldUserData['studyingYear'],
            'branchId' => $oldUserData['branchId'],
            'status' => 'DELETED'
        ];

        $result = $this->userService->updateUserData( $in_data );
        if( $result > 0 ) {

            $user = $this->userService->isUserDeletedSoftly( $id );
            $cnt = count((array)$user);
            if( $cnt ) {

                return response()->json([
                    'message'   =>      'Record deleted successfully.',
                    'error'     =>      [],
                    'errorArr'     =>      [],
                    'data'      =>      []
                ], 200);
            } else {

                return response()->json([
                    'message' => 'Unable to delete record!',
                    'error' => ['Unable to delete record!'],
                    'errorArr' => ['Unable to delete record!'],
                    'data'  =>  [],
                ], 200);
            }
        } else {

            return response()->json([
                'message'   =>      'No record to delete.',
                'error'     =>      ['No record to delete.'],
                'errorArr'     =>      ['No record to delete.'],
                'data'      =>      []
            ], 200);
        }
    }

    public function blockUnblockUser() {
        
        $data = $this->request->input();
        $rules = [ 'id'        =>  'required|numeric|min:1' ];

        $validator = Validator::make( $data, $rules);
        if ( !$validator->passes()) {

            // TODO Handle your error
            return response()->json([
                'message'   =>      'Some errors occured',
                'error'     =>      $validator->errors(),
                'errorArr'  =>      $validator->errors()->all(),
                'data'      =>      []
            ], 200);
        } 

        $id = intval( $data['id'] );
        $user = $this->userService->isUserIdExistsData( $id );
        if( !$user ) {

            return response()->json([
                'message' => 'Invalid user id!',
                'error' => [ 'id' => 'Invalid user id!' ],
                'errorArr' => ['Invalid user id!'],
                'data'  =>  [],
            ], 200);
        } 

        $oldUserData = $this->userService->getUserByIdData( $id );
        $cnt = count((array)$oldUserData);
        if( !$cnt ) {

            return response()->json([
                'message' => 'Record not found!',
                'error' => [],
                'errorArr' => [],
                'data'  =>  $oldUserData,
            ], 200);
        }

        $in_data = [
            'id' => $oldUserData['id'],
            'userName' => $oldUserData['userName'],
            'universityEmail' => $oldUserData['universityEmail'],
            'password' => $oldUserData['password'],
            'gender' => $oldUserData['gender'],
            'studyingYear' => $oldUserData['studyingYear'],
            'branchId' => $oldUserData['branchId'],
            'status' => 'DELETED'
        ];

        $result = $this->userService->updateUserData( $in_data );
        if( $result > 0 ) {

            $user = $this->userService->isUserDeletedSoftly( $id );
            $cnt = count((array)$user);
            if( $cnt ) {

                return response()->json([
                    'message'   =>      'Record deleted successfully.',
                    'error'     =>      [],
                    'errorArr'     =>      [],
                    'data'      =>      []
                ], 200);
            } else {

                return response()->json([
                    'message' => 'Unable to delete record!',
                    'error' => ['Unable to delete record!'],
                    'errorArr' => ['Unable to delete record!'],
                    'data'  =>  [],
                ], 200);
            }
        } else {

            return response()->json([
                'message'   =>      'No record to delete.',
                'error'     =>      ['No record to delete.'],
                'errorArr'     =>      ['No record to delete.'],
                'data'      =>      []
            ], 200);
        }
    }

    public function hardDeleteUser() {
        
        $data = $this->request->input();
        $rules = [ 'id'        =>  'required|numeric|min:1' ];

        $validator = Validator::make( $data, $rules);
        if ( !$validator->passes()) {

            return response()->json([
                'message'   =>      'Some errors occured',
                'error'     =>      $validator->errors(),
                'errorArr'  =>      $validator->errors()->all(),
                'data'      =>      []
            ], 200);
        } 

        $id = intval( $data['id'] );
        if( $id < 1 ) {

            return response()->json([
                'message' => 'Some errors occured!',
                'error' => [ 'id' => 'Id must be numeric and should be greater than 0!'],
                'errorArr' => ['Id must be numeric and should be greater than 0!'],
                'data'  =>  [],
            ], 200);
        }

        $user = $this->userService->isUserIdExistsData( $id );
        if( !$user ) {

            return response()->json([
                'message' => 'Invalid user id!',
                'error' => [ 'id' => 'Invalid user id!' ],
                'errorArr' => [ 'Invalid user id!' ],
                'data'  =>  $user,
            ], 200);
        } 

        $result = User::destroy($id);
        if( $result ) {

            return response()->json([
                'message' => 'Hard delete successfull. Record deleted successfully!',
                'error' => [],
                'errorArr' => [],
                'data'  =>  [],
            ], 200);
        } else {

            return response()->json([
                'message' => 'Unable to delete record!',
                'error' => [ 'id' => 'Invalid user id. Unable to delete record!'],
                'errorArr' => ['Invalid user id. Unable to delete record!'],
                'data'  =>  [],
            ], 200);
        }
    }

    public function forgotPassword() {

        $data = $this->request->input();
        $rules = [
            'universityEmail'       =>      'required|email',
        ];

        $validator = Validator::make( $data, $rules);
        if ( !$validator->passes()) {

            // TODO Handle your error
            return response()->json([
                'message'   =>      'Some errors occured',
                'error'     =>      $validator->errors(),
                'errorArr'  =>      $validator->errors()->all(),
                'data'      =>      []
            ], 200);
        } 

        if( !$this->userService->isEmailExistsData( $data['universityEmail'] ) ) {

            return response()->json([
                'message'   =>      'Some errors occured',
                'error'     =>      [ "universityEmail" => "University email(". $data['universityEmail'] .") does not exists!"],
                'errorArr'     =>      ["University email(". $data['universityEmail'] .") does not exists!"],
                'data'      =>      []
            ], 200);
        }

        $in_data['name'] = "Straw Admin";
        $tokenConfig = [
            'universityEmail'   =>    $data['universityEmail'],
            'createdAt'         =>    strtotime("now")
        ];
        $in_data['token'] = base64_encode( json_encode( $tokenConfig ));
        Mail::send('emails.forgotPassword', $in_data, function($message) use($data, $in_data) {

            $message->to( $data['universityEmail'], $in_data['name'] )->subject('Straw link for change password.');
        });

        // Mail::to( 'bawa_d@ymail.com', 'Deepak Bawa' )->subject('Laravel Make Mail');
 
        if (Mail::failures()) {
          
            return response()->json([
                'message' => 'Unable to send emails!',
                'error'     =>      ['email' => 'Unable to send email'],
                'errorArr'  =>      ['Unable to send email'],
                'data'      =>      []
            ], 200);
         }else{
          
            return response()->json([
                'message' => 'Password reset link sent your registered email ID successfully!. Its valid for 30 minutes only.',
                'error' => [],
                'errorArr'  =>      [],
                'data'  =>  ['Password reset link sent your registered email ID successfully!. Its valid for 30 minutes only.']
            ], 200);
         }
    }

    public function verifyForgotPasswordToken() {

        $data = $this->request->input();

        if( !isset( $data['token'] ) || $data['token'] == '' ) {

            return response()->json([
                'message' => 'Invalid Token',
                'error' => [],
                'data'  =>  []
            ], 200);
        }

        $decodedBase = base64_decode( $data['token']);
        $decodedJson = json_decode($decodedBase);

        if( !isset($decodedJson->universityEmail) || !isset( $decodedJson->createdAt ) ) {

            return response()->json([
                'message'   =>      'Some errors occured',
                'error'     =>      [ "token" => "Token is tampered or not valid!"],
                'errorArr'     =>      ["Token is tampered or not valid!"],
                'data'      =>      []
            ], 200);
        } 

        if( !$this->userService->isEmailExistsData( $decodedJson->universityEmail ) ) {

            return response()->json([
                'message'   =>      'Some errors occured',
                'error'     =>      [ "universityEmail" => "University email(". $decodedJson->universityEmail .") does not exists!"],
                'errorArr'     =>      ["University email(". $decodedJson->universityEmail .") does not exists!"],
                'data'      =>      []
            ], 200);
        } 

        $tokenCreatedAt = $decodedJson->createdAt;
        $current = strtotime("now");
        $minPassed = round((($current - $tokenCreatedAt)/60));

        // 30 minutes
        if( $minPassed > 30 ) {

            return response()->json([
                'message'   =>      'Some errors occured',
                'error'     =>      [ "token" => "Token expired!" ],
                'errorArr'     =>      [ "Token expired!" ],
                'data'      =>      []
            ], 200);
        }

        return view('password.resetPasswordForm', [ 'email' => $decodedJson->universityEmail ]);
    }

    public function resetPassword() {
    
        $data = $this->request->input();

        $rules = [
            'password'              =>      'required',
            'universityEmail'       =>      'required|email'
        ];

        $validator = Validator::make( $data, $rules);
        if ( !$validator->passes()) {

            // TODO Handle your error
            return response()->json([
                'message'   =>      'Some errors occured',
                'error'     =>      $validator->errors(),
                'errorArr'  =>      $validator->errors()->all(),
                'data'      =>      []
            ], 200);
        } 

        if( !$this->userService->isEmailExistsData( $data['universityEmail'] ) ) {

            return response()->json([
                'message'   =>      'Some errors occured',
                'error'     =>      [ "universityEmail" => "University email(". $data['universityEmail'] .") does not exists!"],
                'errorArr'     =>      ["University email(". $data['universityEmail'] .") does not exists!"],
                'data'      =>      []
            ], 200);
        }
        
        $data['password'] = Hash::make($data['password']);
        if( $this->userService->updatePasswordByEmailData( $data ) ) {

            return response()->json([
                'message'   =>      'Password reset successfully!',
                'error'     =>      [],
                'errorArr'     =>   [],
                'data'      =>      []
            ], 200);
        } else {

            return response()->json([
                'message'   =>      'Some errors occured',
                'error'     =>      [ "password_reset" => "Unable to reset password!"],
                'errorArr'     =>      ["Unable to reset password!"],
                'data'      =>      []
            ], 200);
        }
    }

    public function saveUserNotificationSettings() {

        $data = $this->request->input();
        $rules = [
            'newPollReceived'       =>      'required|numeric|min:0',
            'pollVoteReceived'      =>      'required|numeric|min:0',
            'pollCommentReceived'   =>      'required|numeric|min:0',
            'pollEnded'             =>      'required|numeric|min:0'
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
        
        $in_data = $data;
        unset($data);
        $data['settings'] = json_encode($in_data);
        $data['userId'] = $this->loggedInUser->id;        
        if( $this->userNotificationSettingService->isUserNotificationSettingsExists( $data['userId'] ) ) {
            
            $result = $this->userNotificationSettingService->updateUserNotificationSettings( $data );
            if( $result > 0 ) {

                return response()->json([
                    'message'   =>      'Record updated successfully.',
                    'error'     =>      [],
                    'errorArr'  =>      [],
                    'data'      =>      $this->userNotificationSettingService->getInsertedUserNotificationSettings( $data['userId'] )
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
               
            $result = $this->userNotificationSettingService->insertUserNotificationSettings( $data );
            if( $result->id > 0 ) {

                return response()->json([
                    'message'   =>      'Record inserted successfully.',
                    'error'     =>      [],
                    'errorArr'  =>      [],
                    'data'      =>      $this->userNotificationSettingService->getInsertedUserNotificationSettings( $data['userId'] )
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

    public function getInsertedUserNotificationSettings() {

        return response()->json([
            'message'   =>      'Record Found.',
            'error'     =>      [],
            'errorArr'  =>      [],
            'data'      =>      $this->userNotificationSettingService->getInsertedUserNotificationSettings( $this->loggedInUser->id )
        ], 200); 
    }
}