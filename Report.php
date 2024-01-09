<?php

namespace App\Entity;

use App\Repository\ReportRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: ReportRepository::class)]
class Report
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(type: Types::TEXT)]
    private ?string $analysis = null;

    #[ORM\Column]
    private ?int $nb_error = null;

    #[ORM\Column(type: Types::TIME_MUTABLE)]
    private ?\DateTime $analysis_date = null;

    #[ORM\Column(type: Types::TIME_MUTABLE)]
    private ?\DateTime $modification_date = null;

    #[ORM\Column(type: Types::TEXT)]
    private ?string $comment = null;

    #[ORM\ManyToOne(inversedBy: 'owner_id')]
    private ?Project $project = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getAnalysis(): ?string
    {
        return $this->analysis;
    }

    public function setAnalysis(string $analysis): static
    {
        $this->analysis = $analysis;

        return $this;
    }

    public function getNbError(): ?int
    {
        return $this->nb_error;
    }

    public function setNbError(int $nb_error): static
    {
        $this->nb_error = $nb_error;

        return $this;
    }

    public function getAnalysisDate(): ?\DateTime
    {
        return $this->analysis_date;
    }

    public function setAnalysisDate(\DateTime $analysis_date): static
    {
        $this->analysis_date = $analysis_date;
        $this->analysis_date->format("H:m:s");

        return $this;
    }

    public function getModificationDate(): ?\DateTime
    {
        return $this->modification_date;
    }

    public function setModificationDate(\DateTime $modification_date): static
    {
        $this->modification_date = $modification_date;
        $this->modification_date->format("d-m-Y");

        return $this;
    }

    public function getComment(): ?string
    {
        return $this->comment;
    }

    public function setComment(string $comment): static
    {
        $this->comment = $comment;

        return $this;
    }

    public function getProject(): ?Project
    {
        return $this->project;
    }

    public function setProject(?Project $project): static
    {
        $this->project = $project;

        return $this;
    }

}
