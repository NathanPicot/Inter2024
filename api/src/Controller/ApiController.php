<?php

namespace App\Controller;

use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Users\UsersCommands;

class ApiController extends AbstractController
{
    #[Route('/api', name: 'app_api')]
    public function index(): JsonResponse
    {
        return $this->json([
            'message' => 'Welcome to your new controller!',
            'path' => 'src/Controller/ApiController.php',
        ]);
    }

    #[Route('/api/addUser', name: 'addUser')]
    public function addUser(Request $request, UsersCommands $usersCommands): Response
    {
        $data = json_decode($request->getContent(), true, 512, JSON_THROW_ON_ERROR);

        // Extraire les valeurs de user, password et email
        $user = $data['user'] ?? null;
        $password = $data['password'] ?? null;
        $email = $data['email'] ?? null;

        // Appeler la méthode addUser avec les paramètres
        $result = $usersCommands->addUser($user, $password, $email);

        // Créer une réponse avec le résultat
        return new JsonResponse(['message' => $result]);
    }
}

