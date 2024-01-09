<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;

class FormulaireCreaCompteController extends AbstractController
{
    #[Route('/formulaire/crea/compte', name: 'app_formulaire_crea_compte')]
    public function index(): JsonResponse
    {
        return $this->json([
            'message' => 'Welcome to your new controller!',
            'path' => 'src/Controller/FormulaireCreaCompteController.php',
        ]);
    }
}
