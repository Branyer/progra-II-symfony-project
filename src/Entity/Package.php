<?php

namespace App\Entity;

use App\Repository\PackageRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=PackageRepository::class)
 */
class Package
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\ManyToOne(targetEntity=Cable::class, inversedBy="packages")
     * @ORM\JoinColumn(nullable=false)
     */
    private $Cable;

    /**
     * @ORM\ManyToOne(targetEntity=Internet::class, inversedBy="Packages")
     * @ORM\JoinColumn(nullable=false)
     */
    private $Internet;

    /**
     * @ORM\ManyToOne(targetEntity=Telephony::class, inversedBy="Packages")
     * @ORM\JoinColumn(nullable=false)
     */
    private $Telephony;

    /**
     * @ORM\Column(type="float")
     */
    private $Discount;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getCable(): ?Cable
    {
        return $this->Cable;
    }

    public function setCable(?Cable $Cable): self
    {
        $this->Cable = $Cable;

        return $this;
    }

    public function getInternet(): ?Internet
    {
        return $this->Internet;
    }

    public function setInternet(?Internet $Internet): self
    {
        $this->Internet = $Internet;

        return $this;
    }

    public function getTelephony(): ?Telephony
    {
        return $this->Telephony;
    }

    public function setTelephony(?Telephony $Telephony): self
    {
        $this->Telephony = $Telephony;

        return $this;
    }

    public function getDiscount(): ?float
    {
        return $this->Discount;
    }

    public function setDiscount(float $Discount): self
    {
        $this->Discount = $Discount;

        return $this;
    }
}
