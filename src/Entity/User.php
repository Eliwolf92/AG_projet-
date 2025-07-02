<?php

namespace App\Entity;

use App\Repository\UserRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\Security\Core\User\PasswordAuthenticatedUserInterface;
use Symfony\Component\Security\Core\User\UserInterface;

#[ORM\Entity(repositoryClass: UserRepository::class)]
#[ORM\UniqueConstraint(name: 'UNIQ_IDENTIFIER_EMAIL', fields: ['email'])]
#[UniqueEntity(fields: ['email'], message: 'There is already an account with this email')]
class User implements UserInterface, PasswordAuthenticatedUserInterface
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 180)]
    private ?string $email = null;

    /**
     * @var list<string> The user roles
     */
    #[ORM\Column]
    private array $roles = [];

    /**
     * @var string The hashed password
     */
    #[ORM\Column]
    private ?string $password = null;

    #[ORM\Column(length: 255)]
    private ?string $username = null;

    /**
     * @var Collection<int, Art>
     */
    #[ORM\OneToMany(targetEntity: Art::class, mappedBy: 'artiste')]
    private Collection $arts;

    /**
     * @var Collection<int, ServiceRequest>
     */
    #[ORM\OneToMany(targetEntity: ServiceRequest::class, mappedBy: 'user')]
    private Collection $serviceRequests;

    /**
     * @var Collection<int, Demandes>
     */
    #[ORM\OneToMany(targetEntity: Demandes::class, mappedBy: 'demandeurs')]
    private Collection $demandes;

    public function __construct()
    {
        $this->arts = new ArrayCollection();
        $this->serviceRequests = new ArrayCollection();
        $this->demandes = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }



    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function setEmail(string $email): static
    {
        $this->email = $email;

        return $this;
    }

    /**
     * A visual identifier that represents this user.
     *
     * @see UserInterface
     */
    public function getUserIdentifier(): string
    {
        return (string) $this->email;
    }

    /**
     * @see UserInterface
     */
    public function getRoles(): array
    {
        $roles = $this->roles;
        // guarantee every user at least has ROLE_USER
        $roles[] = 'ROLE_USER';

        return array_unique($roles);
    }

    /**
     * @param list<string> $roles
     */
    public function setRoles(array $roles): static
    {
        $this->roles = $roles;

        return $this;
    }

    /**
     * @see PasswordAuthenticatedUserInterface
     */
    public function getPassword(): ?string
    {
        return $this->password;
    }

    public function setPassword(string $password): static
    {
        $this->password = $password;

        return $this;
    }

    /**
     * @see UserInterface
     */
    public function eraseCredentials(): void
    {
        // If you store any temporary, sensitive data on the user, clear it here
        // $this->plainPassword = null;
    }

    public function getUsername(): ?string
    {
        return $this->username;
    }

    public function setUsername(string $username): static
    {
        $this->username = $username;

        return $this;
    }

        public function __toString(): string
{
    return $this->getUsername(); // ou getNom() si tu as un champ "nom"
}

    /**
     * @return Collection<int, Art>
     */
    public function getArts(): Collection
    {
        return $this->arts;
    }

    public function addArt(Art $art): static
    {
        if (!$this->arts->contains($art)) {
            $this->arts->add($art);
            $art->setArtiste($this);
        }

        return $this;
    }

    public function removeArt(Art $art): static
    {
        if ($this->arts->removeElement($art)) {
            // set the owning side to null (unless already changed)
            if ($art->getArtiste() === $this) {
                $art->setArtiste(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, ServiceRequest>
     */
    public function getServiceRequests(): Collection
    {
        return $this->serviceRequests;
    }

    public function addServiceRequest(ServiceRequest $serviceRequest): static
    {
        if (!$this->serviceRequests->contains($serviceRequest)) {
            $this->serviceRequests->add($serviceRequest);
            $serviceRequest->setUser($this);
        }

        return $this;
    }

    public function removeServiceRequest(ServiceRequest $serviceRequest): static
    {
        if ($this->serviceRequests->removeElement($serviceRequest)) {
            // set the owning side to null (unless already changed)
            if ($serviceRequest->getUser() === $this) {
                $serviceRequest->setUser(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, Demandes>
     */
    public function getDemandes(): Collection
    {
        return $this->demandes;
    }

    public function addDemande(Demandes $demande): static
    {
        if (!$this->demandes->contains($demande)) {
            $this->demandes->add($demande);
            $demande->setDemandeurs($this);
        }

        return $this;
    }

    public function removeDemande(Demandes $demande): static
    {
        if ($this->demandes->removeElement($demande)) {
            // set the owning side to null (unless already changed)
            if ($demande->getDemandeurs() === $this) {
                $demande->setDemandeurs(null);
            }
        }

        return $this;
    }



}
