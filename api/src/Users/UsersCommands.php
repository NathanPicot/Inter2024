<?php

namespace App\Users;

use App\Entity\Users;
use Exception;
use Doctrine\ORM\EntityManagerInterface;

class UsersCommands
{
    private $entityManager;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    public function AddUser(string $user, string $password, string $email): string
    {

        $userRepository = $this->entityManager->getRepository(Users::class);
        // Utilisez la méthode findOneBy pour trouver l'utilisateur par email
        $utilisateur = $userRepository->findOneBy(['email' => $email]);

        if ($utilisateur) {
            return 'email deja existant';
        }

        $userRepository = $this->entityManager->getRepository(Users::class);
        // Utilisez la méthode findOneBy pour trouver l'utilisateur par email
        $utilisateur = $userRepository->findOneBy(['username' => $user]);

        if ($utilisateur) {
            return 'pseudo deja utilisé';
        }

        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            return 'Format d\'email invalide';
        }

        $password_hash = password_hash($password, PASSWORD_DEFAULT);

        // Créez une instance de l'entité User avec les données fournies
        $newUser = new Users();
        $newUser->setUsername($user);
        $newUser->setPasswordHash($password_hash); // Assurez-vous de hasher le mot de passe avant de l'enregistrer en base de données
        $newUser->setEmail($email);

        // Persistez l'entité dans la base de données
        $this->entityManager->persist($newUser);
        $this->entityManager->flush();

        // Vous pouvez personnaliser le message de retour selon vos besoins
        return 'Utilisateur ajouté avec succès.';
    }

    function DeleteUsers(int $userId)
    {
        throw new \RuntimeException('Not implemented');
    }

    function GetUser(int $userId)
    {
        throw new \RuntimeException('Not implemented');
    }

    function EditUser(int $userId, string $user, string $password, string $email)
    {
        throw new \RuntimeException('Not implemented');
    }

}