<?php

namespace App\Entity;

use App\Repository\AwardsRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: AwardsRepository::class)]
class Awards
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $award_type = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $title = null;

    #[ORM\Column(length: 255)]
    private ?string $identifier = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $funding_stream = null;

    #[ORM\Column(length: 255)]
    private ?string $programme = null;

    #[ORM\Column(length: 255)]
    private ?string $status = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $contracting_organisation = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $contractor_type = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $start_date = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $end_date = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $publication_date = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $estimated_publication_date = null;

    #[ORM\Column(nullable: true)]
    private ?float $cost = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $programme_stream = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $call_identifier = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $call = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $related_publication_identifier = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $related_publication_title = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $related_publication_date = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $managing_centre = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $additional_funder = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $research_type = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $trials = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $public_health = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $lead_person_type = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $website = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $funder = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getAwardType(): ?string
    {
        return $this->award_type;
    }

    public function setAwardType(?string $award_type): static
    {
        $this->award_type = $award_type;

        return $this;
    }

    public function getTitle(): ?string
    {
        return $this->title;
    }

    public function setTitle(?string $title): static
    {
        $this->title = $title;

        return $this;
    }

    public function getIdentifier(): ?string
    {
        return $this->identifier;
    }

    public function setIdentifier(string $identifier): static
    {
        $this->identifier = $identifier;

        return $this;
    }

    public function getFundingStream(): ?string
    {
        return $this->funding_stream;
    }

    public function setFundingStream(?string $funding_stream): static
    {
        $this->funding_stream = $funding_stream;

        return $this;
    }

    public function getProgramme(): ?string
    {
        return $this->programme;
    }

    public function setProgramme(string $programme): static
    {
        $this->programme = $programme;

        return $this;
    }

    public function getStatus(): ?string
    {
        return $this->status;
    }

    public function setStatus(string $status): static
    {
        $this->status = $status;

        return $this;
    }

    public function getContractingOrganisation(): ?string
    {
        return $this->contracting_organisation;
    }

    public function setContractingOrganisation(?string $contracting_organisation): static
    {
        $this->contracting_organisation = $contracting_organisation;

        return $this;
    }

    public function getContractorType(): ?string
    {
        return $this->contractor_type;
    }

    public function setContractorType(?string $contractor_type): static
    {
        $this->contractor_type = $contractor_type;

        return $this;
    }

    public function getStartDate(): ?string
    {
        return $this->start_date;
    }

    public function setStartDate(?string $start_date): static
    {
        $this->start_date = $start_date;

        return $this;
    }

    public function getEndDate(): ?string
    {
        return $this->end_date;
    }

    public function setEndDate(?string $end_date): static
    {
        $this->end_date = $end_date;

        return $this;
    }

    public function getPublicationDate(): ?string
    {
        return $this->publication_date;
    }

    public function setPublicationDate(?string $publication_date): static
    {
        $this->publication_date = $publication_date;

        return $this;
    }

    public function getEstimatedPublicationDate(): ?string
    {
        return $this->estimated_publication_date;
    }

    public function setEstimatedPublicationDate(?string $estimated_publication_date): static
    {
        $this->estimated_publication_date = $estimated_publication_date;

        return $this;
    }

    public function getCost(): ?float
    {
        return $this->cost;
    }

    public function setCost(float $cost): static
    {
        $this->cost = $cost;

        return $this;
    }

    public function getProgrammeStream(): ?string
    {
        return $this->programme_stream;
    }

    public function setProgrammeStream(?string $programme_stream): static
    {
        $this->programme_stream = $programme_stream;

        return $this;
    }

    public function getCallIdentifier(): ?string
    {
        return $this->call_identifier;
    }

    public function setCallIdentifier(?string $call_identifier): static
    {
        $this->call_identifier = $call_identifier;

        return $this;
    }

    public function getCall(): ?string
    {
        return $this->call;
    }

    public function setCall(?string $call): static
    {
        $this->call = $call;

        return $this;
    }

    public function getRelatedPublicationIdentifier(): ?string
    {
        return $this->related_publication_identifier;
    }

    public function setRelatedPublicationIdentifier(?string $related_publication_identifier): static
    {
        $this->related_publication_identifier = $related_publication_identifier;

        return $this;
    }

    public function getRelatedPublicationTitle(): ?string
    {
        return $this->related_publication_title;
    }

    public function setRelatedPublicationTitle(?string $related_publication_title): static
    {
        $this->related_publication_title = $related_publication_title;

        return $this;
    }

    public function getRelatedPublicationDate(): ?string
    {
        return $this->related_publication_date;
    }

    public function setRelatedPublicationDate(?string $related_publication_date): static
    {
        $this->related_publication_date = $related_publication_date;

        return $this;
    }

    public function getManagingCentre(): ?string
    {
        return $this->managing_centre;
    }

    public function setManagingCentre(?string $managing_centre): static
    {
        $this->managing_centre = $managing_centre;

        return $this;
    }

    public function getAdditionalFunder(): ?string
    {
        return $this->additional_funder;
    }

    public function setAdditionalFunder(?string $additional_funder): static
    {
        $this->additional_funder = $additional_funder;

        return $this;
    }

    public function getResearchType(): ?string
    {
        return $this->research_type;
    }

    public function setResearchType(?string $research_type): static
    {
        $this->research_type = $research_type;

        return $this;
    }

    public function getTrials(): ?string
    {
        return $this->trials;
    }

    public function setTrials(?string $trials): static
    {
        $this->trials = $trials;

        return $this;
    }

    public function getPublicHealth(): ?string
    {
        return $this->public_health;
    }

    public function setPublicHealth(?string $public_health): static
    {
        $this->public_health = $public_health;

        return $this;
    }

    public function getLeadPersonType(): ?string
    {
        return $this->lead_person_type;
    }

    public function setLeadPersonType(?string $lead_person_type): static
    {
        $this->lead_person_type = $lead_person_type;

        return $this;
    }

    public function getWebsite(): ?string
    {
        return $this->website;
    }

    public function setWebsite(?string $website): static
    {
        $this->website = $website;

        return $this;
    }

    public function getFunder(): ?string
    {
        return $this->funder;
    }

    public function setFunder(?string $funder): static
    {
        $this->funder = $funder;

        return $this;
    }
}