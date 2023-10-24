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
use Symfony\Component\HttpKernel\Exception\UnprocessableEntityHttpException;
use Symfony\Contracts\HttpClient\Exception\ClientExceptionInterface;
use Symfony\Contracts\HttpClient\Exception\RedirectionExceptionInterface;
use Symfony\Contracts\HttpClient\Exception\ServerExceptionInterface;
use Symfony\Contracts\HttpClient\Exception\TransportExceptionInterface;
use Symfony\Contracts\HttpClient\HttpClientInterface;

/**
 * @psalm-type HitsType = object{data: object{hits: object{hits: list<object>}}}
 */
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
        $json = json_encode($results);
        $json = $json !== false ? (object)json_decode($json) : throw new UnprocessableEntityHttpException('Award Json could not be processed!');
        $this->logger->info('Json type: ' . gettype($json));
        /**
         * @psalm-var HitsType $json
         */
        $hits = $this->justTheHits($json);
        /**
         * @var list<object{_source:object}> $hits
         */
        $res = $this->aggAward($hits);
        $res = json_encode($res);
        $time_end_php = microtime(true);
        $time_php = $time_end_php - $time_start_php;
        $this->logger->info('PHP took: ' . $time_php);

        return (object)json_decode((string)$res);
//        return (object)json_decode($response);
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
                $response->data = $search->asArray();
            else :
                $response->error = ['message' => 'asArray method not found!'];
            endif;
        } catch (ClientResponseException | ServerResponseException $e) {
            $response->error = ['message' => 'Error retrieving search results!'];
        }

        return $response;
    }

    /**
     * @psalm-param HitsType $data
     * @return array<object>
     */
    public function justTheHits(object $data): array
    {
        return $data->data->hits->hits;
    }

    /**
     * @param list<object{_source:object}> $award
     */
    private function aggAward(array $award): object
    {
        return $award[0]->_source;
    }
}
