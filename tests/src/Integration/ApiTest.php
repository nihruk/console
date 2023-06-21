<?php

declare(strict_types=1);

namespace src\Integration;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class ApiTest extends WebTestCase
{
    public function testOpenApi(): void
    {
        $client = static::createClient();
        $client->request(
            'GET',
            '/api/doc.json',
        );
        $this->assertResponseIsSuccessful();
        $this->assertResponseHeaderSame('Content-Type', 'application/json');
        $response = $client->getResponse();
        $this->assertJson((string)$response->getContent());
        $data = (array)json_decode((string)$response->getContent(), true);
        $this->assertArrayHasKey('openapi', $data);
    }
}
