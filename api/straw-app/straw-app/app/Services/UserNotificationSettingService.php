<?php
namespace App\Services;
use App\UserNotificationSettings;
use DB;

class UserNotificationSettingService {

    public function __construct() {
        DB::enableQueryLog();
    }

    public function isUserNotificationSettingsExists( $userId ) {

        $cnt = UserNotificationSettings::where('userId', $userId)->count();
        return $cnt > 0 ? true : false;
    }

    public function insertUserNotificationSettings( $in_data ) {

        $data = UserNotificationSettings::create($in_data);
        return $data;
    }

    public function updateUserNotificationSettings( $in_data ) {

        DB::table('user_notification_settings')->where( 'userId', $in_data['userId'] )->update($in_data);
        return $in_data['userId'];
    }

    public function getInsertedUserNotificationSettings( $userId ) {

        $result = DB::table('user_notification_settings AS uns')
                    ->leftJoin('users AS usr', 'uns.userId', '=', 'usr.id')
                    ->where( 'uns.userId', '=', $userId )
                    ->select(
                        'uns.id',
                        'uns.userId',
                        'uns.settings AS userNotificationSettings',
                        'uns.status',
                        'usr.userName', 
                        'usr.universityEmail', 
                        'usr.gender', 
                        'usr.imageLink', 
                        'usr.studyingYear', 
                        'usr.branchId', 
                        'usr.status'
                    )
                    ->first();
        if( count( (array)$result ) ) {

            $userNotificationSettings = json_decode($result->userNotificationSettings);
            $user = [
                'id' => $result->id,
                'userId' => $result->userId,
                'status' => $result->status,
                'userName' => $result->userName,
                'universityEmail' => $result->universityEmail,
                'gender' => $result->gender,
                'imageLink' => $result->imageLink,
                'studyingYear' => $result->studyingYear,
                'branchId' => $result->branchId,
            ];
            return [
                'user' => $user,
                'userNotificationSettings' => [
                    "newPollReceived" => (string)$userNotificationSettings->newPollReceived,
                    "pollVoteReceived" => (string)$userNotificationSettings->pollVoteReceived,
                    "pollCommentReceived" => (string)$userNotificationSettings->pollCommentReceived,
                    "pollEnded" => (string)$userNotificationSettings->pollEnded
                ]
            ];
        } else {

            return null;
        }
    }
}
?>