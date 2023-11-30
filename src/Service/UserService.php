<?php

namespace App\Service;

use App\Entity\User;
use App\Repository\UserRepository;
use Symfony\Component\Security\Core\User\PasswordAuthenticatedUserInterface;

class UserService implements UserServiceInterface
{
    private UserRepository $userRepository;

    /**
     * @param UserRepository $userRepository
     */
    public function __construct(UserRepository $userRepository)
    {
        $this->userRepository = $userRepository;
    }


    public function create(User $user): User
    {
        $this->userRepository->add($user, true);

        return $user;
    }

    public function delete(int $id): bool
    {
        $user = $this->userRepository->find($id);

        if (empty($user)) {
            return false;
        }

        $this->userRepository->remove($user);

        return true;
    }

    public function changePassword(PasswordAuthenticatedUserInterface $user, string $newHashedPassword): void
    {
        $this->userRepository->upgradePassword($user, $newHashedPassword);
    }

}