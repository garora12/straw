<?php
namespace App\Services;
use App\RelUserPoints;
use Illuminate\Database\QueryException;
use DB;

class UserPointsService {

    public function __construct() {
        DB::enableQueryLog();
    }

    public function insertUserPoints( $in_data ) {
        
        $in_data['status'] = 'OPEN';
        if( $in_data['transactionFor'] == 'SIGNUP' ) {
            $in_data['transactionType'] = 'CREDIT';
            $in_data['points'] = 500;

        } else if( $in_data['transactionFor'] == 'POLLCREATED' ) {
            // $in_data['transactionType'] = 'DEBIT';
            // $in_data['points'] = 10;
            $in_data['transactionType'] = 'CREDIT';
            $in_data['points'] = 5;

        } else if( $in_data['transactionFor'] == 'POLLVOTED' ) {
            $in_data['transactionType'] = 'CREDIT';
            $in_data['points'] = 1;
        }

        $data = RelUserPoints::create( $in_data );
        return $data;
    }
}
