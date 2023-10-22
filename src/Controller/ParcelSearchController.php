<?php

declare(strict_types=1);

namespace App\Controller;

use App\Dto\ParcelDto;
use App\Service\ParcelService;
use Nelmio\ApiDocBundle\Annotation\Model;
use OpenApi\Attributes as OA;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class ParcelSearchController extends AbstractController
{
    public function __construct(private readonly ParcelService $parcelService)
    {
    }
    #[OA\Response(
        response: 200,
        description: 'Returns the rewards of an user',
        content: new OA\JsonContent(
            type: 'array',
            items: new OA\Items(ref: new Model(type: ParcelDto::class, groups: ['full']))
        )
    )]
    #[OA\Response(
        response: 204,
        description: 'No content'
    )]
    #[OA\Parameter(
        name: 'searchType',
        description: 'Поле используется для определения типа поиска. Допустимые значения sender_phone и receiver_fullname',
        in: 'query',
        schema: new OA\Schema(type: 'string')
    )]
    #[OA\Parameter(
        name: 'q',
        description: 'Поле используется для поиска по заданному значению',
        in: 'query',
        schema: new OA\Schema(type: 'string')
    )]
    #[OA\Tag(name: 'Parcel')]
    #[Route('/api/parcel', name: 'app_parcel_search', methods: 'GET')]
    public function __invoke(Request $request): JsonResponse
    {
        $parcels = $this->parcelService->search($request->query);
        return $parcels
            ? $this->json($parcels, 200, [], ['groups' => 'parcel','person'])
            : $this->json([], 204);
    }
}
