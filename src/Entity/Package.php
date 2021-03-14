<?php

namespace App\Entity;

use App\Repository\PackageRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
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

    /**
     * @ORM\OneToMany(targetEntity=User::class, mappedBy="package")
     */
    private $users;

    /**
     * @ORM\OneToMany(targetEntity=Bill::class, mappedBy="package")
     */
    private $bills;

    public function __construct()
    {
        $this->users = new ArrayCollection();
        $this->bills = new ArrayCollection();
    }

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

    /**
     * @return Collection|User[]
     */
    public function getUsers(): Collection
    {
        return $this->users;
    }

    public function addUser(User $user): self
    {
        if (!$this->users->contains($user)) {
            $this->users[] = $user;
            $user->setPackage($this);
        }

        return $this;
    }

    public function removeUser(User $user): self
    {
        if ($this->users->removeElement($user)) {
            // set the owning side to null (unless already changed)
            if ($user->getPackage() === $this) {
                $user->setPackage(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|Bill[]
     */
    public function getBills(): Collection
    {
        return $this->bills;
    }

    public function addBill(Bill $bill): self
    {
        if (!$this->bills->contains($bill)) {
            $this->bills[] = $bill;
            $bill->setPackage($this);
        }

        return $this;
    }

    public function removeBill(Bill $bill): self
    {
        if ($this->bills->removeElement($bill)) {
            // set the owning side to null (unless already changed)
            if ($bill->getPackage() === $this) {
                $bill->setPackage(null);
            }
        }

        return $this;
    }
}
