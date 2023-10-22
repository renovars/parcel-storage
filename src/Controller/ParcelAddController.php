<?php

declare(strict_types=1);

namespace App\Controller;

use App\Service\ParcelService;
use App\Service\ValidationService;
use OpenApi\Attributes as OA;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class ParcelAddController extends AbstractController
{
    public function __construct(private readonly ParcelService $parcelService, private readonly ValidationService $validationService)
    {
    }

    #[OA\Tag(name: 'Parcel')]
    #[OA\RequestBody(
        description: 'Request data example',
        required: true,
        content: new OA\JsonContent(
            properties: [
                new OA\Property(
                    property: 'sender',
                    properties: [
                        new OA\Property(
                            property: 'fullName',
                            properties: [
                                new OA\Property(property: 'firstName', type: 'string'),
                                new OA\Property(property: 'lastName', type: 'string'),
                                new OA\Property(property: 'middleName', type: 'string'),
                            ]
                        ),
                        new OA\Property(property: 'phone', type: 'string'),
                        new OA\Property(
                            property: 'address',
                            properties: [
                                new OA\Property(property: 'country', type: 'string'),
                                new OA\Property(property: 'city', type: 'string'),
                                new OA\Property(property: 'street', type: 'string'),
                                new OA\Property(property: 'house', type: 'string'),
                                new OA\Property(property: 'apartment', type: 'string'),
                            ]
                        ),
                    ]
                ),
                new OA\Property(
                    property: 'recipient',
                    properties: [
                        new OA\Property(
                            property: 'fullName',
                            properties: [
                                new OA\Property(property: 'firstName', type: 'string'),
                                new OA\Property(property: 'lastName', type: 'string'),
                                new OA\Property(property: 'middleName', type: 'string'),
                            ]
                        ),
                        new OA\Property(property: 'phone', type: 'string'),
                        new OA\Property(
                            property: 'address',
                            properties: [
                                new OA\Property(property: 'country', type: 'string'),
                                new OA\Property(property: 'city', type: 'string'),
                                new OA\Property(property: 'street', type: 'string'),
                                new OA\Property(property: 'house', type: 'string'),
                                new OA\Property(property: 'apartment', type: 'string'),
                            ]
                        ),
                    ]
                ),
                new OA\Property(
                    property: 'dimensions',
                    properties: [
                        new OA\Property(property: 'weight', type: 'number'),
                        new OA\Property(property: 'length', type: 'number'),
                        new OA\Property(property: 'height', type: 'number'),
                        new OA\Property(property: 'width', type: 'number'),
                    ]
                ),
                new OA\Property(property: 'estimatedCost', type: 'number'),
            ]
        ),
    )]
    #[OA\Response(
        response: 201,
        description: 'Created'
    )]
    #[OA\Response(
        response: 400,
        description: 'Invalid data'
    )]
    #[Route('/api/parcel', name: 'api_parcel_add', methods: 'POST')]
    public function __invoke(Request $request): JsonResponse
    {
        $parcelService = $this->parcelService;
        $validationService = $this->validationService;
        $requestData = json_decode($request->getContent(), true);

        $validationResult = $validationService->validateParcelData($requestData);

        $parcelService->addParcel($requestData);
        return $validationResult === 'accepted' ? $this->json($request->getPayload(), 201) : $this->json('Invalid data', 400);
    }
}
