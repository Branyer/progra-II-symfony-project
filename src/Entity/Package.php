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
     * @ORM\Column(type="float")
     */
    private $Discount;

    /**
     * @ORM\ManyToOne(targetEntity=Internet::class, inversedBy="packages")
     */
    private $internet;

    /**
     * @ORM\ManyToOne(targetEntity=Cable::class, inversedBy="packages")
     */
    private $cable;

    /**
     * @ORM\ManyToOne(targetEntity=Telephony::class, inversedBy="packages")
     */
    private $telephony;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $Name;

    public function getId(): ?int
    {
        return $this->id;
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

    public function getInternet(): ?Internet
    {
        return $this->internet;
    }

    public function setInternet(?Internet $internet): self
    {
        $this->internet = $internet;

        return $this;
    }

    public function getCable(): ?Cable
    {
        return $this->cable;
    }

    public function setCable(?Cable $cable): self
    {
        $this->cable = $cable;

        return $this;
    }

    public function getTelephony(): ?Telephony
    {
        return $this->telephony;
    }

    public function setTelephony(?Telephony $telephony): self
    {
        $this->telephony = $telephony;

        return $this;
    }

    public function getName(): ?string
    {
        return $this->Name;
    }

    public function setName(string $Name): self
    {
        $this->Name = $Name;

        return $this;
    }
}
