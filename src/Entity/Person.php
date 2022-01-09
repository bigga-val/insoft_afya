<?php

namespace App\Entity;

use App\Repository\PersonRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=PersonRepository::class)
 */
class Person
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $nomPostnom;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $adressePhysique;

    /**
     * @ORM\Column(type="string", length=20, nullable=true)
     */
    private $telephone;

    /**
     * @ORM\Column(type="datetime_immutable", nullable=true)
     */
    private $createdAt;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $createdBy;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $photoProfile;

    /**
     * @ORM\Column(type="datetime_immutable")
     */
    private $editedAt;

    /**
     * @ORM\OneToOne(targetEntity=User::class, inversedBy="person", cascade={"persist", "remove"})
     * @ORM\JoinColumn(nullable=false)
     */
    private $UserPerson;

    /**
     * @ORM\OneToOne(targetEntity=Patient::class, mappedBy="Person", cascade={"persist", "remove"})
     */
    private $Adress;

    /**
     * @ORM\OneToOne(targetEntity=Patient::class, mappedBy="Person", cascade={"persist", "remove"})
     */
    private $person;



    public function getId(): ?int
    {
        return $this->id;
    }
    public function getNomPostnom(): ?string
    {
        return $this->nomPostnom;
    }

    public function setNomPostnom(?string $nomPostnom): self
    {
        $this->nomPostnom = $nomPostnom;

        return $this;
    }

    public function getAdressePhysique(): ?string
    {
        return $this->adressePhysique;
    }

    public function setAdressePhysique(?string $adressePhysique): self
    {
        $this->adressePhysique = $adressePhysique;

        return $this;
    }

    public function getTelephone(): ?string
    {
        return $this->telephone;
    }

    public function setTelephone(?string $telephone): self
    {
        $this->telephone = $telephone;

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

    public function getCreatedBy(): ?string
    {
        return $this->createdBy;
    }

    public function setCreatedBy(string $createdBy): self
    {
        $this->createdBy = $createdBy;

        return $this;
    }

    public function getPhotoProfile(): ?string
    {
        return $this->photoProfile;
    }

    public function setPhotoProfile(?string $photoProfile): self
    {
        $this->photoProfile = $photoProfile;

        return $this;
    }

    public function getEditedAt(): ?\DateTimeImmutable
    {
        return $this->editedAt;
    }

    public function setEditedAt(\DateTimeImmutable $editedAt): self
    {
        $this->editedAt = $editedAt;

        return $this;
    }

    public function getUserPerson(): ?User
    {
        return $this->UserPerson;
    }

    public function setUserPerson(User $UserPerson): self
    {
        $this->UserPerson = $UserPerson;

        return $this;
    }

    public function getAdress(): ?Patient
    {
        return $this->Adress;
    }

    public function setAdress(Patient $Adress): self
    {
        // set the owning side of the relation if necessary
        if ($Adress->getPerson() !== $this) {
            $Adress->setPerson($this);
        }

        $this->Adress = $Adress;

        return $this;
    }

    public function getPerson(): ?Patient
    {
        return $this->person;
    }

    public function setPerson(Patient $person): self
    {
        // set the owning side of the relation if necessary
        if ($person->getPerson() !== $this) {
            $person->setPerson($this);
        }

        $this->person = $person;

        return $this;
    }


}
