<?php
namespace App\Services;
use App\Poll;
use App\RelPollGroup;
use App\RelPollGender;
use App\RelPollYear;
use App\RelPollCountries;
use App\RelPollBranches;
use App\RelPollVotes;
use App\RelPollComments;
use App\RelPollCommentsLikes;
use App\Group;
use App\Country;
use App\Branch;
use App\RelUserPoints;
use DB;

use App\Services\UserPointsService;

use Illuminate\Database\QueryException;

class PollService {

    public function __construct() {
        DB::enableQueryLog();
    }

    public function getAllPollsDataCount( $in_data ) {

        if( isset( $in_data['search'] ) && !empty( $in_data['search'] ) ) {

            $result = DB::table('polls AS poll')
                    ->leftJoin('users AS usr', 'poll.userId', '=', 'usr.id')
                    ->where('poll.status', '!=', 'DELETED')
                    ->where('usr.id', '!=', '1')
                    ->where( 'poll.question', 'LIKE', '%'. $in_data['search'] .'%' )
                    ->orWhere( 'poll.allowComments', 'LIKE', '%'. $in_data['search'] .'%' )
                    ->orWhere( 'usr.userName', 'LIKE', '%'. $in_data['search'] .'%' )
                    ->select(
                        'poll.id',
                        'poll.userId',
                        'poll.question',
                        // 'poll.imageLink',
                        'poll.allowComments',
                        'poll.status',
                        'usr.userName'
                    )
                    ->orderBy('poll.id', 'desc')
                    ->get(); 
        } else {

            $result = DB::table('polls AS poll')
                    ->leftJoin('users AS usr', 'poll.userId', '=', 'usr.id')
                    ->where('poll.status', '!=', 'DELETED')
                    ->where('usr.id', '!=', '1')
                    ->select(
                        'poll.id',
                        'poll.userId',
                        'poll.question',
                        // 'poll.imageLink',
                        'poll.allowComments',
                        'poll.status',
                        'usr.userName'
                    )
                    ->orderBy('poll.id', 'desc')
                    ->get();
        }
        return $result->count();
    }

    public function getAllPollsData( $in_data ) {

        if( isset( $in_data['search'] ) && !empty( $in_data['search'] ) ) {

            return $result = DB::table('polls AS poll')
                    ->leftJoin('users AS usr', 'poll.userId', '=', 'usr.id')
                    ->where('poll.status', '!=', 'DELETED')
                    ->where('usr.id', '!=', '1')
                    ->where( 'poll.question', 'LIKE', '%'. $in_data['search'] .'%' )
                    ->orWhere( 'poll.allowComments', 'LIKE', '%'. $in_data['search'] .'%' )
                    ->orWhere( 'usr.userName', 'LIKE', '%'. $in_data['search'] .'%' )
                    ->select(
                        'poll.id',
                        'poll.userId',
                        'poll.question',
                        // 'poll.imageLink',
                        'poll.allowComments',
                        'poll.status',
                        'usr.userName'
                    )
                    ->orderBy('poll.id', 'desc')
                    ->offset($in_data['offset'])
                    ->limit($in_data['limit'])->get(); 
        } else {

            return $result = DB::table('polls AS poll')
                    ->leftJoin('users AS usr', 'poll.userId', '=', 'usr.id')
                    ->where('poll.status', '!=', 'DELETED')
                    ->where('usr.id', '!=', '1')
                    ->select(
                        'poll.id',
                        'poll.userId',
                        'poll.question',
                        // 'poll.imageLink',
                        'poll.allowComments',
                        'poll.status',
                        'usr.userName'
                    )
                    ->orderBy('poll.id', 'desc')
                    ->offset($in_data['offset'])->limit($in_data['limit'])
                    ->get();
        }
    }

    /* public function getPollByIdData( $id ) {

        $result = DB::table('polls AS poll')
                    ->leftJoin('rel_poll_branches AS rpb', 'poll.id', '=', 'rpb.pollId')
                    ->leftJoin('branches AS b', 'rpb.branchId', '=', 'b.id')
                    ->leftJoin('rel_poll_countries AS rpc', 'poll.id', '=', 'rpc.pollId')
                    ->leftJoin('countries AS c', 'rpc.countryId', '=', 'c.id')
                    ->leftJoin('rel_poll_years AS rpy', 'poll.id', '=', 'rpy.pollId')
                    ->leftJoin('rel_poll_genders AS rpg', 'poll.id', '=', 'rpg.pollId')
                    ->leftJoin('rel_poll_groups AS rpgrp', 'poll.id', '=', 'rpgrp.pollId')
                    ->leftJoin('groups AS g', 'rpgrp.groupId', '=', 'g.id')
                    ->where([
                        ['poll.id', '=', $id],
                        ['poll.status', '!=', 'DELETED']
                    ])
                    ->select(
                        'poll.id',
                        'poll.userId',
                        'poll.question',
                        'poll.imageLink',
                        'poll.allowComments',
                        'poll.status',
                        'rpb.branchId',

                        'rpc.countryId',
                        'c.name AS countryName',
                        
                        'rpy.year',
                        'rpg.gender',
                        'rpgrp.groupId',
                        'b.name AS branchName',
                        'g.name AS groupName'
                    )
                    ->get(); 
                        
        if( $result ) {

            $out_data = [
                'poll' => [],
                'branchIds' => [],
                'countryIds' => [],
                'years' => [],
                'genders' => [],
                'groups' => []
            ];
            $branchIdArr = [];
            $countryIdArr = [];
            $yearsArr = [];
            $gendersArr = [];
            $groupsArr = [];

            $poll = [];
            $branchId = [];
            $countryId = [];
            $years = [];
            $genders = [];
            $groups = [];

            foreach( $result AS $key => $val ) {
                $poll['id'] = $val->id;
                $poll['userId'] = $val->userId;
                $poll['question'] = $val->question;
                $poll['imageLink'] = $val->imageLink;
                $poll['allowComments'] = $val->allowComments;
                $poll['status'] = $val->status;
                
                if( !in_array( $val->branchId, $branchIdArr ) ) {
                    $branchIdArr[] = $val->branchId;
                    $branchId[] = [
                        'id' => $val->branchId,
                        'name' => $val->branchName
                    ];
                }
                
                if( !in_array( $val->countryId, $countryIdArr ) ) {
                    $countryIdArr[] = $val->countryId;
                    $countryId[] = [
                        'id' => $val->countryId,
                        'name' => $val->countryName
                    ];
                }

                if( !in_array( $val->year, $yearsArr ) ) {
                    $yearsArr[] = $val->year;
                    $years[] = [
                        'id' => $val->year,
                        'name' => $val->year
                    ];
                }

                if( !in_array( $val->gender, $gendersArr ) ) {
                    $gendersArr[] = $val->gender;
                    $genders[] = [
                        'id' => $val->gender,
                        'name' => $val->gender
                    ];
                }

                if( !in_array( $val->groupId, $groupsArr ) ) {
                    $groupsArr[] = $val->groupId;
                    $groups[] = [
                        'id' => $val->groupId,
                        'name' => $val->groupName
                    ];
                }
            }

            return $out_data = (object)[
                'poll' => $poll,
                'branchIds' => $branchId,
                'countryIds' => $countryId,
                'years' => $years,
                'genders' => $genders,
                'groups' => $groups
            ];
        } else {

        }
        die();
    } */

    public function getOnlyPollById( $id ) {

        return Poll::where([
            ['id', '=', $id],
            ['status', '!=', 'DELETED']
        ])->first()->toArray();
    }

    public function getPollByIdData( $pollId ) {

        return $this->getInsertedPoll( $pollId );
    }

    public function getPollsByUserIdData( $userId, $in_data ) {

        return Poll::where([
            ['userId', '=', $userId],
            ['status', '=', 'OPEN'],
        ])->offset($in_data['offset'])->limit($in_data['limit'])->get(); 
    }

    public function getDeletedPollByIdData( $id ) {

        return Poll::where([
            ['id', '=', $id],
            ['status', '=', 'DELETED']
        ])->first();
    }

    public function isPollIdExistsData( $id ) {

        $poll = Poll::where('id', $id)->count();
        return $poll > 0 ? true : false;
    }

    public function isPollIdLive( $pollId ) {

        $currentDateTime = date("Y-m-d h:i:s");
        $day_before = date( 'Y-m-d h:i:s', strtotime( $currentDateTime . ' -1 day' ) );

        $result = Poll::where([
            ['id', '=', $pollId],
            ['published_at', '>=', $day_before],
            ['status', '=', 'OPEN']
        ])->count(); 
        return $result > 0 ? true : false;
    }

    public function isPollIdBelongsToUser( $pollId, $userId ) {
        $poll = Poll::where([
            ['id', '=', $pollId],
            ['userId', '=', $userId],
            ['status', '!=', 'DELETED'],
        ])->count();
        return $poll > 0 ? true : false;
    }

    public function deletePollGroups( $pollId ) {

        $res = RelPollGroup::where( 'pollId', $pollId )->delete();
        return true;
    }

    public function insertPollGroups( $pollId, $groupsId ) {

        $in_data = [];

        $result = $this->deletePollGroups( $pollId );
        foreach( $groupsId AS $key => $val ) {

            if( $val == 'ALL' ) {

                $in_data[] = [
                    'pollId'    =>  $pollId,
                    'groupId'   =>  0,
                    'created_at'=>date('Y-m-d H:i:s'),
                    'updated_at'=> date('Y-m-d H:i:s')
                ];
                break;
            } else {
                
                $in_val = intval($val);
                if( $in_val > 0 ) {

                    $in_data[] = [
                        'pollId'    =>  $pollId,
                        'groupId'   =>  $in_val,
                        'created_at'=>date('Y-m-d H:i:s'),
                        'updated_at'=> date('Y-m-d H:i:s')
                    ];
                }
            }
        }

        $data = RelPollGroup::insert( $in_data );
        return $data;
    }

    public function insertPollData( $in_data ) {

        $data = Poll::create($in_data);
        return $data;
    }

    public function updatePollData( $in_data ) {

        $affectedRows = DB::table('polls')->where( 'id', $in_data['id'] )->update($in_data);
        return $in_data['id'];
    }

    public function hardDeletePoll( $pollId ) {
        return $result = Poll::destroy($pollId);
    }

