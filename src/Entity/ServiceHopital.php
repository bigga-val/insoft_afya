<?php

namespace App\Entity;

use App\Repository\ServiceHopitalRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=ServiceHopitalRepository::class)
 */
class ServiceHopital
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\ManyToMany(targetEntity=Service::class, inversedBy="serviceHopitals")
     */
    private $serviceID;

    /**
     * @ORM\ManyToMany(targetEntity=Hopital::class, inversedBy="serviceHopitals")
     */
    private $hopitalID;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $createdBy;

    /**
     * @ORM\Column(type="datetime_immutable", nullable=true)
     */
    private $createdAt;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $status;

    public function __construct()
    {
        $this->serviceID = new ArrayCollection();
        $this->hopitalID = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    /**
     * @return Collection|Service[]
     */
    public function getServiceID(): Collection
    {
        return $this->serviceID;
    }

    public function addServiceID(Service $serviceID): self
    {
        if (!$this->serviceID->contains($serviceID)) {
            $this->serviceID[] = $serviceID;
        }

        return $this;
    }

    public function removeServiceID(Service $serviceID): self
    {
        $this->serviceID->removeElement($serviceID);

        return $this;
    }

    /**
     * @return Collection|Hopital[]
     */
    public function getHopitalID(): Collection
    {
        return $this->hopitalID;
    }

    public function addHopitalID(Hopital $hopitalID): self
    {
        if (!$this->hopitalID->contains($hopitalID)) {
            $this->hopitalID[] = $hopitalID;
        }

        return $this;
    }

    public function removeHopitalID(Hopital $hopitalID): self
    {
        $this->hopitalID->removeElement($hopitalID);

        return $this;
    }

    public function getCreatedBy(): ?string
    {
        return $this->createdBy;
    }

    public function setCreatedBy(?string $createdBy): self
    {
        $this->createdBy = $createdBy;

        return $this;
    }

    public function getCreatedAt(): ?\DateTimeImmutable
    {
        return $this->createdAt;
    }

    public function setCreatedAt(?\DateTimeImmutable $createdAt): self
    {
        $this->createdAt = $createdAt;

        return $this;
    }

    public function getStatus(): ?string
    {
        return $this->status;
    }

    public function setStatus(?string $status): self
    {
        $this->status = $status;

        return $this;
    }
}
