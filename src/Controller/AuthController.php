<?php

namespace App\Controller;

use App\Entity\User;
use App\Service\UserServiceInterface;
use Lexik\Bundle\JWTAuthenticationBundle\Services\JWTTokenManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Validator\Validator\ValidatorInterface;

class AuthController extends AbstractController
{
    private UserServiceInterface $userService;
    private UserPasswordHasherInterface $hasher;

    /**
     * @param UserServiceInterface $userService
     * @param UserPasswordHasherInterface $hasher
     */
    public function __construct(UserServiceInterface $userService, UserPasswordHasherInterface $hasher)
    {
        $this->userService = $userService;
        $this->hasher = $hasher;
    }


    /**
     * @Route("/registration", name="app_registration", methods={"POST"})
     */
    public function register(Request $request, ValidatorInterface $validator): JsonResponse
    {
        $context = json_decode($request->getContent(), true, 512, JSON_THROW_ON_ERROR);

        $user = new User();
        $user->setEmail($context['email']);
        $user->setRoles([User::USER_ROLE]);
        $user->setLastName($context['last_name']);
        $user->setFristName($context['first_name']);
        $user->setTelephoneNumber($context['telephone_number']);
        $user->setAddress($context['address']);
        $user->setPassword($this->hasher->hashPassword($user, $context['password']));

        $errors = $validator->validate($user);

        if (count($errors) > 0) {
            return $this->json(
                [
                    $errors,
                    'Something went wrong',
                ],
                500
            );
        }

        $this->userService->create($user);

        return $this->json([
            'message' => 'User was created',
            $user,
        ]);
    }

    /**
     * @Route("/login", name="app_login_check", methods={"POST"})
     * @param UserInterface $user
     * @param JWTTokenManagerInterface $JWTManager
     * @return JsonResponse
     */
    public function getTokenUser(UserInterface $user, JWTTokenManagerInterface $JWTManager): JsonResponse
    {
        return new JsonResponse(['token' => $JWTManager->create($user)]);
    }
}
