<?php

namespace App\Entity;

use App\Repository\BookRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=BookRepository::class)
 */
class Book
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
    private $bookName;

    /**
     * @ORM\Column(type="float")
     */
    private $price;

    /**
     * @ORM\ManyToOne(targetEntity=Author::class, inversedBy="books")
     */
    private $author;

    /**
     * @ORM\ManyToOne(targetEntity=Category::class, inversedBy="books")
     */
    private $category;

    /**
     * @ORM\ManyToMany(targetEntity=IssueBook::class, inversedBy="books")
     */
    private $issueBook;

    /**
     * @ORM\OneToMany(targetEntity=BookIssueBook::class, mappedBy="book")
     */
    private $bookIssueBooks;

    public function __construct()
    {
        $this->issueBook = new ArrayCollection();
        $this->bookIssueBooks = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getBookName(): ?string
    {
        return $this->bookName;
    }

    public function setBookName(string $bookName): self
    {
        $this->bookName = $bookName;

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

    public function getAuthor(): ?Author
    {
        return $this->author;
    }

    public function setAuthor(?Author $author): self
    {
        $this->author = $author;

        return $this;
    }

    public function getCategory(): ?Category
    {
        return $this->category;
    }

    public function setCategory(?Category $category): self
    {
        $this->category = $category;

        return $this;
    }

    /**
     * @return Collection<int, IssueBook>
     */
    public function getIssueBook(): Collection
    {
        return $this->issueBook;
    }

    public function addIssueBook(IssueBook $issueBook): self
    {
        if (!$this->issueBook->contains($issueBook)) {
            $this->issueBook[] = $issueBook;

        }

        return $this;
    }

    public function removeIssueBook(IssueBook $issueBook): self
    {
        $this->issueBook->removeElement($issueBook);

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
            $bookIssueBook->setBook($this);
        }

        return $this;
    }

    public function removeBookIssueBook(BookIssueBook $bookIssueBook): self
    {
        if ($this->bookIssueBooks->removeElement($bookIssueBook)) {
            // set the owning side to null (unless already changed)
            if ($bookIssueBook->getBook() === $this) {
                $bookIssueBook->setBook(null);
            }
        }

        return $this;
    }
}
