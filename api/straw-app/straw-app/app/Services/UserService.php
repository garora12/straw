<?php
namespace App\Services;
use App\User;
use App\RelUserGroup;
use App\RelUserCountry;
use App\Group;
use App\Country;
use DB;

class UserService {

    public function __construct() {
        DB::enableQueryLog();
    }

    public function getAllUsersDataCount( $in_data ) {

        $out_data;
        if( isset( $in_data['search'] ) && !empty( $in_data['search'] ) ) {
            $out_data = User::where( 'status', '!=', 'DELETED' )
            ->where( 'id', '!=', '1' )
            ->where( 'userName', 'LIKE', '%'. $in_data['search'] .'%' )
            ->orWhere( 'universityEmail', 'LIKE', '%'. $in_data['search'] .'%' )
            ->orWhere( 'gender', 'LIKE', '%'. $in_data['search'] .'%' )
            ->orWhere( 'status', 'LIKE', '%'. $in_data['search'] .'%' )
            ->orderBy('id', 'desc')->get(); 
        } else {
            $out_data = User::where( [
                ['id', '!=', '1'],
                ['status', '!=', 'DELETED'],
            ] )->orderBy('id', 'desc')->get(); 
        }

        return $out_data->count();
    }

    public function getAllUsersData( $in_data ) {

        if( isset( $in_data['search'] ) && !empty( $in_data['search'] ) ) {
            return User::where( 'status', '!=', 'DELETED' )
            ->where( 'id', '!=', '1' )
            ->where( 'userName', 'LIKE', '%'. $in_data['search'] .'%' )
            ->orWhere( 'universityEmail', 'LIKE', '%'. $in_data['search'] .'%' )
            ->orWhere( 'gender', 'LIKE', '%'. $in_data['search'] .'%' )
            ->orWhere( 'status', 'LIKE', '%'. $in_data['search'] .'%' )
            ->orderBy('id', 'desc')
            ->offset($in_data['offset'])
            ->limit($in_data['limit'])->get(); 
        } else {
            return User::where( [
                ['id', '!=', '1'],
                ['status', '!=', 'DELETED'],
            ] )->orderBy('id', 'desc')->offset($in_data['offset'])->limit($in_data['limit'])->get(); 
        }
    }

    public function getUserByIdDataOld( $id ) {

        return User::where([
            ['id', '=', $id],
            ['status', '!=', 'DELETED']
        ])->first();
    }

    public function getUserByIdData( $id ) {

        return User::where([
            ['id', '=', $id],
            ['status', '!=', 'DELETED']
        ])->first();
    }

    public function getDeletedUserByIdData( $id ) {

        return User::where([
            ['id', '=', $id],
            ['status', '=', 'DELETED']
        ])->first();
    }

    public function isUserNameExistsData( $userName, $id = false ) {

        $users;
        if( $id ) {

            $users = User::where([
                ['id', '!=', $id],
                ['userName', '=', $userName]
            ])->count();
        } else {

            $users = User::where('userName', $userName)->count();
        }
        return $users > 0 ? true : false;
    }

    public function isEmailExistsData( $email, $id = false ) {

        $users;
        if( $id ) {

            $users = User::where([
                ['id', '!=', $id],
                ['universityEmail', '=', $email]
            ])->count();
        } else {

            $users = User::where('universityEmail', $email)->count();
        }
        return $users > 0 ? true : false;
    }

    public function insertUserData( $in_data ) {
        
        $data = User::create($in_data);
        return $data;
    }

    public function deleteUserGroups( $userId ) {

        $res = RelUserGroup::where( 'userId', $userId )->delete();
        return true;
    }

    public function insertUserGroups( $userId, $groupsId ) {

        $in_data = [];

        $result = $this->deleteUserGroups( $userId );
        foreach( $groupsId AS $key => $val ) {

            if( $val == 'ALL' ) {

                $in_data[] = [
                    'userId'    =>  $userId,
                    'groupId'   =>  0,
                    'created_at'=>date('Y-m-d H:i:s'),
                    'updated_at'=> date('Y-m-d H:i:s')
                ];
                break;
            } else {

                $in_data[] = [
                    'userId'    =>  $userId,
                    'groupId'   =>  $val,
                    'created_at'=>date('Y-m-d H:i:s'),
                    'updated_at'=> date('Y-m-d H:i:s')
                ];
            }
        }

        $data = RelUserGroup::insert( $in_data );
        return $data;
    }

    public function deleteUserCountries( $userId ) {

        $res = RelUserCountry::where( 'userId', $userId )->delete();
        return true;
    }

