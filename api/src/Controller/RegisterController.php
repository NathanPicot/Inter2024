<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use App\Entity\User;

class RegisterController extends AbstractController
{
    #[Route('/api/register', name: 'app_register')]
    public function index(Request $request ,UserPasswordHasherInterface $passwordHasher, EntityManagerInterface $entityManager): JsonResponse
    {
                        // Retrieve credentials from the request
    $credentials = json_decode($request->getContent(), true);

            // // Example data for user registration (you may obtain this from the request)
            // $request = [
            //     'username' => $credentials['username'],
            //     'email' => $credentials['mail'],
            //     'password' => $credentials['password'], // Replace with the actual plaintext password
            // ];
              // Create a new User instance
        $user = new User();
        $user->setUsername($credentials['username']);
        $user->setEmail($credentials['mail']);
    // hash the password (based on the security.yaml config for the $user class)
    $hashedPassword = $passwordHasher->hashPassword(
        $user,
        $credentials['password']
    );
    $user->setPassword($hashedPassword);


    
        // tell Doctrine you want to (eventually) save the Product (no queries yet)
        $entityManager->persist($user);

        // actually executes the queries (i.e. the INSERT query)
        $entityManager->flush();
            // Return a JSON response indicating successful registration
            return new JsonResponse(['message' => 'User registered successfully']);
    }

    
}
