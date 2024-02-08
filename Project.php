<?php

namespace App\Entity;

use App\Repository\ProjectRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: ProjectRepository::class)]
class Project
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $url = null;

    #[ORM\Column(type: Types::DATE_MUTABLE)]
    private ?\DateTimeInterface $project_date = null;

    #[ORM\OneToMany(mappedBy: 'project', targetEntity: Report::class)]
    private Collection $owner_id;

    public function __construct()
    {
        $this->owner_id = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getUrl(): ?string
    {
        return $this->url;
    }

    public function setUrl(string $url): static
    {
        $this->url = $url;

        return $this;
    }

    public function getProjectDate(): ?\DateTime
    {
        return $this->project_date;
    }

    public function setProjectDate(\DateTime $project_date): static
    {
        $this->project_date = $project_date;
        $this->project_date->format("d-m-Y");

        return $this;
    }

    /**
     * @return Collection<int, Report>
     */
    public function getOwnerId(): Collection
    {
        return $this->owner_id;
    }

    public function addOwnerId(Report $ownerId): static
    {
        if (!$this->owner_id->contains($ownerId)) {
            $this->owner_id->add($ownerId);
            $ownerId->setProject($this);
        }

        return $this;
    }

    public function removeOwnerId(Report $ownerId): static
    {
        if ($this->owner_id->removeElement($ownerId)) {
            // set the owning side to null (unless already changed)
            if ($ownerId->getProject() === $this) {
                $ownerId->setProject(null);
            }
        }

        return $this;
    }

}
