<?php


namespace App\Services;


use App\Models\User;
use App\Repositories\UserRepositoryInterface;
use Illuminate\Support\Arr;

class UserService
{
    protected  $userRepository;

    public function __construct(UserRepositoryInterface $userRepository)
    {
        $this->userRepository = $userRepository;
    }

    public function createUser($data)
    {
        $user = $this->userRepository->create(
            Arr::only($data, ['name', 'email', 'password'])
        );
        $user->profile()->create(
            Arr::only($data, ['bio'])
        );

        return $user;
    }
}
