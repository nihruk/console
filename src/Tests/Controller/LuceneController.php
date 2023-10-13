<?php

declare(strict_types=1);

namespace App\Tests\Controller;

use Psr\Log\LoggerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Contracts\HttpClient\Exception\ClientExceptionInterface;
use Symfony\Contracts\HttpClient\Exception\RedirectionExceptionInterface;
use Symfony\Contracts\HttpClient\Exception\ServerExceptionInterface;
use Symfony\Contracts\HttpClient\Exception\TransportExceptionInterface;
use Symfony\Contracts\HttpClient\HttpClientInterface;

#[Route('/api', name: 'api_')]
class LuceneController extends AbstractController
{
    /**
     * @throws TransportExceptionInterface
     */
    #[Route('/parse/{query}', name: 'luce_index', defaults: ['query' => 'name:foo AND NOT (bio:bar OR bio:baz) AND height:[100 TO 200]'], methods: ['GET'])]
    public function luce(
        HttpClientInterface $httpClient,
        LoggerInterface $logger,
        string $query
    ): Response {
        $response = $httpClient->request('GET', 'http://luceneparser:8081/api/v1/parse/lucene?q=' . $query);
        try {
            $response = $response->getContent();
        } catch (ClientExceptionInterface | RedirectionExceptionInterface | ServerExceptionInterface | TransportExceptionInterface $e) {
        }
        $logger->info((string)json_encode($response));
        return $this->json($response, headers: ['Content-Type' => 'application/json;charset=UTF-8']);
    }

    /**
     * @throws TransportExceptionInterface
     */
    #[Route('/es/{query}', name: 'es_index', defaults: ['query' => ''], methods: ['GET'])]
    public function es(
        HttpClientInterface $httpClient,
        LoggerInterface $logger,
        string $query
    ): Response {
        $response = $httpClient->request(
            'GET',
            'https://elastic:' . $_SERVER['ELASTIC_PASSWORD'] . '@es01:9200/_search?q=' . $query,
            ['verify_peer' => false,]
        );
        try {
            $response = $response->getContent();
        } catch (ClientExceptionInterface | RedirectionExceptionInterface | ServerExceptionInterface | TransportExceptionInterface $e) {
        }
        $logger->info((string)json_encode($response));
        return $this->json($response, headers: ['Content-Type' => 'application/json;charset=UTF-8']);
    }
}
