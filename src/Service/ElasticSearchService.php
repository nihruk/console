<?php

declare(strict_types=1);

namespace App\Service;

use Elastic\Elasticsearch\Client;
use Elastic\Elasticsearch\ClientBuilder;
use Elastic\Elasticsearch\Exception\AuthenticationException;
use Elastic\Elasticsearch\Exception\ClientResponseException;
use Elastic\Elasticsearch\Exception\ServerResponseException;
use Psr\Log\LoggerInterface;
use Symfony\Component\HttpClient\Psr18Client;
use stdClass;
use Symfony\Contracts\HttpClient\Exception\ClientExceptionInterface;
use Symfony\Contracts\HttpClient\Exception\RedirectionExceptionInterface;
use Symfony\Contracts\HttpClient\Exception\ServerExceptionInterface;
use Symfony\Contracts\HttpClient\Exception\TransportExceptionInterface;
use Symfony\Contracts\HttpClient\HttpClientInterface;

class ElasticSearchService
{
    /**
     * @var Client
     */
    private Client $client;

    /**
     * @throws AuthenticationException
     */
    public function __construct(
        private readonly LoggerInterface $logger,
        private readonly HttpClientInterface $httpClient
    ) {
        $hosts = [
            'https://es01:9200',
        ];
        $this->client = ClientBuilder::create()->setHttpClient(new Psr18Client())->setHosts($hosts)->setBasicAuthentication(
            'elastic',
            $_SERVER['ELASTIC_PASSWORD']
        )->setSSLVerification(false)->build();
    }

    /**
     * @throws TransportExceptionInterface
     * @throws ServerExceptionInterface
     * @throws RedirectionExceptionInterface
     * @throws ClientExceptionInterface
     */
    public function getAwardById(string $id): object
    {
        $params = [
            'index' => 'research_awards_v7',
            'body' => [
                'query' => [
                    'query_string' => [
                        'query' => 'identifier=' . json_encode($id)
                    ]
                ]
            ]
        ];
        $this->logger->info((string)json_encode($id));
        $results = $this->getQuery($params);

        $time_start_node = microtime(true);
        $response = $this->httpClient->request('POST', 'http://luceneparser:8081/run', [
            'json' => ['fn' => 'aggAward', 'input' => json_encode($results)],
            'headers' => ['Content-Type' => 'application/json']
        ]);
        $response = $response->getContent();
        $this->logger->info((string)json_encode($response));
        $time_end_node = microtime(true);
        $time_node = $time_end_node - $time_start_node;
        $this->logger->info('Node took: ' . $time_node);


        $time_start_php = microtime(true);
        $resjson = (object)json_decode((string)json_encode($results));
        /**
         * @var object{data: object{hits: object{hits: list<object{_source:object}>}}} $resjson
         */
        $hits = $this->justTheHits($resjson);
        $res = $this->aggAward($hits);
        $res = json_encode($res);
        $time_end_php = microtime(true);
        $time_php = $time_end_php - $time_start_php;
        $this->logger->info('PHP took: ' . $time_php);

//        return (object)json_decode((string)$res);
        return (object)json_decode($response);
    }

    /**
     * @param array<array-key, mixed> $params
     * @return object
     */
    private function getQuery(array $params): object
    {
        $response = new stdClass();
        try {
            /**
             * @psalm-suppress MixedArgumentTypeCoercion
             * https://github.com/elastic/elasticsearch-php/issues/1346
             * similar to original issue but being caught at method argument type level
             */
            $search = $this->client->search($params);
            if (method_exists($search, 'asArray')) :
                $response->data = (object)$search->asArray();
            else :
                $response->error = ['message' => 'asArray method not found!'];
            endif;
        } catch (ClientResponseException | ServerResponseException $e) {
            $response->error = ['message' => 'Error retrieving search results!'];
        }

        return $response;
    }

    /**
     * @param object{data: object{hits: object{hits: list<object{_source:object}>}}} $data
     */
    public function justTheHits(object $data): object
    {
        $hits = $data->data->hits->hits;
        if ($hits) {
            $hits = $hits[0]->_source;
        }
        return (object)$hits;
    }

    private function aggAward(object $award): object
    {
        return $award;
    }
}
