<?php

namespace App\Entity;

use App\Repository\ArtServiceRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: ArtServiceRepository::class)]
class ArtService
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\ManyToOne(inversedBy: 'artServices')]
    private ?Art $Art_id = null;

    #[ORM\ManyToOne(inversedBy: 'artServices')]
    private ?Artistes $Artiste_id = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getArtId(): ?Art
    {
        return $this->Art_id;
    }

    public function setArtId(?Art $Art_id): static
    {
        $this->Art_id = $Art_id;

        return $this;
    }

    public function getArtisteId(): ?Artistes
    {
        return $this->Artiste_id;
    }

    public function setArtisteId(?Artistes $Artiste_id): static
    {
        $this->Artiste_id = $Artiste_id;

        return $this;
    }
}
