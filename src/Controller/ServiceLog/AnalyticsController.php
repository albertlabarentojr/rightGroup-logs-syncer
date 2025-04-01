<?php

namespace App\Controller\ServiceLog;

use App\Repository\ServiceLog\ServiceLogFilter;
use App\Repository\ServiceLog\ServiceLogRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

final class AnalyticsController extends AbstractController {

    public function __construct(private readonly ServiceLogRepository $serviceLogRepository)
    {
    }

    #[Route('/dashboard', name: 'service_log.analytics.dashboard', methods: ['GET'])]
    public function index(): Response
    {
        return $this->render('analytics/dashboard.html.twig');
    }

    #[Route('/api/count', name: 'service_log.analytics.count', methods: ['GET'])]
    public function count(Request $request): Response
    {
        return $this->json([
            'count' => $this->serviceLogRepository->total(ServiceLogFilter::fromRequest($request->query->all())),
        ]);
    }
}
