<?php

declare(strict_types=1);

namespace App\Tests\Integration;

use App\Tests\Entity\StaffTest\Staff;
use Doctrine\Persistence\ObjectRepository;

class StaffTest extends IntegrationTestCase
{
    private ObjectRepository $staffRepository;

    /** @psalm-suppress PossiblyNullReference, MixedMethodCall */
    public function testEntityFromRepoReturnsCorrectValue(): void
    {
        /** @var Staff $dora */
        $dora = $this->staffRepository->find('4');

        $this->assertSame(
            'Dora',
            $dora->getName(),
            "An unexpected value was retrieved from a 'staff' entity."
        );
    }

    /** @psalm-suppress PossiblyNullReference, MixedMethodCall */
    public function testAddedEntityReturnsCorrectValue(): void
    {
        $name = 'Muttley';
        $occupation = 'sidekick';

        $muttley = new Staff();
        $muttley->setName($name);
        $muttley->setOccupation($occupation);
        $this->entityManager->persist($muttley); /** @phpstan-ignore-line */
        $this->entityManager->flush(); /** @phpstan-ignore-line */

        /** @var Staff $dbMuttley */
        $dbMuttley = $this->staffRepository->findOneBy(
            [
                'Name' => $name,
                'Occupation' => $occupation
            ]
        );

        $this->assertSame(
            $dbMuttley->getName(),
            $muttley->getName(),
            'we were unable to persist an enity and retrieve its values'
        );
    }

    /** @psalm-suppress PossiblyNullArgument, MixedArgument, PossiblyNullReference  */
    protected function setUp(): void
    {
        parent::setUp();

        #@todo we could throw an exception here if getRepository returns null

        $this->staffRepository = $this->entityManager /** @phpstan-ignore-line */
            ->getRepository(Staff::class);
    }
}
