<?php

declare(strict_types=1);

namespace App\Tests\Integration\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class LuceneControllerTest extends WebTestCase
{
    public function testElastic(): void
    {
        $client = static::createClient();
        $client->request(
            'GET',
            '/api/es/centre:CCF',
        );
        $this->assertResponseIsSuccessful();
        $this->assertResponseHeaderSame('Content-Type', 'application/json');
        $response = $client->getResponse();
        $this->assertJson((string)$response->getContent());
    }
}
