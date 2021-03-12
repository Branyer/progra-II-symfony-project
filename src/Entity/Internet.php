<?php

namespace App\Entity;

use App\Repository\InternetRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=InternetRepository::class)
 */
class Internet
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
    private $speed;

    /**
     * @ORM\Column(type="float")
     */
    private $price;

    /**
     * @ORM\OneToMany(targetEntity=Package::class, mappedBy="Internet")
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

    public function getSpeed(): ?int
    {
        return $this->speed;
    }

    public function setSpeed(int $speed): self
    {
        $this->speed = $speed;

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
            $package->setInternet($this);
        }

        return $this;
    }

    public function removePackage(Package $package): self
    {
        if ($this->Packages->removeElement($package)) {
            // set the owning side to null (unless already changed)
            if ($package->getInternet() === $this) {
                $package->setInternet(null);
            }
        }

        return $this;
    }
}
