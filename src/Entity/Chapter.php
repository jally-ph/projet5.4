<?php

namespace App\Entity;

use App\Entity\User;
use Doctrine\ORM\Mapping as ORM;
use App\Repository\ChapterRepository;
use Doctrine\ORM\PersistentCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\Common\Collections\ArrayCollection;

/**
 * @ORM\Entity(repositoryClass=ChapterRepository::class)
 */
class Chapter
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;


    /**
     * @ORM\Column(type="string", length=255)
     */
    private $title;

    /**
     * @ORM\Column(type="text", length=65535)
     */
    private $content;

    /**
     * @ORM\Column(type="datetime")
     */
    private $publishedDate;

    /**
     * @ORM\ManyToOne(targetEntity=Books::class, inversedBy="chapters")
     * @ORM\JoinColumn(nullable=false)
     */
    private $books;

    /**
     * @ORM\OneToMany(targetEntity=Comment::class, mappedBy="chapter", orphanRemoval=true)
     */
    private $comments;

    /**
     * @ORM\Column(type="boolean")
     */
    private $public;

    /**
     * @ORM\Column(type="boolean")
     */
    private $completed;

    /**
     * @ORM\OneToMany(targetEntity=Like::class, mappedBy="chapter")
     */
    private $likes;


  

    public function __construct()
    {
        $this->comments = new ArrayCollection();
        $this->likes = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }



    public function getTitle(): ?string
    {
        return $this->title;
    }

    public function setTitle(string $title): self
    {
        $this->title = $title;

        return $this;
    }

    public function getContent(): ?string
    {
        return $this->content;
    }

    public function setContent(string $content): self
    {
        $this->content = $content;

        return $this;
    }

    public function getPublishedDate(): ?\DateTimeInterface
    {
        return $this->publishedDate;
    }

    public function setPublishedDate(\DateTimeInterface $publishedDate): self
    {
        $this->publishedDate = $publishedDate;

        return $this;
    }

    public function getBooks(): ?Books
    {
        return $this->books;
    }

    public function setBooks(?Books $books): self
    {
        $this->books = $books;

        return $this;
    }

    /**
     * @return Collection|Comment[]
     */
    public function getComments(): Collection
    {
        return $this->comments;
    }

    public function addComment(Comment $comment): self
    {
        if (!$this->comments->contains($comment)) {
            $this->comments[] = $comment;
            $comment->setChapter($this);
        }

        return $this;
    }

    public function removeComment(Comment $comment): self
    {
        if ($this->comments->contains($comment)) {
            $this->comments->removeElement($comment);
            // set the owning side to null (unless already changed)
            if ($comment->getChapter() === $this) {
                $comment->setChapter(null);
            }
        }

        return $this;
    }

    public function getPublic(): ?bool
    {
        return $this->public;
    }

    public function setPublic(bool $public): self
    {
        $this->public = $public;

        return $this;
    }

    public function getCompleted(): ?bool
    {
        return $this->completed;
    }

    public function setCompleted(bool $completed): self
    {
        $this->completed = $completed;

        return $this;
    }

    /**
     * @return Collection|Like[]
     */
    public function getLikes(): Collection
    {
        return $this->likes;
    }

    public function addLike(Like $like): self
    {
        if (!$this->likes->contains($like)) {
            $this->likes[] = $like;
            $like->setChapter($this);
        }

        return $this;
    }

    public function removeLike(Like $like): self
    {
        if ($this->likes->contains($like)) {
            $this->likes->removeElement($like);
            // set the owning side to null (unless already changed)
            if ($like->getChapter() === $this) {
                $like->setChapter(null);
            }
        }

        return $this;
    }

    /*
    * savoir si le chap est liké par cet user
    */
    public function isLikedByUser(User $user) : bool {
        
        foreach($this->likes as $like){
            if ($like->getUser() === $user) return true;
        }

        return false;
    }
}
