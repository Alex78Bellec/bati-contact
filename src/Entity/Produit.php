<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\ProduitRepository")
 */
class Produit
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
    private $category;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $type;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $matiere;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Fabricant", inversedBy="produits")
     * @ORM\JoinColumn(nullable=false)
     */
    private $fabric;

    /**
     * @ORM\ManyToMany(targetEntity="App\Entity\Distributeur", inversedBy="produits")
     */
    private $distrib;

    public function __construct()
    {
        $this->distrib = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getCategory(): ?string
    {
        return $this->category;
    }

    public function setCategory(string $category): self
    {
        $this->category = $category;

        return $this;
    }

    public function getType(): ?string
    {
        return $this->type;
    }

    public function setType(string $type): self
    {
        $this->type = $type;

        return $this;
    }

    public function getMatiere(): ?string
    {
        return $this->matiere;
    }

    public function setMatiere(string $matiere): self
    {
        $this->matiere = $matiere;

        return $this;
    }

    public function getFabric(): ?fabricant
    {
        return $this->fabric;
    }

    public function setFabric(?fabricant $fabric): self
    {
        $this->fabric = $fabric;

        return $this;
    }

    public function __toString()
    {
        return $this->category;
    }

    /**
     * @return Collection|distributeur[]
     */
    public function getDistrib(): Collection
    {
        return $this->distrib;
    }

    public function addDistrib(distributeur $distrib): self
    {
        if (!$this->distrib->contains($distrib)) {
            $this->distrib[] = $distrib;
        }

        return $this;
    }

    public function removeDistrib(distributeur $distrib): self
    {
        if ($this->distrib->contains($distrib)) {
            $this->distrib->removeElement($distrib);
        }

        return $this;
    }


}
