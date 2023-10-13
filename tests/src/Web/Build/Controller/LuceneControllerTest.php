<?php

declare(strict_types=1);

namespace App\Tests\Web\Build\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class LuceneControllerTest extends WebTestCase
{
    public function testLuceneParser(): void
    {
        $test_file = (string)file_get_contents('/srv/ioda/tests/config/testLuceneParser.json');
        $test_data = (array)json_decode($test_file, true);
        $test_query = is_string($test_data['query']) ? $test_data['query'] : '';
        $test_response = is_string($test_data['response']) ? $test_data['response'] : '';
        $client = static::createClient();
        $client->request(
            'GET',
            '/api/parse/' . $test_query,
        );
        $this->assertResponseIsSuccessful();
        $this->assertResponseHeaderSame('Content-Type', 'application/json;charset=UTF-8');
        $response = $client->getResponse();
        $this->assertJson((string)$response->getContent());
        $this->assertJsonStringEqualsJsonString(
            (string)json_encode($test_response),
            (string)$response->getContent()
        );
    }

    public function testElastic(): void
    {
        $client = static::createClient();
        $client->request(
            'GET',
            '/api/es/centre:CCF',
        );
        $this->assertResponseIsSuccessful();
        $this->assertResponseHeaderSame('Content-Type', 'application/json;charset=UTF-8');
        $response = $client->getResponse();
        $this->assertJson((string)$response->getContent());
    }
}
