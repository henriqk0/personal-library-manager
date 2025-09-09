<?php

namespace App\Entity;

use App\Repository\WriterRepository;
use Symfony\Component\Validator\Constraints as Assert;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: WriterRepository::class)]
#[ORM\Table(name:"writer")]
class Writer
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $name = null;

    #[ORM\Column(type:"date")]
    private $birthdate = null;

    /**
     * @var Collection<int, Book>
     */
    #[ORM\OneToMany(targetEntity: Book::class, mappedBy: 'writer')]
    private Collection $writer;

    #[ORM\Column]
    private ?bool $birth_before_christ = null;

    public function __construct()
    {
        $this->writer = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): static
    {
        $this->name = $name;

        return $this;
    }

    public function getBirthdate(): ?\DateTimeInterface
    {
        return $this->birthdate;
    }

    public function setBirthdate(\DateTimeInterface $birthdate): static
    {
        $this->birthdate = $birthdate;

        return $this;
    }

    /**
     * @return Collection<int, Book>
     */
    public function getWriter(): Collection
    {
        return $this->writer;
    }

    public function addWriter(Book $writer): static
    {
        if (!$this->writer->contains($writer)) {
            $this->writer->add($writer);
            $writer->setWriter($this);
        }

        return $this;
    }

    public function removeWriter(Book $writer): static
    {
        if ($this->writer->removeElement($writer)) {
            // set the owning side to null (unless already changed)
            if ($writer->getWriter() === $this) {
                $writer->setWriter(null);
            }
        }

        return $this;
    }

    public function __toString():string
    {
        return $this->getName();
    }

    public function isBirthBeforeChrist(): ?bool
    {
        return $this->birth_before_christ;
    }

    public function setBirthBeforeChrist(bool $birth_before_christ): static
    {
        $this->birth_before_christ = $birth_before_christ;

        return $this;
    }
}
