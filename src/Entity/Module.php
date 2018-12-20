<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Cocur\Slugify\Slugify;

/**
 * @ORM\Entity(repositoryClass="App\Repository\ModuleRepository")
 */
class Module
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
    private $titre;

    /**
     * @ORM\Column(type="boolean")
     */
    private $etatPublication;

    /**
     * @ORM\Column(type="text", nullable=true)
     */
    private $contenu;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $contenuCourt;

    /**
     * @ORM\Column(type="datetime")
     */
    private $dateInsertion;

    /**
     * @ORM\Column(type="datetime", nullable=true)
     */
    private $dateModification;

    /**
     * @ORM\ManyToMany(targetEntity="App\Entity\Categorie", inversedBy="modules", cascade={"persist"})
     * @ORM\JoinTable(name="module_categorie")
     */
    private $categories;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\PageModule", mappedBy="module", orphanRemoval=true)
     */
    private $pageModules;



    public function __construct()
    {
        $this->dateInsertion = new \DateTime();
        $this->categories = new ArrayCollection();
        $this->pageModules = new ArrayCollection();

    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getTitre(): ?string
    {
        return $this->titre;
    }

    public function setTitre(string $titre): self
    {
        $this->titre = $titre;

        return $this;
    }

    public function getSlug():string
    {
        return (new Slugify())->slugify($this->titre);
    }

    public function getEtatPublication(): ?bool
    {
        return $this->etatPublication;
    }

    public function setEtatPublication(bool $etatPublication): self
    {
        $this->etatPublication = $etatPublication;

        return $this;
    }

    public function getContenu(): ?string
    {
        return $this->contenu;
    }

    public function setContenu(?string $contenu): self
    {
        $this->contenu = $contenu;

        return $this;
    }

    public function getContenuCourt(): ?string
    {
        return $this->contenuCourt;
    }

    public function setContenuCourt(?string $contenuCourt): self
    {
        $this->contenuCourt = $contenuCourt;

        return $this;
    }

    public function getDateInsertion(): ?\DateTimeInterface
    {
        return $this->dateInsertion;
    }

    public function setDateInsertion(\DateTimeInterface $dateInsertion): self
    {
        $this->dateInsertion = $dateInsertion;

        return $this;
    }

    public function getDateModification(): ?\DateTimeInterface
    {
        return $this->dateModification;
    }

    public function setDateModification(?\DateTimeInterface $dateModification): self
    {
        $this->dateModification = $dateModification;

        return $this;
    }



    /**
     * @return Collection|Categorie[]
     */
    public function getCategories(): Collection
    {
        return $this->categories;
    }

    public function addCategory(Categorie $category): self
    {
        if (!$this->categories->contains($category)) {
            $this->categories[] = $category;
            $category->addModule($this);
        }

        return $this;
    }

    public function removeCategory(Categorie $category): self
    {
        if ($this->categories->contains($category)) {
            $this->categories->removeElement($category);
            $category->removeModule($this);
        }

        return $this;
    }

    /**
     * @return Collection|PageModule[]
     */
    public function getPageModules(): Collection
    {
        return $this->pageModules;
    }

    public function addPageModule(PageModule $pageModule): self
    {
        if (!$this->pageModules->contains($pageModule)) {
            $this->pageModules[] = $pageModule;
            $pageModule->setModule($this);
        }

        return $this;
    }

    public function removePageModule(PageModule $pageModule): self
    {
        if ($this->pageModules->contains($pageModule)) {
            $this->pageModules->removeElement($pageModule);
            // set the owning side to null (unless already changed)
            if ($pageModule->getModule() === $this) {
                $pageModule->setModule(null);
            }
        }

        return $this;
    }

}
