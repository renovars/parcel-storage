<?php

namespace App\Service;

use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\Validator\Validation;

class ValidationService
{
    public function validateParcelData(array $data): string
    {
        $validator = Validation::createValidator();

        $constraints = new Assert\Collection([
            'sender' => $this->getPersonConstraints(),
            'recipient' => $this->getPersonConstraints(),
            'dimensions' => [
                new Assert\Collection([
                    'weight' => [
                        new Assert\NotBlank(),
                        new Assert\Type('integer'),
                    ],
                    'length' => [
                        new Assert\NotBlank(),
                        new Assert\Type('integer'),
                    ],
                    'height' => [
                        new Assert\NotBlank(),
                        new Assert\Type('integer'),
                    ],
                    'width' => [
                        new Assert\NotBlank(),
                        new Assert\Type('integer'),
                    ],
                ]),
            ],
            'estimatedCost' => [
                new Assert\NotBlank(),
                new Assert\Type('integer'),
            ],
        ]);

        $errors = $validator->validate($data, $constraints);

        return $errors->count() > 0 ? 'Validation fail' : 'accepted';
    }

    public function getPersonConstraints(): array
    {
        return [
            new Assert\Collection([
                'fullName' => new Assert\Collection([
                    'firstName' => [
                        new Assert\NotBlank(),
                        new Assert\Type('string'),
                    ],
                    'lastName' => [
                        new Assert\NotBlank(),
                        new Assert\Type('string'),
                    ],
                    'middleName' => [
                        new Assert\NotBlank(),
                        new Assert\Type('string'),
                    ],
                ]),
                'phone' => [
                    new Assert\NotBlank(),
                    new Assert\Type('string'),
                ],
                'address' => new Assert\Collection([
                    'country' => [
                        new Assert\NotBlank(),
                        new Assert\Type('string'),
                    ],
                    'city' => [
                        new Assert\NotBlank(),
                        new Assert\Type('string'),
                    ],
                    'street' => [
                        new Assert\NotBlank(),
                        new Assert\Type('string'),
                    ],
                    'house' => [
                        new Assert\NotBlank(),
                        new Assert\Type('string'),
                    ],
                    'apartment' => [
                        new Assert\NotBlank(),
                        new Assert\Type('string'),
                    ],
                ]),
            ]),
        ];
    }
}
