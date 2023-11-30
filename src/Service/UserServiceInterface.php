<?php

namespace App\Service;

use App\Entity\User;
use Symfony\Component\Security\Core\User\PasswordAuthenticatedUserInterface;

interface UserServiceInterface
{
    public function create(User $user): User;
    public function delete(int $id): bool;
    public function changePassword(PasswordAuthenticatedUserInterface $user, string $newHashedPassword): void;
}