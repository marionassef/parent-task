<?php

namespace Tests\Unit;

use App\Exceptions\CustomValidationException;
use App\Services\UserService;
use Tests\TestCase;

class UserTest extends TestCase
{
    /**
     * @var \Illuminate\Contracts\Foundation\Application|mixed
     */
    private UserService $userService;

    public function __construct(?string $name = null, array $data = [], $dataName = '')
    {
        parent::__construct($name, $data, $dataName);

        $this->userService = app(UserService::class);
    }

    /**
     * A basic unit test example.
     *
     * @return void
     */
    public function test_example()
    {
        $this->assertTrue(true);
    }

    public function testListProviders()
    {
        $response = $this->userService->list([]);
        $this->assertCount(6, $response);
    }

    public function testListFilteredByInvalidProvider()
    {
        try {
            $this->userService->list(['provider' => 'DataProviderZ']);
        } catch (\Exception $exception) {
            $this->assertEquals("Invalid Provider", $exception->getMessage());
        }
    }

    public function testListFilteredByProviderX()
    {
        $response = $this->userService->list(['provider' => 'DataProviderX']);
        $this->assertCount(3, $response);
    }

    public function testListFilteredByProviderY()
    {
        $response = $this->userService->list(['provider' => 'DataProviderY']);
        $this->assertCount(3, $response);
    }

    public function testFilterByAuthorizedStatusCode()
    {
        $response = $this->userService->list(['statusCode' => 'authorised']);
        $this->assertCount(2, $response);
    }

    public function testFilterByDeclineStatusCode()
    {
        $response = $this->userService->list(['statusCode' => 'decline']);
        $this->assertCount(3, $response);
    }

    public function testListFilteredByRefundedStatusCode()
    {
        $response = $this->userService->list(['statusCode' => 'refunded']);
        $this->assertCount(1, $response);
    }


    public function testListFilteredByMinBalance()
    {
        $response = $this->userService->list(['balanceMin' => 1000]);
        $this->assertCount(1, $response);
    }

    public function testListFilteredByMaxBalance()
    {
        $response = $this->userService->list(['balanceMax' => 100]);
        $this->assertCount(2, $response);
    }

    public function testListFilteredByCurrency()
    {
        $response = $this->userService->list(['currency' => 'USD']);
        $this->assertCount(3, $response);
    }

    public function testListFilteredByAllFiltersProviderX()
    {
        $response = $this->userService->list([
            'currency' => 'USD',
            'provider' => 'DataProviderX',
            'statusCode' => 'decline',
            'balanceMin' => 100,
            'balanceMax' => 1000
        ]);
        $this->assertCount(2, $response);
    }

    public function testListFilteredByAllFiltersProviderXZeroResult()
    {
        $response = $this->userService->list([
            'currency' => 'JOD',
            'provider' => 'DataProviderX',
            'statusCode' => 'decline',
            'balanceMin' => 100,
            'balanceMax' => 1000
        ]);
        $this->assertCount(0, $response);
    }

    public function testListFilteredByAllFiltersProviderY()
    {
        $response = $this->userService->list([
            'currency' => 'USD',
            'provider' => 'DataProviderY',
            'statusCode' => 'decline',
            'balanceMin' => 100,
            'balanceMax' => 1000
        ]);
        $this->assertCount(0, $response);
    }
}
