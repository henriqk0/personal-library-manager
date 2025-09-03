<?php

namespace App\Entity;

use App\Repository\BookRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: BookRepository::class)]
class Book
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $title = null;

    #[ORM\Column]
    private ?int $num_pages = null;

    private Collection $owner;

    #[ORM\ManyToOne(inversedBy: 'writer')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Writer $writer = null;

    /**
     * @var Collection<int, Status>
     */
    #[ORM\OneToMany(targetEntity: Status::class, mappedBy: 'book')]
    private Collection $statuses;

    public function __construct()
    {
        $this->owner = new ArrayCollection();
        $this->statuses = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getTitle(): ?string
    {
        return $this->title;
    }

    public function setTitle(string $title): static
    {
        $this->title = $title;

        return $this;
    }

    public function getNumPages(): ?int
    {
        return $this->num_pages;
    }

    public function setNumPages(int $num_pages): static
    {
        $this->num_pages = $num_pages;

        return $this;
    }

    public function getWriter(): ?Writer
    {
        return $this->writer;
    }

    public function setWriter(?Writer $writer): static
    {
        $this->writer = $writer;

        return $this;
    }

    /**
     * @return Collection<int, Status>
     */
    public function getStatuses(): Collection
    {
        return $this->statuses;
    }

    public function addStatus(Status $status): static
    {
        if (!$this->statuses->contains($status)) {
            $this->statuses->add($status);
            $status->setBook($this);
        }

        return $this;
    }

    public function removeStatus(Status $status): static
    {
        if ($this->statuses->removeElement($status)) {
            // set the owning side to null (unless already changed)
            if ($status->getBook() === $this) {
                $status->setBook(null);
            }
        }

        return $this;
    }
}
