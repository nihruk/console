<?php

declare(strict_types=1);

namespace App\Tests\Web\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class ContentNegotiationControllerTest extends WebTestCase
{
    public function testJsonResponse(): void
    {
        $client = static::createClient();
        $client->request(
            'GET',
            '/api/pirates',
            [],
            [],
            [
                'HTTP_ACCEPT' => 'application/json'
            ]
        );
        $this->assertResponseIsSuccessful();
        $this->assertResponseHeaderSame('Content-Type', 'application/json');
    }

    public function testMismatchResponse(): void
    {
        $client = static::createClient();
        $client->request(
            'GET',
            '/api/pirates/text',
            [],
            [],
            [
                'HTTP_ACCEPT' => 'application/json'
            ]
        );
        $response = $client->getResponse();
        $this->assertSame(406, $response->getStatusCode());
        $this->assertResponseHeaderSame('Content-Type', 'application/json');
    }

    public function testUnsupportedHeader(): void
    {
        $client = static::createClient();
        $client->request(
            'GET',
            '/api/pirates',
            [],
            [],
            [
                'HTTP_ACCEPT' => 'text/html'
            ]
        );
        $response = $client->getResponse();
        $this->assertResponseHeaderNotSame('Content-Type', 'text/html');
        $this->assertResponseHeaderSame('Content-Type', 'application/json');
        $this->assertSame(406, $response->getStatusCode());
        $this->assertJson((string)$response->getContent());
    }

    public function testNonExistentRoute(): void
    {
        $client = static::createClient();
        $client->request(
            'GET',
            '/non/non/heinous',
            [],
            [],
            [
                'HTTP_ACCEPT' => 'application/json'
            ]
        );
        $response = $client->getResponse();
        $this->assertResponseHeaderSame('Content-Type', 'application/json');
        $this->assertSame(404, $response->getStatusCode());
        $this->assertJson((string)$response->getContent());
    }

    public function testFiveHundred(): void
    {
        $client = static::createClient();
        $client->request(
            'POST',
            '/api/five-hundred',
            [],
            [],
            [
                'HTTP_ACCEPT' => 'application/json'
            ]
        );
        $response = $client->getResponse();
        $this->assertResponseHeaderSame('Content-Type', 'application/json');
        $this->assertSame(500, $response->getStatusCode());
        $this->assertJson((string)$response->getContent());
    }
}
