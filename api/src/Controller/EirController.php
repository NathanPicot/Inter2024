<?php

namespace App\Controller;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Process\Exception\ProcessFailedException;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Process\Process;
use Symfony\Component\Filesystem\Filesystem;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;

class EirController extends AbstractController
{
    #[Route('/api/eir', name: 'app_eir_scan')]
    public function index(Request $request): Response
    {
        // // Change this to the path where you downloaded Eir project
        // $eirPath = '/path/to/eir';

        // // Check if Eir directory exists
        // if (!is_dir($eirPath)) {
        //     return $this->json([
        //         'error' => 'Eir directory does not exist.',
        //     ]);
        // }

        // Clone the GitHub repository
        // Clone the GitHub repository
        $credentials = json_decode($request->getContent(), true);

        // Clone the GitHub repository
        $repoUrl = $credentials['repoUrl'];
        $repoPath = sys_get_temp_dir() . '/repo'; // Temporary directory to clone the repository

        // Clone the repository
        $cloneProcess = new Process(['git', 'clone', $repoUrl, $repoPath]);
        $cloneProcess->setTimeout(300); // 5 minutes timeout

        try {
            $cloneProcess->mustRun();
        } catch (ProcessFailedException $exception) {
                     // Delete the cloned repository
                     $filesystem = new Filesystem();
                     $filesystem->remove($repoPath);
         
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

            // Create a downloadable JSON file
            $response = new Response($output);
            $response->headers->set('Content-Type', 'application/json');
            $response->headers->set('Content-Disposition', 'attachment; filename="eir_output.json"');
            return $response;
        } catch (ProcessFailedException $exception) {
            // Handle failed command execution
            return $this->json([
                'error' => 'Failed to run Eir: ' . $exception->getMessage(),
            ]);
        }
    }
}
