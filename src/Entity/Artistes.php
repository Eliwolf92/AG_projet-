<?php

namespace App\Entity;

use App\Repository\ArtistesRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: ArtistesRepository::class)]
class Artistes
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $name = null;

    #[ORM\Column(length: 255)]
    private ?string $mail = null;

    #[ORM\Column(length: 255)]
    private ?string $media1 = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $media2 = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $media3 = null;

    /**
     * @var Collection<int, ArtService>
     */
    #[ORM\OneToMany(targetEntity: ArtService::class, mappedBy: 'Artiste_id')]
    private Collection $artServices;

    public function __construct()
    {
        $this->artServices = new ArrayCollection();
    }


    public function getId(): ?int
    {
        return $this->id;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): static
    {
        $this->name = $name;

        return $this;
    }

    public function getMail(): ?string
    {
        return $this->mail;
    }

    public function setMail(string $mail): static
    {
        $this->mail = $mail;

        return $this;
    }

    public function getMedia1(): ?string
    {
        return $this->media1;
    }

    public function setMedia1(string $media1): static
    {
        $this->media1 = $media1;

        return $this;
    }

    public function getMedia2(): ?string
    {
        return $this->media2;
    }

    public function setMedia2(?string $media2): static
    {
        $this->media2 = $media2;

        return $this;
    }

    public function getMedia3(): ?string
    {
        return $this->media3;
    }

    public function setMedia3(?string $media3): static
    {
        $this->media3 = $media3;

        return $this;
    }

    /**
     * @return Collection<int, ArtService>
     */
    public function getArtServices(): Collection
    {
        return $this->artServices;
    }

    public function addArtService(ArtService $artService): static
    {
        if (!$this->artServices->contains($artService)) {
            $this->artServices->add($artService);
            $artService->setArtisteId($this);
        }

        return $this;
    }

    public function removeArtService(ArtService $artService): static
    {
        if ($this->artServices->removeElement($artService)) {
            // set the owning side to null (unless already changed)
            if ($artService->getArtisteId() === $this) {
                $artService->setArtisteId(null);
            }
        }

        return $this;
    }


}
