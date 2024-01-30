<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Process\Process;

class PhpReaperController extends AbstractController
{
    #[Route('/php/reaper', name: 'app_php_reaper')]
    public function index(): JsonResponse
    {
        // Execute the php-reaper command
        $process = new Process(['php', 'php-reaper', '-d', 'directory_with_php_files']);
        $process->run();

        // Check if the command was successful
        if (!$process->isSuccessful()) {
            return $this->json([
                'error' => 'Failed to execute php-reaper command.',
            ]);
        }
        // Get the command output
        $output = $process->getOutput();

// Convert the output to an array or object (if necessary)
$data = json_decode($output, true); // Set second argument to true to decode as an associative array


        // Return a JSON response with the command output
        return $this->json([
            'message' => 'php-reaper command executed successfully.',
            'output' => $data,
        ]);
    }
}
