<?php

declare(strict_types=1);

namespace App\Controller;

use App\Service\ParcelService;
use OpenApi\Attributes as OA;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class ParcelDeleteController extends AbstractController
{
    public function __construct(private ParcelService $parcelService)
    {
    }
    #[OA\Parameter(
        name: 'id',
        description: 'id посылки',
        in: 'query',
        schema: new OA\Schema(type: 'integer')
    )]
    #[OA\Tag(name: 'Parcel')]
    #[Route('/api/parcel', name: 'app_parcel_delete', methods: 'DELETE')]
    public function __invoke(Request $request): JsonResponse
    {
        $parcelId = $request->query->get('id');
        $message = $this->parcelService->deleteParcel($parcelId);

        return $message
            ? $this->json($message)
            : $this->json('Parcel not found', 404);
    }
}
