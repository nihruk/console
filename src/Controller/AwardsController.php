<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Component\HttpFoundation\Request;
use App\Entity\Awards;

#[Route('/api', name: 'api_')]
class AwardsController extends AbstractController
{

    #[Route('/awards', name: 'award_list', methods: 'get')]
    public function list(ManagerRegistry $registry): JsonResponse
    {
        $awards = $registry->getRepository(Awards::class)->findAll();

        $awardsData = array();
        foreach ($awards as $award):
            $awardsData[] = $this->getAwardData($award);
        endforeach;

        return $this->json($awardsData, headers: ['Content-Type' => 'application/json;charset=UTF-8']);
    }

    #[Route('/awards/{id}', name: 'award_get', methods: 'get')]
    public function get(ManagerRegistry $registry, int $id): JsonResponse
    {
        $award = $registry->getRepository(Awards::class)->find($id);

        if (!$award):
            return $this->json('No award found for id '.$id, 404);
        endif;

        $awardData = $this->getAwardData($award);

        return $this->json($awardData, headers: ['Content-Type' => 'application/json;charset=UTF-8']);
    }

//    #[Route('/awards/{identifier}', name: 'award_findOne', methods: 'get')]
//    public function findOne(ManagerRegistry $registry, string $identifier): JsonResponse
//    {
//        $award = $registry->getRepository(Awards::class)->findOneBy(array('identifier' => $identifier));
//
//        if (!$award):
//            return $this->json('No award found for identifier '.$identifier, 404);
//        endif;
//
//        $awardData = $this->getAwardData($award);
//
//        return $this->json($awardData, headers: ['Content-Type' => 'application/json;charset=UTF-8']);
//    }

    #[Route('/awards', name: 'award_findOneByIdentifier', methods: 'post')]
    public function findOneByIdentifier(ManagerRegistry $registry, Request $request): JsonResponse
    {
        $query = json_decode($request->getContent(), true);
        $identifier = $query['identifier'];

        $award = $registry->getRepository(Awards::class)->findOneBy(array('identifier' => $identifier));

        if (!$award):
            return $this->json('No award found for identifier '.$identifier, 404);
        endif;

        $awardData = $this->getAwardData($award);

        return $this->json($awardData, headers: ['Content-Type' => 'application/json;charset=UTF-8']);
    }

    #[Route('/awards', name: 'award_findOneByQueryParam', methods: 'post')]
    public function findOneByQueryParam(ManagerRegistry $registry, Request $request): JsonResponse
    {
        $query = json_decode($request->getContent(), true);
        $queryKey = array_key_first($query);
        $queryValue = $query[$queryKey];

        $awards = $registry->getRepository(Awards::class)->findBy(array($queryKey => $queryValue), array('identifier' => 'ASC'));

        if (!$awards):
            return $this->json('No awards found for ' . $queryKey . ' = ' . $queryValue, 404);
        endif;
        $awardsData = array();

        foreach ($awards as $award):
            $awardsData[] = $this->getAwardData($award);
        endforeach;

        return $this->json($awardsData, headers: ['Content-Type' => 'application/json;charset=UTF-8']);
    }


    /**
     * @param mixed $award
     * @return array
     */
    public function getAwardData(mixed $award): array
    {
        $awardData[] = [
            'system_id' => $award->getId(),
            'award_type' => $award->getAwardType(),
            'title' => $award->getTitle(),
            'identifier' => $award->getIdentifier(),
            'funding_stream' => $award->getFundingStream(),
            'programme' => $award->getProgramme(),
            'status' => $award->getStatus(),
            'contracting_organisation' => $award->getContractingOrganisation(),
            'start_date' => $award->getStartDate(),
            'end_date' => $award->getEndDate(),
            'publication_date' => $award->getPublicationDate(),
            'estimated_publication_date' => $award->getEstimatedPublicationDate(),
            'award_amount' => $award->getCost(),
            'programme_stream' => $award->getProgrammeStream(),
            'call_identifier' => $award->getCallIdentifier(),
            'call' => $award->getCall(),
            'related_publication_identifier' => $award->getRelatedPublicationIdentifier(),
            'related_publication_title' => $award->getRelatedPublicationTitle(),
            'related_publication_date' => $award->getRelatedPublicationDate(),
            'managing_centre' => $award->getManagingCentre(),
            'additional_funder' => $award->getAdditionalFunder(),
            'research_type' => $award->getResearchType(),
            'trials' => $award->getTrials(),
            'public_health' => $award->getPublicHealth(),
            'lead_person_type' => $award->getLeadPersonType(),
            'website' => $award->getWebsite(),
            'funder' => $award->getFunder()
        ];
        return $awardData;
    }
}