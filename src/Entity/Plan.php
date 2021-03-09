<?php

namespace App\Entity;

use App\Repository\PlanRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=PlanRepository::class)
 */
class Plan
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\OneToMany(targetEntity=Channel::class, mappedBy="planID")
     */
    private $Channels;

    /**
     * @ORM\OneToMany(targetEntity=Cable::class, mappedBy="Plan")
     */
    private $Cables;

    public function __construct()
    {
        $this->Channels = new ArrayCollection();
        $this->Cables = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    /**
     * @return Collection|Channel[]
     */
    public function getChannels(): Collection
    {
        return $this->Channels;
    }

    public function addChannel(Channel $channel): self
    {
        if (!$this->Channels->contains($channel)) {
            $this->Channels[] = $channel;
            $channel->setPlanID($this);
        }

        return $this;
    }

    public function removeChannel(Channel $channel): self
    {
        if ($this->Channels->removeElement($channel)) {
            // set the owning side to null (unless already changed)
            if ($channel->getPlanID() === $this) {
                $channel->setPlanID(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|Cable[]
     */
    public function getCables(): Collection
    {
        return $this->Cables;
    }

    public function addCable(Cable $cable): self
    {
        if (!$this->Cables->contains($cable)) {
            $this->Cables[] = $cable;
            $cable->setPlan($this);
        }

        return $this;
    }

    public function removeCable(Cable $cable): self
    {
        if ($this->Cables->removeElement($cable)) {
            // set the owning side to null (unless already changed)
            if ($cable->getPlan() === $this) {
                $cable->setPlan(null);
            }
        }

        return $this;
    }
}
