<?php


namespace App\Http\Controllers;


use App\Helpers\CustomResponse;
use App\Http\Requests\UsersListRequest;
use App\Services\UserService;
use Illuminate\Http\JsonResponse;

class UserApiController extends Controller
{
    public UserService $userService;

    public function __construct(UserService $tandaTenantService)
    {
        $this->userService = $tandaTenantService;
    }

    /**
     * @throws \App\Exceptions\CustomValidationException
     */
    public function list(UsersListRequest $request): JsonResponse
    {
        return CustomResponse::successResponse(__('success'), $this->userService->list($request->validated()));
    }
}
