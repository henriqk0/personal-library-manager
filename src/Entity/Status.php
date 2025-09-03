<?php

namespace App\Entity;

use App\Repository\StatusRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: StatusRepository::class)]
class Status
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column]
    private ?\DateTime $starting_date = null;

    #[ORM\Column]
    private ?int $current_page = null;

    #[ORM\ManyToOne(inversedBy: 'statuses')]
    #[ORM\JoinColumn(nullable: false)]
    private ?User $reader = null;

    #[ORM\ManyToOne(inversedBy: 'statuses')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Book $book = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getStartingDate(): ?\DateTime
    {
        return $this->starting_date;
    }

    public function setStartingDate(\DateTime $starting_date): static
    {
        $this->starting_date = $starting_date;

        return $this;
    }

    public function getCurrentPage(): ?int
    {
        return $this->current_page;
    }

    public function setCurrentPage(int $current_page): static
    {
        $this->current_page = $current_page;

        return $this;
    }

    public function getReader(): ?User
    {
        return $this->reader;
    }

    public function setReader(?User $reader): static
    {
        $this->reader = $reader;

        return $this;
    }

    public function getBook(): ?Book
    {
        return $this->book;
    }

    public function setBook(?Book $book): static
    {
        $this->book = $book;

        return $this;
    }
}
