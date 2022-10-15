<?php

namespace App\Entity;

use App\Repository\BookIssueBookRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=BookIssueBookRepository::class)
 */
class BookIssueBook
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\ManyToOne(targetEntity=Book::class, inversedBy="bookIssueBooks")
     */
    private $book;

    /**
     * @ORM\ManyToOne(targetEntity=IssueBook::class, inversedBy="bookIssueBooks")
     */
    private $issueBook;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getBook(): ?Book
    {
        return $this->book;
    }

    public function setBook(?Book $book): self
    {
        $this->book = $book;

        return $this;
    }

    public function getIssueBook(): ?IssueBook
    {
        return $this->issueBook;
    }

    public function setIssueBook(?IssueBook $issueBook): self
    {
        $this->issueBook = $issueBook;

        return $this;
    }
}