    public function insertUserCountries( $userId, $groupsId ) {

        $in_data = [];

        $result = $this->deleteUserCountries( $userId );
        foreach( $groupsId AS $key => $val ) {

            if( $val == 'ALL' ) {

                $in_data[] = [
                    'userId'    =>  $userId,
                    'countryId'   =>  0,
                    'created_at'=>date('Y-m-d H:i:s'),
                    'updated_at'=> date('Y-m-d H:i:s')
                ];
                break;
            } else {

                $in_data[] = [
                    'userId'    =>  $userId,
                    'countryId'   =>  $val,
                    'created_at'=>date('Y-m-d H:i:s'),
                    'updated_at'=> date('Y-m-d H:i:s')
                ];
            }
        }

        $data = RelUserCountry::insert( $in_data );
        return $data;
    }

    public function getSignedInUserData( $userId ) {

        $result = DB::table('users AS usr')
                    ->leftJoin('branches AS brn', 'usr.branchId', '=', 'brn.id')
                    ->leftJoin('rel_user_countries AS ruc', 'usr.id', '=', 'ruc.userId')
                    ->leftJoin('countries AS cntr', 'cntr.id', '=', 'ruc.countryId')
                    ->leftJoin('rel_user_groups AS rug', 'usr.id', '=', 'rug.userId')
                    ->leftJoin('groups AS grp', 'rug.groupId', '=', 'grp.id')
                    ->leftJoin( 'user_notification_settings AS uns', 'usr.id', '=', 'uns.userId' )
                    ->leftJoin( 'rel_user_notification_tokens AS runt', 'usr.id', '=', 'runt.userId' )
                    ->where( 'usr.id', '=', $userId )
                    ->select( 
                        'usr.id', 
                        'usr.userName', 
                        'usr.universityEmail', 
                        'usr.gender', 
                        'usr.imageLink', 
                        'usr.studyingYear', 
                        'usr.branchId', 
                        'usr.status', 
                        // 'usr.created_at', 
                        // 'usr.updated_at', 
                        'rug.groupId AS rel_user_groups_id',
                        'ruc.countryId AS rel_user_countries_id',
                        'brn.name AS branchName', 
                        'grp.id AS groupId', 
                        'grp.name AS groupName', 
                        'grp.parent_id AS groupParentId', 
                        'cntr.id AS countryId', 
                        'cntr.name AS countryName',
                        'uns.settings AS settings',
                        'runt.token AS fcmNotificationToken'
                    )
                    ->get();
                    
        if( isset($result[0]) && count( (array)$result[0] ) ) {
            
            $data = $result[0];
            $out_data = [
                "id" => $data->id,
                "userName" => $data->userName,
                "universityEmail" => $data->universityEmail,
                "gender" => $data->gender,
                "imageLink" => $data->imageLink,
                "studyingYear" => $data->studyingYear,
                "branchId" => $data->branchId,
                "branchName" => $data->branchName,
                "status" => $data->status,
                "fcmNotificationToken" => $data->fcmNotificationToken,
                "userNotificationSettings" => json_decode( $data->settings )
                // "created_at" => $data->created_at,
                // "updated_at" => $data->updated_at,
            ];
    
            $selectedGroupIds = [];
            $alreadyAddedCountries = [];
            $rel_user_groups_id = null;
            $rel_user_countries_id = null;
            foreach( $result AS $key => $val ) {
                
                if( $val->countryId ) {
                    
                    if( !in_array( $val->countryId, $alreadyAddedCountries ) ) {

                        $rel_user_countries_id = $val->rel_user_countries_id;
                        $out_data['countries'][] = [
                            'countryId' => $val->countryId,
                            'countryName' => $val->countryName
                        ];
                        $alreadyAddedCountries[] = $val->countryId;
                    }
                } 
                // else {
                //     $out_data['countries'] = [];
                //     break;
                // }
                
                if( !in_array( $val->groupId, $selectedGroupIds ) ) {
                        
                    $rel_user_groups_id = $val->rel_user_groups_id;
                    if( !is_null( $val->groupId ) ) {
                        $selectedGroupIds[] = $val->groupId;
                    } 
                }
            }

            /** to check if the selectedGroupIds are empty then all groups are selected */
            $isGroupEmpty = false;

            if( empty( $selectedGroupIds ) ) {
                $isGroupEmpty = true;
            } else {
                $isGroupEmpty = false;                
            }

            $groups = Group::all()->toArray();
            $parentsArr = [];
            $groupsArr = [];
            $sessionGroupsIds = [];

            foreach( $result AS $key => $val ) {
    
                if( $val->groupId && $val->groupParentId == 0 ) {
    
                    foreach( $groups AS $k => $v ) {

                        if( $val->groupId == $v['parent_id'] ) {

                            $groupsArr['groups'][$val->groupId]['parentId'] = $val->groupParentId;
                            $groupsArr['groups'][$val->groupId]['groupId'] = $val->groupId;
                            $groupsArr['groups'][$val->groupId]['groupName'] = $val->groupName;
                            
                            if( in_array( $v['id'], $selectedGroupIds ) ) {
    
                                $groupsArr['groups'][$val->groupId]['children'][$v['id']] = [
                                    'parentId' => $v['parent_id'], 
                                    'groupId' => $v['id'],
                                    'groupName' => $v['name']
                                ];
                            }
                        }
                    } 
                } 
            }

            if( is_array( $groupsArr ) && !empty( $groupsArr ) ) {

                foreach( $groupsArr AS $key => $val ) {

                    $i = 0;
                    foreach( $val AS $k => $v ) {
    
                        $out_data['groups'][$i]['parentId'] = $v['parentId'];
                        $out_data['groups'][$i]['groupId'] = $v['groupId'];
                        $out_data['groups'][$i]['groupName'] = $v['groupName'];
                        $sessionGroupsIds[] = $v['groupId'];
                        
                        if( isset( $v['children'] ) && is_array( $v['children'] ) ) {
    
                            foreach( $v['children'] AS $ck => $cv ) {
        
                                $out_data['groups'][$i]['children'][] = [
                                    'parentId' => $cv['parentId'], 
                                    'groupId' => $cv['groupId'],
                                    'groupName' => $cv['groupName']
                                ];
                                $sessionGroupsIds[] = $cv['groupId'];
                            }
                        }
                        $i++;
                    }
                }
            } else {

                $i = 0;                
                if( $rel_user_groups_id == 0 ) {
                    
                    foreach ( $groups as $key => $value ) {
                        
                        if( $value['parent_id'] == 0 ) {
                            
                            foreach ( $groups as $k => $val ) {
                            
                                if( $val['parent_id'] == $value['id'] ) {

                                    $out_data['groups'][$i]['parentId'] = $value['parent_id'];
                                    $out_data['groups'][$i]['groupId'] = $value['id'];
                                    $out_data['groups'][$i]['groupName'] = $value['name'];
                                    $sessionGroupsIds[] = $value['id'];

                                    $out_data['groups'][$i]['children'][] = [
                                        'parentId' => $val['parent_id'], 
                                        'groupId' => $val['id'],
                                        'groupName' => $val['name']
                                    ];
                                    $sessionGroupsIds[] = $val['id'];
                                }
                            }        
                            $i++;
                        }
                    }
                } else {
                    
                    $out_data['groups'] = [];
                }
            }

            $out_data['countries'] = $rel_user_countries_id == 0 ? Country::select( 'id AS countryId', 'name AS countryName' )->get()->toArray() : $out_data['countries'];
            $outGroups = [];
            if( $isGroupEmpty ) {
                $outGroups = Group::select( 'id AS groupId' )->get()->toArray();
            } 
            $out_data['filters'] = [
                'genders' => $out_data['gender'],
                'studyingYears' => $out_data['studyingYear'],
                'branchIds' => $out_data['branchId'],
                'countries' => isset( $out_data['countries'] ) && is_array( $out_data['countries'] ) ? array_column( $out_data['countries'], 'countryId' ) : '',
                'groups' => $isGroupEmpty ? array_column( $outGroups, 'groupId' ) : $sessionGroupsIds
            ];
            return $out_data;
        } else {

            return false;
        }
    }

