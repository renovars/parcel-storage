<?php

namespace App\Service;

use App\Entity\Parcel;
use App\Entity\Person;
use App\Repository\ParcelRepository;
use App\Repository\PersonRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\InputBag;

class ParcelService
{
    public function __construct(
        private readonly EntityManagerInterface $entityManager,
        private readonly ParcelRepository $parcelRepository,
        private readonly PersonRepository $personRepository
    ) {
    }

    public function addParcel(array $parcelData): Parcel
    {
        $sender = new Person();
        $sender->setFullName(
            $parcelData['sender']['fullName']['firstName'] . ' ' .
            $parcelData['sender']['fullName']['lastName'] . ' ' .
            $parcelData['sender']['fullName']['middleName']
        );
        $sender->setPhone($parcelData['sender']['phone']);

        $recipient = new Person();
        $recipient->setFullName(
            $parcelData['recipient']['fullName']['firstName'] . ' ' .
            $parcelData['recipient']['fullName']['lastName'] . ' ' .
            $parcelData['recipient']['fullName']['middleName']
        );
        $recipient->setPhone($parcelData['recipient']['phone']);

        $dimensions = [
            $parcelData['dimensions']['weight'],
            $parcelData['dimensions']['length'],
            $parcelData['dimensions']['height'],
            $parcelData['dimensions']['width'],
        ];

        $estimatedCost    = $parcelData['estimatedCost'];
        $senderAddress    = json_encode($parcelData['sender']['address']);
        $recipientAddress = json_encode($parcelData['recipient']['address']);

        $parcel = new Parcel();
        $parcel
            ->setSender($sender)
            ->setRecipient($recipient)
            ->setDimensions($dimensions)
            ->setEstimatedCost($estimatedCost)
            ->setSenderAddress($senderAddress)
            ->setRecipientAddress($recipientAddress);

        $this->entityManager->persist($parcel);
        $this->entityManager->flush();

        return $parcel;
    }

    public function search(InputBag $query): ?array
    {
        $searchType = $query->get('searchType');
        $q = $query->get('q');

        if (!empty($searchType) && !empty($query)) {
            if ($searchType === "sender_phone") {
                $sender = $this->personRepository->findOneBy(['phone' => $q]);
                $parcels = $this->parcelRepository->findBy(['sender' => $sender->getId()]);
            } else {
                $recipients = $this->personRepository->findBy(['fullName' => $q]);
                foreach ($recipients as $recipient) {
                    $parcels[] = $this->parcelRepository->findBy(['recipient' => $recipient->getId()]);
                }
            }
        }
        return $parcels ?? null;
    }

    public function deleteParcel(string $id): ?string
    {
        $parcel = $this->parcelRepository->findOneBy(['id' => $id]);
        if ($parcel) {
            $this->entityManager->remove($parcel);
            $this->entityManager->flush();
            return 'success';
        }
        return null;
    }
}
