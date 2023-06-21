<?php

declare(strict_types=1);

namespace src\Unit;

use PHPUnit\Framework\TestCase;

class UnitTestsAreRunningTest extends TestCase
{
    public function testUnitTestRanOkTest(): void
    {
        $this->assertTrue(true, 'unit tests running');
    }
}
