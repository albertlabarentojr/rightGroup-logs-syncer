<?php

namespace App\Controller;

use App\Repository\ServiceLogRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

final class AnalyticsController extends AbstractController {

    public function __construct(private readonly ServiceLogRepository $serviceLogRepository)
    {
    }

    #[Route('/home', name: 'analytics.index', methods: ['GET'])]
    public function index(): Response
    {
        return $this->render('analytics/index.html.twig', [
            'name' => 'John Doe', // Pass variables to the template
        ]);
    }

    #[Route('/count', name: 'analytics.count', methods: ['GET'])]
    public function count(): Response
    {
        return $this->json([
            'count' => $this->serviceLogRepository->count(),
        ]);
    }
}
