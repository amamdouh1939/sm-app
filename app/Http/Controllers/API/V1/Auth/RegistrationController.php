<?php

namespace App\Http\Controllers\API\V1\Auth;

use AElnemr\RestFullResponse\CoreJsonResponse;
use App\Http\Controllers\Controller;
use App\Http\Requests\RegistrationRequest;
use App\Http\Resources\UserResource;
use App\Services\UserService;
use Illuminate\Http\Request;

class RegistrationController extends Controller
{
    use CoreJsonResponse;

    protected $userService;

    public function __construct(UserService $userService)
    {
        $this->userService = $userService;
    }

    public function register(RegistrationRequest $request)
    {
        $user = $this->userService->createUser($request->validated());
        return $this->created((new UserResource($user))->resolve());
    }
}
