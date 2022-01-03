<?php

namespace App\Services;

use App\Entity\User;
use App\Form\RegistrationFormType;
use App\Security\AppCustomAuthenticator;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Security\Http\Authentication\UserAuthenticatorInterface;
use App\Repository\UserRepository;

class RegisterService extends AbstractController
{
    private UserRepository $userRepository;
    private UserPasswordHasherInterface $userPasswordHasher;
    private UserAuthenticatorInterface $userAuthenticator;
    private AppCustomAuthenticator $authenticator;


    public function __construct(
        UserRepository $userRepository,
        UserPasswordHasherInterface $userPasswordHasher,
        UserAuthenticatorInterface $userAuthenticator,
        AppCustomAuthenticator $authenticator)
    {
        $this->userRepository = $userRepository;
        $this->userPasswordHasher = $userPasswordHasher;
        $this->userAuthenticator = $userAuthenticator;
        $this->authenticator = $authenticator;
    }

    public function register(Request $request): Response
    {
        $user = new User();
        $form = $this->createForm(RegistrationFormType::class, $user);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            // encode the plain password
            $user->setPassword(

                $this->userPasswordHasher->hashPassword(
                    $user,
                    $form->get('plainPassword')->getData()
                )
            );
            $this->userRepository->persist($user);
            $this->userRepository->flush();
            // do anything else you need here, like send an email

            return $this->userAuthenticator->authenticateUser(
                $user,
                $this->authenticator,
                $request
            );
        }

        return $this->render('registration/register.html.twig', [
            'registrationForm' => $form->createView(),
        ]);
    }
}
