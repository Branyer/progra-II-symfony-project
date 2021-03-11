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
     * @ORM\ManyToOne(targetEntity=Plan::class, inversedBy="Channels")
     * @ORM\JoinColumn(nullable=true)
     */
    private $plan;

    /**
     * @ORM\OneToMany(targetEntity=Program::class, mappedBy="channel", orphanRemoval=true)
     */
    private $programs;

    /**
     * @ORM\ManyToMany(targetEntity=Plan::class, mappedBy="channels")
     */
    private $plans;

    public function __construct()
    {
        $this->programs = new ArrayCollection();
        $this->plans = new ArrayCollection();
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

    public function getPlanID(): ?Plan
    {
        return $this->plan;
    }

    public function setPlanID(?Plan $plan): self
    {
        $this->plan = $plan;

        return $this;
    }

    /**
     * @return Collection|Program[]
     */
    public function getPrograms(): Collection
    {
        return $this->programs;
    }

    public function addProgram(Program $program): self
    {
        // if (!$this->programs->contains($program)) {
            $this->programs[] = $program;
            $program->setChannel($this);
        // }

        return $this;
    }

    public function removeProgram(Program $program): self
    {
        if ($this->programs->removeElement($program)) {
            // set the owning side to null (unless already changed)
            if ($program->getChannel() === $this) {
                $program->setChannel(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|Plan[]
     */
    public function getPlans(): Collection
    {
        return $this->plans;
    }

    public function addPlan(Plan $plan): self
    {
        if (!$this->plans->contains($plan)) {
            $this->plans[] = $plan;
            $plan->addChannel($this);
        }

        return $this;
    }

    public function removePlan(Plan $plan): self
    {
        if ($this->plans->removeElement($plan)) {
            $plan->removeChannel($this);
        }

        return $this;
    }
}
