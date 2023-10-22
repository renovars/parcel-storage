<?php

namespace App\Entity;

use App\Repository\ParcelRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;

#[ORM\Entity(repositoryClass: ParcelRepository::class)]
class Parcel
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    #[Groups(['parcel'])]
    private ?int $id = null;

    #[ORM\ManyToOne(cascade: ['persist', 'remove'], inversedBy: 'parcels')]
    #[ORM\JoinColumn(nullable: false)]
    #[Groups(['parcel'])]
    private ?Person $sender = null;

    #[ORM\ManyToOne(cascade: ['persist', 'remove'], inversedBy: 'parcels')]
    #[ORM\JoinColumn(nullable: false)]
    #[Groups(['parcel'])]
    private ?Person $recipient = null;

    #[ORM\Column]
    #[Groups(['parcel'])]
    private ?string $senderAddress = null;

    #[ORM\Column]
    #[Groups(['parcel'])]
    private ?string $recipientAddress = null;

    #[ORM\Column]
    #[Groups(['parcel'])]
    private array $dimensions = [];

    #[ORM\Column]
    #[Groups(['parcel'])]
    private ?int $estimatedCost = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getSender(): ?Person
    {
        return $this->sender;
    }

    public function setSender(?Person $sender): static
    {
        $this->sender = $sender;

        return $this;
    }

    public function getRecipient(): ?Person
    {
        return $this->recipient;
    }

    public function setRecipient(?Person $recipient): static
    {
        $this->recipient = $recipient;

        return $this;
    }

    public function getDimensions(): array
    {
        return $this->dimensions;
    }

    public function setDimensions(array $dimensions): static
    {
        $this->dimensions = $dimensions;

        return $this;
    }

    public function getEstimatedCost(): ?int
    {
        return $this->estimatedCost;
    }

    public function setEstimatedCost(int $estimatedCost): static
    {
        $this->estimatedCost = $estimatedCost;

        return $this;
    }

    public function getSenderAddress(): ?string
    {
        return $this->senderAddress;
    }

    public function setSenderAddress(string $senderAddress): static
    {
        $this->senderAddress = $senderAddress;

        return $this;
    }

    public function getRecipientAddress(): ?string
    {
        return $this->recipientAddress;
    }

    public function setRecipientAddress(string $recipientAddress): static
    {
        $this->recipientAddress = $recipientAddress;

        return $this;
    }
}
