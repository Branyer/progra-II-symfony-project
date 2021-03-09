<?php

namespace App\Entity;

use App\Repository\TelephonyRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=TelephonyRepository::class)
 */
class Telephony
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="integer")
     */
    private $minutes;

    /**
     * @ORM\Column(type="float")
     */
    private $price;

    /**
     * @ORM\OneToMany(targetEntity=Package::class, mappedBy="Telephony")
     */
    private $Packages;

    public function __construct()
    {
        $this->Packages = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getMinutes(): ?int
    {
        return $this->minutes;
    }

    public function setMinutes(int $minutes): self
    {
        $this->minutes = $minutes;

        return $this;
    }

    public function getPrice(): ?float
    {
        return $this->price;
    }

    public function setPrice(float $price): self
    {
        $this->price = $price;

        return $this;
    }

    /**
     * @return Collection|Package[]
     */
    public function getPackages(): Collection
    {
        return $this->Packages;
    }

    public function addPackage(Package $package): self
    {
        if (!$this->Packages->contains($package)) {
            $this->Packages[] = $package;
            $package->setTelephony($this);
        }

        return $this;
    }

    public function removePackage(Package $package): self
    {
        if ($this->Packages->removeElement($package)) {
            // set the owning side to null (unless already changed)
            if ($package->getTelephony() === $this) {
                $package->setTelephony(null);
            }
        }

        return $this;
    }
}
