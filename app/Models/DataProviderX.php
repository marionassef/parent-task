<?php


namespace App\Models;


use App\Http\Resources\DataProviderXResource;
use JsonStreamingParser\Listener\GeoJsonListener;
use JsonStreamingParser\Parser;

class DataProviderX extends AbstractDataProviders
{
    protected array $users = [];

    const STATES_CODES = [
        'authorised' => 1,
        'decline' => 2,
        'refunded' => 3,
    ];

    const STATES_CODES_REVERSED = [
        1 => 'authorised',
        2 => 'decline',
        3 => 'refunded',
    ];

    public function getData($filters)
    {
        $stream = fopen(storage_path('app/DataProviderX.json'), 'r');

        $listener = new GeoJsonListener(function ($user) use($filters) : void {
            $user = (object)$user;
            if ($this->filterData($user, $filters)) {
                $this->users[] = new DataProviderXResource($user);
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
            if($user->statusCode !== self::STATES_CODES[$filters['statusCode']]){
                return false;
            }
        }
        if (isset($filters['balanceMin'])) {
            if($user->parentAmount < $filters['balanceMin']){
                return false;
            }
        }
        if (isset($filters['balanceMax'])) {
            if($user->parentAmount > $filters['balanceMax']){
                return false;
            }
        }
        if (isset($filters['currency'])) {
            if($user->Currency !== $filters['currency']){
                return false;
            }
        }
        return true;
    }
}
