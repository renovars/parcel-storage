<?php

namespace App\Tests\UnitTests;

use App\Entity\Parcel;
use App\Entity\Person;
use App\Repository\ParcelRepository;
use App\Repository\PersonRepository;
use App\Service\ParcelService;
use Doctrine\ORM\EntityManagerInterface;
use PHPUnit\Framework\TestCase;

class ParcelServiceTest extends TestCase
{
    private EntityManagerInterface $entityManager;
    private ParcelRepository $parcelRepository;
    private PersonRepository $personRepository;
    private ParcelService $parcelService;

    protected function setUp(): void
    {
        $this->entityManager = $this->createMock(EntityManagerInterface::class);
        $this->parcelRepository = $this->createMock(ParcelRepository::class);
        $this->personRepository = $this->createMock(PersonRepository::class);
        $this->parcelService = new ParcelService($this->entityManager, $this->parcelRepository, $this->personRepository);
    }

    public function testCreateParcel()
    {
        $parcelData = [
            'sender' => [
                'fullName' => [
                    'firstName' => 'Arseniy',
                    'lastName' => 'Sergeevich',
                    'middleName' => 'Novikov',
                ],
                'phone' => '89074751122',
                'address' => [
                    'country' => 'Russia',
                    'city' => 'Moscow',
                    'street' => 'Olonetskaya',
                    'house' => '15',
                    'apartment' => '1',
                ],
            ],
            'recipient' => [
                'fullName' => [
                    'firstName' => 'Sergey',
                    'lastName' => 'Valentinovich',
                    'middleName' => 'Solovyev',
                ],
                'phone' => '89265536221',
                'address' => [
                    'country' => 'Ukraine',
                    'city' => 'Kiev',
                    'street' => 'Svetlaya',
                    'house' => '10',
                    'apartment' => '1',
                ],
            ],
            'dimensions' => [
                'weight' => 1,
                'length' => 1,
                'height' => 1,
                'width' => 5,
            ],
            'estimatedCost' => 500,
        ];

        $parcel = $this->parcelService->addParcel($parcelData);

        $this->assertInstanceOf(Parcel::class, $parcel);
        $this->assertInstanceOf(Person::class, $parcel->getSender());
        $this->assertInstanceOf(Person::class, $parcel->getRecipient());
        $this->assertEquals($parcelData['estimatedCost'], $parcel->getEstimatedCost());
    }

}
