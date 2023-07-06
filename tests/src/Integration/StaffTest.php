<?php

declare(strict_types=1);

use App\Tests\Integration\IntegrationTestCase;
use App\Tests\Repository\StaffRepository;
use Doctrine\ORM\EntityManager;


class StaffTest extends IntegrationTestCase
{
    private StaffRepository $staffRepository;

    public function testEntityFromRepoReturnsCorrectValue(): void
    {
        $this->assertSame(
            "Dora",
            $this->staffRepository->find("4")
                ->getName(),
            "An unexpected value was retrieved from a 'staff' entity."
        );
    }

    protected function setUp(): void
    {
        parent::setUp();
        $this->staffRepository = $this->entityManager
            ->getRepository(App\Tests\Entity\Staff::class);
    }

}
