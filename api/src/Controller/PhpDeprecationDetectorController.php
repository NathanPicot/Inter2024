<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Process\Exception\ProcessFailedException;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Process\Process;
use Symfony\Component\Filesystem\Filesystem;

class PhpDeprecationDetectorController extends AbstractController
{
    #[Route('/php/deprecation-detector', name: 'app_php_deprecation_detector')]
    public function index(): JsonResponse
    {
        // Clone the GitHub repository
        $repoUrl = 'https://github.com/Alex101111/NUH-frontend-vujs.git'; // Replace with the URL of the GitHub repository
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
        $cloneProcess->setWorkingDirectory($repoPath);
        // // Create an empty JSON file in the cloned repository
        // $reportPath = $repoPath . '/report.json';
        // $filesystem = new Filesystem();
        // try {
        //     $filesystem->dumpFile($reportPath, '{}'); // Create an empty JSON object
        // } catch (\Exception $e) {
        //     return $this->json([
        //         'error' => 'Failed to create the report file in the cloned repository: ' . $e->getMessage(),
        //     ]);
        // }

        // Run PhpDeprecationDetector
        $phpDeprecationDetectorProcess = new Process([
            'phpdd',
            realpath($repoPath)
        ]);
        $phpDeprecationDetectorProcess->setTimeout(300); // 5 minutes timeout

        try {
            $phpDeprecationDetectorProcess->mustRun();
        } catch (ProcessFailedException $exception) {
                // Delete the cloned repository
        $filesystem = new Filesystem();
        try {
            $filesystem->remove($repoPath);
        } catch (\Exception $e) {
            // Handle exception
        }
            return $this->json([
                'error' => 'Failed to run PhpDeprecationDetector: ' . $exception->getMessage(),
            ]);
        }

        //

        // Delete the cloned repository
        $filesystem = new Filesystem();
        try {
            $filesystem->remove($repoPath);
        } catch (\Exception $e) {
            // Handle exception
        }

  // Check if results are empty
if (empty($phpDeprecationDetectorProcess->getOutput())) {
    // Return custom message if no deprecated dependencies were detected
    return $this->json(['message' => 'No deprecated dependencies have been detected.']);
} else {
    // Return results
    return $this->json($phpDeprecationDetectorProcess->getOutput());
}
    }
}
