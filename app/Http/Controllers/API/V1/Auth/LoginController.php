<?php

namespace App\Http\Controllers\API\V1\Auth;

use AElnemr\RestFullResponse\CoreJsonResponse;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Laravel\Passport\Http\Controllers\AccessTokenController;
use Nyholm\Psr7\Response as Psr7Response;
use Psr\Http\Message\ServerRequestInterface;
use League\OAuth2\Server\Exception\OAuthServerException as LeagueException;
use App\Exceptions\UserInvalidLoginException;

class LoginController extends AccessTokenController
{
    use CoreJsonResponse;

    public function issueToken(ServerRequestInterface $request)
    {

        $this->validateData($request->getParsedBody());

        $token =  $this->withErrorHandling(function () use ($request) {
            return $this->convertResponse(
                $this->server->respondToAccessTokenRequest($request, new Psr7Response)
            );
        });

        return $this->ok(json_decode($token->getContent(), 1));
    }

    public function validateData($data)
    {
        $validator = validator($data, [
            'username' => 'required|email',
            'password' => 'required|string',
        ]);

        if ($validator->fails()) {
            return $this->invalidRequest($validator->errors()->getMessages());
        }
    }


    protected function withErrorHandling($callback)
    {
        try {
            return $callback();
        } catch (LeagueException $e) {
            throw new UserInvalidLoginException($e->getMessage(), $e->getCode());
        }
    }
}
