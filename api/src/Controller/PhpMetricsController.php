<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Process\Exception\ProcessFailedException;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Process\Process;
use Symfony\Component\Filesystem\Filesystem;

class PhpMetricsController extends AbstractController
{
    #[Route('/phpmetrics', name: 'app_phpmetrics')]
    public function index(): JsonResponse
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

        // Install phpmetrics
        $installProcess = new Process(['composer', 'require', '--dev', 'phpmetrics/phpmetrics']);
        $installProcess->setWorkingDirectory($repoPath);
        $installProcess->setTimeout(300); // 5 minutes timeout

        try {
            $installProcess->mustRun();
        } catch (ProcessFailedException $exception) {
            return $this->json([
                'error' => 'Failed to install phpmetrics: ' . $exception->getMessage(),
            ]);
        }

        // Run phpmetrics
        $phpmetricsProcess = new Process([
            'vendor/bin/phpmetrics',
            '--report-json=metrics.json',
            '.',
        ]);
        $phpmetricsProcess->setWorkingDirectory($repoPath);
        $phpmetricsProcess->setTimeout(300); // 5 minutes timeout

        try {
            $phpmetricsProcess->mustRun();
        } catch (ProcessFailedException $exception) {
            return $this->json([
                'error' => 'Failed to run phpmetrics: ' . $exception->getMessage(),
            ]);
        }

        // Read metrics from JSON report
        $metricsPath = $repoPath . '/metrics.json';

        if (file_exists($metricsPath)) {
            $metricsJson = file_get_contents($metricsPath);
            $metrics = json_decode($metricsJson, true);
        } else {
            return $this->json([
                'error' => 'Metrics file not found.',
            ]);
        }

        // Delete the cloned repository
        $filesystem = new Filesystem();
        try {
            $filesystem->remove($repoPath);
        } catch (\Exception $e) {
            // Handle exception
        }

        // Check if metrics were found
        if (empty($metrics)) {
            return $this->json(['message' => 'No metrics found.']);
        }

        // Return metrics
        return $this->json($metrics);
    }
}
