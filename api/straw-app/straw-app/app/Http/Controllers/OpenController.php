<?php

namespace App\Http\Controllers;
use Validator;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Laravel\Lumen\Routing\Controller as BaseController;
use App\Country;
use App\Branch;
use App\Group;
use App\Services\UserService;

use Firebase\JWT\JWT;

use Illuminate\Support\Facades\Mail;
use Redirect,Response,DB,Config;

class OpenController extends BaseController
{
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

    public function getAllCountriesData() {

        return Country::all();
    }

    public function getAllCountries() {

        return response()->json([
            'message' => 'Records found!',
            'error' => [],
            'data'  =>  [
                'countries' => $this->getAllCountriesData()
            ],
        ], 200);
    }

    public function getAllBranchesData() {

        return Branch::all();
    }

    public function getAllBranches() {

        return response()->json([
            'message' => 'Records found!',
            'error' => [],
            'data'  =>  [
                'branches'    =>  $this->getAllBranchesData()
            ],
        ], 200);
    }

    public function getAllGroupsData() {

        return Group::all();
    }

    public function getAllGroups() {

        return response()->json([
            'message' => 'Records found!',
            'error' => [],
            'data'  =>  [
                'groups'  =>  $this->getAllGroupsData()
            ],
        ], 200);
    }

    public function getChildrenNew( $in_data, $parentId ) {

        $out_data = [];
        $childIds = [];
        foreach( $in_data AS $k => $v ) {

            if( $v->parentId == $parentId ) {

                if( !in_array( $v->childId, $childIds ) ) {
    
                    $childIds[] = $v->childId;
    
                    if( $v->childId > 4 ) {
    
                        $out_data[] = [
                            'id' => $v->childId,
                            'parentId' => $v->parentId,
                            'name' => $v->childName
                        ];
                    }
                }
            }
        }

        return $out_data;
    }

    public function getAllGroupsDataNew() {

        $result = DB::select("SELECT a.id AS parentRowId, a.parent_id AS grandParentId, a.name AS parentName, b.id AS childId, b.parent_id AS parentId, b.name AS childName FROM groups AS a, groups AS b where a.id = b.parent_id");
        if( count( (array)$result ) ) {
            $parentIds = [];
            $out_data = [];
            foreach( $result AS $key => $val ) {

                if( !in_array( $val->parentRowId, $parentIds ) ) {
                  
                    if( $val->grandParentId == 0 ) {
                        
                        $parentIds[] = $val->parentRowId;

                        $out_data[] = [
                            'id' => $val->parentRowId,
                            'parentId' => $val->grandParentId,
                            'name' => $val->parentName,
                            'children' => $this->getChildrenNew( $result, $val->parentRowId )
                        ];
                    }
                }
            }
        } 
        return $out_data;
    }

    public function getChildrenCustom( $in_data, $parentId ) {

        $out_data = [];
        $childIds = [];
        foreach( $in_data AS $k => $v ) {

            if( $v->parentId == $parentId ) {

                if( !in_array( $v->childId, $childIds ) ) {
    
                    $childIds[] = $v->childId;
    
                    if( $v->childId > 4 ) {
    
                        $out_data[] = [
                            'id' => $v->childId,
                            'parent_id' => $v->parentId,
                            'value' => $v->childName,
                            'isSelected' => false
                        ];
                    }
                }
            }
        }

        return $out_data;
    }

    public function getAllGroupsDataCustom() {

        $result = DB::select("SELECT a.id AS parentRowId, a.parent_id AS grandParentId, a.name AS parentName, b.id AS childId, b.parent_id AS parentId, b.name AS childName FROM groups AS a, groups AS b where a.id = b.parent_id");
        if( count( (array)$result ) ) {

            $parentIds = [];
            $out_data = [];
            foreach( $result AS $key => $val ) {

                if( !in_array( $val->parentRowId, $parentIds ) ) {
                  
                    if( $val->grandParentId == 0 ) {
                        
                        $parentIds[] = $val->parentRowId;

                        $out_data[] = [
                            'id' => $val->parentRowId,
                            'parent_id' => $val->grandParentId,
                            'value' => $val->parentName,
                            'isClosed' => true,
                            'isSelected' => false,
                            'childList' => $this->getChildrenCustom( $result, $val->parentRowId )
                        ];
                    }
                }
            }
        } 
        return $out_data;
    }

    public function getSignUpData() {

        return response()->json([
            'message' => 'Records found!',
            'error' => [],
            'errorArr' => [],
            'data'  =>  [
                'branches' => $this->getAllBranchesData(),
                'countries' => $this->getAllCountriesData(),
                'groups' => $this->getAllGroupsData(),
                'groupsNew' => $this->getAllGroupsDataNew(),
                'groupsCustom' => $this->getAllGroupsDataCustom()
            ]
        ], 200);
    }

    public function loadPushNotificationView() {

        return view('push-notification/pushNotification', []);
    }

    public function decodeToken() {

        $data = $this->request->input();
        $rules = [
            'token'        =>      'required'
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

        return response()->json([
            'message' => 'Records found!',
            'error' => [],
            'errorArr' => [],
            'data'  =>  [
                'jwt' => $credentials = JWT::decode($data['token'], env('JWT_SECRET'), ['HS256']),
                'createdAt' => date( "Y-m-d h:i:s", $credentials->iat ),
                'expiredAt' => date( "Y-m-d h:i:s", $credentials->exp ),
                'user' => $user = $this->userService->getSignedInUserData( $credentials->sub )
            ]
        ], 200);
    }
}