    public function getInsertedPoll( $pollId ) {

        $result = DB::table('polls AS poll')
                    ->leftJoin('rel_poll_groups AS rpg', 'poll.id', '=', 'rpg.pollId')
                    ->leftJoin('groups AS grp', 'rpg.groupId', '=', 'grp.id')
                    ->leftJoin('rel_poll_genders AS rpge', 'rpge.pollId', '=', 'poll.id')
                    ->leftJoin('rel_poll_years AS rpy', 'rpy.pollId', '=', 'poll.id')
                    ->leftJoin('rel_poll_countries AS rpc', 'rpc.pollId', '=', 'poll.id')
                    ->leftJoin('countries AS c', 'c.id', '=', 'rpc.countryId')
                    ->leftJoin('rel_poll_branches AS rpb', 'rpb.pollId', '=', 'poll.id')
                    ->leftJoin('branches AS b', 'b.id', '=', 'rpb.branchId')
                    ->where( 'poll.id', '=', $pollId )
                    ->select(
                        'poll.id',
                        'poll.userId',
                        'poll.question',
                        'poll.imageLink',
                        'poll.allowComments',
                        'poll.status',
                        'poll.published_at',
                        'rpg.groupId AS rel_poll_groups_id',
                        'grp.id AS groupId', 
                        'grp.name AS groupName', 
                        'grp.parent_id AS groupParentId',
                        'rpge.gender AS gender',
                        'rpy.year AS year',
                        'rpc.countryId AS rel_poll_countries_id',
                        'c.id AS countryId',
                        'c.name AS countryName',
                        'rpb.branchId AS rel_poll_branches_id',
                        'b.id AS branchId',
                        'b.name AS branchName'
                    )
                    ->get();
        
        if( count( (array)$result[0] ) ) {

            $data = $result[0];
            $out_data = [
                "id" => $data->id,
                "userId" => $data->userId,
                "question" => $data->question,
                "imageLink" => $data->imageLink,
                "allowComments" => $data->allowComments,
                "status" => $data->status,
                "published_at" => $data->published_at
            ];

            $selectedGroupIds = [];
            $selectedGenders = [];
            $selectedYears = [];
            $alreadyAddedCountries = [];
            $alreadyAddedBranches = [];
            $countries = [];
            $branches = [];
            $rel_poll_groups_id = null;
            $rel_poll_countries_id = null;
            $rel_poll_branches_id = null;
            foreach( $result AS $key => $val ) {
                    
                if( $val->groupId && !in_array( $val->groupId, $selectedGroupIds ) ) {
                    
                    $rel_poll_groups_id = $val->rel_poll_groups_id;
                    $selectedGroupIds[] = $val->groupId;
                }

                if( $val->gender && !in_array( $val->gender, $selectedGenders ) ) {

                    $selectedGenders[] = $val->gender;
                }

                if( $val->year && !in_array( $val->year, $selectedYears ) ) {

                    $selectedYears[] = (string)$val->year;
                }
                
                if( $val->countryId && !in_array( $val->countryId, $alreadyAddedCountries ) ) {

                    $rel_poll_countries_id = $val->rel_poll_countries_id;
                    $countries[] = [
                        'countryId' => $val->countryId,
                        'countryName' => $val->countryName
                    ];
                    $alreadyAddedCountries[] = $val->countryId;
                } 
            
                if( $val->branchId && !in_array( $val->branchId, $alreadyAddedBranches ) ) {

                    $rel_poll_branches_id = $val->rel_poll_branches_id;
                    $branches[] = [
                        'branchId' => $val->branchId,
                        'branchName' => $val->branchName
                    ];
                    $alreadyAddedBranches[] = $val->branchId;
                }
            }
            $groups = Group::all()->toArray();
            $groupsArr = [];

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
                        
                        if( isset( $v['children'] ) && is_array( $v['children'] ) ) {
    
                            foreach( $v['children'] AS $ck => $cv ) {
        
                                $out_data['groups'][$i]['children'][] = [
                                    'parentId' => $cv['parentId'], 
                                    'groupId' => $cv['groupId'],
                                    'groupName' => $cv['groupName']
                                ];
                            }
                        }
                        $i++;
                    }
                }
            } else {

                $i = 0;                
                if( $rel_poll_groups_id == 0 ) {
                    
                    foreach ( $groups as $key => $value ) {
                        
                        if( $value['parent_id'] == 0 ) {
                            
                            foreach ( $groups as $k => $val ) {
                            
                                if( $val['parent_id'] == $value['id'] ) {

                                    $out_data['groups'][$i]['parentId'] = $value['parent_id'];
                                    $out_data['groups'][$i]['groupId'] = $value['id'];
                                    $out_data['groups'][$i]['groupName'] = $value['name'];

                                    $out_data['groups'][$i]['children'][] = [
                                        'parentId' => $val['parent_id'], 
                                        'groupId' => $val['id'],
                                        'groupName' => $val['name']
                                    ];
                                }
                            }        
                            $i++;
                        }
                    }
                } else {
                    
                    $out_data['groups'] = [];
                }
            }

            $out_data['genders'] = !empty( $selectedGenders ) ? $selectedGenders : ['MALE', 'FEMALE', 'NEUTRAL', 'OTHER'];
            $out_data['years'] = !empty( $selectedYears ) ? $selectedYears : ["1","2","3","4"];
            $out_data['countries'] = $rel_poll_countries_id == 0 ? Country::select( 'id AS countryId', 'name AS countryName' )->get()->toArray() : $countries;
            $out_data['branches'] = $rel_poll_branches_id == 0 ? Branch::select( 'id AS branchId', 'name AS branchName' )->get()->toArray() : $branches;
            return $out_data;

        } else {

            return false;
        }
    }

    public function deletePollGenders( $pollId ) {

        $res = RelPollGender::where( 'pollId', $pollId )->delete();
        return true;
    }

    public function insertPollGenders( $pollId, $genders ) {

        $in_data = [];

        $result = $this->deletePollGenders( $pollId );
        foreach( $genders AS $key => $val ) {

            if( $val == 'ALL' ) {

                /*$in_data = [
                    [
                        'pollId'    =>  $pollId,
                        'gender'   =>  'MALE',
                        'created_at'=>date('Y-m-d H:i:s'),
                        'updated_at'=> date('Y-m-d H:i:s')
                    ],
                    [
                        'pollId'    =>  $pollId,
                        'gender'   =>  'FEMALE',
                        'created_at'=>date('Y-m-d H:i:s'),
                        'updated_at'=> date('Y-m-d H:i:s')
                    ],
                    [
                        'pollId'    =>  $pollId,
                        'gender'   =>  'NEUTRAL',
                        'created_at'=>date('Y-m-d H:i:s'),
                        'updated_at'=> date('Y-m-d H:i:s')
                    ],
                    [
                        'pollId'    =>  $pollId,
                        'gender'   =>  'OTHER',
                        'created_at'=>date('Y-m-d H:i:s'),
                        'updated_at'=> date('Y-m-d H:i:s')
                    ],
                ];*/
                $in_data[] = [
                    'pollId'    =>  $pollId,
                    'gender'   =>  "0",
                    'created_at'=>date('Y-m-d H:i:s'),
                    'updated_at'=> date('Y-m-d H:i:s')
                ];
                break;
            } else {
                $in_data[] = [
                    'pollId'    =>  $pollId,
                    'gender'   =>  $val,
                    'created_at'=>date('Y-m-d H:i:s'),
                    'updated_at'=> date('Y-m-d H:i:s')
                ];
            }
        }

        $data = RelPollGender::insert( $in_data );
        return $data;
    }

    public function deletePollYears( $pollId ) {

        $res = RelPollYear::where( 'pollId', $pollId )->delete();
        return true;
    }

    public function insertPollYears( $pollId, $years ) {

        $in_data = [];

        $result = $this->deletePollYears( $pollId );
        foreach( $years AS $key => $val ) {

            if( $val == 'ALL' ) {

                /*$in_data = [
                    [
                        'pollId'    =>  $pollId,
                        'year'   =>  1,
                        'created_at'=>date('Y-m-d H:i:s'),
                        'updated_at'=> date('Y-m-d H:i:s')
                    ],
                    [
                        'pollId'    =>  $pollId,
                        'year'   =>  2,
                        'created_at'=>date('Y-m-d H:i:s'),
                        'updated_at'=> date('Y-m-d H:i:s')
                    ],
                    [
                        'pollId'    =>  $pollId,
                        'year'   =>  3,
                        'created_at'=>date('Y-m-d H:i:s'),
                        'updated_at'=> date('Y-m-d H:i:s')
                    ],
                    [
                        'pollId'    =>  $pollId,
                        'year'   =>  4,
                        'created_at'=>date('Y-m-d H:i:s'),
                        'updated_at'=> date('Y-m-d H:i:s')
                    ],
                ];*/
                $in_data[] = [
                    'pollId'    =>  $pollId,
                    'year'   =>  0,
                    'created_at'=>date('Y-m-d H:i:s'),
                    'updated_at'=> date('Y-m-d H:i:s')
                ];
                break;
            } else {
                $in_val = intval($val);
                if( $in_val > 0 && $in_val < 5 ) {

                    $in_data[] = [
                        'pollId'    =>  $pollId,
                        'year'   =>  $val,
                        'created_at'=>date('Y-m-d H:i:s'),
                        'updated_at'=> date('Y-m-d H:i:s')
                    ];
                }
            }
        }

        $data = RelPollYear::insert( $in_data );
        return $data;
    }

    public function deletePollCountries( $pollId ) {

        $res = RelPollCountries::where( 'pollId', $pollId )->delete();
        return true;
    }

    public function insertPollCountries( $pollId, $countries ) {

        $in_data = [];
        $result = $this->deletePollCountries( $pollId );
        foreach( $countries AS $key => $val ) {

            if( $val == 'ALL' ) {

                /*$countries = Country::all('id')->toArray();
                foreach( $countries AS $k => $v ) {
                    $in_data[] = [
                        'pollId'    =>  $pollId,
                        'countryId'   =>  $v['id'],
                        'created_at'=>date('Y-m-d H:i:s'),
                        'updated_at'=> date('Y-m-d H:i:s')
                    ];
                }*/
                $in_data[] = [
                    'pollId'    =>  $pollId,
                    'countryId'   =>  0,
                    'created_at'=>date('Y-m-d H:i:s'),
                    'updated_at'=> date('Y-m-d H:i:s')
                ];
                break;
            } else {

                $in_val = intval($val);
                if( $in_val > 0 && $in_val < 5 ) {

                    $in_data[] = [
                        'pollId'    =>  $pollId,
                        'countryId'   =>  $in_val,
                        'created_at'=>date('Y-m-d H:i:s'),
                        'updated_at'=> date('Y-m-d H:i:s')
                    ];
                }
            }
        }

        $data = RelPollCountries::insert( $in_data );
        return $data;
    }

    public function deletePollBranches( $pollId ) {

        $res = RelPollBranches::where( 'pollId', $pollId )->delete();
        return true;
    }

    public function insertPollBranches( $pollId, $branches ) {

        $in_data = [];
        $result = $this->deletePollBranches( $pollId );
        foreach( $branches AS $key => $val ) {

            if( $val == 'ALL' ) {

                /*$countries = RelPollBranches::all('id')->toArray();
                foreach( $countries AS $k => $v ) {
                    $in_data[] = [
                        'pollId'    =>  $pollId,
                        'branchId'   =>  $v['id'],
                        'created_at'=>date('Y-m-d H:i:s'),
                        'updated_at'=> date('Y-m-d H:i:s')
                    ];
                }*/
                $in_data[] = [
                    'pollId'    =>  $pollId,
                    'branchId'   =>  0,
                    'created_at'=>date('Y-m-d H:i:s'),
                    'updated_at'=> date('Y-m-d H:i:s')
                ];
                break;
            } else {

                $in_val = intval($val);
                if( $in_val > 0 && $in_val < 5 ) {

                    $in_data[] = [
                        'pollId'    =>  $pollId,
                        'branchId'   =>  $in_val,
                        'created_at'=>date('Y-m-d H:i:s'),
                        'updated_at'=> date('Y-m-d H:i:s')
                    ];
                }
            }
        }

        $data = RelPollBranches::insert( $in_data );
        return $data;
    }

    public function isUserVotedPollAlready( $pollId, $userId ) {

        $poll = RelPollVotes::where([
            ['pollId', '=', $pollId],
            ['userId', '=', $userId]
        ])->count();
        return $poll > 0 ? true : false;
    }

    public function insertUserPollVote( $in_data ) {
        $data = RelPollVotes::create( $in_data );
        return $data;
    }

    public function updateUserPollVote( $in_data ) {

        DB::table('rel_poll_votes')->where( 'id', $in_data['id'] )->update( $in_data );
        return $in_data['id'];
    }

    public function getPollVoteByPollIdUserId( $pollId, $userId  ) {
        return RelPollVotes::where([
            ['pollId', '=', $pollId],
            ['userId', '=', $userId]
        ])->first();
    }

    public function getPollVoteByPollIdUserIdData( $pollId, $userId ) {

        $result = DB::table( 'rel_poll_votes AS rpv' )
                ->leftJoin( 'users AS usr', 'rpv.userId', '=', 'usr.id' )
                ->leftJoin( 'polls AS poll', 'rpv.pollId', '=', 'poll.id' )
                ->where([
                    ['rpv.pollId', '=', $pollId],
                    ['rpv.userId', '=', $userId]
                ])
                ->select(
                    'rpv.id AS id',
                    'rpv.pollId AS pollId',
                    'rpv.userId AS userId',
                    'rpv.vote AS vote',
                    'usr.userName AS userName',
                    'usr.universityEmail AS universityEmail',
                    'usr.imageLink AS userImageLink',
                    'usr.gender AS gender',
                    'usr.studyingYear AS studyingYear',
                    'poll.question AS question',
                    'poll.imageLink AS pollImageLink',
                    'poll.allowComments AS allowComments'
                )->first();
        return $result;
    }

    public function getPollVoteByPollIdData( $pollId ) {

        return RelPollVotes::where([
            ['id', '=', $pollId],
            ['status', '!=', 'DELETED']
        ])->first();
    }

    public function getPollVisibilityByPollId( $pollId ) {

        try {
            
            $result = DB::table( 'polls AS poll' )
                        ->leftJoin( 'rel_poll_years AS rpy', 'poll.id', '=', 'rpy.pollId' )
                        ->leftJoin( 'rel_poll_genders AS rpg', 'poll.id', '=', 'rpg.pollId' )
                        ->leftJoin( 'rel_poll_branches AS rpb', 'poll.id', '=', 'rpb.pollId' )
                        ->leftJoin( 'rel_poll_groups AS rpgrp', 'poll.id', '=', 'rpgrp.pollId' )
                        ->leftJoin( 'rel_poll_countries AS rpc', 'poll.id', '=', 'rpc.pollId' )
                        ->where( 'poll.id', $pollId )
                        ->select(
                            'rpy.year AS year',
                            'rpg.gender AS gender',
                            'rpb.branchId AS branchId',
                            'rpgrp.groupId AS groupId',
                            'rpc.countryId AS countryId'
                        )
                        ->groupBy(
                            'rpy.year',
                            'rpg.gender',
                            'rpb.branchId',
                            'rpgrp.groupId',
                            'rpc.countryId'
                        )
                        ->get();
            
            if( count($result) ) {

                $out_data = [
                    'years' => [],
                    'genders' => [],
                    'branchIds' => [],
                    'groupIds' => [],
                    'countryIds' => [],
                ];
                $years = [];
                $genders = [];
                $branchIds = [];
                $groupIds = [];
                $countryIds = [];

                foreach( $result AS $key => $val ) {

                    !in_array( $val->year, $years ) ? $years[] = $val->year : '';
                    !in_array( $val->gender, $genders ) ? $genders[] = $val->gender : '';
                    !in_array( $val->groupId, $groupIds ) ? $groupIds[] = $val->groupId : '';
                    !in_array( $val->countryId, $countryIds ) ? $countryIds[] = $val->countryId : '';
                    !in_array( $val->branchId, $branchIds ) ? $branchIds[] = $val->branchId : '';
                }
                return $out_data = [
                    'years' => $years,
                    'genders' => $genders,
                    'branchIds' => $branchIds,
                    'groupIds' => $groupIds,
                    'countryIds' => $countryIds
                ];
            } else {
                
            }

        } catch (QueryException $e) {
           var_dump($e->getMessage());
            //    \Log::error('QueryException: ' . $e->getMessage());   
        }
    }

    public function getUsersPollVisibileToCount( $in_data ) {

        try {

            $result = DB::table( 'users AS usr' )
                        ->leftJoin( 'rel_user_groups AS rug', 'usr.id', '=', 'rug.userId' )
                        ->leftJoin( 'rel_user_countries AS ruc', 'usr.id', '=', 'ruc.userId' )
                        ->select(
                            'usr.id AS id'
                            // 'usr.userName AS userName',
                            // 'usr.studyingYear AS studyingYear',
                            // 'usr.gender AS gender',
                            // 'usr.branchId AS branchId',
                            // 'rug.groupId AS groupId',
                            // 'ruc.countryId AS countryId'
                        )
                        ->groupBy(
                            'usr.id'
                            // 'usr.studyingYear', 
                            // 'usr.gender', 
                            // 'usr.branchId', 
                            // 'rug.groupId', 
                            // 'ruc.countryId'
                        );
            
                        isset( $in_data['years'] ) && !empty( $in_data['years'] ) ? $result = $result->whereIn( 'usr.studyingYear', $in_data['years'] ) : '' ;
                        isset( $in_data['genders'] ) && !empty( $in_data['genders'] ) ? $result = $result->whereIn( 'usr.gender', $in_data['genders'] ) : '' ;
                        isset( $in_data['branchIds'] ) && !empty( $in_data['branchIds'] ) ? $result = $result->whereIn( 'usr.branchId', $in_data['branchIds'] ) : '' ;
                        isset( $in_data['groupIds'] ) && !empty( $in_data['groupIds'] ) ? $result = $result->whereIn( 'rug.groupId', $in_data['groupIds'] ) : '' ;
                        isset( $in_data['countryIds'] ) && !empty( $in_data['countryIds'] ) ? $result = $result->whereIn( 'ruc.countryId', $in_data['countryIds'] ) : '' ;

                        $result = $result->count();
                        return $result;

        } catch (QueryException $e) {
            var_dump($e->getMessage());
            //    \Log::error('QueryException: ' . $e->getMessage());   
        }
    }

    public function countPollVotesByPollId( $pollId ) {

        // $pollVisibility = $this->getPollVisibilityByPollId( $pollId );
        // $userPollVisibiltyCount = $this->getUsersPollVisibileToCount( $pollVisibility );

        $result = RelPollVotes::where([
            ['pollId', '=', $pollId],
            ['status', '=', 'OPEN'],
        ])
        ->select(
            DB::raw('pollId, vote, count(*) as total')
        )->groupBy('vote', 'pollId')
        ->get();

        $out_data = [
            [
                'pollId' => $pollId,
                'vote' => 'YES',
                'total' => 0,
                'percent' => 0
            ],
            [
                'pollId' => $pollId,
                'vote' => 'NO',
                'total' => 0,
                'percent' => 0
            ]
        ];

        if( count( (array)$result ) ) {
            
            foreach( $result AS $key => $val ) {
                
                if( $val['vote'] == 'YES' ) {
                    $out_data[0]['pollId'] = $val['pollId'];
                    $out_data[0]['vote'] = $val['vote'];
                    $out_data[0]['total'] = $val['total'];
                } else if( $val['vote'] == 'NO' ) {
                    $out_data[1]['pollId'] = $val['pollId'];
                    $out_data[1]['vote'] = $val['vote'];
                    $out_data[1]['total'] = $val['total'];
                }
            }
        } 

        $totalUpVotes = isset( $out_data[0]['total'] ) ? intval( $out_data[0]['total'] ) : 0;
        $totalDownVotes = isset( $out_data[1]['total'] ) ? intval( $out_data[1]['total'] ) : 0;
      
        $totalVotes = $totalUpVotes + $totalDownVotes;

        $out_data[0]['pollId'] = $val['pollId'];
        $out_data[0]['vote'] = 'YES';
        $out_data[0]['total'] = $val['total'];
        $out_data[0]['percent'] = $totalUpVotes > 0 ? (( $totalUpVotes / $totalVotes ) * 100) : 0;
        $out_data[0]['percent'] = round( $out_data[0]['percent'] );

        $out_data[1]['pollId'] = $val['pollId'];
        $out_data[1]['vote'] = 'NO';
        $out_data[1]['total'] = $val['total'];
        $out_data[1]['percent'] = $totalDownVotes > 0 ? (( $totalDownVotes / $totalVotes ) * 100) : 0;
        $out_data[1]['percent'] = round( $out_data[1]['percent'] );

        /*
            $totalVotes = $userPollVisibiltyCount > 0 ? intval( $userPollVisibiltyCount ) : 0;

            $out_data[0]['pollId'] = $pollId;
            $out_data[0]['vote'] = 'YES';
            $out_data[0]['total'] = $totalUpVotes;
            $out_data[0]['percent'] = $totalUpVotes > 0 ? (( $totalUpVotes / $totalVotes ) * 100) : 0;
            $out_data[0]['percent'] = round( $out_data[0]['percent'] );

            $out_data[1]['pollId'] = $pollId;
            $out_data[1]['vote'] = 'NO';
            $out_data[1]['total'] = $totalDownVotes;
            $out_data[1]['percent'] = $totalDownVotes > 0 ? (( $totalDownVotes / $totalVotes ) * 100) : 0;
            $out_data[1]['percent'] = round( $out_data[1]['percent'] );
        */

        // if( !empty( $out_data ) ) {

        //     $out_data = $this->calculateVotePercentage( $out_data );
        // }
        return $out_data;
    }

    public function insertUserPollComment( $in_data ) {
        $data = RelPollComments::create( $in_data );
        return $data;
    }

    public function getPollCommentsByPollIdData( $pollId ) {

        return RelPollComments::where([
            ['id', '=', $pollId],
            ['status', '!=', 'DELETED']
        ])->first();
    }

    public function getPollCommentsByPollIdUserIdData( $pollId, $userId ) {

        $result = DB::table( 'rel_poll_comments AS rpc' )
                ->leftJoin( 'users AS usr', 'rpc.userId', '=', 'usr.id' )
                ->leftJoin( 'polls AS poll', 'rpc.pollId', '=', 'poll.id' )
                ->where([
                    ['rpc.pollId', '=', $pollId],
                    ['rpc.userId', '=', $userId]
                ])
                ->select(
                    'rpc.id AS id',
                    'rpc.pollId AS pollId',
                    'rpc.userId AS userId',
                    'rpc.comment AS comment',
                    'rpc.parentId AS parentId',
                    'usr.userName AS userName',
                    'usr.universityEmail AS universityEmail',
                    'usr.imageLink AS userImageLink',
                    'usr.gender AS gender',
                    'usr.studyingYear AS studyingYear',
                    'poll.question AS question',
                    'poll.imageLink AS pollImageLink',
                    'poll.allowComments AS allowComments'
                )->orderBy('rpc.id', 'asc')
                ->get();
        
        if( count( $result ) ) {

            $out_data = [
                'poll' => [],
                'user'  => [],
                'comments' => []
            ];
            $poll = [];
            $user = [];
            $comments = [];
            foreach( $result AS $key => $val ) {

                $poll['pollId'] = $val->pollId;
                $poll['userId'] = $val->userId;
                $poll['question'] = $val->question;
                $poll['allowComments'] = $val->allowComments;

                $user['userId'] = $val->userId;
                $user['userName'] = $val->userName;
                $user['universityEmail'] = $val->universityEmail;
                $user['userImageLink'] = $val->userImageLink;
                $user['gender'] = $val->gender;
                $user['studyingYear'] = $val->studyingYear;
                break;
            }

            $i = 0;
            foreach( $result AS $key => $val ) {

                $comments[$i]['commentId'] = $val->id;
                $comments[$i]['pollId'] = $val->pollId;
                $comments[$i]['userId'] = $val->userId;
                $comments[$i]['parentId'] = $val->parentId;
                $comments[$i]['comment'] = $val->comment;
                $i++;
            }

            $out_data = [
                'poll' => $poll,
                'user'  => $user,
                'comments' => $comments
            ];
        } 
        return $out_data;
    }

    public function getPollCommentsByPollIdUserIdCommentIdData( $pollId, $userId, $commentId ) {

        $out_data = [
            'poll' => [],
            'user'  => [],
            'comments' => []
        ];

        $result = DB::table( 'rel_poll_comments AS rpc' )
                ->leftJoin( 'users AS usr', 'rpc.userId', '=', 'usr.id' )
                ->leftJoin( 'polls AS poll', 'rpc.pollId', '=', 'poll.id' )
                ->where([
                    ['rpc.id', '=', $commentId],
                    ['rpc.pollId', '=', $pollId],
                    ['rpc.userId', '=', $userId]
                ])
                ->select(
                    'rpc.id AS id',
                    'rpc.pollId AS pollId',
                    'rpc.userId AS userId',
                    'rpc.comment AS comment',
                    'rpc.parentId AS parentId',
                    'usr.userName AS userName',
                    'usr.universityEmail AS universityEmail',
                    'usr.imageLink AS userImageLink',
                    'usr.gender AS gender',
                    'usr.studyingYear AS studyingYear',
                    'poll.question AS question',
                    'poll.imageLink AS pollImageLink',
                    'poll.allowComments AS allowComments'
                )->orderBy('rpc.id', 'asc')
                ->get();
                
        if( count( $result ) ) {

            $poll = [];
            $user = [];
            $comments = [];
            foreach( $result AS $key => $val ) {

                $poll['pollId'] = $val->pollId;
                $poll['userId'] = $val->userId;
                $poll['question'] = $val->question;
                $poll['allowComments'] = $val->allowComments;

                $user['userId'] = $val->userId;
                $user['userName'] = $val->userName;
                $user['universityEmail'] = $val->universityEmail;
                $user['userImageLink'] = $val->userImageLink;
                $user['gender'] = $val->gender;
                $user['studyingYear'] = $val->studyingYear;
                break;
            }

            $i = 0;
            foreach( $result AS $key => $val ) {

                $comments[$i]['commentId'] = $val->id;
                $comments[$i]['pollId'] = $val->pollId;
                $comments[$i]['userId'] = $val->userId;
                $comments[$i]['parentId'] = $val->parentId;
                $comments[$i]['comment'] = $val->comment;
                $i++;
            }

            $out_data = [
                'poll' => $poll,
                'user'  => $user,
                'comments' => $comments
            ];
        } 
        return $out_data;
    }

    // one query getPollCommentsByPollId but with duplicate comments issue
    /* public function getPollCommentsByPollId( $in_data ) {

        $result = DB::table( 'rel_poll_comments AS rpc' )
                    ->leftJoin( 'rel_poll_comments_likes AS rpcl', 'rpc.id', '=', 'rpcl.relPollCommentsId' )
                    ->leftJoin( 'rel_poll_votes AS rpv', 'rpc.pollId', '=', 'rpv.pollId' )
                    ->leftJoin( 'users AS usrComments', 'rpc.userId', '=', 'usrComments.id' )
                    ->leftJoin( 'users AS usrLikes', 'rpcl.userId', '=', 'usrLikes.id' )                    
                    ->leftJoin( 'polls AS poll', 'rpc.pollId', '=', 'poll.id' )
                    ->leftJoin( 'users AS usrPoll', 'poll.userId', '=', 'usrPoll.id' )                    
                    ->where( 'rpc.pollId', $in_data['pollId'] )
                    ->select(
                        'rpc.id as id', 
                        'rpv.vote AS vote', 
                        'rpc.comment AS comment', 
                        'rpc.parentId as commentParentId', 
                        'rpc.userId AS commentedByUserId',
                        'usrComments.userName as commentedByUserName', 
                        'usrComments.imageLink as commentedByUserImageLink', 

                        'poll.id AS pollId',
                        'poll.question as question', 
                        'poll.imageLink as pollImageLink', 
                        'poll.allowComments as allowComments', 
                        'usrPoll.id as pollCreatedByUserId', 
                        'usrPoll.userName as pollCreatedByUserName', 
                        'usrPoll.imageLink as pollCreatedByUserImageLink', 
                        
                        'rpcl.value AS pollLiked', 
                        'rpcl.userId AS likedByUserId',
                        'usrLikes.userName as likedByUserName', 
                        'usrLikes.imageLink as likedByUserImageLink'
                    )
                    ->groupBy(
                        'id',
                        'comment',

                        'pollId',
                        'question',
                        'pollImageLink',
                        'allowComments',
                        
                        'pollCreatedByUserId',
                        'pollCreatedByUserName',
                        'pollCreatedByUserImageLink',
                        
                        'vote',
                        
                        'commentParentId',
                        'commentedByUserId',
                        'commentedByUserName',
                        'commentedByUserImageLink',
                        
                        'pollLiked',
                        'likedByUserId',
                        'likedByUserName',
                        'likedByUserImageLink'
                    )
                    ->orderBy('rpc.id', 'asc')
                    ->offset($in_data['offset'])->limit($in_data['limit'])
                    ->get();
                    
        $out_data = [];
        if( count( $result ) ) {

            $poll = [];
            $user = [];
            $comments = [];
            foreach( $result AS $key => $val ) {

                $poll['pollId'] = $val->pollId;
                $poll['question'] = $val->question;
                $poll['pollImageLink'] = $val->pollImageLink;
                $poll['allowComments'] = $val->allowComments;

                $poll['pollCreatedByUserId'] = $val->pollCreatedByUserId;
                $poll['pollCreatedByUserName'] = $val->pollCreatedByUserName;
                $poll['pollCreatedByUserImageLink'] = $val->pollCreatedByUserImageLink;

                if( $val->pollImageLink != 'null' && strlen( $val->pollImageLink ) > 0 ) {

                    $pollImageUrl = url('storage/polls/'. $val->pollImageLink);
                    list( $pollWidth, $pollHeight ) = getimagesize( $pollImageUrl );

                    $poll['pollImageDetails'] = [
                        'relativePath' => $pollImageUrl,
                        'width' => $pollWidth,
                        'height' => $pollHeight
                    ];
                }

                if( $val->pollCreatedByUserImageLink != 'null' && strlen( $val->pollCreatedByUserImageLink ) > 0 ) {

                    $userImageUrl = url('storage/'. $val->pollCreatedByUserImageLink);
                    list( $userWidth, $userHeight ) = getimagesize( $userImageUrl );

                    $poll['pollCreatedByImageDetails'] = [
                        'relativePath' => $userImageUrl,
                        'width' => $userWidth,
                        'height' => $userHeight
                    ];
                }
                break;
            }

            $i = 0;
            $userCntr = 0;
            $userIdExistsArr = [];
            foreach( $result AS $key => $val ) {

                // if( !in_array( $val->userId, $userIdExistsArr ) ) {

                //     $userIdExistsArr[] = $val->userId;
                //     $user[$userCntr]['userId'] = $val->userId;
                //     $user[$userCntr]['userName'] = $val->userName;
                //     $user[$userCntr]['universityEmail'] = $val->universityEmail;
                //     $user[$userCntr]['userImageLink'] = $val->userImageLink;
                //     $user[$userCntr]['gender'] = $val->gender;
                //     $user[$userCntr]['studyingYear'] = $val->studyingYear;
                //     $userCntr++;
                // }

                $comments[$i]['pollId'] = $val->pollId;
                $comments[$i]['commentId'] = $val->id;
                $comments[$i]['vote'] = $val->vote;
                $comments[$i]['comment'] = $val->comment;
                $comments[$i]['commentParentId'] = $val->commentParentId;
                $comments[$i]['commentedByUserId'] = $val->commentedByUserId;
                $comments[$i]['commentedByUserName'] = $val->commentedByUserName;
                $comments[$i]['commentedByUserImageLink'] = $val->commentedByUserImageLink;

                if( $val->commentedByUserImageLink != 'null' && strlen( $val->commentedByUserImageLink ) > 0 ) {

                    $userImageUrl = url('storage/'. $val->commentedByUserImageLink);
                    list( $userWidth, $userHeight ) = getimagesize( $userImageUrl );

                    $comments[$i]['commentedByUserImageDetails'] = [
                        'relativePath' => $userImageUrl,
                        'width' => $userWidth,
                        'height' => $userHeight
                    ];
                }

                $comments[$i]['pollLiked'] = $val->pollLiked;
                $comments[$i]['likedByUserId'] = $val->likedByUserId;
                $comments[$i]['likedByUserName'] = $val->likedByUserName;
                $comments[$i]['likedByUserImageLink'] = $val->likedByUserImageLink;

                if( $val->likedByUserImageLink != 'null' && strlen( $val->likedByUserImageLink ) > 0 ) {

                    $userImageUrl = url('storage/'. $val->likedByUserImageLink);
                    list( $userWidth, $userHeight ) = getimagesize( $userImageUrl );

                    $comments[$i]['likedByUserImageDetails'] = [
                        'relativePath' => $userImageUrl,
                        'width' => $userWidth,
                        'height' => $userHeight
                    ];
                }
                $i++;
            }

            $out_data = [
                'poll' => $poll,
                'comments' => $comments
            ];
        } 
        return $out_data;
    } */

    public function getPollDetailsByPollId( $pollId ) {

        $poll = [];
        $result = DB::table( 'polls AS poll' )
                        ->join( 'users AS usr', 'poll.userId', '=', 'usr.id' )
                        ->where([
                            [ 'poll.id', '=', $pollId ],
                            [ 'poll.status', '=', 'OPEN' ],
                        ])
                        ->select(
                            'poll.id as pollId', 
                            'poll.question as question', 
                            'poll.imageLink as pollImageLink', 
                            'poll.allowComments as allowComments',
                            'usr.id as pollCreatedByUserId', 
                            'usr.userName as pollCreatedByUserName', 
                            'usr.imageLink as pollCreatedByUserImageLink'
                        )
                        ->get();

        if( isset( $result[0] ) && !empty( $result[0] ) ) {

            $result = $result[0];
            $poll['pollId'] = $result->pollId;
            $poll['question'] = $result->question;
            $poll['pollImageLink'] = $result->pollImageLink;
            $poll['allowComments'] = $result->allowComments;

            $poll['pollCreatedByUserId'] = $result->pollCreatedByUserId;
            $poll['pollCreatedByUserName'] = $result->pollCreatedByUserName;
            $poll['pollCreatedByUserImageLink'] = $result->pollCreatedByUserImageLink;

            if( $result->pollImageLink != 'null' && strlen( $result->pollImageLink ) > 0 ) {

                $pollImageUrl = url('storage/polls/'. $result->pollImageLink);
                list( $pollWidth, $pollHeight ) = getimagesize( $pollImageUrl );

                $poll['pollImageDetails'] = [
                    'relativePath' => $pollImageUrl,
                    'width' => $pollWidth,
                    'height' => $pollHeight
                ];
            }

            if( $result->pollCreatedByUserImageLink != 'null' && strlen( $result->pollCreatedByUserImageLink ) > 0 ) {

                $userImageUrl = url('storage/'. $result->pollCreatedByUserImageLink);
                list( $userWidth, $userHeight ) = getimagesize( $userImageUrl );

                $poll['pollCreatedByImageDetails'] = [
                    'relativePath' => $userImageUrl,
                    'width' => $userWidth,
                    'height' => $userHeight
                ];
            }
        }

        return $poll;
    }

    public function getPollVotesByPollId( $pollId ) {

        return RelPollVotes::where([
            [ 'pollId', '=', $pollId ]
        ])
        ->select(
            'id',
            'pollId',
            'userId',
            'vote'
        )->get();
    }

    public function getLikedCommentsByLoggedInUser( $userId ) {

        return $result = DB::table( 'rel_poll_comments_likes as rpcl' )
        ->leftJoin( 'users AS usr', 'rpcl.userId', '=', 'usr.id' )
        ->where([
            [ 'userId', '=', $userId ]
        ])
        ->select(
            'rpcl.id AS id',
            'rpcl.pollId AS pollId',
            'rpcl.relPollCommentsId AS relPollCommentsId',
            'rpcl.value AS value',
            'rpcl.userId AS likedByUserId',
            'usr.userName as likedByUserName', 
            'usr.imageLink as likedByUserImageLink'
        )->get();
    }

    public function getPollCommentsByPollIds( $in_data, $pollVotes, $likedComments ) {

        $comments = [];
        $votesArr = [];
        $likedCmnts = [];
        $result = DB::table( 'rel_poll_comments as rpc' )
                        ->join( 'users as usrComments', 'rpc.userId', '=', 'usrComments.id' )
                        ->where([
                            [ 'rpc.pollId', '=', $in_data['pollId'] ]
                        ])
                        ->select(
                            'rpc.pollId as pollId', 
                            'rpc.id as commentId', 
                            'rpc.comment as comment', 
                            'rpc.parentId as commentParentId', 
                            'rpc.userId as commentedByUserId',

                            'usrComments.userName as commentedByUserName', 
                            'usrComments.imageLink as commentedByUserImageLink'
                        )
                        ->offset($in_data['offset'])->limit($in_data['limit'])
                        ->get();
        if( isset( $result[0] ) && !empty( $result[0] ) ) {

            foreach( $pollVotes AS $key => $val ) {
                
                $votesArr[] = $val->userId;
            }
            
            foreach( $likedComments AS $key => $val ) {

                $likedCmnts[] = $val->relPollCommentsId;
            }
            
            $i = 0;
            foreach( $result AS $key => $val ) {

                $comments[$i]['pollId'] = $val->pollId;
                $comments[$i]['commentId'] = $val->commentId;
                $comments[$i]['comment'] = $val->comment;
                $comments[$i]['commentParentId'] = $val->commentParentId;
                $comments[$i]['commentedByUserId'] = $val->commentedByUserId;
                $comments[$i]['commentedByUserName'] = $val->commentedByUserName;
                $comments[$i]['commentedByUserImageLink'] = $val->commentedByUserImageLink;

                if( $val->commentedByUserImageLink != 'null' && strlen( $val->commentedByUserImageLink ) > 0 ) {

                    $userImageUrl = url('storage/'. $val->commentedByUserImageLink);
                    list( $userWidth, $userHeight ) = getimagesize( $userImageUrl );
    
                    $comments[$i]['commentedByUserImageDetails'] = [
                        'relativePath' => $userImageUrl,
                        'width' => $userWidth,
                        'height' => $userHeight
                    ];
                }

                if( in_array( $val->commentedByUserId, $votesArr ) ) {
                    
                    foreach( $pollVotes AS $k => $v ) {

                        if( $v->userId == $val->commentedByUserId ) {

                            $comments[$i]['vote'] = $v->vote;
                        }
                    }
                } else {

                    $comments[$i]['vote'] = '';
                }

                if( in_array( $val->commentId, $likedCmnts ) ) {

                    foreach( $likedComments AS $k => $v ) {

                        if( $val->commentId == $v->relPollCommentsId ) {

                            $comments[$i]['pollLiked'] = $v->value;
                            $comments[$i]['likedByUserId'] = $v->likedByUserId;
                            $comments[$i]['likedByUserName'] = $v->likedByUserName;
                            $comments[$i]['likedByUserImageLink'] = $v->likedByUserImageLink;

                            if( $v->likedByUserImageLink != 'null' && strlen( $v->likedByUserImageLink ) > 0 ) {

                                $userImageUrl = url('storage/'. $v->likedByUserImageLink);
                                list( $userWidth, $userHeight ) = getimagesize( $userImageUrl );
                
                                $comments[$i]['likedByUserImageDetails'] = [
                                    'relativePath' => $userImageUrl,
                                    'width' => $userWidth,
                                    'height' => $userHeight
                                ];
                            }
                        }
                    }
                } else {

                    $comments[$i]['pollLiked'] = '';
                    $comments[$i]['pollLiked'] = '';
                    $comments[$i]['likedByUserId'] = '';
                    $comments[$i]['likedByUserName'] = '';
                    $comments[$i]['likedByUserImageLink'] = '';
                    $comments[$i]['likedByUserImageDetails'] = '';
                }
                $i++;
            }
        }
        return $comments;
    }

    public function getLoggedInUserActionOnCommentByUserIdCommentId( $userId, $commentId ) {

        return $result = DB::table( 'rel_poll_comments_likes AS rpcl' )
                        ->leftJoin( 'users AS usr', 'rpcl.userId', 'usr.id' )
                        ->select( 
                            'rpcl.value AS pollLiked', 
                            'usr.id AS likedByUserId',
                            'usr.UserName AS likedByUserName',
                            'usr.imageLink AS likedByUserImageLink',
                        )
                        ->where([
                            ['rpcl.userId', '=', $userId],
                            ['rpcl.relPollCommentsId', '=', $commentId]
                        ])
                        ->get()
                        ->first();
    }

    public function getMostLikedCommentDetailsByRelPollCommentsId( $relPollCommentsId ) {

        return $result = DB::table( 'rel_poll_comments AS rpc' )
                        ->leftJoin( 'users AS usr', 'rpc.userId', '=', 'usr.id' )
                        ->where( 'rpc.id', $relPollCommentsId )
                        ->select( 
                            'rpc.pollId AS pollId',
                            'rpc.id AS commentId',
                            'rpc.comment AS comment',
                            'rpc.parentId AS commentParentId',
                            'rpc.userId AS commentedByUserId',
                            'usr.UserName AS commentedByUserName',
                            'usr.imageLink AS commentedByUserImageLink'
                        )
                        ->get()
                        ->first();
    }

    public function mostLikedCommentIdByPollId( $pollId ) {

        $result = RelPollCommentsLikes::where([
            ['pollId', '=', $pollId],
            ['value', '=', 'YES']
        ])
        ->select(
            DB::raw('relPollCommentsId, count(*) as cnt')
        )->groupBy('relPollCommentsId')
        ->orderBy('cnt', 'desc')
        ->limit(1)
        ->get()
        ->first();
        if( $result != null ) {

            return $result->toArray();
        } else {
            return [];
        }
    }

    public function getPollCommentsByPollId( $in_data ) {

        $out_data = [
            'poll' => $this->getPollDetailsByPollId( $in_data['pollId'] ),
            'votes' => $pollVotes = $this->getPollVotesByPollId( $in_data['pollId'] ),
            'likedComments' => $likedComments = $this->getLikedCommentsByLoggedInUser( $in_data['loggedInUserId'] ),
            'comments' => $this->getPollCommentsByPollIds( $in_data, $pollVotes, $likedComments ),
            'mostLikedCommentId' => 0,
            'mostLikedCommentDetails' => []
        ];

        if( $in_data['offset'] == 0 ) {

            $result = $this->mostLikedCommentIdByPollId( $in_data['pollId'] );
            if( count($result) ) {
                $relPollCommentsId = $result['relPollCommentsId'];
                $likedCommentDetails = $this->getMostLikedCommentDetailsByRelPollCommentsId( $relPollCommentsId );

                $out_data['mostLikedCommentId'] = $likedCommentDetails->commentId;
                $out_data['mostLikedCommentCount'] = $result['cnt'];
                
                if( $likedCommentDetails->commentedByUserImageLink != 'null' && strlen( $likedCommentDetails->commentedByUserImageLink ) > 0 ) {
                    
                    $userImageUrl = url('storage/'. $likedCommentDetails->commentedByUserImageLink);
                    list( $userWidth, $userHeight ) = getimagesize( $userImageUrl );
                    
                    $out_data['mostLikedCommentDetails'] = [
                        'pollId' => $likedCommentDetails->pollId,
                        'commentId' => $likedCommentDetails->commentId,
                        'comment' => $likedCommentDetails->comment,
                        'commentParentId' => $likedCommentDetails->commentParentId,
                        'commentedByUserId' => $likedCommentDetails->commentedByUserId,
                        'commentedByUserName' => $likedCommentDetails->commentedByUserName,
                        'commentedByUserImageLink' => $likedCommentDetails->commentedByUserImageLink,
                        'likedByUserImageDetails' => [
                            'relativePath' => $userImageUrl,
                            'width' => $userWidth,
                            'height' => $userHeight
                        ]
                    ];

                    $data = $this->getLoggedInUserActionOnCommentByUserIdCommentId( $in_data['loggedInUserId'], $relPollCommentsId );

                    if( $data->likedByUserImageLink != 'null' && strlen( $data->likedByUserImageLink ) > 0 ) {

                        $userImageUrl = url('storage/'. $likedCommentDetails->commentedByUserImageLink);
                        list( $userWidth, $userHeight ) = getimagesize( $userImageUrl );

                        $out_data['mostLikedCommentDetails'] = [
                            'pollLiked' => $data->pollLiked,
                            'likedByUserId' => $data->likedByUserId,
                            'likedByUserName' => $data->likedByUserName,
                            'likedByUserImageLink' => $data->likedByUserImageLink,
                            'likedByUserImageDetails' => [
                                'relativePath' => $userImageUrl,
                                'width' => $userWidth,
                                'height' => $userHeight
                            ]
                        ];
                    }
                }
            }
        }
        return $out_data;
    }

    public function countMyLivePolls( $in_data ) {

        return $result = DB::table( 'polls AS poll' )
                ->leftJoin( 'users AS usr', 'poll.userId', '=', 'usr.id' )
                ->leftJoin( 'rel_poll_comments AS rpc', 'poll.id', '=', 'rpc.pollId' )
                ->where([
                    ['usr.id', '=', $in_data['userId']],
                    ['poll.published_at', '>=', $in_data['day_before']],
                    ['poll.status', '=', 'OPEN']
                ])
                ->count(); 
    }

    public function getMyLivePolls( $in_data ) {

        $where = [
            ['usr.id', '=', $in_data['userId']],
            ['poll.published_at', '>=', $in_data['day_before']],
            ['poll.status', '=', 'OPEN']
        ];
        
        return $result = DB::table( 'polls AS poll' )
                ->leftJoin( 'users AS usr', 'poll.userId', '=', 'usr.id' )
                ->leftJoin( 'rel_poll_comments AS rpc', 'poll.id', '=', 'rpc.pollId' )
                ->where( $where )
                ->select(
                    'poll.id AS pollId',
                    'poll.question AS question',
                    'poll.imageLink AS pollImageLink',
                    'poll.allowComments AS allowComments',
                    'poll.published_at AS published_at',
                    'usr.id AS userId',
                    'usr.userName AS userName',
                    'usr.imageLink AS userImageLink',
                    DB::raw('COUNT(rpc.id) AS totalComments')
                )->groupBy(
                    'poll.id',
                    'poll.question',
                    'poll.imageLink',
                    'poll.allowComments',
                    'poll.published_at',
                    'usr.id',
                    'usr.userName',
                    'usr.imageLink'
                )->orderBy('poll.id', 'asc')
                ->offset($in_data['offset'])->limit($in_data['limit'])->get(); 
    }

    public function countMyPolls( $in_data ) {

        $result = DB::table( 'polls AS poll' )
                ->leftjoin('rel_poll_votes AS rpv', 'poll.id', '=', 'rpv.pollId')
                ->leftJoin( 'users AS usr', 'poll.userId', '=', 'usr.id' )
                ->leftJoin( 'rel_poll_comments AS rpc', 'poll.id', '=', 'rpc.pollId' )
                ->where([
                    ['poll.userId', '=', $in_data['userId']],
                    ['poll.status', '=', 'OPEN']
                ])
                ->select(
                    'poll.id AS pollId',
                    'poll.question AS question',
                    'poll.imageLink AS pollImageLink',
                    'poll.allowComments AS allowComments',
                    'poll.published_at AS published_at',
                    'rpv.vote AS vote',
                    'usr.id AS userId',
                    'usr.userName AS userName',
                    'usr.imageLink AS userImageLink',
                    DB::raw('COUNT(rpc.id) AS totalComments'),
                    DB::raw('COUNT(*) AS totalVotes')
                );
        
        isset( $in_data['poll'] ) && !empty( $in_data['poll'] ) ? $result = $result->where( 'poll.question', 'LIKE', '%'. $in_data['poll'] .'%' ) : '';
        isset( $in_data['tags'] ) && !empty( $in_data['tags'] ) ? $result = $result->where( 'poll.question', 'LIKE', '%'. $in_data['tags'] .'%' ) : '' ;
        isset( $in_data['people'] ) && !empty( $in_data['people'] ) ? $result = $result->where( 'usr.userName', 'LIKE', '%'. $in_data['people'] .'%' ) : '';
        
        $result = $result->groupBy(
                    'poll.id',
                    'poll.question',
                    'poll.imageLink',
                    'poll.allowComments',
                    'poll.published_at',
                    'rpv.vote',
                    'usr.id',
                    'usr.userName',
                    'usr.imageLink'
                )->orderBy('poll.id', 'desc')
                ->get();
        return $result->count();
    }

    public function getPollIdsByUser( $userId ) {

        $result = DB::table('polls AS pol')
                    ->where( 'userId', $userId )
                    ->select( 'id' )
                    ->get();
        
        $out_data = [];
        $cnt = count((array)$result);
        if( $cnt > 0 ) {
            foreach( $result AS $key => $val ) {

                $out_data[] = $val->id;
            }
            return $out_data;
        } else {
            return false;
        }
    }
    
    public function getMyPolls( $in_data ) {

        $pollIds = $this->getPollIdsByUser( $in_data['userId'] );

        if( count( $pollIds ) < 1 ) {
            return [];
        }

        $result = DB::table( 'polls AS poll' )
                ->leftjoin('rel_poll_votes AS rpv', 'poll.id', '=', 'rpv.pollId')
                ->leftJoin( 'users AS usr', 'poll.userId', '=', 'usr.id' )
                ->leftJoin( 'rel_poll_comments AS rpc', 'poll.id', '=', 'rpc.pollId' )
                ->where([
                    ['poll.status', '=', 'OPEN']
                ])
                ->whereIn('poll.id', $pollIds)
                ->select(
                    'poll.id AS pollId',
                    'poll.question AS question',
                    'poll.imageLink AS pollImageLink',
                    'poll.allowComments AS allowComments',
                    'poll.published_at AS published_at',
                    'rpv.vote AS vote',
                    'usr.id AS userId',
                    'usr.userName AS userName',
                    'usr.imageLink AS userImageLink',
                    DB::raw('COUNT(rpc.id) AS totalComments'),
                    DB::raw('COUNT(*) AS totalVotes')
                );
        
        isset( $in_data['poll'] ) && !empty( $in_data['poll'] ) ? $result = $result->where( 'poll.question', 'LIKE', '%'. $in_data['poll'] .'%' ) : '';
        isset( $in_data['tags'] ) && !empty( $in_data['tags'] ) ? $result = $result->where( 'poll.question', 'LIKE', '%'. $in_data['tags'] .'%' ) : '' ;
        isset( $in_data['people'] ) && !empty( $in_data['people'] ) ? $result = $result->where( 'usr.userName', 'LIKE', '%'. $in_data['people'] .'%' ) : '';

        $result = $result->groupBy(
                    'poll.id',
                    'poll.question',
                    'poll.imageLink',
                    'poll.allowComments',
                    'poll.published_at',
                    'rpv.vote',
                    'usr.id',
                    'usr.userName',
                    'usr.imageLink'
                )->orderBy('poll.id', 'desc')
                ->offset($in_data['offset'])->limit($in_data['limit'])->get(); 
                
        $out_data = [];
        $pollIds = [];
        if( count( (array)$result ) ) { 
            $i = 0;
            foreach( $result AS $key => $val ) {

                if( !in_array( $val->pollId, $pollIds ) ) {

                    $pollIds[] = $val->pollId;

                    $out_data[$i]['pollId'] = $val->pollId;
                    $out_data[$i]['question'] = $val->question;
                    $out_data[$i]['pollImageLink'] = $val->pollImageLink;
                    $out_data[$i]['allowComments'] = $val->allowComments;
                    $out_data[$i]['published_at'] = $val->published_at;
                    $out_data[$i]['vote'] = $val->vote;
                    $out_data[$i]['userId'] = $val->userId;
                    $out_data[$i]['userName'] = $val->userName;
                    $out_data[$i]['userImageLink'] = $val->userImageLink;
                    $out_data[$i]['totalComments'] = $val->totalComments;

                    if( $val->pollImageLink != 'null' && strlen( $val->pollImageLink ) > 0 ) {

                        $pollImageUrl = url('storage/polls/'. $val->pollImageLink);
                        list( $pollWidth, $pollHeight ) = getimagesize( $pollImageUrl );
    
                        $out_data[$i]['pollImageDetails'] = [
                            'relativePath' => $pollImageUrl,
                            'width' => $pollWidth,
                            'height' => $pollHeight
                        ];
                    }

                    if( $val->vote == 'YES' ) {
                        $out_data[$i]['votes'][0]['pollId'] = $val->pollId;
                        $out_data[$i]['votes'][0]['vote'] = $val->vote;
                        $out_data[$i]['votes'][0]['totalVotes'] = $val->totalVotes;

                        $out_data[$i]['votes'][1]['pollId'] = $val->pollId;
                        $out_data[$i]['votes'][1]['vote'] = 'NO';
                        $out_data[$i]['votes'][1]['totalVotes'] = 0;
                    } else if( $val->vote == 'NO' ) {

                        $out_data[$i]['votes'][0]['pollId'] = $val->pollId;
                        $out_data[$i]['votes'][0]['vote'] = 'YES';
                        $out_data[$i]['votes'][0]['totalVotes'] = 0;

                        $out_data[$i]['votes'][1]['pollId'] = $val->pollId;
                        $out_data[$i]['votes'][1]['vote'] = $val->vote;
                        $out_data[$i]['votes'][1]['totalVotes'] = $val->totalVotes;
                    }
                    $i++;
                } else {

                    if( array_search( $val->pollId, $pollIds ) !== false ) {
                            
                        $index = array_search( $val->pollId, $pollIds );

                        $out_data[$index]['pollId'] = $val->pollId;
                        $out_data[$index]['question'] = $val->question;
                        $out_data[$index]['pollImageLink'] = $val->pollImageLink;
                        $out_data[$index]['allowComments'] = $val->allowComments;
                        $out_data[$index]['published_at'] = $val->published_at;
                        $out_data[$index]['vote'] = $val->vote;
                        $out_data[$index]['userId'] = $val->userId;
                        $out_data[$index]['userName'] = $val->userName;
                        $out_data[$index]['userImageLink'] = $val->userImageLink;
                        $out_data[$index]['totalComments'] = $val->totalComments;  

                        if( $val->pollImageLink != 'null' && strlen( $val->pollImageLink ) > 0 ) {

                            $pollImageUrl = url('storage/polls/'. $val->pollImageLink);
                            list( $pollWidth, $pollHeight ) = getimagesize( $pollImageUrl );
        
                            $out_data[$index]['pollImageDetails'] = [
                                'relativePath' => $pollImageUrl,
                                'width' => $pollWidth,
                                'height' => $pollHeight
                            ];
                        }

                        if( $val->vote == 'YES' ) {
                            $out_data[$index]['votes'][0]['pollId'] = $val->pollId;
                            $out_data[$index]['votes'][0]['vote'] = $val->vote;
                            $out_data[$index]['votes'][0]['totalVotes'] = $val->totalVotes;

                        } else if( $val->vote == 'NO' ) {       
                            $out_data[$index]['votes'][1]['pollId'] = $val->pollId;
                            $out_data[$index]['votes'][1]['vote'] = $val->vote;
                            $out_data[$index]['votes'][1]['totalVotes'] = $val->totalVotes;
                        }
                    }
                }
            }
        }

        if( !empty( $out_data ) ) {

            $out_data = $this->calculateVotePercentage( $out_data );
        }
        return $out_data;
    }

    public function countLivePolls( $in_data ) {
        
        $where = [
            ['poll.userId', '!=', $in_data['userId']],
            ['poll.published_at', '>=', $in_data['day_before']],
            ['poll.status', '=', 'OPEN']
        ];

        $result = DB::table( 'polls AS poll' )
                ->leftJoin( 'users AS usr', 'poll.userId', '=', 'usr.id' )
                ->leftJoin( 'rel_poll_comments AS rpc', 'poll.id', '=', 'rpc.pollId' )
                ->leftJoin( 'rel_poll_genders AS rpg', 'poll.id', '=', 'rpg.pollId' )
                ->leftJoin( 'rel_poll_years AS yrs', 'poll.id', '=', 'yrs.pollId' )
                ->leftJoin( 'rel_poll_countries AS rpcntr', 'poll.id', '=', 'rpcntr.pollId' )
                ->leftJoin( 'rel_poll_groups AS rpgrp', 'poll.id', '=', 'rpgrp.pollId' )
                ->leftJoin( 'rel_poll_branches AS rpb', 'poll.id', '=', 'rpb.pollId' )
                ->whereNotIn('poll.id', function ($query) use( $in_data ) {
                    $query->select('pollId')->distinct()->from('rel_poll_votes')->where( 'userId', $in_data['userId'] );
                })
                ->select(
                    'poll.id AS pollId',
                    'poll.question AS question',
                    'poll.imageLink AS pollImageLink',
                    'poll.allowComments AS allowComments',
                    'poll.published_at AS published_at',
                    'usr.id AS userId',
                    'usr.userName AS userName',
                    'usr.imageLink AS userImageLink',
                    DB::raw('COUNT(rpc.id) AS totalComments')
                )->groupBy(
                    'poll.id',
                    'poll.question',
                    'poll.imageLink',
                    'poll.allowComments',
                    'poll.published_at',
                    'usr.id',
                    'usr.userName',
                    'usr.imageLink'
                )->orderBy('poll.id', 'desc');
        
        $result = $result->where( $where );
        
        isset( $in_data['poll'] ) && !empty( $in_data['poll'] ) ? $result = $result->where( 'poll.question', 'LIKE', '%'. $in_data['poll'] .'%' ) : '';
        isset( $in_data['tags'] ) && !empty( $in_data['tags'] ) ? $result = $result->where( 'poll.question', 'LIKE', '%'. $in_data['tags'] .'%' ) : '' ;
        isset( $in_data['people'] ) && !empty( $in_data['people'] ) ? $result = $result->where( 'usr.userName', 'LIKE', '%'. $in_data['people'] .'%' ) : '';

        if( isset( $in_data['search'] ) && !empty( $in_data['search'] ) ) {

            $result = $result->where( 'poll.question', 'LIKE', '%'. $in_data['search'] .'%' )
                        ->orWhere( 'poll.allowComments', 'LIKE', '%'. $in_data['search'] .'%' )
                        ->orWhere( 'usr.userName', 'LIKE', '%'. $in_data['search'] .'%' );
        }

        isset( $in_data['genders'] ) && is_array( $in_data['genders'] ) ? $result = $result->whereIn( 'rpg.gender', $in_data['genders'] ) : '';
        isset( $in_data['years'] ) && is_array( $in_data['years'] ) ? $result = $result->whereIn( 'yrs.year', $in_data['years'] ) : '';
        isset( $in_data['countryIds'] ) && is_array( $in_data['countryIds'] ) ? $result = $result->whereIn( 'rpcntr.countryId', $in_data['countryIds'] ) : '';
        isset( $in_data['groupIds'] ) && is_array( $in_data['groupIds'] ) ? $result = $result->whereIn( 'rpgrp.groupId', $in_data['groupIds'] ) : '';
        isset( $in_data['branchIds'] ) && is_array( $in_data['branchIds'] ) ? $result = $result->whereIn( 'rpb.branchId', $in_data['branchIds'] ) : '';

        $result = $result->get();
        return $result->count();
    }

    public function getLivePolls( $in_data ) {

        $where = [
            ['poll.userId', '!=', $in_data['userId']],
            ['poll.published_at', '>=', $in_data['day_before']],
            ['poll.status', '=', 'OPEN']
        ];

        $result = DB::table( 'polls AS poll' )
                ->leftJoin( 'users AS usr', 'poll.userId', '=', 'usr.id' )
                ->leftJoin( 'rel_poll_comments AS rpc', 'poll.id', '=', 'rpc.pollId' )
                ->leftJoin( 'rel_poll_genders AS rpg', 'poll.id', '=', 'rpg.pollId' )
                ->leftJoin( 'rel_poll_years AS yrs', 'poll.id', '=', 'yrs.pollId' )
                ->leftJoin( 'rel_poll_countries AS rpcntr', 'poll.id', '=', 'rpcntr.pollId' )                
                ->leftJoin( 'rel_poll_groups AS rpgrp', 'poll.id', '=', 'rpgrp.pollId' )
                ->leftJoin( 'rel_poll_branches AS rpb', 'poll.id', '=', 'rpb.pollId' )
                ->whereNotIn('poll.id', function ($query) use( $in_data ) {
                    $query->select('pollId')->distinct()->from('rel_poll_votes')->where( 'userId', $in_data['userId'] );
                })
                ->select(
                    'poll.id AS pollId',
                    'poll.question AS question',
                    'poll.imageLink AS pollImageLink',
                    'poll.allowComments AS allowComments',
                    'poll.published_at AS published_at',
                    'usr.id AS userId',
                    'usr.userName AS userName',
                    'usr.imageLink AS userImageLink',
                    DB::raw('COUNT(rpc.id) AS totalComments')
                )->groupBy(
                    'poll.id',
                    'poll.question',
                    'poll.imageLink',
                    'poll.allowComments',
                    'poll.published_at',
                    'usr.id',
                    'usr.userName',
                    'usr.imageLink'
                )->orderBy('poll.id', 'desc')
                ->offset($in_data['offset'])->limit($in_data['limit']);
        
        $result = $result->where( $where );
        
        /* filters starts here */
        isset( $in_data['poll'] ) && !empty( $in_data['poll'] ) ? $result = $result->where( 'poll.question', 'LIKE', '%'. $in_data['poll'] .'%' ) : '';
        isset( $in_data['tags'] ) && !empty( $in_data['tags'] ) ? $result = $result->where( 'poll.question', 'LIKE', '%'. $in_data['tags'] .'%' ) : '' ;
        isset( $in_data['people'] ) && !empty( $in_data['people'] ) ? $result = $result->where( 'usr.userName', 'LIKE', '%'. $in_data['people'] .'%' ) : '';

        if( isset( $in_data['search'] ) && !empty( $in_data['search'] ) ) {

            $result = $result->where( 'poll.question', 'LIKE', '%'. $in_data['search'] .'%' )
                        ->orWhere( 'poll.allowComments', 'LIKE', '%'. $in_data['search'] .'%' )
                        ->orWhere( 'usr.userName', 'LIKE', '%'. $in_data['search'] .'%' );
        }

        isset( $in_data['genders'] ) && is_array( $in_data['genders'] ) ? $result = $result->whereIn( 'rpg.gender', $in_data['genders'] ) : '';
        isset( $in_data['years'] ) && is_array( $in_data['years'] ) ? $result = $result->whereIn( 'yrs.year', $in_data['years'] ) : '';
        isset( $in_data['countryIds'] ) && is_array( $in_data['countryIds'] ) ? $result = $result->whereIn( 'rpcntr.countryId', $in_data['countryIds'] ) : '';
        isset( $in_data['groupIds'] ) && is_array( $in_data['groupIds'] ) ? $result = $result->whereIn( 'rpgrp.groupId', $in_data['groupIds'] ) : '';
        isset( $in_data['branchIds'] ) && is_array( $in_data['branchIds'] ) ? $result = $result->whereIn( 'rpb.branchId', $in_data['branchIds'] ) : '';
        /* filters ends here */

        $result = $result->get(); 

        if( $result ) {

            $out_data = [];
            foreach( $result AS $key => $val ) {
                
                $tmp = $val;
                $tmp->pollId = $val->pollId;
                $tmp->question = $val->question;

                $tmp->pollImageLink = $val->pollImageLink;
                $tmp->userImageLink = $val->userImageLink;

                $tmp->allowComments = $val->allowComments;
                $tmp->published_at = $val->published_at;
                $tmp->userId = $val->userId;
                $tmp->userName = $val->userName;
                $tmp->totalComments = $val->totalComments;

                if( $val->pollImageLink != 'null' && strlen( $val->pollImageLink ) > 0 ) {

                    $pollImageUrl = url('storage/polls/'. $val->pollImageLink);
                    list( $pollWidth, $pollHeight ) = getimagesize( $pollImageUrl );

                    $tmp->pollImageDetails = [
                        'relativePath' => $pollImageUrl,
                        'width' => $pollWidth,
                        'height' => $pollHeight
                    ];
                }

                if( $val->userImageLink != 'null' && strlen( $val->userImageLink ) > 0 ) {

                    $userImageUrl = url('storage/'. $val->userImageLink);
                    list( $userWidth, $userHeight ) = getimagesize( $userImageUrl );             

                    $tmp->userImageDetails = [
                        'relativePath' => url('storage/'. $val->userImageLink),
                        'width' => $userWidth,
                        'height' => $userHeight
                    ];
                }
            }
        }
        return $result;
    }

    public function calculateVotePercentage( $in_data ) {

        $out_data = [];
        $i = 0;
        $pollIds = [];
        foreach( $in_data as $key => $val ) {

            if( !in_array( $val['pollId'], $pollIds ) ) {

                $pollIds[] = $val['pollId'];
                $pollId = $val['pollId'];

                // $pollVisibility = $this->getPollVisibilityByPollId( $pollId );
                // $userPollVisibiltyCount = $this->getUsersPollVisibileToCount( $pollVisibility );

                $totalUpVotes = isset( $val['votes'][0]['totalVotes'] ) ? intval( $val['votes'][0]['totalVotes'] ) : 0;
                $totalDownVotes = isset( $val['votes'][1]['totalVotes'] ) ? intval( $val['votes'][1]['totalVotes'] ) : 0;
                $totalVotes = $totalUpVotes + $totalDownVotes;
                // $totalVotes = $userPollVisibiltyCount;

                $out_data[$key]['pollId'] = $val['pollId'];
                $out_data[$key]['question'] = $val['question'];
                $out_data[$key]['pollImageLink'] = $val['pollImageLink'];
                $out_data[$key]['allowComments'] = $val['allowComments'];
                $out_data[$key]['published_at'] = $val['published_at'];
                $out_data[$key]['vote'] = $val['vote'];
                $out_data[$key]['userId'] = $val['userId'];
                $out_data[$key]['userName'] = $val['userName'];

                if( isset( $val['userImageLink'] ) ) {

                    $out_data[$key]['userImageLink'] = $val['userImageLink'];
                }
                
                $out_data[$key]['totalComments'] = $val['totalComments'];
                $out_data[$key]['pollImageDetails'] = isset( $val['pollImageDetails'] ) ? $val['pollImageDetails'] : null;

                $out_data[$key]['votes'][0]['pollId'] = $val['pollId'];
                $out_data[$key]['votes'][0]['totalVotes'] = $totalVotes;
                $out_data[$key]['votes'][0]['vote'] = 'YES';
                $out_data[$key]['votes'][0]['count'] = $totalUpVotes;
                $out_data[$key]['votes'][0]['percent'] = $totalUpVotes > 0 ? (( $totalUpVotes / $totalVotes ) * 100) : 0;
                $out_data[$key]['votes'][0]['percent'] = round( $out_data[$key]['votes'][0]['percent'] );
                
                $out_data[$key]['votes'][1]['pollId'] = $val['pollId'];
                $out_data[$key]['votes'][1]['totalVotes'] = $totalVotes;
                $out_data[$key]['votes'][1]['vote'] = 'NO';
                $out_data[$key]['votes'][1]['count'] = $totalDownVotes;
                $out_data[$key]['votes'][1]['percent'] = $totalDownVotes > 0 ? (( $totalDownVotes / $totalVotes ) * 100) : 0;
                $out_data[$key]['votes'][1]['percent'] = round( $out_data[$key]['votes'][1]['percent'] );
            } else {

            }
        }
        return $out_data;
    }

    public function countVotedPolls( $in_data ) {

        if( isset( $in_data['search'] ) && !empty( $in_data['search'] ) ) {

            $result = DB::table('polls AS poll')
                        ->join('rel_poll_votes AS rpv', 'poll.id', '=', 'rpv.pollId')
                        ->leftJoin('users AS usr', 'poll.userId', '=', 'usr.id')
                        ->leftJoin( 'rel_poll_comments AS rpc', 'poll.id', '=', 'rpc.pollId' )
                        ->where('poll.status', '=', 'OPEN')

                        ->where( 'poll.question', 'LIKE', '%'. $in_data['search'] .'%' )
                        ->orWhere( 'poll.allowComments', 'LIKE', '%'. $in_data['search'] .'%' )
                        ->orWhere( 'rpv.vote', 'LIKE', '%'. $in_data['search'] .'%' )
                        ->orWhere( 'usr.userName', 'LIKE', '%'. $in_data['search'] .'%' )

                        ->select(
                            'poll.id AS pollId'
                        )->groupBy(
                            'poll.id'
                        )->orderBy('poll.id', 'desc')->orderBy('rpv.vote')
                        ->get(); 
            return $result->count();
        } else {

            $result = DB::table('polls AS poll')
                        ->join('rel_poll_votes AS rpv', 'poll.id', '=', 'rpv.pollId')
                        ->leftJoin('users AS usr', 'poll.userId', '=', 'usr.id')
                        ->leftJoin( 'rel_poll_comments AS rpc', 'poll.id', '=', 'rpc.pollId' )
                        ->where('poll.status', '=', 'OPEN')
                        ->select(
                            'poll.id AS pollId'
                        )->groupBy(
                            'poll.id'
                        )->orderBy('poll.id', 'desc')->orderBy('rpv.vote')
                        ->get(); 
            return $result->count();
        }
    } 

    public function getVotedPolls( $in_data ) {

        if( isset( $in_data['search'] ) && !empty( $in_data['search'] ) ) {

            $result = DB::table('polls AS poll')
                        ->join('rel_poll_votes AS rpv', 'poll.id', '=', 'rpv.pollId')
                        ->leftJoin('users AS usr', 'poll.userId', '=', 'usr.id')
                        ->leftJoin( 'rel_poll_comments AS rpc', 'poll.id', '=', 'rpc.pollId' )
                        ->where('poll.status', '=', 'OPEN')
                        
                        ->where( 'poll.question', 'LIKE', '%'. $in_data['search'] .'%' )
                        ->orWhere( 'poll.allowComments', 'LIKE', '%'. $in_data['search'] .'%' )
                        ->orWhere( 'rpv.vote', 'LIKE', '%'. $in_data['search'] .'%' )
                        ->orWhere( 'usr.userName', 'LIKE', '%'. $in_data['search'] .'%' )
                        
                        ->select(
                            'poll.id AS pollId',
                            'poll.question AS question',
                            'poll.imageLink AS pollImageLink',
                            'poll.allowComments AS allowComments',
                            'poll.published_at AS published_at',
                            'rpv.vote AS vote',
                            'usr.id AS userId',
                            'usr.userName AS userName',
                            'usr.imageLink AS userImageLink',
                            DB::raw('COUNT(rpc.id) AS totalComments'),
                            DB::raw('COUNT(*) AS totalVotes')
                        )->groupBy(
                            'poll.id',
                            'poll.question',
                            'poll.imageLink',
                            'poll.allowComments',
                            'poll.published_at',
                            'rpv.vote',
                            'usr.id',
                            'usr.userName',
                            'usr.imageLink'
                        )->orderBy('poll.id', 'desc')->orderBy('rpv.vote')
                        ->offset($in_data['offset'])
                        ->limit($in_data['limit'])->get(); 
        } else {

            $result = DB::table('polls AS poll')
                        ->join('rel_poll_votes AS rpv', 'poll.id', '=', 'rpv.pollId')
                        ->leftJoin('users AS usr', 'poll.userId', '=', 'usr.id')
                        ->leftJoin( 'rel_poll_comments AS rpc', 'poll.id', '=', 'rpc.pollId' )
                        ->where('poll.status', '=', 'OPEN')
                        ->select(
                            'poll.id AS pollId',
                            'poll.question AS question',
                            'poll.imageLink AS pollImageLink',
                            'poll.allowComments AS allowComments',
                            'poll.published_at AS published_at',
                            'rpv.vote AS vote',
                            'usr.id AS userId',
                            'usr.userName AS userName',
                            'usr.imageLink AS userImageLink',
                            DB::raw('COUNT(rpc.id) AS totalComments'),
                            DB::raw('COUNT(*) AS totalVotes')
                        )->groupBy(
                            'poll.id',
                            'poll.question',
                            'poll.imageLink',
                            'poll.allowComments',
                            'poll.published_at',
                            'rpv.vote',
                            'usr.id',
                            'usr.userName',
                            'usr.imageLink'
                        )->orderBy('poll.id', 'desc')->orderBy('rpv.vote')
                        ->offset($in_data['offset'])
                        ->limit($in_data['limit'])->get(); 
        }
        
        $out_data = [];
        $pollIds = [];
        if( count( (array)$result ) ) {
            $i = 0;
            foreach( $result AS $key => $val ) {

                if( !in_array( $val->pollId, $pollIds ) ) {

                    $pollIds[] = $val->pollId;

                    $out_data[$i]['pollId'] = $val->pollId;
                    $out_data[$i]['question'] = $val->question;
                    $out_data[$i]['pollImageLink'] = $val->pollImageLink;
                    $out_data[$i]['allowComments'] = $val->allowComments;
                    $out_data[$i]['published_at'] = $val->published_at;
                    $out_data[$i]['vote'] = $val->vote;
                    $out_data[$i]['userId'] = $val->userId;
                    $out_data[$i]['userName'] = $val->userName;
                    $out_data[$i]['userImageLink'] = $val->userImageLink;                    
                    $out_data[$i]['totalComments'] = $val->totalComments;

                    if( $val->pollImageLink != 'null' && strlen( $val->pollImageLink ) > 0 ) {

                        $pollImageUrl = url('storage/polls/'. $val->pollImageLink);
                        list( $pollWidth, $pollHeight ) = getimagesize( $pollImageUrl );
    
                        $out_data[$i]['pollImageDetails'] = [
                            'relativePath' => $pollImageUrl,
                            'width' => $pollWidth,
                            'height' => $pollHeight
                        ];
                    }

                    if( $val->vote == 'YES' ) {
                        $out_data[$i]['votes'][0]['pollId'] = $val->pollId;
                        $out_data[$i]['votes'][0]['vote'] = $val->vote;
                        $out_data[$i]['votes'][0]['totalVotes'] = $val->totalVotes;

                        $out_data[$i]['votes'][1]['pollId'] = $val->pollId;
                        $out_data[$i]['votes'][1]['vote'] = 'NO';
                        $out_data[$i]['votes'][1]['totalVotes'] = 0;
                    } else if( $val->vote == 'NO' ) {

                        $out_data[$i]['votes'][0]['pollId'] = $val->pollId;
                        $out_data[$i]['votes'][0]['vote'] = 'YES';
                        $out_data[$i]['votes'][0]['totalVotes'] = 0;

                        $out_data[$i]['votes'][1]['pollId'] = $val->pollId;
                        $out_data[$i]['votes'][1]['vote'] = $val->vote;
                        $out_data[$i]['votes'][1]['totalVotes'] = $val->totalVotes;
                    }
                    $i++;
                } else {

                    if( array_search( $val->pollId, $pollIds ) !== false ) {
                            
                        $index = array_search( $val->pollId, $pollIds );

                        $out_data[$index]['pollId'] = $val->pollId;
                        $out_data[$index]['question'] = $val->question;
                        $out_data[$index]['pollImageLink'] = $val->pollImageLink;
                        $out_data[$index]['allowComments'] = $val->allowComments;
                        $out_data[$index]['published_at'] = $val->published_at;
                        $out_data[$index]['vote'] = $val->vote;
                        $out_data[$index]['userId'] = $val->userId;
                        $out_data[$index]['userName'] = $val->userName;
                        $out_data[$index]['userImageLink'] = $val->userImageLink;
                        $out_data[$index]['totalComments'] = $val->totalComments;  

                        if( $val->pollImageLink != 'null' && strlen( $val->pollImageLink ) > 0 ) {

                            $pollImageUrl = url('storage/polls/'. $val->pollImageLink);
                            list( $pollWidth, $pollHeight ) = getimagesize( $pollImageUrl );
        
                            $out_data[$index]['pollImageDetails'] = [
                                'relativePath' => $pollImageUrl,
                                'width' => $pollWidth,
                                'height' => $pollHeight
                            ];
                        }

                        if( $val->vote == 'YES' ) {
                            $out_data[$index]['votes'][0]['pollId'] = $val->pollId;
                            $out_data[$index]['votes'][0]['vote'] = $val->vote;
                            $out_data[$index]['votes'][0]['totalVotes'] = $val->totalVotes;

                        } else if( $val->vote == 'NO' ) {

                            $out_data[$index]['votes'][1]['pollId'] = $val->pollId;
                            $out_data[$index]['votes'][1]['vote'] = $val->vote;
                            $out_data[$index]['votes'][1]['totalVotes'] = $val->totalVotes;
                        }
                    }
                }
            }
        }

        if( !empty( $out_data ) ) {

            $out_data = $this->calculateVotePercentage( $out_data );
        }

        return $out_data;
    }

    public function countPollVotes() {

        return $result = RelPollVotes::where([
            ['status', '=', 'OPEN'],
        ])
        ->select(
            DB::raw('pollId, vote, count(*) as total')
        )->groupBy('vote', 'pollId')
        ->orderBy('pollId')
        ->get();

        $out_data = [];
        if( count( (array)$result ) ) {

            foreach( $result AS $key => $val ) {
                
                if( $val['vote'] == 'YES' ) {
                    $out_data[0]['pollId'] = $val['pollId'];
                    $out_data[0]['vote'] = $val['vote'];
                    $out_data[0]['total'] = $val['total'];
                } else if( $val['vote'] == 'NO' ) {
                    $out_data[1]['pollId'] = $val['pollId'];
                    $out_data[1]['vote'] = $val['vote'];
                    $out_data[1]['total'] = $val['total'];
                }
            }
        } 

        $totalVotes = intval( $out_data[0]['total'] ) + intval( $out_data[1]['total'] );
        $totalUpVotes = intval( $out_data[0]['total'] );
        $totalDownVotes = intval( $out_data[1]['total'] );

        $out_data[0]['percent'] = $totalUpVotes > 0 ? (( $totalUpVotes / $totalVotes ) * 100) : 0;
        $out_data[1]['percent'] = $totalDownVotes > 0 ? (( $totalDownVotes / $totalVotes ) * 100) : 0;
        return $out_data;
    }
    
    public function getMyVotedPollIdsByUser( $userId ) {

        $result = DB::table('rel_poll_votes AS rpv')
                    ->where( 'userId', $userId )
                    ->select( db::raw( 'DISTINCT pollId' ) )
                    ->get();
        
        $out_data = [];
        $cnt = count((array)$result);
        if( $cnt > 0 ) {
            foreach( $result AS $key => $val ) {

                $out_data[] = $val->pollId;
            }
            return $out_data;
        } else {
            return false;
        }
    }

    public function countPollsVotedDashboard() {
        
        $result = DB::table('polls AS poll')
                ->join('rel_poll_votes AS rpv', 'poll.id', '=', 'rpv.pollId')
                ->leftJoin('users AS usr', 'poll.userId', '=', 'usr.id')
                ->leftJoin( 'rel_poll_comments AS rpc', 'poll.id', '=', 'rpc.pollId' )
                ->where('poll.status', '=', 'OPEN')                
                ->select(
                    'poll.id AS pollId',
                    'poll.question AS question',
                    'poll.imageLink AS pollImageLink',
                    'poll.allowComments AS allowComments',
                    'poll.published_at AS published_at',
                    'rpv.vote AS vote',
                    'usr.id AS userId',
                    'usr.userName AS userName',
                    'usr.imageLink AS userImageLink',
                    DB::raw('COUNT(rpc.id) AS totalComments'),
                    DB::raw('COUNT(*) AS totalVotes')
                );
        
        $result = $result->groupBy(
                    'poll.id',
                    'poll.question',
                    'poll.imageLink',
                    'poll.allowComments',
                    'poll.published_at',
                    'rpv.vote',
                    'usr.id',
                    'usr.userName',
                    'usr.imageLink'
                )->orderBy('poll.id', 'desc')->orderBy('rpv.vote')
                ->get(); 
        return $result->count();
    }

    public function countPollsVotedByMe( $in_data ) {
        
        $result = DB::table('polls AS poll')
                ->join('rel_poll_votes AS rpv', 'poll.id', '=', 'rpv.pollId')
                ->leftJoin('users AS usr', 'poll.userId', '=', 'usr.id')
                ->leftJoin( 'rel_poll_comments AS rpc', 'poll.id', '=', 'rpc.pollId' )
                ->where('poll.status', '=', 'OPEN')
                ->where('rpv.userId', '=', $in_data['userId'])                    
                ->select(
                    'poll.id AS pollId',
                    'poll.question AS question',
                    'poll.imageLink AS pollImageLink',
                    'poll.allowComments AS allowComments',
                    'poll.published_at AS published_at',
                    'rpv.vote AS vote',
                    'usr.id AS userId',
                    'usr.userName AS userName',
                    'usr.imageLink AS userImageLink',
                    DB::raw('COUNT(rpc.id) AS totalComments'),
                    DB::raw('COUNT(*) AS totalVotes')
                );
        
        isset( $in_data['poll'] ) && !empty( $in_data['poll'] ) ? $result = $result->where( 'poll.question', 'LIKE', '%'. $in_data['poll'] .'%' ) : '';
        isset( $in_data['tags'] ) && !empty( $in_data['tags'] ) ? $result = $result->where( 'poll.question', 'LIKE', '%'. $in_data['tags'] .'%' ) : '' ;
        isset( $in_data['people'] ) && !empty( $in_data['people'] ) ? $result = $result->where( 'usr.userName', 'LIKE', '%'. $in_data['people'] .'%' ) : '';

        $result = $result->groupBy(
                    'poll.id',
                    'poll.question',
                    'poll.imageLink',
                    'poll.allowComments',
                    'poll.published_at',
                    'rpv.vote',
                    'usr.id',
                    'usr.userName',
                    'usr.imageLink'
                )->orderBy('poll.id', 'desc')->orderBy('rpv.vote')
                ->get(); 
        return $result->count();
    }

    public function getPollsVotedByMe( $in_data ) {

        $pollIds = $this->getMyVotedPollIdsByUser( $in_data['userId'] );

        if( count( $pollIds ) < 1 ) {
            return [];
        }

        $result = DB::table('polls AS poll')
                    ->leftjoin('rel_poll_votes AS rpv', 'poll.id', '=', 'rpv.pollId')
                    ->leftJoin('users AS usr', 'poll.userId', '=', 'usr.id')
                    ->leftJoin( 'rel_poll_comments AS rpc', 'poll.id', '=', 'rpc.pollId' )
                    ->where('poll.status', '=', 'OPEN')
                    ->whereIn('rpv.pollId', $pollIds)
                    ->select(
                        'poll.id AS pollId',
                        'poll.question AS question',
                        'poll.imageLink AS pollImageLink',
                        'poll.allowComments AS allowComments',
                        'poll.published_at AS published_at',
                        'rpv.vote AS vote',
                        'usr.id AS userId',
                        'usr.userName AS userName',
                        'usr.imageLink AS userImageLink',
                        DB::raw('COUNT(rpc.id) AS totalComments'),
                        DB::raw('COUNT(*) AS totalVotes')
                    );
        
        isset( $in_data['poll'] ) && !empty( $in_data['poll'] ) ? $result = $result->where( 'poll.question', 'LIKE', '%'. $in_data['poll'] .'%' ) : '';
        isset( $in_data['tags'] ) && !empty( $in_data['tags'] ) ? $result = $result->where( 'poll.question', 'LIKE', '%'. $in_data['tags'] .'%' ) : '' ;
        isset( $in_data['people'] ) && !empty( $in_data['people'] ) ? $result = $result->where( 'usr.userName', 'LIKE', '%'. $in_data['people'] .'%' ) : '';
        
        $result = $result->groupBy(
            'poll.id',
            'poll.question',
            'poll.imageLink',
            'poll.allowComments',
            'poll.published_at',
            'rpv.vote',
            'usr.id',
            'usr.userName',
            'usr.imageLink'
        )->orderBy('poll.id', 'desc')->orderBy('rpv.vote')
        ->offset($in_data['offset'])->limit($in_data['limit'])
        ->get(); 

        $out_data = [];
        $pollIds = [];
        if( count( (array)$result ) ) {
            $i = 0;
            foreach( $result AS $key => $val ) {

                if( !in_array( $val->pollId, $pollIds ) ) {

                    $pollIds[] = $val->pollId;

                    $out_data[$i]['pollId'] = $val->pollId;
                    $out_data[$i]['question'] = $val->question;
                    $out_data[$i]['pollImageLink'] = $val->pollImageLink;
                    $out_data[$i]['allowComments'] = $val->allowComments;
                    $out_data[$i]['published_at'] = $val->published_at;
                    $out_data[$i]['vote'] = $val->vote;
                    $out_data[$i]['userId'] = $val->userId;
                    $out_data[$i]['userName'] = $val->userName;
                    $out_data[$i]['userImageLink'] = $val->userImageLink;
                    $out_data[$i]['totalComments'] = $val->totalComments;

                    if( $val->pollImageLink != 'null' && strlen( $val->pollImageLink ) > 0 ) {

                        $pollImageUrl = url('storage/polls/'. $val->pollImageLink);
                        list( $pollWidth, $pollHeight ) = getimagesize( $pollImageUrl );
    
                        $out_data[$i]['pollImageDetails'] = [
                            'relativePath' => $pollImageUrl,
                            'width' => $pollWidth,
                            'height' => $pollHeight
                        ];
                    }

                    if( $val->vote == 'YES' ) {
                        $out_data[$i]['votes'][0]['pollId'] = $val->pollId;
                        $out_data[$i]['votes'][0]['vote'] = $val->vote;
                        $out_data[$i]['votes'][0]['totalVotes'] = $val->totalVotes;

                        $out_data[$i]['votes'][1]['pollId'] = $val->pollId;
                        $out_data[$i]['votes'][1]['vote'] = 'NO';
                        $out_data[$i]['votes'][1]['totalVotes'] = 0;
                    } else if( $val->vote == 'NO' ) {

                        $out_data[$i]['votes'][0]['pollId'] = $val->pollId;
                        $out_data[$i]['votes'][0]['vote'] = 'YES';
                        $out_data[$i]['votes'][0]['totalVotes'] = 0;

                        $out_data[$i]['votes'][1]['pollId'] = $val->pollId;
                        $out_data[$i]['votes'][1]['vote'] = $val->vote;
                        $out_data[$i]['votes'][1]['totalVotes'] = $val->totalVotes;
                    }
                    $i++;
                } else {

                    if( array_search( $val->pollId, $pollIds ) !== false ) {
                            
                        $index = array_search( $val->pollId, $pollIds );

                        $out_data[$index]['pollId'] = $val->pollId;
                        $out_data[$index]['question'] = $val->question;
                        $out_data[$index]['pollImageLink'] = $val->pollImageLink;
                        $out_data[$index]['allowComments'] = $val->allowComments;
                        $out_data[$index]['published_at'] = $val->published_at;
                        $out_data[$index]['vote'] = $val->vote;
                        $out_data[$index]['userId'] = $val->userId;
                        $out_data[$index]['userName'] = $val->userName;
                        $out_data[$index]['userImageLink'] = $val->userImageLink;
                        $out_data[$index]['totalComments'] = $val->totalComments; 

                        if( $val->pollImageLink != 'null' && strlen( $val->pollImageLink ) > 0 ) {

                            $pollImageUrl = url('storage/polls/'. $val->pollImageLink);
                            list( $pollWidth, $pollHeight ) = getimagesize( $pollImageUrl );
        
                            $out_data[$index]['pollImageDetails'] = [
                                'relativePath' => $pollImageUrl,
                                'width' => $pollWidth,
                                'height' => $pollHeight
                            ];
                        }

                        if( $val->vote == 'YES' ) {
                            $out_data[$index]['votes'][0]['pollId'] = $val->pollId;
                            $out_data[$index]['votes'][0]['vote'] = $val->vote;
                            $out_data[$index]['votes'][0]['totalVotes'] = $val->totalVotes;
    
                            // $out_data[$index]['votes'][1]['pollId'] = $val->pollId;
                            // $out_data[$index]['votes'][1]['vote'] = 'NO';
                            // $out_data[$index]['votes'][1]['totalVotes'] = 0;
                        } else if( $val->vote == 'NO' ) {
    
                            // $out_data[$index]['votes'][0]['pollId'] = $val->pollId;
                            // $out_data[$index]['votes'][0]['vote'] = 'YES';
                            // $out_data[$index]['votes'][0]['totalVotes'] = 0;
    
                            $out_data[$index]['votes'][1]['pollId'] = $val->pollId;
                            $out_data[$index]['votes'][1]['vote'] = $val->vote;
                            $out_data[$index]['votes'][1]['totalVotes'] = $val->totalVotes;
                        }
                    }
                }
            }
        }

        if( !empty( $out_data ) ) {

            $out_data = $this->calculateVotePercentage( $out_data );
        }
        return $out_data;
    }

    public function ifCommentAlreadyLiked( $in_data ) {

        $poll = RelPollCommentsLikes::where([
            [ 'pollId', '=', $in_data['pollId'] ],
            [ 'relPollCommentsId', '=', $in_data['relPollCommentsId'] ],
            [ 'userId', '=', $in_data['userId'] ],
        ])->count();
        return $poll > 0 ? true : false;
    }

    public function getCommentLikeDislikeByRelPollCommentsId( $relPollCommentsId ) {

        $result = RelPollCommentsLikes::where( 'relPollCommentsId', '=', $relPollCommentsId )->get()->toArray();
        if( count( $result ) ) {
            return (object)$result[0];
        } else {
            return $res->id = 0;
        }
    }

    public function insertCommentLikeDislike( $in_data ) {

        if( $this->ifCommentAlreadyLiked( $in_data ) ) {

            $affectedRows = DB::table('rel_poll_comments_likes')->where([
                [ 'pollId', '=', $in_data['pollId'] ],
                [ 'relPollCommentsId', '=', $in_data['relPollCommentsId'] ]
            ])->update($in_data);
            return $this->getCommentLikeDislikeByRelPollCommentsId( $in_data['relPollCommentsId'] );
        } else {

            $data = RelPollCommentsLikes::create($in_data);
            return $data;
        }
    }

    public function isCommentsAllowedOnPoll( $pollId ) {

        $poll = Poll::where([
            ['id', '=', $pollId],
            ['allowComments', '=', 'YES']
        ])->count();
        return $poll > 0 ? true : false;
    }

    public function countPollsByUserId( $userId ) {

        return Poll::where([
            ['userId', '=', $userId],
            ['status', '=', 'OPEN'],
        ])->count(); 
    }

    // total votes received
    public function countResponseReceivedPollsByUserId( $userId ) {

        $result = DB::select( "SELECT COUNT(*) AS cnt FROM rel_poll_votes WHERE pollId IN( SELECT id FROM polls WHERE userId = ". $userId ." )" );
        return $result[0]->cnt > 0 ? $result[0]->cnt : 0;
    }

    // total polls votes to
    public function countPollsSupportedByUserId( $userId ) {

        return RelPollVotes::where( 'userId', $userId )->count();
    }

    public function getUserPointsBalance( $userId ) {

        $result = RelUserPoints::where( 'userId', $userId )
                ->select( DB::raw( 'transactionType, SUM(points) AS points' ) )
                ->groupBy( 'transactionType' )
                ->get();
        
        $out_data = [
            [
                // 'pollId' => $pollId,
                'vote' => 'YES',
                'total' => 0,
                'percent' => 0
            ],
            [
                // 'pollId' => $pollId,
                'vote' => 'NO',
                'total' => 0,
                'percent' => 0
            ]
        ];

        $debit = $credit = 0;
        if( count( (array)$result ) ) {
            
            foreach( $result AS $key => $val ) {
                
                if( $val['transactionType'] == 'DEBIT' ) {
                    $debit = $val['points'];

                } else if( $val['transactionType'] == 'CREDIT' ) {
                    $credit = $val['points'];
                    
                }
            }

            return $userPointsBalance = $credit - $debit;
        } else {

            return 0;
        }
    }

    public function getUserStats( $userId ) {

        return [
            'totalCreatedPolls' => $this->countPollsByUserId( $userId ),
            'totalResponseReceived' => $this->countResponseReceivedPollsByUserId( $userId ),
            'totalPollsSupported' => $this->countPollsSupportedByUserId( $userId ),
            'strawPoints' => $this->getUserPointsBalance( $userId )
        ];
    }

    public function sharePoll( $pollId ) {

        return Poll::select( 'id', 'question', 'imageLink' )->where( 'id', $pollId )->get()->first()->toArray();
    }
}
?>