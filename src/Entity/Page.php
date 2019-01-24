<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\PageRepository")
 */
class Page
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
    private $titrePage;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $descriptionPage;

    /**
     * @ORM\Column(type="boolean")
     */
    private $etatPublicationPage;

    /**
     * @ORM\Column(type="datetime")
     */
    private $dateInsertionPage;

    /**
     * @ORM\Column(type="datetime", nullable=true)
     */
    private $dateModificationPage;

    /**
     * @ORM\ManyToMany(targetEntity="App\Entity\Categorie", inversedBy="pages")
     * @ORM\JoinTable(name="categorie_page")
     */
    private $categories;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\PageModule", mappedBy="page", orphanRemoval=true, fetch="EAGER")
     */
    private $pageModules;
    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Page", inversedBy="children")
     * @ORM\JoinColumn(name="parent_id", referencedColumnName="id")
     */

    private $parent;
    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Page", mappedBy="parent")
     */
    private $children;

    public function __construct()
    {
        $this->dateInsertionPage= new \DateTime();
        $this->categories = new ArrayCollection();
        $this->pageModules = new ArrayCollection();

    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getTitrePage(): ?string
    {
        return $this->titrePage;
    }

    public function setTitrePage(string $titrePage): self
    {
        $this->titrePage = $titrePage;

        return $this;
    }

    public function getDescriptionPage(): ?string
    {
        return $this->descriptionPage;
    }

    public function setDescriptionPage(?string $descriptionPage): self
    {
        $this->descriptionPage = $descriptionPage;

        return $this;
    }

    public function getEtatPublicationPage(): ?bool
    {
        return $this->etatPublicationPage;
    }

    public function setEtatPublicationPage(bool $etatPublicationPage): self
    {
        $this->etatPublicationPage = $etatPublicationPage;

        return $this;
    }

    public function getDateInsertionPage(): ?\DateTimeInterface
    {
        return $this->dateInsertionPage;
    }

    public function setDateInsertionPage(\DateTimeInterface $dateInsertionPage): self
    {
        $this->dateInsertionPage = $dateInsertionPage;

        return $this;
    }

    public function getDateModificationPage(): ?\DateTimeInterface
    {
        return $this->dateModificationPage;
    }

    public function setDateModificationPage(?\DateTimeInterface $dateModificationPage): self
    {
        $this->dateModificationPage = $dateModificationPage;

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
        }

        return $this;
    }

    public function removeCategory(Categorie $category): self
    {
        if ($this->categories->contains($category)) {
            $this->categories->removeElement($category);
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
            $pageModule->setPage($this);
        }

        return $this;
    }

    public function removePageModule(PageModule $pageModule): self
    {
        if ($this->pageModules->contains($pageModule)) {
            $this->pageModules->removeElement($pageModule);
            // set the owning side to null (unless already changed)
            if ($pageModule->getPage() === $this) {
                $pageModule->setPage(null);
            }
        }

        return $this;
    }
    /**
     * @return mixed
     */
    public function getParent()
    {
        return $this->parent;
    }

    /**
     * @param mixed $parent
     */
    public function setParent($parent): void
    {
        $this->parent = $parent;
    }

    /**
     * @return mixed
     */
    public function getChildren()
    {
        return $this->children;
    }

    /**
     * @param mixed $children
     */
    public function setChildren($children): void
    {
        $this->children = $children;
    }
}
