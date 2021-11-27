<?php

namespace App\Entity;

use App\Repository\HopitalRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=HopitalRepository::class)
 */
class Hopital
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $NomHopital;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $Adresse;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $NoUrgence;

    /**
     * @ORM\ManyToMany(targetEntity=ServiceHopital::class, mappedBy="hopitalID")
     */
    private $serviceHopitals;

    public function __construct()
    {
        $this->serviceHopitals = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNomHopital(): ?string
    {
        return $this->NomHopital;
    }

    public function setNomHopital(string $NomHopital): self
    {
        $this->NomHopital = $NomHopital;

        return $this;
    }

    public function getAdresse(): ?string
    {
        return $this->Adresse;
    }

    public function setAdresse(?string $Adresse): self
    {
        $this->Adresse = $Adresse;

        return $this;
    }

    public function getNoUrgence(): ?string
    {
        return $this->NoUrgence;
    }

    public function setNoUrgence(?string $NoUrgence): self
    {
        $this->NoUrgence = $NoUrgence;

        return $this;
    }

    /**
     * @return Collection|ServiceHopital[]
     */
    public function getServiceHopitals(): Collection
    {
        return $this->serviceHopitals;
    }

    public function addServiceHopital(ServiceHopital $serviceHopital): self
    {
        if (!$this->serviceHopitals->contains($serviceHopital)) {
            $this->serviceHopitals[] = $serviceHopital;
            $serviceHopital->addHopitalID($this);
        }

        return $this;
    }

    public function removeServiceHopital(ServiceHopital $serviceHopital): self
    {
        if ($this->serviceHopitals->removeElement($serviceHopital)) {
            $serviceHopital->removeHopitalID($this);
        }

        return $this;
    }
}
