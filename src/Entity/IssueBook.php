<?php

namespace App\Entity;

use App\Repository\IssueBookRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=IssueBookRepository::class)
 */
class IssueBook
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="date")
     */
    private $issueDate;

    /**
     * @ORM\Column(type="date", nullable=true)
     */
    private $returnDate;

    /**
     * @ORM\ManyToMany(targetEntity=Book::class, mappedBy="issueBook")
     */
    private $books;

    /**
     * @ORM\OneToMany(targetEntity=BookIssueBook::class, mappedBy="issueBooks")
     */
    private $bookIssueBooks;

    public function __construct()
    {
        $this->books = new ArrayCollection();
        $this->bookIssueBooks = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getIssueDate(): ?\DateTimeInterface
    {
        return $this->issueDate;
    }

    public function setIssueDate(\DateTimeInterface $issueDate): self
    {
        $this->issueDate = $issueDate;

        return $this;
    }

    public function getReturnDate(): ?\DateTimeInterface
    {
        return $this->returnDate;
    }

    public function setReturnDate(?\DateTimeInterface $returnDate): self
    {
        $this->returnDate = $returnDate;

        return $this;
    }

    /**
     * @return Collection<int, Book>
     */
    public function getBooks(): Collection
    {
        return $this->books;
    }

    public function addBook(Book $book): self
    {
        if (!$this->books->contains($book)) {
            $this->books[] = $book;
            $book->addIssueBook($this);
        }

        return $this;
    }

    public function removeBook(Book $book): self
    {
        if ($this->books->removeElement($book)) {
            $book->removeIssueBook($this);
        }

        return $this;
    }

    /**
     * @return Collection<int, BookIssueBook>
     */
    public function getBookIssueBooks(): Collection
    {
        return $this->bookIssueBooks;
    }

    public function addBookIssueBook(BookIssueBook $bookIssueBook): self
    {
        if (!$this->bookIssueBooks->contains($bookIssueBook)) {
            $this->bookIssueBooks[] = $bookIssueBook;
            $bookIssueBook->setIssueBook($this);
        }

        return $this;
    }

    public function removeBookIssueBook(BookIssueBook $bookIssueBook): self
    {
        if ($this->bookIssueBooks->removeElement($bookIssueBook)) {
            // set the owning side to null (unless already changed)
            if ($bookIssueBook->getIssueBook() === $this) {
                $bookIssueBook->setIssueBook(null);
            }
        }

        return $this;
    }
}
