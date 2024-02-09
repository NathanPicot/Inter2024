<?php
namespace App\Controller;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use App\Entity\User;
use Symfony\Component\Security\Core\Exception\BadCredentialsException;
use Symfony\Component\Security\Core\User\UserProviderInterface;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Lexik\Bundle\JWTAuthenticationBundle\Services\JWTTokenManagerInterface;
use Doctrine\ORM\EntityManagerInterface;

class LoginController extends AbstractController
{
    private $jwtManager;
    private $entityManager; // Define the entityManager property
    
    public function __construct(JWTTokenManagerInterface $jwtManager, EntityManagerInterface $entityManager)
    {
        $this->jwtManager = $jwtManager;
        $this->entityManager = $entityManager;
    }

    #[Route('/api/login', name: 'api_login', methods: ['POST'])]
    public function login(Request $request): JsonResponse
    {
                // Retrieve credentials from the request
    $credentials = json_decode($request->getContent(), true);

    // Check if both username and password are provided
    if (!isset($credentials['username']) || !isset($credentials['password'])) {
        return $this->json(['error' => 'Username and password are required.'], Response::HTTP_BAD_REQUEST);
    }


     // Authenticate the user (You may use your authentication provider here)
        // For example, you can use Symfony's built-in security features or custom logic
        $user = $this->authenticateUser( $request);
        if (!$user) {
            throw new BadCredentialsException('Invalid credentials');
        }

        // Generate JWT token
        $token = $this->jwtManager->create($user);

        // Return the token to the frontend
        return $this->json(['token' => $token]);
}
  /**
     * Dummy method to authenticate the user.
     * Replace this with your actual authentication logic.
     */
    private function authenticateUser(Request $request)
    {
        $credentials = json_decode($request->getContent(), true);

        // Replace this with your actual logic to authenticate the user
        // For example, you can check the credentials against your database
        // or an external service
    // For example, you can check the credentials against your database
    // return $credentials['username'];
$user = $this->entityManager->getRepository(User::class)->findOneBy(['email' => $credentials['username']]);
// If no user found with the provided username, or password does not match, return null
if (!$user || !password_verify($credentials['password'], $user->getPassword())) {
    return null;
}
    
        // Return the authenticated user
        return $user;
    }
}