<?php

namespace App\Controller;

use App\Services\RegisterService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class RegistrationController extends AbstractController
{
    private RegisterService $registerService;

    public function __construct(RegisterService $registerService)
    {
        $this->registerService = $registerService;
    }

    #[Route('/register', name: 'app_register')]
    public function register(Request $request): Response
    {
        return $this->registerService->register($request);
    }
}
