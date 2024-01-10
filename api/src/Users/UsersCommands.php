<?php

namespace App\Users;

use App\Entity\Users;
use Doctrine\ORM\EntityManagerInterface;
use RuntimeException;

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

    function DeleteUser(int $userId)
    {
        $user = $this->entityManager->getRepository(Users::class)->find($userId);

        if (!$user) {
            return 'Utilisateur non trouvé';
        }

        // Remove the user entity
        $this->entityManager->remove($user);

        // Flush changes to the database
        $this->entityManager->flush();

        return 'Utilisateur supprimé avec succès';
    }

    public function GetUser(int $userId): ?array
    {
        // Récupérer l'entité utilisateur par ID
        $user = $this->entityManager->getRepository(Users::class)->find($userId);

        // Vérifier si l'utilisateur existe
        if (!$user) {
            return null; // Retourner null si l'utilisateur n'est pas trouvé
        }

        // Construire et retourner un tableau d'informations utilisateur
        return [
            'id' => $user->getId(),
            'username' => $user->getUsername(),
            'email' => $user->getEmail(),
            // Ajoutez d'autres propriétés selon les besoins
        ];
    }

    function EditUser(int $userId, string $user, string $password, string $email)
    {
        // Récupérer l'entité utilisateur par ID
        $userEntity = $this->entityManager->getRepository(Users::class)->find($userId);

        // Vérifier si l'utilisateur existe
        if (!$userEntity) {
            throw new RuntimeException('Utilisateur non trouvé');
        }

        // Vérification de l'unicité du mail (en excluant l'email de l'utilisateur actuel)
        $existingEmailUser = $this->entityManager->getRepository(Users::class)->findOneBy(['email' => $email]);

        // Si l'email est changé et qu'il existe déjà pour un autre utilisateur
        if ($existingEmailUser && $existingEmailUser->getId() !== $userId) {
            throw new RuntimeException('Email déjà utilisé par un autre utilisateur');
        }

        // Vérification de l'unicité du pseudo
        $existingUsernameUser = $this->entityManager->getRepository(Users::class)->findOneBy(['username' => $user]);
        if ($existingUsernameUser && $existingUsernameUser->getId() !== $userId) {
            throw new RuntimeException('Pseudo déjà utilisé par un autre utilisateur');
        }

        // Mettre à jour les informations de l'utilisateur
        $userEntity->setUsername($user);
        $userEntity->setPasswordHash(password_hash($password, PASSWORD_DEFAULT)); // Assurez-vous de hasher le mot de passe
        $userEntity->setEmail($email);

        // Enregistrer les modifications dans la base de données
        $this->entityManager->flush();

        return 'Information du compte modifier';
    }

}