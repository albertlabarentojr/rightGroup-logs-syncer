<?php

namespace App\Controller\ServiceLog;

use App\Repository\Data\PaginationData;
use App\Repository\ServiceLog\ServiceLogFilter;
use App\Repository\ServiceLog\ServiceLogRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

final class ServiceLogController extends AbstractController
{
    public function __construct(private readonly ServiceLogRepository $serviceLogRepository)
    {
    }

    #[Route('/api/service_logs', name: 'service_log.list', methods: ['GET'])]
    public function list(Request $request): Response
    {
        return new JsonResponse(
            $this->serviceLogRepository->paginated(
                filter: ServiceLogFilter::fromRequest($request->query->all()),
                paginationData: PaginationData::fromRequest($request),
            )->toArray()
        );
    }

    #[Route('/api/service_logs/{serviceLogId}', name: 'service_log.delete', methods: ['DELETE'])]
    public function delete(int $serviceLogId): Response
    {
        $this->serviceLogRepository->delete(id: $serviceLogId);

        return new Response(null, Response::HTTP_NO_CONTENT);
    }
}
