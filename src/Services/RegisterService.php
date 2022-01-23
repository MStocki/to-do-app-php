<?php

declare(strict_types=1);

namespace App\Services;

use App\Entity\User;
use App\Security\AppCustomAuthenticator;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Security\Http\Authentication\UserAuthenticatorInterface;
use App\Repository\UserRepository;

class RegisterService
{

    public function __construct(
        private UserRepository $userRepository
    ) {}

    public function register(User $user):void
    {
        $this->userRepository->persist($user);
        $this->userRepository->flush();
    }
}
