<?php

namespace App\Entity;

use App\Repository\RecipeRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: RecipeRepository::class)]
class Recipe
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $name = null;

    #[ORM\Column(nullable: true)]
    private ?array $ingredients = null;

    #[ORM\Column]
    private array $instructions = [];

    #[ORM\Column(nullable: true)]
    private ?int $prepTimeMinutes = null;

    #[ORM\Column(nullable: true)]
    private ?int $cookTimeMinutes = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $difficulty = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(?string $name): static
    {
        $this->name = $name;

        return $this;
    }

    public function getIngredients(): ?array
    {
        return $this->ingredients;
    }

    public function setIngredients(?array $ingredients): static
    {
        $this->ingredients = $ingredients;

        return $this;
    }

    public function getInstructions(): array
    {
        return $this->instructions;
    }

    public function setInstructions(array $instructions): static
    {
        $this->instructions = $instructions;

        return $this;
    }

    public function getPrepTimeMinutes(): ?int
    {
        return $this->prepTimeMinutes;
    }

    public function setPrepTimeMinutes(?int $prepTimeMinutes): static
    {
        $this->prepTimeMinutes = $prepTimeMinutes;

        return $this;
    }

    public function getCookTimeMinutes(): ?int
    {
        return $this->cookTimeMinutes;
    }

    public function setCookTimeMinutes(?int $cookTimeMinutes): static
    {
        $this->cookTimeMinutes = $cookTimeMinutes;

        return $this;
    }

    public function getDifficulty(): ?string
    {
        return $this->difficulty;
    }

    public function setDifficulty(?string $difficulty): static
    {
        $this->difficulty = $difficulty;

        return $this;
    }
}
