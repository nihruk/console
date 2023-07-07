<?php

declare(strict_types=1);

namespace App\Tests\Integration;

use Doctrine\ORM\EntityManager;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

abstract class IntegrationTestCase extends WebTestCase
{
    protected ?EntityManager $entityManager;

    #@todo we could throw an exception here if this returns null

    /** @psalm-suppress  PossiblyNullReference, MixedMethodCall */
    protected function setUp(): void
    {
        $kernel = self::bootKernel();

        /** @var EntityManager $entityManager */
        $entityManager = $kernel->getContainer()/** @phpstan-ignore-line */
        ->get('doctrine')
            ->getManager();

        $this->entityManager = $entityManager;
    }

    /** @psalm-suppress  PossiblyNullReference */
    protected function tearDown(): void
    {
        parent::tearDown();

        // free up memory
        $this->entityManager->close(); /** @phpstan-ignore-line */
        $this->entityManager = null;
    }
}
