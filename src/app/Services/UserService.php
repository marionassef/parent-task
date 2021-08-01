<?php

namespace App\Services;

use App\Constants\ListOfProviders;
use App\Exceptions\CustomValidationException;
use Illuminate\Support\Arr;

class UserService
{
    /**
     * @throws \App\Exceptions\CustomValidationException
     */
    public function list($data)
    {
        if (isset($data['provider'])) {

            $this->validateProvider($data['provider']);

            $provider = new (ListOfProviders::LIST_OF_PROVIDERS[$data['provider']]);
            return $provider->getData($data);
        } else {
            $users = [];
            foreach (ListOfProviders::LIST_OF_PROVIDERS as $provider) {
                $provider = new ($provider);
                $users[] = $provider->getData($data);
            }
            return Arr::flatten($users);
        }
    }

    /**
     * @throws \App\Exceptions\CustomValidationException
     */
    private function validateProvider($provider)
    {
        if (!array_key_exists($provider, ListOfProviders::LIST_OF_PROVIDERS)) {
            throw new CustomValidationException('Invalid Provider');
        }
    }
}
