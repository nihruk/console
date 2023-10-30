<?php

declare(strict_types=1);

namespace App\Tests\Web\Init\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class AwardsControllerTest extends WebTestCase
{
    public function testAward(): void
    {
        $client = static::createClient();
        $id = '01/01/01'; // make sure is an id that exists
        $client->request(
            'GET',
            '/api/awards/' . $id,
        );
        $this->assertResponseHeaderSame('Content-Type', 'application/json;charset=UTF-8');
        $response = $client->getResponse();
        $this->assertSame(200, $response->getStatusCode());
        $content = (string)$response->getContent();
        $this->assertJson($content);
        $jsonContent = (object)json_decode($content);
        $this->assertEquals($id, $jsonContent->id);
    }
}
