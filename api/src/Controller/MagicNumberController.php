<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Process\Exception\ProcessFailedException;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Process\Process;
use Symfony\Component\Filesystem\Filesystem;

class MagicNumberController extends AbstractController
{
    #[Route('/magic-number-scan', name: 'app_magic_number_scan')]
    public function index(): JsonResponse
    { // Clone the GitHub repository
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

        // Install phpmnd
        $installProcess = new Process(['composer', 'require', '--dev', 'povils/phpmnd']);
        $installProcess->setWorkingDirectory($repoPath);
        $installProcess->setTimeout(300); // 5 minutes timeout

        try {
            $installProcess->mustRun();
        } catch (ProcessFailedException $exception) {
            return $this->json([
                'error' => 'Failed to install phpmnd: ' . $exception->getMessage(),
            ]);
        }

        // Run phpmnd
        $phpmndProcess = new Process([
            'vendor/bin/phpmnd',
            '--xml-output',
            'report.xml',
            '.',
        ]);
        $phpmndProcess->setWorkingDirectory($repoPath);
        $phpmndProcess->setTimeout(300); // 5 minutes timeout

        try {
            $phpmndProcess->mustRun();
        } catch (ProcessFailedException $exception) {
            return $this->json([
                'error' => 'Failed to run phpmnd: ' . $exception->getMessage(),
            ]);
        }

        // Parse XML report and extract results
        $reportPath = $repoPath . '/report.xml';
        $results = []; // Initialize results array

        if (file_exists($reportPath)) {
            $xml = simplexml_load_file($reportPath);
            foreach ($xml->file as $file) {
                $fileName = (string) $file['name'];
                $violations = [];
                foreach ($file->error as $error) {
                    $violations[] = (string) $error['line'];
                }
                $results[$fileName] = $violations;
            }
        } else {
            return $this->json([
                'error' => 'Report file not found.',
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

        // Check if magic numbers were found
        if (empty($results)) {
            return $this->json(['message' => 'No magic numbers found.']);
        }

        // Return results
        return $this->json($results);
    }
    }

