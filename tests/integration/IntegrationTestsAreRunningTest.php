<?php

namespace App\Tests\Integration;

use PHPUnit\Framework\TestCase;

class IntegrationTestsAreRunningTest extends TestCase
{
    public function testIntegrationTestRanOk(): void
    {
        $this->assertTrue(true,'integration tests running');
    }
}
