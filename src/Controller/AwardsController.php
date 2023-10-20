<?php

declare(strict_types=1);

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use OpenApi\Attributes as OA;
use Symfony\Component\Routing\Annotation\Route;
use App\Service\ElasticSearchService;
use Psr\Log\LoggerInterface;
use Symfony\Contracts\HttpClient\Exception\ClientExceptionInterface;
use Symfony\Contracts\HttpClient\Exception\RedirectionExceptionInterface;
use Symfony\Contracts\HttpClient\Exception\ServerExceptionInterface;
use Symfony\Contracts\HttpClient\Exception\TransportExceptionInterface;

#[Route('/api', name: 'api_')]
class AwardsController extends AbstractController
{
    /**
     * @throws TransportExceptionInterface
     * @throws ServerExceptionInterface
     * @throws RedirectionExceptionInterface
     * @throws ClientExceptionInterface
     */
    #[Route('/awards/{awardId}', name: 'award_get', requirements: ['awardId' => '.+'], methods: ['GET'])]
    #[OA\Response(response: 200, description: 'An award.', content: new OA\JsonContent(properties: [
        new OA\Property(property: 'id', type: 'string'),
        new OA\Property(property: 'title', type: 'string'),
        new OA\Property(property: 'start', type: 'string', example: '2023-10-17'),
        new OA\Property(property: 'end', type: 'string', example: '2023-10-17'),
        new OA\Property(property: 'funding', type: 'integer', example: 1),
        new OA\Property(property: 'website', type: 'string'),
        new OA\Property(property: 'manager', type: 'string'),
        new OA\Property(property: 'call', type: 'string'),
        new OA\Property(property: 'programme', type: 'string'),
        new OA\Property(property: 'contractor', type: 'string'),
        new OA\Property(property: 'isrctn', type: 'string', example: 'ISRCTN27206209'),
        new OA\Property(property: 'prospero', type: 'string'),
        new OA\Property(
            property: 'resources',
            type: 'array',
            items: new OA\Items(type: 'string')
        ),
        new OA\Property(
            property: 'people',
            type: 'array',
            items: new OA\Items(
            // your list item
                properties: [
                    new OA\Property(
                        property: 'person',
                        type: 'string'
                    ),
                    new OA\Property(
                        property: 'role',
                        type: 'string',
                        example: 'lead_applicant'
                    ),
                    new OA\Property(
                        property: 'credit',
                        type: 'array',
                        items: new OA\Items(type: 'string', example: 'conceptualisation')
                    )
                ],
                type: 'object'
            ),
        ),
    ], type: 'object'))]
    #[OA\Response(response: 400, description: 'An HTTP 400 Bad Request error.', content: new OA\JsonContent(properties: [
        new OA\Property(property: 'message', type: 'string'),
        new OA\Property(property: 'http', properties: [
            new OA\Property(property: 'status', type: 'string', example: '400'),
            new OA\Property(property: 'message', type: 'string'),
        ], type: 'object'),
    ], type: 'object'))]
    #[OA\Response(response: 404, description: 'An HTTP 404 Not Found error.', content: new OA\JsonContent(properties: [
        new OA\Property(property: 'message', type: 'string'),
        new OA\Property(property: 'http', properties: [
            new OA\Property(property: 'status', type: 'string', example: '404'),
            new OA\Property(property: 'message', type: 'string'),
        ], type: 'object'),
    ], type: 'object'))]
    #[OA\Response(response: 405, description: 'An HTTP 405 Method Not Allowed error.', content: new OA\JsonContent(properties: [
        new OA\Property(property: 'message', type: 'string'),
        new OA\Property(property: 'http', properties: [
            new OA\Property(property: 'status', type: 'string', example: '405'),
            new OA\Property(property: 'message', type: 'string'),
        ], type: 'object'),
    ], type: 'object'))]
    #[OA\Response(response: 406, description: 'An HTTP 406 Not Acceptable error.', content: new OA\JsonContent(properties: [
        new OA\Property(property: 'message', type: 'string'),
        new OA\Property(property: 'http', properties: [
            new OA\Property(property: 'status', type: 'string', example: '406'),
            new OA\Property(property: 'message', type: 'string'),
        ], type: 'object'),
    ], type: 'object'))]
    #[OA\Response(response: 415, description: 'An HTTP 415 Unsupported Media Type error.', content: new OA\JsonContent(properties: [
        new OA\Property(property: 'message', type: 'string'),
        new OA\Property(property: 'http', properties: [
            new OA\Property(property: 'status', type: 'string', example: '415'),
            new OA\Property(property: 'message', type: 'string'),
        ], type: 'object'),
    ], type: 'object'))]
    #[OA\Response(response: 500, description: 'An HTTP 500 Internal Server Error error.', content: new OA\JsonContent(properties: [
        new OA\Property(property: 'message', type: 'string'),
        new OA\Property(property: 'http', properties: [
            new OA\Property(property: 'status', type: 'string', example: '500'),
            new OA\Property(property: 'message', type: 'string'),
        ], type: 'object'),
    ], type: 'object'))]
    #[OA\Response(response: 502, description: 'An HTTP 502 Bad Gateway error.', content: new OA\JsonContent(properties: [
        new OA\Property(property: 'message', type: 'string'),
        new OA\Property(property: 'http', properties: [
            new OA\Property(property: 'status', type: 'string', example: '502'),
            new OA\Property(property: 'message', type: 'string'),
        ], type: 'object'),
    ], type: 'object'))]
    #[OA\Response(response: 503, description: 'An HTTP 503 Service Unavailable error.', content: new OA\JsonContent(properties: [
        new OA\Property(property: 'message', type: 'string'),
        new OA\Property(property: 'http', properties: [
            new OA\Property(property: 'status', type: 'string', example: '503'),
            new OA\Property(property: 'message', type: 'string'),
        ], type: 'object'),
    ], type: 'object'))]
    #[OA\Response(response: 504, description: 'An HTTP 504 Gateway Timeout error.', content: new OA\JsonContent(properties: [
        new OA\Property(property: 'message', type: 'string'),
        new OA\Property(property: 'http', properties: [
            new OA\Property(property: 'status', type: 'string', example: '504'),
            new OA\Property(property: 'message', type: 'string'),
        ], type: 'object'),
    ], type: 'object'))]
    public function get(
        ElasticSearchService $elasticSearch,
        LoggerInterface $logger,
        string $awardId
    ): Response {
        $logger->info($awardId);
        $response = $elasticSearch->getAwardById($awardId);
        return $this->json($response, headers: ['Content-Type' => 'application/json;charset=UTF-8']);
    }
}
