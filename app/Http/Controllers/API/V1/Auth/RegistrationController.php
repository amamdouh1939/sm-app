<?php

namespace App\Http\Controllers\API\V1\Auth;

use AElnemr\RestFullResponse\CoreJsonResponse;
use App\Http\Controllers\Controller;
use App\Http\Requests\RegistrationRequest;
use App\Http\Resources\UserResource;
use App\Models\User;
use Illuminate\Http\Request;

class RegistrationController extends Controller
{
    use CoreJsonResponse;

    public function register(RegistrationRequest $request)
    {
        $user = User::create($request->only('name', 'email', 'password'));
        $user->profile()->create($request->only('bio'));

        return $this->created((new UserResource($user))->resolve());
    }
}
