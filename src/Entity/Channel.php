<?php

namespace App\Entity;

use App\Repository\ChannelRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=ChannelRepository::class)
 */
class Channel
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
    private $Name;

    /**
     * @ORM\OneToMany(targetEntity=Program::class, mappedBy="channelId")
     */
    private $Programation;

    /**
     * @ORM\ManyToOne(targetEntity=Plan::class, inversedBy="Channels")
     * @ORM\JoinColumn(nullable=false)
     */
    private $planID;

    public function __construct()
    {
        $this->Programation = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
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
     * @return Collection|Program[]
     */
    public function getProgramation(): Collection
    {
        return $this->Programation;
    }

    public function addProgramation(Program $programation): self
    {
        if (!$this->Programation->contains($programation)) {
            $this->Programation[] = $programation;
            $programation->setChannelId($this);
        }

        return $this;
    }

    public function removeProgramation(Program $programation): self
    {
        if ($this->Programation->removeElement($programation)) {
            // set the owning side to null (unless already changed)
            if ($programation->getChannelId() === $this) {
                $programation->setChannelId(null);
            }
        }

        return $this;
    }

    public function getPlanID(): ?Plan
    {
        return $this->planID;
    }

    public function setPlanID(?Plan $planID): self
    {
        $this->planID = $planID;

        return $this;
    }
}
