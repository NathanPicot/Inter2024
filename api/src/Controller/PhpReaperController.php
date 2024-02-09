<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Process\Exception\ProcessFailedException;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Process\Process;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Filesystem\Filesystem;
use Symfony\Component\HttpFoundation\Response;

class PhpReaperController extends AbstractController
{
    #[Route('/api/php-reaper', name: 'app_php_reaper', methods: ['POST'])]
    public function index(Request $request): Response
    {
        $credentials = json_decode($request->getContent(), true);

        // Clone the GitHub repository
        $repoUrl = $credentials['repoUrl']; // Replace with the URL of the GitHub repository
        $repoPath = sys_get_temp_dir() . '/repo'; // Temporary directory to clone the repository
        putenv('GIT_SSL_NO_VERIFY=true');
        $cloneProcess = new Process(['git', 'clone', $repoUrl, $repoPath]);
        $cloneProcess->setTimeout(300); // 5 minutes timeout
        $cloneProcess->mustRun();

        // Check if cloning was successful
        if (!$cloneProcess->isSuccessful()) {
            return $this->json([
                'error' =>  'Failed to clone the GitHub repository ' ,
            ]);
        }

        // Iterate over PHP files in the repository
        $phpFiles = [];
        $finder = new \Symfony\Component\Finder\Finder();
        $finder->files()->in($repoPath)->name('*.php');
        foreach ($finder as $file) {
            // Execute commands on each PHP file
            $command = ['php', 'php-reaper', '-d', $file->getRealPath()]; // Change to file path, not repo path
            $process = new Process($command);
            $process->setTimeout(60); // 1 minute timeout

            try {
                $process->mustRun();
                $phpFiles[$file->getRelativePathname()] = $process->getOutput();
            } catch (ProcessFailedException $exception) {
                // Handle failed command execution
                $phpFiles[$file->getRelativePathname()] = 'Error: ' . $exception->getMessage();
            }
        }

// Delete the cloned repository

// Replace forward slashes with backslashes in the repo path
$repoPath = str_replace('/', '\\', $repoPath);

// Delete the cloned repository
$filesystem = new Filesystem();
try {
    $filesystem->remove($repoPath);
} catch (\Exception $e) {
    // Handle exception
}
              // Convert the multidimensional array to a JSON string
              $jsonOutput = json_encode($phpFiles);


                    // Create a downloadable JSON file
                    $response = new Response($jsonOutput);
                    $response->headers->set('Content-Type', 'application/json');
                    $response->headers->set('Content-Disposition', 'attachment; filename="eir_output.json"');
        
                    return $response;

    }
}