    public function isUserIdExistsData( $id ) {

        $user = User::where([
            ['id', '=', $id],
            ['status', '!=', 'DELETED']
        ])->count();
        return $user > 0 ? true : false;
    }

    public function isUserDeletedSoftly( $id ) {

        $user = User::where([
            ['id', '=', $id],
            ['status', '=', 'DELETED']
        ])->count();
        return $user > 0 ? true : false;
    }

    public function updateUserData( $in_data ) {

        DB::table('users')->where( 'id', $in_data['id'] )->update($in_data);
        return $in_data['id'];
    }

    public function updatePasswordByEmailData( $in_data ) {

        DB::table('users')->where( 'universityEmail', $in_data['universityEmail'] )->update($in_data);
        return true;
    }

    public function deleteAllUserDataByUserId( $userId ) {

        // delete user groups
        DB::table( 'rel_user_groups' )->where( 'userId', $userId )->delete();

        // delete user countries
        DB::table( 'rel_user_countries' )->where( 'userId', $userId )->delete();

        // delete user points
        DB::table( 'rel_user_points' )->where( 'userId', $userId )->delete();

        // delete user notification tokens
        DB::table( 'rel_user_notification_tokens' )->where( 'userId', $userId )->delete();
        
        // delete user notification settings
        DB::table( 'user_notification_settings' )->where( 'userId', $userId )->delete();

        return true;
    }
}
?>
