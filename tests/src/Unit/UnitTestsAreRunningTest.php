<?php

declare(strict_types=1);

namespace App\Tests\Unit;

use PHPUnit\Framework\TestCase;

final class UnitTestsAreRunningTest extends TestCase
{
    public function testUnitTestRanOkTest(): void
    {
        $this->assertTrue(true, 'unit tests running');
    }
}
