<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Process\Exception\ProcessFailedException;
use Symfony\Component\Process\Process;
use Symfony\Component\Filesystem\Filesystem;

class CodeSnifferController extends AbstractController
{
    #[Route('/run-phpcs', name: 'run_phpcs')]
    public function runPHPCS(): JsonResponse
    {
        // Clone the GitHub repository
        $repoUrl = 'https://github.com/Alex101111/NUH-Backend-PHP.git'; // Replace with the URL of the GitHub repository
        $repoPath = sys_get_temp_dir() . '/repo'; // Temporary directory to clone the repository
        putenv('GIT_SSL_NO_VERIFY=true');
        $cloneProcess = new Process(['git', 'clone', $repoUrl, $repoPath]);
        $cloneProcess->setTimeout(300); // 5 minutes timeout

        try {
            $cloneProcess->mustRun();
        } catch (ProcessFailedException $exception) {
            return $this->json([
                'error' => 'Failed to clone the GitHub repository: ' . $exception->getMessage(),
            ]);
        }

        // Run PHP_CodeSniffer on the repository with PSR-12 standard
        $phpcsProcess = new Process(['phpcs', '--standard=PSR12', $repoPath]);
        $phpcsProcess->setTimeout(300); // 5 minutes timeout

        try {
            $phpcsProcess->mustRun();
            $phpcsOutput = $phpcsProcess->getOutput();
        } catch (ProcessFailedException $exception) {
            return $this->json([
                'error' => 'PHP_CodeSniffer failed: ' . $exception->getMessage(),
            ]);
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


        // Return PHP_CodeSniffer output
        return $this->json([
            'phpcs_output' => $phpcsOutput,
        ]);
    }
}
