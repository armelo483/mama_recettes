<?php

namespace App\Entity;

use App\Repository\RecipeRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Cocur\Slugify\Slugify;

/**
 * @ORM\Entity(repositoryClass=RecipeRepository::class)
 */
class Recipe
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
    private $title;


    /**
     * @ORM\Column(type="text")
     */
    private $description;

    /**
     * @ORM\Column(type="datetime_immutable")
     */
    private $created_at;

    /**
     * @ORM\Column(type="datetime_immutable")
     */
    private $updated_at;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $image_url;

    /**
     * @ORM\Column(type="float")
     */
    private $budget;

    /**
     * @ORM\ManyToMany(targetEntity=Category::class, mappedBy="recipes")
     */
    private $categories;

    /**
     * @ORM\ManyToMany(targetEntity=Ingredient::class, mappedBy="recipes")
     */
    private $ingredients;

    /**
     * @ORM\Column(type="time", nullable=true)
     */
    private $cookingDuration;

    /**
     * @ORM\Column(type="boolean", nullable=true)
     */
    private $isMisEnAvant;

    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    private $niveau_difficulte;

    public function __construct()
    {
        $this->categories = new ArrayCollection();
        $this->ingredients = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getTitle(): ?string
    {
        return $this->title;
    }

    public function getSlug(): string {

        return (new Slugify())->slugify($this->title);
    }

    public function setTitle(string $title): self
    {
        $this->title = $title;

        return $this;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(string $description): self
    {
        $this->description = $description;

        return $this;
    }

    public function getCreatedAt(): ?\DateTimeImmutable
    {
        return $this->created_at;
    }

    public function setCreatedAt(\DateTimeImmutable $created_at): self
    {
        $this->created_at = $created_at;

        return $this;
    }

    public function getUpdatedAt(): ?\DateTimeImmutable
    {
        return $this->updated_at;
    }

    public function setUpdatedAt(\DateTimeImmutable $updated_at): self
    {
        $this->updated_at = $updated_at;

        return $this;
    }

    public function getImageUrl(): ?string
    {
        return $this->image_url;
    }

    public function setImageUrl(string $image_url): self
    {
        $this->image_url = $image_url;

        return $this;
    }

    public function getBudget(): ?float
    {
        return $this->budget;
    }

    public function setBudget(float $budget): self
    {
        $this->budget = $budget;

        return $this;
    }

    /**
     * @return Collection<int, Category>
     */
    public function getCategories(): Collection
    {
        return $this->categories;
    }

    public function addCategory(Category $category): self
    {
        if (!$this->categories->contains($category)) {
            $this->categories[] = $category;
            $category->addRecipe($this);
        }

        return $this;
    }

    public function removeCategory(Category $category): self
    {
        if ($this->categories->removeElement($category)) {
            $category->removeRecipe($this);
        }

        return $this;
    }

    /**
     * @return Collection<int, Category>
     */
    public function getIngredients(): Collection
    {
        return $this->ingredients;
    }

    public function addIngredient(Category $ingredient): self
    {
        if (!$this->ingredients->contains($ingredient)) {
            $this->ingredients[] = $ingredient;
            $ingredient->addIngredient($this);
        }

        return $this;
    }

    public function removeIngredient(Category $ingredient): self
    {
        if ($this->ingredients->removeElement($ingredient)) {
            $ingredient->removeIngredient($this);
        }

        return $this;
    }

    public function getCookingDuration(): ?\DateTimeInterface
    {
        return $this->cookingDuration;
    }

    public function setCookingDuration(?\DateTimeInterface $cookingDuration): self
    {
        $this->cookingDuration = $cookingDuration;

        return $this;
    }

    public function getIsMisEnAvant(): ?bool
    {
        return $this->isMisEnAvant;
    }

    public function setIsMisEnAvant(?bool $isMisEnAvant): self
    {
        $this->isMisEnAvant = $isMisEnAvant;

        return $this;
    }

    public function getNiveauDifficulte(): ?int
    {
        return $this->niveau_difficulte;
    }

    public function setNiveauDifficulte(?int $niveau_difficulte): self
    {
        $this->niveau_difficulte = $niveau_difficulte;

        return $this;
    }

}
