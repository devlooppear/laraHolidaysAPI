<?php

// app/Repositories/UserRepository.php

namespace App\Repositories;

use App\Models\User;

class UserRepository
{
    public function getAll(): array
    {
        return User::all()->toArray();
    }

    public function getById(int $userId): array
    {
        return User::findOrFail($userId)->toArray();
    }

    public function create(array $userData): User
    {
        return User::create($userData);
    }

    public function update(int $userId, array $userData): array
    {
        $user = User::findOrFail($userId);

        if (is_array($userData)) {
            $user->update($userData);
        } else {

            $user->update([$userData]);
        }

        return $user->toArray();
    }


    public function delete(int $userId): void
    {
        User::findOrFail($userId)->delete();
    }
}
