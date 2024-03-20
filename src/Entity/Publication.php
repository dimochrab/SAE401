<?php

namespace App\Entity;

use App\Repository\PublicationRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: PublicationRepository::class)]
class Publication
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column]
    private ?int $PostID = null;

    #[ORM\Column(type: Types::DATETIME_MUTABLE)]
    private ?\DateTimeInterface $DateTime = null;

    #[ORM\Column(nullable: true)]
    private ?int $LikesCount = null;

    #[ORM\ManyToOne(inversedBy: 'publications')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Utilisateur $UserID = null;


    #[ORM\OneToMany(targetEntity: Commentaire::class, mappedBy: 'PostID')]
    private Collection $commentaires;

    public function __construct()
    {
        $this->commentaires = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getPostID(): ?int
    {
        return $this->PostID;
    }

    public function setPostID(int $PostID): static
    {
        $this->PostID = $PostID;

        return $this;
    }

    public function getDateTime(): ?\DateTimeInterface
    {
        return $this->DateTime;
    }

    public function setDateTime(\DateTimeInterface $DateTime): static
    {
        $this->DateTime = $DateTime;

        return $this;
    }

    public function getLikesCount(): ?int
    {
        return $this->LikesCount;
    }

    public function setLikesCount(?int $LikesCount): static
    {
        $this->LikesCount = $LikesCount;

        return $this;
    }

    public function getUserID(): ?Utilisateur
    {
        return $this->UserID;
    }

    public function setUserID(?Utilisateur $UserID): static
    {
        $this->UserID = $UserID;

        return $this;
    }


    /**
     * @return Collection<int, Commentaire>
     */
    public function getCommentaires(): Collection
    {
        return $this->commentaires;
    }

    public function addCommentaire(Commentaire $commentaire): static
    {
        if (!$this->commentaires->contains($commentaire)) {
            $this->commentaires->add($commentaire);
            $commentaire->setPostID($this);
        }

        return $this;
    }

    public function removeCommentaire(Commentaire $commentaire): static
    {
        if ($this->commentaires->removeElement($commentaire)) {
            // set the owning side to null (unless already changed)
            if ($commentaire->getPostID() === $this) {
                $commentaire->setPostID(null);
            }
        }

        return $this;
    }
}
