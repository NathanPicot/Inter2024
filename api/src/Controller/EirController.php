<?php

namespace App\Controller;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Process\Exception\ProcessFailedException;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Process\Process;
use Symfony\Component\Filesystem\Filesystem;

class EirController extends AbstractController
{
    #[Route('/eir', name: 'app_eir_scan')]
    public function index(): JsonResponse
    {
        // Change this to the path where you downloaded Eir project
        $eirPath = '/path/to/eir';

        // Check if Eir directory exists
        if (!is_dir($eirPath)) {
            return $this->json([
                'error' => 'Eir directory does not exist.',
            ]);
        }

        // Clone the GitHub repository
        $repoUrl = 'https://github.com/Alex101111/NUH-Backend-PHP.git'; // Replace with the URL of the GitHub repository
        $repoPath = sys_get_temp_dir() . '/eir_repo'; // Temporary directory to clone the repository

        // Clone the repository
        $cloneProcess = new Process(['git', 'clone', $repoUrl, $repoPath]);
        $cloneProcess->setTimeout(300); // 5 minutes timeout

        try {
            $cloneProcess->mustRun();
        } catch (ProcessFailedException $exception) {
            return $this->json([
                'error' => 'Failed to clone the GitHub repository: ' . $exception->getMessage(),
            ]);
        }

        // Run Eir vulnerability scanner
        $process = new Process(['mono', 'PHPAnalysis.exe', '--all', '--target', $repoPath]);
        $process->setTimeout(300); // 5 minutes timeout

        try {
            $process->mustRun();

            // Output success message or result
            $output = $process->getOutput();

            // Delete the cloned repository
            $filesystem = new Filesystem();
            $filesystem->remove($repoPath);

            return $this->json([
                'message' => 'Eir scan completed successfully.',
                'output' => $output,
            ]);
        } catch (ProcessFailedException $exception) {
            // Handle failed command execution
            return $this->json([
                'error' => 'Failed to run Eir: ' . $exception->getMessage(),
            ]);
        }
    }
}
