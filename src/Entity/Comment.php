<?php

namespace App\Entity;

use App\Repository\CommentRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: CommentRepository::class)]
class Comment
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\ManyToOne(inversedBy: 'comments')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Fruit $content = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getContent(): ?Fruit
    {
        return $this->content;
    }

    public function setContent(?Fruit $content): static
    {
        $this->content = $content;

        return $this;
    }
}
