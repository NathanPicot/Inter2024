<?php

namespace App\Controller;

use App\Users\UsersCommands;
use JsonException;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

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

    #[Route('/api/deleteUser', name: 'deleteUser')]
    public function deleteUser(Request $request, UsersCommands $usersCommands): Response
    {
        $data = json_decode($request->getContent(), true, 512, JSON_THROW_ON_ERROR);

        // Extraire les valeurs de user, password et email
        $userId = $data['userId'] ?? null;

        // Appeler la méthode addUser avec les paramètres
        $result = $usersCommands->deleteUser($userId);

        // Créer une réponse avec le résultat
        return new JsonResponse(['message' => $result]);
    }

    #[Route('/api/getUser', name: 'getUser')]
    public function fetchUser(Request $request, UsersCommands $usersCommands): JsonResponse
    {
        try {
            $data = json_decode($request->getContent(), true, 512, JSON_THROW_ON_ERROR);

            // Extract values for user ID
            $userId = $data['userId'] ?? null;

            if (!is_int($userId)) {
                return new JsonResponse(['error' => 'Invalid userId provided'], 400);
            }

            // Call the getUser method with the parameters
            $user = $usersCommands->getUser($userId);

            if ($user === null) {
                return new JsonResponse(['error' => 'User not found'], 404);
            }

            // Return user data as JSON
            return new JsonResponse(['user' => $user]);

        } catch (JsonException $e) {
            return new JsonResponse(['error' => 'Invalid JSON format in the request'], 400);
        }
    }

    #[Route('/api/editUser', name: 'getUser')]
    public function editUser(Request $request, UsersCommands $usersCommands): JsonResponse
    {
        try {
            $data = json_decode($request->getContent(), true, 512, JSON_THROW_ON_ERROR);

            // Extraire les valeurs de user, password et email
            $userId = $data['userId'];
            $user = $data['user'] ?? null;
            $password = $data['password'] ?? null;
            $email = $data['email'] ?? null;

            // Appeler la méthode addUser avec les paramètres
            $result = $usersCommands->editUser($userId, $user, $password, $email);

            // Créer une réponse avec le résultat
            return new JsonResponse(['message' => $result]);

        } catch (JsonException $e) {
            return new JsonResponse(['error' => 'Invalid JSON format in the request'], 400);
        }
    }

}

