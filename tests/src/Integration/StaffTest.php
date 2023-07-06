<?php

declare(strict_types=1);

use App\Tests\Entity\Staff;
use App\Tests\Integration\IntegrationTestCase;
use Doctrine\Persistence\ObjectRepository;

//use App\Tests\Repository\ObjectRepository;


class StaffTest extends IntegrationTestCase
{
    private ObjectRepository $staffRepository;

    public function testEntityFromRepoReturnsCorrectValue(): void
    {
        $this->assertSame(
            "Dora",
            $this->staffRepository->find("4")
                ->getName(),
            "An unexpected value was retrieved from a 'staff' entity."
        );
    }

    public function testAddedEntityReturnsCorrectValue(): void
    {
        $name = 'Muttley';
        $occupation = 'sidekick';

        $muttley = new Staff();
        $muttley->setName($name);
        $muttley->setOccupation($occupation);
        $this->entityManager->persist($muttley);
        $this->entityManager->flush();

        $dbMuttley = $this->staffRepository->findOneBy(
            [
                'Name' => $name,
                'Occupation' => $occupation
            ]);

        $this->assertSame(
            $dbMuttley->getName(),
            $muttley->getName(),
            'we were unable to persist an enity and retrieve its values'
        );


    }


    protected function setUp(): void
    {
        parent::setUp();
        $this->staffRepository = $this->entityManager
            ->getRepository(App\Tests\Entity\Staff::class);
    }

}
