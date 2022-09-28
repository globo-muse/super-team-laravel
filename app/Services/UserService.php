<?php

namespace App\Services;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Auth;

class UserService
{

    public function __construct(protected User $repository) {}

    public function getUserAuth()
    {
        $user = Auth::user();
        return $user;
    }

    public function getUserByEmail(string $email)
    {
        return $this->repository->getUserByEmail($email);
    }

    public function updateUser($userId, $data)
    {
        if ($data['image']->isValid() ?? false) {
            $data['image'] = $data['image']->store("users");
        }
        return $this->repository->find($userId)->update($data);
    }
}
