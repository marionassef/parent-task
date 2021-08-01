<?php


namespace App\Models;


class AbstractDataProviders
{
    protected array $users = [];
    const STATES_CODES = [];
    const STATES_CODES_REVERSED = [];

    public function getData($filters){}

    private function filterData($user, $filters){}
}
