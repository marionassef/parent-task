<?php


namespace App\Models;


use App\Http\Resources\DataProviderYResource;
use JsonStreamingParser\Listener\GeoJsonListener;
use JsonStreamingParser\Parser;

class DataProviderY extends AbstractDataProviders
{
    protected array $users = [];

    const STATES_CODES = [
        'authorised' => 100,
        'decline' => 200,
        'refunded' => 300,
    ];

    const STATES_CODES_REVERSED = [
        100 => 'authorised',
        200 => 'decline',
        300 => 'refunded',
    ];

    public function getData($filters)
    {
        $stream = fopen(storage_path('app/DataProviderY.json'), 'r');

        $listener = new GeoJsonListener(function ($user) use($filters) : void {
            $user = (object)$user;
            if ($this->filterData($user, $filters)) {
                $this->users[] = new DataProviderYResource($user);
            }
        });

        $parser = new Parser($stream, $listener);
        $parser->parse();
        fclose($stream);
        return $this->users;
    }

    private function filterData($user, $filters): bool
    {
        if (isset($filters['statusCode']) && array_key_exists($filters['statusCode'], self::STATES_CODES)) {
            if($user->status !== self::STATES_CODES[$filters['statusCode']]){
                return false;
            }
        }
        if (isset($filters['balanceMin'])) {
            if($user->balance < $filters['balanceMin']){
                return false;
            }
        }
        if (isset($filters['balanceMax'])) {
            if($user->balance > $filters['balanceMax']){
                return false;
            }
        }
        if (isset($filters['currency'])) {
            if($user->currency !== $filters['currency']){
                return false;
            }
        }
        return true;
    }

}
