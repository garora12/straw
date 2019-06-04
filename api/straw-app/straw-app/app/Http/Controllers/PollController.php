<?php

namespace App\Http\Controllers;
use Validator;
use App\User;
use App\RelUserGroup;
use Illuminate\Http\Request;
use Firebase\JWT\ExpiredException;
use Laravel\Lumen\Routing\Controller as BaseController;

use Illuminate\Support\Facades\Mail;
use Redirect,Response,DB,Config;

use App\Services\PollService;
use App\Services\NotificationService;
use App\Services\UserPointsService;
use App\Services\UserService;

class PollController extends BaseController {

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
    public function __construct(Request $request, PollService $PollService, NotificationService $NotificationService, UserPointsService $UserPointsService, UserService $UserService) {
        $this->request = $request;
        $this->loggedInUser = $this->request->auth;
        $this->PollService = $PollService;
        $this->notificationService = $NotificationService;
        $this->userPointsService = $UserPointsService;
        $this->userService = $UserService;
    }

    public function getAllPollsCount() {

        $in_data = [];
        return response()->json([
            'message' => 'Records found!',
            'error' => [],
            'errorArr' => [],
            'cnt' => $this->PollService->getAllPollsDataCount( $in_data )
        ], 200);
    }

    public function getAllPolls() {

        $data = $this->request->input();
        $rules = [];

        isset($data['offset']) ? $rules['offset']  = 'required|numeric|min:0' : '';
        isset($data['limit']) ? $rules['limit']  = 'required|numeric|min:1' : '';

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

        $in_data = [
            'offset'    =>  isset($data['offset']) ? $data['offset'] : 0,
            'limit'     =>  isset($data['limit']) ? $data['limit'] : 10,
            'search'    =>  isset($data['search']) ? $data['search'] : ''
        ];
        $users = $this->PollService->getAllPollsData( $in_data );
        if( count( (array)$users ) ) {

            return response()->json([
                'message' => 'Records found!',
                'error' => [],
                'errorArr' => [],
                'data'  =>  $users,
                'cnt' => $this->PollService->getAllPollsDataCount( $in_data )
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

    public function getPollById( $in_id ) {

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
        $user = $this->PollService->getPollByIdData( $id );
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

    public function getPollsByUserId() {

        $data = $this->request->input();
        $rules = [
            'userId'    =>  'required|numeric|min:1'
        ];

        isset($data['offset']) ? $rules['offset']  = 'required|numeric|min:0' : '';
        isset($data['limit']) ? $rules['limit']  = 'required|numeric|min:1' : '';

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

        $in_data = [
            'offset'    =>  isset($data['offset']) ? $data['offset'] : 0,
            'limit'     =>  isset($data['limit']) ? $data['limit'] : 10,
        ];
        $userId = intval($data['userId']);
        $user = $this->PollService->getPollsByUserIdData( $userId, $in_data );
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

    public function insertPoll() {

        $userId = 0;
        $data = $this->request->input();
        $rules = [
            'question'              =>      'required',
            'allowComments'         =>      'required',
            'status'                =>      'required'
        ];
        
        isset($data['groupIds']) ? $rules['groupIds']  = 'required' : '';
        isset($data['countryIds']) ? $rules['countryIds']  = 'required' : '';
        isset($data['genders']) ? $rules['genders']  = 'required' : '';
        isset($data['years']) ? $rules['years']  = 'required' : '';
        isset($data['branchIds']) ? $rules['branchIds']  = 'required' : '';
        
        if( $this->loggedInUser->id == 1 ) {

            isset($data['userId']) ? $rules['userId']  = 'required' : '';            
            $userId = $data['userId'];
        } else {

            $userId = $this->loggedInUser->id;
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

        if( $this->request->file('imageLink') ) {

            $image = $this->request->file('imageLink');
            $input['imagename'] = time().'.'.$image->getClientOriginalExtension();
            $destinationPath = storage_path('polls');
            $image->move($destinationPath, $input['imagename']);
            $data['imageLink'] = $input['imagename'];
        } 

        if( isset( $data['groupIds'] ) ) {

            $strGroupIds = $data['groupIds'];
            unset($data['groupIds']);
            $groupIds = explode( ',', $strGroupIds );
    
            if( !is_array( $groupIds ) || (count( $groupIds ) < 1) ) {
    
                return response()->json([
                    'message'   =>      'Some errors occured',
                    'error'     =>      ["groupIds" => "Groups not selected!"],
                    'errorArr'  =>      ["Groups not selected!"],
                    'data'      =>      []
                ], 200);
            }
        }

        if( isset( $data['genders'] ) ) {

            $strGenders = $data['genders'];
            unset($data['genders']);
            $genders = explode( ',', $strGenders );
    
            if( !is_array( $genders ) || (count( $genders ) < 1) ) {
    
                return response()->json([
                    'message'   =>      'Some errors occured',
                    'error'     =>      ["genders" => "Genders not selected!"],
                    'errorArr'  =>      ["Genders not selected!"],
                    'data'      =>      []
                ], 200);
            }
        }

        if( isset( $data['years'] ) ) {

            $strYears = $data['years'];
            unset($data['years']);
            $years = explode( ',', $strYears );
    
            if( !is_array( $years ) || (count( $years ) < 1) ) {
    
                return response()->json([
                    'message'   =>      'Some errors occured',
                    'error'     =>      ["years" => "Years not selected!"],
                    'errorArr'  =>      ["Years not selected!"],
                    'data'      =>      []
                ], 200);
            }
        }

        if( isset( $data['countryIds'] ) ) {

            $strCountries = $data['countryIds'];
            unset($data['countryIds']);
            $countries = explode( ',', $strCountries );
    
            if( !is_array( $countries ) || (count( $countries ) < 1) ) {
    
                return response()->json([
                    'message'   =>      'Some errors occured',
                    'error'     =>      ["countryIds" => "Countries not selected!"],
                    'errorArr'  =>      ["Countries not selected!"],
                    'data'      =>      []
                ], 200);
            }
        }

        if( isset( $data['branchIds'] ) ) {

            $strBranches = $data['branchIds'];
            unset($data['branchIds']);
            $branches = explode( ',', $strBranches );
    
            if( !is_array( $branches ) || (count( $branches ) < 1) ) {
    
                return response()->json([
                    'message'   =>      'Some errors occured',
                    'error'     =>      ["branchIds" => "Branches not selected!"],
                    'errorArr'  =>      ["Branches not selected!"],
                    'data'      =>      []
                ], 200);
            }
        }

        $data['userId'] = $userId;
        $result = $this->PollService->insertPollData( $data );
        if( $result->id > 0 ) {
            
            $poll = $this->PollService->getPollByIdData( $result->id );
            $cnt = count((array)$poll);
            if( $cnt ) {
                
                // isset( $groupIds ) ? $this->PollService->insertPollGroups( $poll->poll['id'], $groupIds ) : '';
                // isset( $genders ) ? $this->PollService->insertPollGenders( $poll->poll['id'], $genders ) : '';
                // isset( $years ) ? $this->PollService->insertPollYears( $poll->poll['id'], $years ) : '';
                // isset( $countries ) ? $this->PollService->insertPollCountries( $poll->poll['id'], $countries ) : '';
                // isset( $branches ) ? $this->PollService->insertPollBranches( $poll->poll['id'], $branches ) : '';

                isset( $groupIds ) ? $this->PollService->insertPollGroups( $poll['id'], $groupIds ) : '';
                isset( $genders ) ? $this->PollService->insertPollGenders( $poll['id'], $genders ) : '';
                isset( $years ) ? $this->PollService->insertPollYears( $poll['id'], $years ) : '';
                isset( $countries ) ? $this->PollService->insertPollCountries( $poll['id'], $countries ) : '';
                isset( $branches ) ? $this->PollService->insertPollBranches( $poll['id'], $branches ) : '';

                $this->userPointsService->insertUserPoints([
                    'pollId' => $result->id,
                    'userId' => $userId,
                    'transactionFor' => 'POLLCREATED'
                ]);

                return response()->json([
                    'message'   =>      'Record inserted successfully.',
                    'error'     =>      [],
                    'errorArr'  =>      [],
                    'data'      =>      [
                        'polls'     =>  $polls = $this->PollService->getInsertedPoll( $poll['id'] ),
                        'notificationDetails' => $this->notificationService->newPollReceived( $poll['id'], $poll ),
                        'pollShareLink' => url() .'/poll/share/'. base64_encode( $poll['id'] )
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

    public function updatePoll() {
        
        $userId = 0;
        $oldUserData;
        $data = $this->request->input();
        $rules = [
            'id'                    =>      'required|numeric|min:1',
            'question'              =>      'required',
            'allowComments'         =>      'required',
            'status'                =>      'required'
        ];

        isset($data['groupIds']) ? $rules['groupIds']  = 'required' : '';
        isset($data['countryIds']) ? $rules['countryIds']  = 'required' : '';
        isset($data['genders']) ? $rules['genders']  = 'required' : '';
        isset($data['years']) ? $rules['years']  = 'required' : '';
        isset($data['branchIds']) ? $rules['branchIds']  = 'required' : '';

        if( $this->loggedInUser->id == 1 ) {

            isset($data['userId']) ? $rules['userId']  = 'required' : '';            
            $userId = $data['userId'];
        } else {

            $userId = $this->loggedInUser->id;
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

        $id = intval( $data['id'] );
        $poll = $this->PollService->isPollIdExistsData( $id );
        if( !$poll ) {

            return response()->json([
                'message' => 'Invalid poll id!',
                'error' => [ 'id' => 'Invalid poll id!' ],
                'errorArr' => [ 'Invalid poll id!' ],
                'data'  =>  $poll,
            ], 200);
        } 

        $poll = $this->PollService->isPollIdBelongsToUser( $id, $userId );
        if( !$poll ) {

            return response()->json([
                'message' => 'Poll is not belongs to the logged in user!',
                'error' => [ 'id' => 'Poll is not belongs to the logged in user!' ],
                'errorArr' => [ 'Poll is not belongs to the logged in user!' ],
                'data'  =>  $poll,
            ], 200);
        } 
        
        if( isset( $data['groupIds'] ) ) {

            $strGroupIds = $data['groupIds'];
            unset($data['groupIds']);
            $groupIds = explode( ',', $strGroupIds );
    
            if( !is_array( $groupIds ) || (count( $groupIds ) < 1) ) {
    
                return response()->json([
                    'message'   =>      'Some errors occured',
                    'error'     =>      ["groupIds" => "Groups not selected!"],
                    'errorArr'  =>      ["Groups not selected!"],
                    'data'      =>      []
                ], 200);
            }
        }

        if( isset( $data['genders'] ) ) {

            $strGenders = $data['genders'];
            unset($data['genders']);
            $genders = explode( ',', $strGenders );
    
            if( !is_array( $genders ) || (count( $genders ) < 1) ) {
    
                return response()->json([
                    'message'   =>      'Some errors occured',
                    'error'     =>      ["genders" => "Genders not selected!"],
                    'errorArr'  =>      ["Genders not selected!"],
                    'data'      =>      []
                ], 200);
            }
        }

        if( isset( $data['years'] ) ) {

            $strYears = $data['years'];
            unset($data['years']);
            $years = explode( ',', $strYears );
    
            if( !is_array( $years ) || (count( $years ) < 1) ) {
    
                return response()->json([
                    'message'   =>      'Some errors occured',
                    'error'     =>      ["years" => "Years not selected!"],
                    'errorArr'  =>      ["Years not selected!"],
                    'data'      =>      []
                ], 200);
            }
        }

        if( isset( $data['countryIds'] ) ) {

            $strCountries = $data['countryIds'];
            unset($data['countryIds']);
            $countries = explode( ',', $strCountries );
    
            if( !is_array( $countries ) || (count( $countries ) < 1) ) {
    
                return response()->json([
                    'message'   =>      'Some errors occured',
                    'error'     =>      ["countryIds" => "Countries not selected!"],
                    'errorArr'  =>      ["Countries not selected!"],
                    'data'      =>      []
                ], 200);
            }
        }

        if( isset( $data['branchIds'] ) ) {

            $strBranches = $data['branchIds'];
            unset($data['branchIds']);
            $branches = explode( ',', $strBranches );
    
            if( !is_array( $branches ) || (count( $branches ) < 1) ) {
    
                return response()->json([
                    'message'   =>      'Some errors occured',
                    'error'     =>      ["branchIds" => "Branches not selected!"],
                    'errorArr'  =>      ["Branches not selected!"],
                    'data'      =>      []
                ], 200);
            }
        }

        $data['userId'] = $userId;
        $id = $this->PollService->updatePollData( $data );
        if( $id > 0 ) {

            $poll = $this->PollService->getPollByIdData( $id );
            $cnt = count((array)$poll);
            if( $cnt ) {

                isset( $groupIds ) ? $this->PollService->insertPollGroups( $poll['id'], $groupIds ) : '';
                isset( $genders ) ? $this->PollService->insertPollGenders( $poll['id'], $genders ) : '';
                isset( $years ) ? $this->PollService->insertPollYears( $poll['id'], $years ) : '';
                isset( $countries ) ? $this->PollService->insertPollCountries( $poll['id'], $countries ) : '';
                isset( $branches ) ? $this->PollService->insertPollBranches( $poll['id'], $branches ) : '';

                return response()->json([
                    'message'   =>      'Record updated successfully.',
                    'error'     =>      [],
                    'errorArr'     =>      [],
                    'data'      =>      [
                        'polls'     =>  $this->PollService->getInsertedPoll( $poll['id'] )
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

    public function patchPoll() {

        $userId = 0;
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

        isset($data['question']) ? $rules['question']  = 'required' : '';
        isset($data['allowComments']) ? $rules['allowComments']  = 'required' : '';
        isset($data['status']) ? $rules['status']  = 'required' : '';
        
        if( $this->loggedInUser->id == 1 ) {

            isset($data['userId']) ? $rules['userId']  = 'required' : '';            
            $userId = $data['userId'];
        } else {

            $userId = $this->loggedInUser->id;
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

        $id = intval( $data['id'] );
        $poll = $this->PollService->isPollIdExistsData( $id );
        if( !$poll ) {

            return response()->json([
                'message' => 'Invalid poll id!',
                'error' => [ 'id' => 'Invalid poll id!' ],
                'errorArr' => [ 'Invalid poll id!' ],
                'data'  =>  $poll,
            ], 200);
        } 

        if( $this->loggedInUser->id != 1 ) {

            $poll = $this->PollService->isPollIdBelongsToUser( $id, $userId );
            if( !$poll ) {
    
                return response()->json([
                    'message' => 'Poll is not belongs to the logged in user!',
                    'error' => [ 'id' => 'Poll is not belongs to the logged in user!' ],
                    'errorArr' => [ 'Poll is not belongs to the logged in user!' ],
                    'data'  =>  $poll,
                ], 200);
            } 
        }

        if( isset( $data['groupIds'] ) ) {

            $strGroupIds = $data['groupIds'];
            unset($data['groupIds']);
            $groupIds = explode( ',', $strGroupIds );
    
            if( !is_array( $groupIds ) || (count( $groupIds ) < 1) ) {
    
                return response()->json([
                    'message'   =>      'Some errors occured',
                    'error'     =>      ["groupIds" => "Groups not selected!"],
                    'errorArr'  =>      ["Groups not selected!"],
                    'data'      =>      []
                ], 200);
            }
        }

        if( isset( $data['genders'] ) ) {

            $strGenders = $data['genders'];
            unset($data['genders']);
            $genders = explode( ',', $strGenders );
    
            if( !is_array( $genders ) || (count( $genders ) < 1) ) {
    
                return response()->json([
                    'message'   =>      'Some errors occured',
                    'error'     =>      ["genders" => "Genders not selected!"],
                    'errorArr'  =>      ["Genders not selected!"],
                    'data'      =>      []
                ], 200);
            }
        }

        if( isset( $data['years'] ) ) {

            $strYears = $data['years'];
            unset($data['years']);
            $years = explode( ',', $strYears );
    
            if( !is_array( $years ) || (count( $years ) < 1) ) {
    
                return response()->json([
                    'message'   =>      'Some errors occured',
                    'error'     =>      ["years" => "Years not selected!"],
                    'errorArr'  =>      ["Years not selected!"],
                    'data'      =>      []
                ], 200);
            }
        }

        if( isset( $data['countryIds'] ) ) {

            $strCountries = $data['countryIds'];
            unset($data['countryIds']);
            $countries = explode( ',', $strCountries );
    
            if( !is_array( $countries ) || (count( $countries ) < 1) ) {
    
                return response()->json([
                    'message'   =>      'Some errors occured',
                    'error'     =>      ["countryIds" => "Countries not selected!"],
                    'errorArr'  =>      ["Countries not selected!"],
                    'data'      =>      []
                ], 200);
            }
        }

        if( isset( $data['branchIds'] ) ) {

            $strBranches = $data['branchIds'];
            unset($data['branchIds']);
            $branches = explode( ',', $strBranches );
    
            if( !is_array( $branches ) || (count( $branches ) < 1) ) {
    
                return response()->json([
                    'message'   =>      'Some errors occured',
                    'error'     =>      ["branchIds" => "Branches not selected!"],
                    'errorArr'  =>      ["Branches not selected!"],
                    'data'      =>      []
                ], 200);
            }
        }

        $oldPollData = $this->PollService->getPollByIdData( $id );
        $cnt = count((array)$oldPollData);
        if( !$cnt ) {

            return response()->json([
                'message' => 'Record not found!',
                'error' => [],
                'errorArr' => [],
                'data'  =>  $oldPollData,
            ], 200);
        }

        $in_data = [
            'id' => $oldPollData['id'],
            'userId' => $userId,
            'question' => isset($data['question']) ? $data['question'] : $oldPollData['question'],
            'allowComments' => isset($data['allowComments']) ? $data['allowComments'] : $oldPollData['allowComments'],
            'status' => isset($data['status']) ? $data['status'] : $oldPollData['status']
        ];

        $result = $this->PollService->updatePollData( $in_data );
        if( $result > 0 ) {

            $poll = $this->PollService->getPollByIdData( $in_data['id'] );
            $cnt = count((array)$poll);
            if( $cnt ) {

                isset( $groupIds ) ? $this->PollService->insertPollGroups( $poll['id'], $groupIds ) : '';
                isset( $genders ) ? $this->PollService->insertPollGenders( $poll['id'], $genders ) : '';
                isset( $years ) ? $this->PollService->insertPollYears( $poll['id'], $years ) : '';
                isset( $countries ) ? $this->PollService->insertPollCountries( $poll['id'], $countries ) : '';
                isset( $branches ) ? $this->PollService->insertPollBranches( $poll['id'], $branches ) : '';

                return response()->json([
                    'message'   =>      'Record updated successfully.',
                    'error'     =>      [],
                    'errorArr'     =>      [],
                    'data'      =>      [
                        'polls'  => $this->PollService->getInsertedPoll( $poll['id'] )
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

    public function changePollPic() {

        $userId = 0;
        $flag = 0;
        $data = $this->request->input();
        // print_r($data);die;
        $rules = [
            'id'                    =>      'required|numeric|min:1',
        ];
        
        if( isset( $data['userId'] ) ) {

            if( $this->loggedInUser->id == 1 ) {
    
                isset($data['userId']) ? $rules['userId']  = 'required|numeric|min:1' : '';            
                isset( $data['userId'] ) ? $userId = $data['userId'] : $flag = 1;
            } else {
    
                $userId = $this->loggedInUser->id;
            }
        } else {

            $userId = $this->loggedInUser->id;
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

        if( $flag ) {
            $userId = $data['userId'];
        }

        $id = intval( $data['id'] );
        $poll = $this->PollService->isPollIdExistsData( $id );
        if( !$poll ) {

            return response()->json([
                'message' => 'Invalid poll id!',
                'error' => [ 'id' => 'Invalid poll id!' ],
                'errorArr' => [ 'Invalid poll id!' ],
                'data'  =>  $poll,
            ], 200);
        } 

        $poll = $this->PollService->isPollIdBelongsToUser( $id, $userId );
        if( !$poll ) {

            return response()->json([
                'message' => 'Poll is not belongs to the logged in user!',
                'error' => [ 'id' => 'Poll is not belongs to the logged in user!' ],
                'errorArr' => [ 'Poll is not belongs to the logged in user!' ],
                'data'  =>  $poll,
            ], 200);
        } 
        
        if( $this->request->file('imageLink') ) {

            $image = $this->request->file('imageLink');
            $input['imagename'] = time().'.'.$image->getClientOriginalExtension();
            $destinationPath = storage_path('polls');
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

        $oldPollData = $this->PollService->getPollByIdData( $id );
        $cnt = count((array)$oldPollData);
        if( !$cnt ) {

            return response()->json([
                'message' => 'Record not found!',
                'error' => [],
                'errorArr' => [],
                'data'  =>  $oldPollData,
            ], 200);
        }

        $in_data = [
            'id' => $oldPollData['id'],
            'userId' => $userId,
            'question' => isset($data['question']) ? $data['question'] : $oldPollData['question'],
            'allowComments' => isset($data['allowComments']) ? $data['allowComments'] : $oldPollData['allowComments'],
            'status' => isset($data['status']) ? $data['status'] : $oldPollData['status'],
            'imageLink' => $data['imageLink']
        ];
        
        $result = $this->PollService->updatePollData( $in_data );
        if( $result > 0 ) {

            $poll = $this->PollService->getPollByIdData( $in_data['id'] );
            $cnt = count((array)$poll);
            if( $cnt ) {

                return response()->json([
                    'message'   =>      'Record updated successfully.',
                    'error'     =>      [],
                    'errorArr'     =>      [],
                    'data'      =>      [
                        'poll'  => $this->PollService->getInsertedPoll( $oldPollData['id'] )
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

    public function softDeletePoll() {
        
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
        $poll = $this->PollService->isPollIdExistsData( $id );
        if( !$poll ) {

            return response()->json([
                'message' => 'Invalid poll id!',
                'error' => [ 'id' => 'Invalid poll id!' ],
                'errorArr' => [ 'Invalid poll id!' ],
                'data'  =>  $poll,
            ], 200);
        } 

        if( $this->loggedInUser->id !== 1 ) {

            $poll = $this->PollService->isPollIdBelongsToUser( $id, $this->loggedInUser->id );
            if( !$poll ) {
    
                return response()->json([
                    'message' => 'Poll is not belongs to the logged in user!',
                    'error' => [ 'id' => 'Poll is not belongs to the logged in user!' ],
                    'errorArr' => [ 'Poll is not belongs to the logged in user!' ],
                    'data'  =>  $poll,
                ], 200);
            } 
        }

        $oldPollData = $this->PollService->getPollByIdData( $id );
        $cnt = count((array)$oldPollData);
        if( !$cnt ) {

            return response()->json([
                'message' => 'Record not found!',
                'error' => [],
                'errorArr' => [],
                'data'  =>  $oldPollData,
            ], 200);
        }

        $in_data = [
            'id' => $oldPollData['id'],
            'userId' => isset($data['userId']) ? $data['userId'] : $oldPollData['userId'],
            'question' => isset($data['question']) ? $data['question'] : $oldPollData['question'],
            'allowComments' => isset($data['allowComments']) ? $data['allowComments'] : $oldPollData['allowComments'],
            'status' => 'DELETED'
        ];

        $result = $this->PollService->updatePollData( $in_data );
        if( $result > 0 ) {

            $poll = $this->PollService->getDeletedPollByIdData( $in_data['id'] );
            $cnt = count((array)$poll);
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

    public function hardDeletePoll() {
        
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
        $poll = $this->PollService->isPollIdExistsData( $id );
        if( !$poll ) {

            return response()->json([
                'message' => 'Invalid poll id!',
                'error' => [ 'id' => 'Invalid poll id!' ],
                'errorArr' => [ 'Invalid poll id!' ],
                'data'  =>  $poll,
            ], 200);
        } 

        if( $this->loggedInUser->id !== 1 ) {

            $poll = $this->PollService->isPollIdBelongsToUser( $id, $this->loggedInUser->id );
            if( !$poll ) {
    
                return response()->json([
                    'message' => 'Poll is not belongs to the logged in user!',
                    'error' => [ 'id' => 'Poll is not belongs to the logged in user!' ],
                    'errorArr' => [ 'Poll is not belongs to the logged in user!' ],
                    'data'  =>  $poll,
                ], 200);
            } 
        }

        $result = $this->PollService->hardDeletePoll( $id );
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
                'error' => [ 'id' => 'Invalid poll id. Unable to delete record!'],
                'errorArr' => ['Invalid poll id. Unable to delete record!'],
                'data'  =>  [],
            ], 200);
        }
    }

    public function insertPollVote() {

        $data = $this->request->input();
        $rules = [
            'pollId'        =>      'required|numeric|min:1',
            'vote'          =>      'required'
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
        
        $poll = $this->PollService->isPollIdExistsData( $data['pollId'] );
        if( !$poll ) {

            return response()->json([
                'message' => 'Invalid poll id!',
                'error' => [ 'id' => 'Invalid poll id!' ],
                'errorArr' => [ 'Invalid poll id!' ],
                'data'  =>  $poll,
            ], 200);
        } 

        $poll = $this->PollService->isPollIdLive( $data['pollId'] );
        if( !$poll ) {

            return response()->json([
                'message' => 'You can not vote as poll already expired!',
                'error' => [ 'id' => 'You can not vote as poll already expired!' ],
                'errorArr' => [ 'You can not vote as poll already expired!' ],
                'data'  =>  $poll,
            ], 200);
        } 

        $data['userId'] = $this->loggedInUser->id;
        if( $this->PollService->isUserVotedPollAlready( $data['pollId'], $data['userId'] ) ) {
            
            $oldPollVoteData = $this->PollService->getPollVoteByPollIdUserId( $data['pollId'], $data['userId'] );
            $cnt = count((array)$oldPollVoteData);
            if( $cnt ) {
                
                $in_data = [
                    'id' => $oldPollVoteData['id'],
                    'userId' => $this->loggedInUser->id,
                    'pollId' => isset($data['pollId']) ? $data['pollId'] : $oldPollVoteData['pollId'],
                    'vote' => isset($data['vote']) ? $data['vote'] : $oldPollVoteData['vote'],
                    'status' => isset($data['status']) ? $data['status'] : $oldPollVoteData['status']
                ];

                $result = $this->PollService->updateUserPollVote( $in_data );
                if( $result > 0 ) {
                    
                    return response()->json([
                        'message'   =>      'Record updated successfully.',
                        'error'     =>      [],
                        'errorArr'     =>      [],
                        'data'      =>      [
                            'polls'     =>  $this->PollService->getPollVoteByPollIdUserIdData( $in_data['pollId'], $in_data['userId'] ),
                            'votePercentage' => $this->PollService->countPollVotesByPollId( $in_data['pollId'] )
                        ]
                    ], 200);
                } else {
                    return response()->json([
                        'message' => 'Record updated but not retrieved!',
                        'error' => [],
                        'errorArr' => [],
                        'data'  =>  [],
                    ], 200);
                }
            } else {

                return response()->json([
                    'message' => 'Record not found against provided pollId and userId!',
                    'error' => ['Record not found against provided pollId and userId!'],
                    'errorArr' => ['Record not found against provided pollId and userId!'],
                    'data'  =>  [],
                ], 200);
            }
        } else {

            $result = $this->PollService->insertUserPollVote( $data );
            if( $result->id > 0 ) {
                
                $pollVote = $this->PollService->getPollVoteByPollIdData( $result->id );
                $cnt = count((array)$pollVote);
                if( $cnt ) {

                    $this->userPointsService->insertUserPoints([
                        'pollId' => $pollVote->pollId,
                        'userId' => $pollVote->userId,
                        'transactionFor' => 'POLLVOTED'
                    ]);

                    $pollCreatedBy = $this->PollService->getPollByIdData( $data['pollId'] );
                    
                    return response()->json([
                        'message'   =>      'Record inserted successfully.',
                        'error'     =>      [],
                        'errorArr'  =>      [],
                        'data'      =>      [
                            'polls'     =>  $this->PollService->getPollVoteByPollIdUserIdData( $pollVote->pollId, $pollVote->userId ),
                            'votePercentage' => $this->PollService->countPollVotesByPollId( $data['pollId'] ),
                            'notificationDetails' => $this->notificationService->voteReceivedOnUserPoll( $pollVote->pollId, $pollCreatedBy['userId'], $data['vote'] )
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
    }

    public function countPollVotesByPollId() {
        
        $data = $this->request->input();
        $rules = [];

        $rules['pollId']  = 'required|numeric|min:1';

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

        $pollId = intval( $data['pollId'] );
        $poll = $this->PollService->isPollIdExistsData( $pollId );
        if( !$poll ) {

            return response()->json([
                'message' => 'Invalid poll id!',
                'error' => [ 'id' => 'Invalid poll id!' ],
                'errorArr' => [ 'Invalid poll id!' ],
                'data'  =>  $poll,
            ], 200);
        } 

        $votes = $this->PollService->countPollVotesByPollId( $pollId );
        if( count( $votes ) ) {

            return response()->json([
                'message' => 'Records found!',
                'error' => [],
                'errorArr' => [],
                'data'  =>  [
                    'votes' => $votes
                ]
            ], 200);
        } else {

            return response()->json([
                'message' => 'Record not found!',
                'error' => [],
                'errorArr' => ['Record not found!'],
                'data'  =>  $votes,
            ], 200);
        }
    }

    public function insertPollComment() {

        $data = $this->request->input();
        $rules = [
            'pollId'        =>      'required|numeric|min:1',
            'comment'       =>      'required'
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
        
        $poll = $this->PollService->isPollIdExistsData( $data['pollId'] );
        if( !$poll ) {

            return response()->json([
                'message' => 'Invalid poll id!',
                'error' => [ 'id' => 'Invalid poll id!' ],
                'errorArr' => [ 'Invalid poll id!' ],
                'data'  =>  $poll,
            ], 200);
        } 

        $poll = $this->PollService->isCommentsAllowedOnPoll( $data['pollId'] );
        if( !$poll ) {

            return response()->json([
                'message' => 'Comments are diabled on this poll!',
                'error' => [ 'id' => 'Comments are diabled on this poll!' ],
                'errorArr' => [ 'Comments are diabled on this poll!' ],
                'data'  =>  [],
            ], 200);
        }

        $data['userId'] = $this->loggedInUser->id;
        $result = $this->PollService->insertUserPollComment( $data );
        if( $result->id > 0 ) {
            $pollComment = $this->PollService->getPollCommentsByPollIdData( $result->id );
            $cnt = count((array)$pollComment);
            if( $cnt ) {
                
                $pollCreatedBy = $this->PollService->getPollByIdData( $pollComment->pollId );
                $commentedBy = $this->loggedInUser->id;
                $userData = $this->userService->getUserByIdData( $commentedBy );

                return response()->json([
                    'message'   =>      'Record inserted successfully.',
                    'error'     =>      [],
                    'errorArr'  =>      [],
                    'data'      =>      $this->PollService->getPollCommentsByPollIdUserIdCommentIdData( $pollComment->pollId, $pollComment->userId, $pollComment->id ),
                    'notificationDetails' => $this->notificationService->commentReceivedOnUserPoll( $pollComment->pollId, $pollCreatedBy['userId'], $data['comment'], $userData->userName )
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

    public function getPollCommentsByPollId() {

        $data = $this->request->input();
        $rules = [
            'pollId'        =>      'required|numeric|min:1'
        ];

        isset($data['offset']) ? $rules['offset']  = 'required|numeric|min:0' : '';
        isset($data['limit']) ? $rules['limit']  = 'required|numeric|min:1' : '';

        $validator = Validator::make( $data, $rules);
        if ( !$validator->passes()) {

            return response()->json([
                'message'   =>      'Some errors occured',
                'error'     =>      $validator->errors(),
                'errorArr'  =>      $validator->errors()->all(),
                'data'      =>      []
            ], 200);
        } 

        $in_data = [
            'pollId' => $data['pollId'],
            'loggedInUserId' => $this->loggedInUser->id,
            'offset'    =>  isset($data['offset']) ? $data['offset'] : 0,
            'limit'     =>  isset($data['limit']) ? $data['limit'] : 10
        ];
        
        $poll = $this->PollService->isPollIdExistsData( $data['pollId'] );
        if( !$poll ) {

            return response()->json([
                'message' => 'Invalid poll id!',
                'error' => [ 'id' => 'Invalid poll id!' ],
                'errorArr' => [ 'Invalid poll id!' ],
                'data'  =>  $poll,
            ], 200);
        } 

        $pollComments = $this->PollService->getPollCommentsByPollId( $in_data );
        if( count( (array)$pollComments ) ) {
            return response()->json([
                'message'   =>      'Records found.',
                'error'     =>      [],
                'errorArr'  =>      [],
                'data'      =>      $pollComments
            ], 200);
        } else {
            return response()->json([
                'message' => 'Record not found!',
                'error' => ['Record not found!'],
                'errorArr'  =>  ['Record not found!'],
                'data'  =>  []
            ], 200);           
        }
    }

    public function getMyLivePolls() {

        $data = $this->request->input();
        $rules = [];

        isset($data['offset']) ? $rules['offset']  = 'required|numeric|min:0' : '';
        isset($data['limit']) ? $rules['limit']  = 'required|numeric|min:1' : '';

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

        $currentDateTime = date("Y-m-d h:i:s");
        $day_before = date( 'Y-m-d h:i:s', strtotime( $currentDateTime . ' -1 day' ) );

        $in_data = [
            'day_before' => $day_before,
            'userId' => $this->loggedInUser->id,
            'offset'    =>  isset($data['offset']) ? $data['offset'] : 0,
            'limit'     =>  isset($data['limit']) ? $data['limit'] : 10
        ];
        $cnt = $this->PollService->countMyLivePolls( $in_data );
        if( $cnt ) {

            return response()->json([
                'message' => 'Records found!',
                'error' => [],
                'errorArr' => [],
                'data'  =>  [
                    'totalPolls' => $cnt,
                    'polls' => $this->PollService->getMyLivePolls( $in_data )
                ],
            ], 200);
        } else {

            return response()->json([
                'message' => 'Record not found!',
                'error' => [],
                'errorArr' => ['Record not found!'],
                'data'  =>  [],
            ], 200);
        }
    }

    public function getMyPolls() {

        $data = $this->request->input();
        $rules = [];

        isset($data['offset']) ? $rules['offset']  = 'required|numeric|min:0' : '';
        isset($data['limit']) ? $rules['limit']  = 'required|numeric|min:1' : '';
        isset($data['poll']) ? $rules['poll']  = 'required' : '';
        isset($data['people']) ? $rules['people']  = 'required' : '';
        isset($data['tags']) ? $rules['tags']  = 'required' : '';

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

        $currentDateTime = date("Y-m-d h:i:s");
        $day_before = date( 'Y-m-d h:i:s', strtotime( $currentDateTime . ' -1 day' ) );
        
        $in_data = [
            'day_before' => $day_before,
            'userId' => $this->loggedInUser->id,
            'offset'    =>  isset($data['offset']) ? $data['offset'] : 0,
            'limit'     =>  isset($data['limit']) ? $data['limit'] : 10
        ];
        
        isset( $data['poll'] ) ? $in_data['poll'] = $data['poll'] : '';
        isset( $data['people'] ) ? $in_data['people'] = $data['people'] : '';
        isset( $data['tags'] ) ? $in_data['tags'] = '#'. $data['tags'] : '';
        
        $cnt = $this->PollService->countMyPolls( $in_data );
        if( $cnt ) {

            return response()->json([
                'message' => 'Records found!',
                'error' => [],
                'errorArr' => [],
                'data'  =>  [
                    'totalPolls' => $cnt,
                    'polls' => $this->PollService->getMyPolls( $in_data )
                ],
            ], 200);
        } else {

            return response()->json([
                'message' => 'Record not found!',
                'error' => [],
                'errorArr' => ['Record not found!'],
                'data'  =>  [],
            ], 200);
        }
    }

    public function getLivePollsCount() {
        
        $currentDateTime = date("Y-m-d h:i:s");
        $day_before = date( 'Y-m-d h:i:s', strtotime( $currentDateTime . ' -1 day' ) );
        $in_data = [
            'userId' => 1,
            'day_before' => $day_before
        ];
        return response()->json([
            'message' => 'Records found!',
            'error' => [],
            'errorArr' => [],
            'cnt' => $this->PollService->countLivePolls( $in_data )
        ], 200);        
    }

    public function getLivePolls() {

        $data = $this->request->input();
        $rules = [];

        isset($data['offset']) ? $rules['offset']  = 'required|numeric|min:0' : '';
        isset($data['limit']) ? $rules['limit']  = 'required|numeric|min:1' : '';
        isset($data['genders']) ? $rules['genders']  = 'required' : '';
        isset($data['countryIds']) ? $rules['countryIds']  = 'required' : '';
        isset($data['groupIds']) ? $rules['groupIds']  = 'required' : '';
        isset($data['branchIds']) ? $rules['branchIds']  = 'required' : '';

        isset($data['poll']) ? $rules['poll']  = 'required' : '';
        isset($data['people']) ? $rules['people']  = 'required' : '';
        isset($data['tags']) ? $rules['tags']  = 'required' : '';

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

        $currentDateTime = date("Y-m-d h:i:s");
        $day_before = date( 'Y-m-d h:i:s', strtotime( $currentDateTime . ' -1 day' ) );

        $in_data = [
            'day_before' => $day_before,
            'offset'    =>  isset($data['offset']) ? $data['offset'] : 0,
            'limit'     =>  isset($data['limit']) ? $data['limit'] : 10,
            'search'    =>  isset($data['search']) ? $data['search'] : '',
            'userId'    =>  isset($this->loggedInUser->id) ? $this->loggedInUser->id : ''
        ];

        isset( $data['poll'] ) ? $in_data['poll'] = $data['poll'] : '';
        isset( $data['people'] ) ? $in_data['people'] = $data['people'] : '';
        isset( $data['tags'] ) ? $in_data['tags'] = '#'. $data['tags'] : '';

        if( isset( $data['genders'] ) ) {

            $gendersArr = explode( ',', $data['genders'] );
            $in_data['genders'] = $gendersArr;
            $in_data['genders'][] = "0";
        }

        if( isset( $data['years'] ) ) {

            $yearsArr = explode( ',', $data['years'] );
            $in_data['years'] = $yearsArr;
            $in_data['years'][] = "0";
        }

        if( isset( $data['countryIds'] ) ) {

            $countryIdsArr = explode( ',', $data['countryIds'] );
            $in_data['countryIds'] = $countryIdsArr;
            $in_data['countryIds'][] = "0";
        }

        if( isset( $data['groupIds'] ) ) {

            $groupIdsArr = explode( ',', $data['groupIds'] );
            $in_data['groupIds'] = $groupIdsArr;
            $in_data['groupIds'] = "0";
        }

        if( isset( $data['branchIds'] ) ) {

            $branchIdsArr = explode( ',', $data['branchIds'] );
            $in_data['branchIds'] = $branchIdsArr;
            $in_data['branchIds'][] = "0";
        }

        $cnt = $this->PollService->countLivePolls( $in_data );
        if( $cnt > 0 ) {
            
            return response()->json([
                'message' => 'Records found!',
                'error' => [],
                'errorArr' => [],
                'data'  =>  [
                    'totalPolls' => $cnt,
                    'polls' => $this->PollService->getLivePolls( $in_data )
                ],
            ], 200);
        } else {

            return response()->json([
                'message' => 'Record not found!',
                'error' => [],
                'errorArr' => ['Record not found!'],
                'data'  =>  [],
            ], 200);
        }
    }

    public function rePublishPoll() {

        $userId = 0;
        $data = $this->request->input();
        $rules = [];

        $rules = [
            'pollId'                =>      'required|numeric|min:1',
            'published_at'          =>      'required|date|date_format:Y-m-d'
        ];

        $userId = $this->loggedInUser->id;

        $validator = Validator::make( $data, $rules);
        if ( !$validator->passes()) {

            return response()->json([
                'message'   =>      'Some errors occured',
                'error'     =>      $validator->errors(),
                'errorArr'  =>      $validator->errors()->all(),
                'data'      =>      []
            ], 200);
        } 

        $id = intval( $data['pollId'] );
        $poll = $this->PollService->isPollIdExistsData( $id );
        if( !$poll ) {

            return response()->json([
                'message' => 'Invalid poll id!',
                'error' => [ 'id' => 'Invalid poll id!' ],
                'errorArr' => [ 'Invalid poll id!' ],
                'data'  =>  $poll,
            ], 200);
        } 

        if( $this->loggedInUser->id != 1 ) {

            $poll = $this->PollService->isPollIdBelongsToUser( $id, $userId );
            if( !$poll ) {
    
                return response()->json([
                    'message' => 'Poll is not belongs to the logged in user!',
                    'error' => [ 'id' => 'Poll is not belongs to the logged in user!' ],
                    'errorArr' => [ 'Poll is not belongs to the logged in user!' ],
                    'data'  =>  $poll,
                ], 200);
            } 
        }

        $oldPollData = $this->PollService->getPollByIdData( $id );
        $cnt = count((array)$oldPollData);
        if( !$cnt ) {

            return response()->json([
                'message' => 'Record not found!',
                'error' => [],
                'errorArr' => [],
                'data'  =>  $oldPollData,
            ], 200);
        }

        $in_data = [
            'id' => $oldPollData['id'],
            'userId' => $userId,
            'question' => isset($data['question']) ? $data['question'] : $oldPollData['question'],
            'allowComments' => isset($data['allowComments']) ? $data['allowComments'] : $oldPollData['allowComments'],
            'status' => isset($data['status']) ? $data['status'] : $oldPollData['status'],
            'published_at' => $data['published_at']
        ];

        $result = $this->PollService->updatePollData( $in_data );
        if( $result > 0 ) {

            $poll = $this->PollService->getPollByIdData( $in_data['id'] );
            $cnt = count((array)$poll);
            if( $cnt ) {

                return response()->json([
                    'message'   =>      'Poll republish successfully.',
                    'error'     =>      [],
                    'errorArr'     =>      [],
                    'data'      =>      [
                        'polls'  => $this->PollService->getInsertedPoll( $poll['id'] )
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

    public function getVotedPolls() {

        $data = $this->request->input();
        $rules = [];

        isset($data['offset']) ? $rules['offset']  = 'required|numeric|min:0' : '';
        isset($data['limit']) ? $rules['limit']  = 'required|numeric|min:1' : '';

        $validator = Validator::make( $data, $rules);
        if ( !$validator->passes()) {

            return response()->json([
                'message'   =>      'Some errors occured',
                'error'     =>      $validator->errors(),
                'errorArr'  =>      $validator->errors()->all(),
                'data'      =>      []
            ], 200);
        }

        $in_data = [
            'offset'    =>  isset($data['offset']) ? $data['offset'] : 0,
            'limit'     =>  isset($data['limit']) ? $data['limit'] : 10,
            'search'    =>  isset($data['search']) ? $data['search'] : ''
        ];
        
        $cnt = $this->PollService->countVotedPolls( $in_data );
        if( $cnt > 0 ) {

            return response()->json([
                'message' => 'Records found!',
                'error' => [],
                'errorArr' => [],
                'data'  =>  [
                    'totalPolls' => $cnt,
                    'polls' => $this->PollService->getVotedPolls( $in_data )
                ],
            ], 200);
        } else {

            return response()->json([
                'message' => 'Record not found!',
                'error' => [],
                'errorArr' => ['Record not found!'],
                'data'  =>  [],
            ], 200);
        }
    }

    public function countPollsVotedDashboard() {
        
        return response()->json([
            'message' => 'Records found!',
            'error' => [],
            'errorArr' => [],
            'cnt' => $this->PollService->countPollsVotedDashboard()
        ], 200);        
    }

    public function getPollsVotedByMe() {

        $data = $this->request->input();
        $rules = [];

        isset($data['offset']) ? $rules['offset']  = 'required|numeric|min:0' : '';
        isset($data['limit']) ? $rules['limit']  = 'required|numeric|min:1' : '';
        isset($data['poll']) ? $rules['poll']  = 'required' : '';
        isset($data['people']) ? $rules['people']  = 'required' : '';
        isset($data['tags']) ? $rules['tags']  = 'required' : '';
        
        $validator = Validator::make( $data, $rules);
        if ( !$validator->passes()) {

            return response()->json([
                'message'   =>      'Some errors occured',
                'error'     =>      $validator->errors(),
                'errorArr'  =>      $validator->errors()->all(),
                'data'      =>      []
            ], 200);
        }

        $in_data = [
            'offset'    =>  isset($data['offset']) ? $data['offset'] : 0,
            'limit'     =>  isset($data['limit']) ? $data['limit'] : 10,
            'userId'    =>  isset($this->loggedInUser->id) ? $this->loggedInUser->id : ''
        ];

        isset( $data['poll'] ) ? $in_data['poll'] = $data['poll'] : '';
        isset( $data['people'] ) ? $in_data['people'] = $data['people'] : '';
        isset( $data['tags'] ) ? $in_data['tags'] = '#'. $data['tags'] : '';

        $cnt = $this->PollService->countPollsVotedByMe( $in_data );
        if( $cnt > 0 ) {

            return response()->json([
                'message' => 'Records found!',
                'error' => [],
                'errorArr' => [],
                'data'  =>  [
                    'totalPolls' => $cnt,
                    'polls' => $this->PollService->getPollsVotedByMe( $in_data )
                ],
            ], 200);
        } else {

            return response()->json([
                'message' => 'Record not found!',
                'error' => [],
                'errorArr' => ['Record not found!'],
                'data'  =>  [],
            ], 200);
        }
    }

    public function insertCommentLikeDislike() {

        $data = $this->request->input();
        $rules = [
            'pollId'                =>      'required',
            'value'                 =>      'required',
            'relPollCommentsId'     =>      'required'
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

        $poll = $this->PollService->isPollIdExistsData( $data['pollId'] );
        if( !$poll ) {

            return response()->json([
                'message' => 'Invalid poll id!',
                'error' => [ 'id' => 'Invalid poll id!' ],
                'errorArr' => [ 'Invalid poll id!' ],
                'data'  =>  $poll,
            ], 200);
        }        

        $data['userId'] = $this->loggedInUser->id;
        $result = $this->PollService->insertCommentLikeDislike( $data );
        if( $result->id > 0 ) {
            
            $pollCreatedBy = $this->PollService->getPollByIdData( $data['pollId'] );
            $userDetails = $this->userService->getUserByIdData( $data['userId'] );
            return response()->json([
                'message'   =>      'Record saved successfully.',
                'error'     =>      [],
                'errorArr'  =>      [],
                'data'      =>      $result,
                'notificationDetails' => $this->notificationService->commentReceivedOnUserPoll( $data['pollId'], $pollCreatedBy['userId'], $data['value'], $userDetails->userName )
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

    public function getUserStats() {

        $userId = $this->loggedInUser->id;
        $user = $this->PollService->getUserStats( $userId );
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

    public function pollEnded() {

        return response()->json([
            'message' => 'Records found!',
            'error' => [],
            'errorArr'  =>  [],
            'data'  =>  $this->notificationService->pollEnded()
        ], 200);        
    }

    public function deletePollImageByPollId() {

        $data = $this->request->input();
        $rules = [];

        $rules['pollId']  = 'required|numeric|min:0';

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

        $id = intval( $data['pollId'] );
        $poll = $this->PollService->getOnlyPollById( $id );
        $cnt = count($poll);
        if( $cnt ) {

            if( $poll['imageLink'] != '' && $poll['imageLink'] != 'undefined' ) {

                $filename = $poll['imageLink'];
                $path = storage_path('polls/' . $filename);
                if( unlink( $path ) ) {

                    $poll['imageLink'] = '';
                    $result = $this->PollService->updatePollData( $poll );
                    if( $result > 0 ) {

                        return response()->json([
                            'message' => 'Image deleted successfully!',
                            'error' => [],
                            'errorArr'  =>  [],
                            'data'  =>  $this->PollService->getPollByIdData( $id )
                        ], 200);
                    } else {
                        
                        return response()->json([
                            'message'   =>      'Unable to update image link.',
                            'error'     =>      ['Unable to update image link.'],
                            'errorArr'     =>      ['Unable to update image link.'],
                            'data'      =>      []
                        ], 200);
                    }
                } else {

                    return response()->json([
                        'message'   =>      'Unable to delete image.',
                        'error'     =>      ['Unable to delete image.'],
                        'errorArr'     =>      ['Unable to delete image.'],
                        'data'      =>      []
                    ], 200);
                }
            } else {
                
                return response()->json([
                    'message' => 'Poll do not contain any image!',
                    'error' => ['Poll do not contain any image!'],
                    'errorArr'  =>  ['Poll do not contain any image!'],
                    'data'  =>  [],
                ], 200);
            }
        } else {

            return response()->json([
                'message' => 'Record not found!',
                'error' => ['Record not found!'],
                'errorArr'  =>  ['Record not found!'],
                'data'  =>  [],
            ], 200);
        }       
    }

    public function sharePoll( $in_slug ) {

        $pollId = intval( base64_decode( $in_slug ) );
        $tagsStr = '';

        $poll = $this->PollService->isPollIdExistsData( $pollId );
        if( !$poll ) {

            return response()->json([
                'message' => 'Invalid poll id!',
                'error' => [ 'id' => 'Invalid poll id!' ],
                'errorArr' => [ 'Invalid poll id!' ],
                'data'  =>  $poll,
            ], 200);
        } 

        $poll = $this->PollService->sharePoll( $pollId );
        $cnt = count($poll);
        if( $cnt ) {

            if( $poll['imageLink'] != 'null' && strlen( $poll['imageLink'] ) > 0 ) {

                $pollImageUrl = url('storage/polls/'. $poll['imageLink']);
                list( $pollWidth, $pollHeight ) = getimagesize( $pollImageUrl );

                $poll['pollImageDetails'] = $pollImageUrl;

                $poll['baseUrl'] = url();
                $poll['slug'] = url() .'/poll/share/'. $in_slug;

                $tmpPollArr = explode( '#', $poll['question'] );
                
                if( count($tmpPollArr) ) {

                    foreach ( $tmpPollArr as $key => $value ) {
                        
                        if( $key == 0 ) {

                            $poll['question'] = $tmpPollArr[$key];
                        } else {

                            $poll['tags'][] = '#'. $tmpPollArr[$key];
                            $tagsStr .= $tagsStr .' '. $tmpPollArr[$key];
                        }
                    }
                    $poll['tagsStr'] = $tagsStr;
                }

                return view('share-poll.sharePollPage', [ 'poll' => $poll ]);
            }            
        } 
    }
}