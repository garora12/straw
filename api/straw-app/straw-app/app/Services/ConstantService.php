<?php
namespace App\Services;

class ConstantService {

    private $specialUserNames = [];

    public function __construct() {

        $this->specialUserNames = [
            'founder1',
            'founder2',
            'founder3'
        ];
    }

    public function getSpecialUserNames() {

        return $this->specialUserNames;
    }
}
?>