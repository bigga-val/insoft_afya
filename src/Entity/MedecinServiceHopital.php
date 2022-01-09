<?php

namespace App\Entity;

use App\Repository\MedecinServiceHopitalRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=MedecinServiceHopitalRepository::class)
 */
class MedecinServiceHopital
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="datetime_immutable")
     */
    private $createdAt;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $createBy;

    /**
     * @ORM\ManyToOne(targetEntity=Doctor::class)
     * @ORM\JoinColumn(nullable=false)
     */
    private $medecin;

    /**
     * @ORM\ManyToOne(targetEntity=ServiceHopital::class)
     * @ORM\JoinColumn(nullable=false)
     */
    private $ServiceHopital;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $status;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getCreatedAt(): ?\DateTimeImmutable
    {
        return $this->createdAt;
    }

    public function setCreatedAt(\DateTimeImmutable $createdAt): self
    {
        $this->createdAt = $createdAt;

        return $this;
    }

    public function getCreateBy(): ?string
    {
        return $this->createBy;
    }

    public function setCreateBy(?string $createBy): self
    {
        $this->createBy = $createBy;

        return $this;
    }

    public function getMedecin(): ?Doctor
    {
        return $this->medecin;
    }

    public function setMedecin(?Doctor $medecin): self
    {
        $this->medecin = $medecin;

        return $this;
    }

    public function getServiceHopital(): ?ServiceHopital
    {
        return $this->ServiceHopital;
    }

    public function setServiceHopital(?ServiceHopital $ServiceHopital): self
    {
        $this->ServiceHopital = $ServiceHopital;

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
