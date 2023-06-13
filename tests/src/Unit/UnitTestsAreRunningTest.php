<?php

namespace App\Tests\Unit;

use PHPUnit\Framework\TestCase;

final class UnitTestsAreRunningTest extends TestCase
{
    public function testUnitTestRanOkTest(): void
    {
        $this->assertTrue(true, 'unit tests running');
    }
}
