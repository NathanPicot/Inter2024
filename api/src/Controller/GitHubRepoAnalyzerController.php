<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Process\Exception\ProcessFailedException;
use Symfony\Component\Process\Process;
use Symfony\Component\Filesystem\Filesystem;


class GitHubRepoAnalyzerController extends AbstractController
{
    #[Route('/analyze-github-repo', name: 'analyze_github_repo')]
    public function analyzeGitHubRepo()
    {
      
    }
}
