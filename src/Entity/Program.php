<?php

namespace App\Entity;

use App\Repository\ProgramRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=ProgramRepository::class)
 */
class Program
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
    private $name;

    /**
     * @ORM\Column(type="time")
     */
    private $Hour;

    /**
     * @ORM\Column(type="array")
     */
    private $WeekDay = [];

    /**
     * @ORM\ManyToOne(targetEntity=Channel::class, inversedBy="programs")
     * @ORM\JoinColumn(nullable=true)
     */
    private $channel;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): self
    {
        $this->name = $name;

        return $this;
    }
    public function getWeekDay(): ?array
    {
        return $this->WeekDay;
    }

    public function setWeekDay(array $WeekDay): self
    {
        $this->WeekDay = $WeekDay;

        return $this;
    }

    public function getHour(): ?\DateTimeInterface
    {
        return $this->Hour;
    }

    public function setHour(\DateTimeInterface $Hour): self
    {
        $this->Hour = $Hour;

        return $this;
    }

    public function getChannel(): ?Channel
    {
        return $this->channel;
    }

    public function setChannel(?Channel $channel): self
    {
        $this->channel = $channel;

        return $this;
    }

}
