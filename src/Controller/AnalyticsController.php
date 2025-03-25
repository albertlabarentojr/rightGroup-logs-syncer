<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

final class AnalyticsController extends AbstractController{
    #[Route('/count', name: 'analytics.count', methods: ['GET'])]
    public function count(): Response
    {
        return $this->json([
            'success' => true,
        ]);
    }
}
