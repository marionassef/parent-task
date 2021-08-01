<?php


namespace App\Constants;


use App\Models\DataProviderX;
use App\Models\DataProviderY;

class ListOfProviders
{
     const LIST_OF_PROVIDERS = [
        'DataProviderX' => DataProviderX::class,
        'DataProviderY' => DataProviderY::class,
    ];
}
