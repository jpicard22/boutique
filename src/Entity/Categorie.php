<?php

namespace App\Entity;

use App\Repository\CategorieRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=CategorieRepository::class)
 */
class Categorie
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=50)
     */
    private $libelleC;

    /**
     * @ORM\Column(type="date")
     */
    private $dateAjoutC;

    /**
     * @ORM\ManyToMany(targetEntity=Produit::class, mappedBy="categories")
     */
    private $produits;

    

    public function __construct()
    {
        $this->produits = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getLibelleC(): ?string
    {
        return $this->libelleC;
    }

    public function setLibelleC(string $libelleC): self
    {
        $this->libelleC = $libelleC;

        return $this;
    }

    public function getDateAjoutC(): ?\DateTimeInterface
    {
        return $this->dateAjoutC;
    }

    public function setDateAjoutC(\DateTimeInterface $dateAjoutC): self
    {
        $this->dateAjoutC = $dateAjoutC;

        return $this;
    }

    /**
     * @return Collection<int, Produit>
     */
    public function getProduits(): Collection
    {
        return $this->produits;
    }

    public function addProduit(Produit $produit): self
    {
        if (!$this->produits->contains($produit)) {
            $this->produits[] = $produit;
            $produit->addCategory($this);
        }

        return $this;
    }

    public function removeProduit(Produit $produit): self
    {
        if ($this->produits->removeElement($produit)) {
            $produit->removeCategory($this);
        }

        return $this;
    }

   
}
