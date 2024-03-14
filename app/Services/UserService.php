<?php

// app/Services/UserService.php

namespace App\Services;

use App\Repositories\UserRepository;
use Exception;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;

class UserService
{
    protected $userRepository;

    public function __construct(UserRepository $userRepository)
    {
        $this->userRepository = $userRepository;
    }

    public function createUser(array $userData): array
    {
        try {
            $userData['password'] = Hash::make($userData['password']);
            $user = $this->userRepository->create($userData);

            $token = $user->createToken('Personal Access Token')->accessToken;

            // Insert the token into the personal_access_tokens table
            DB::table('personal_access_tokens')->insert([
                'tokenable_type' => get_class($user),
                'tokenable_id' => $user->id,
                'name' => 'Personal Access Token',
                'token' => $token,
            ]);

            return [
                'user' => $user,
            ];
        } catch (Exception $e) {
            Log::error('Error creating user: ' . $e->getMessage());
            throw $e;
        }
    }

    public function getAllUsers(): array
    {
        try {
            return $this->userRepository->getAll();
        } catch (Exception $e) {
            Log::error('Error fetching all users: ' . $e->getMessage());
            throw $e;
        }
    }

    public function getUserById(int $userId): array
    {
        try {
            return $this->userRepository->getById($userId);
        } catch (Exception $e) {
            Log::error('Error fetching user by ID: ' . $e->getMessage());
            throw $e;
        }
    }

    public function updateUser(int $userId, array $userData): array
    {
        try {
            return $this->userRepository->update($userId, $userData);
        } catch (Exception $e) {
            Log::error('Error updating user: ' . $e->getMessage());
            throw $e;
        }
    }

    public function deleteUser(int $userId): void
    {
        try {
            $this->userRepository->delete($userId);
        } catch (Exception $e) {
            Log::error('Error deleting user: ' . $e->getMessage());
            throw $e;
        }
    }
}
