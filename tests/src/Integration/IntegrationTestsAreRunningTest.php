<?php

declare(strict_types=1);

namespace App\Tests\Integration;

final class IntegrationTestsAreRunningTest extends IntegrationTestCase
{
    public function testIntegrationTestRanOkTest(): void
    {
        $this->assertTrue(true, 'integration tests running');
    }
}
