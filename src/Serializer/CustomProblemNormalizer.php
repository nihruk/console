<?php

namespace App\Serializer;

use Symfony\Component\ErrorHandler\Exception\FlattenException;
use Symfony\Component\Serializer\Normalizer\NormalizerInterface;

class CustomProblemNormalizer implements NormalizerInterface
{
    /**
     * @param array<array-key, mixed> $context
     * @return array<string, array<string, mixed>|string>
     */
    public function normalize($object, string $format = null, array $context = []): array
    {
        // $message =  $object->getMessage();
        // $code = $object->getStatusCode();
        $message =  "";
        $code = "";
        return [
            'content' => 'This is my custom problem normalizer.',
            'exception' => [
                'message' => $message,
                'code' => $code,
            ],
        ];
    }

    /**
     * @param array<int, string> $context
     */
    public function supportsNormalization($data, string $format = null, array $context = []): bool
    {
        return $data instanceof FlattenException;
    }
}
