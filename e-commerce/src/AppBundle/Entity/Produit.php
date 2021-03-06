<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Produit
 *
 * @ORM\Table(name="produit")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\ProduitRepository")
 */
class Produit
{
    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="integer", precision=0, scale=0, nullable=false, unique=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $id;

    /**
     * @var string
     *
     * @ORM\Column(name="libelle", type="string", length=255, precision=0, scale=0, nullable=false, unique=false)
     */
    private $libelle;

    /**
     * @var string
     *
     * @ORM\Column(name="desc_court", type="text", precision=0, scale=0, nullable=false, unique=false)
     */
    private $descCourt;

    /**
     * @var string
     *
     * @ORM\Column(name="desc_long", type="text", precision=0, scale=0, nullable=false, unique=false)
     */
    private $descLong;

    /**
     * @var string
     *
     * @ORM\Column(name="image_princ", type="string", length=255, precision=0, scale=0, nullable=false, unique=false)
     */
    private $imagePrinc;

    /**
     * @var string
     *
     * @ORM\Column(name="image_1", type="string", length=255, precision=0, scale=0, nullable=false, unique=false)
     */
    private $image1;

    /**
     * @var string
     *
     * @ORM\Column(name="image_2", type="string", length=255, precision=0, scale=0, nullable=false, unique=false)
     */
    private $image2;

    /**
     * @var string
     *
     * @ORM\Column(name="prix", type="decimal", precision=5, scale=2, nullable=false, unique=false)
     */
    private $prix;

    /**
     * @var \Doctrine\Common\Collections\Collection
     *
     * @ORM\ManyToMany(targetEntity="Categorie", inversedBy="produits")
     * @ORM\JoinTable(name="categorie_produit",
     *   joinColumns={
     *     @ORM\JoinColumn(name="produit_id", referencedColumnName="id", onDelete="CASCADE")
     *   },
     *   inverseJoinColumns={
     *     @ORM\JoinColumn(name="categorie_id", referencedColumnName="id", onDelete="CASCADE")
     *   }
     * )
     */
    private $categories;

    /**
     * @ORM\Column(name="slug", type="string", length=50, unique=true)
     */
    private $slug;

    /**
     * @var string
     *
     * @ORM\Column(name="inStock", type="boolean")
     */
    private $inStock;


    /**
     * @ORM\OneToMany(targetEntity="Avis",mappedBy="produit_id")
     */
    private $Avis;



    /**
     * Constructor
     */
    public function __construct()
    {
        $this->categories = new \Doctrine\Common\Collections\ArrayCollection();
    }


    /**
     * Get id
     *
     * @return integer
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set libelle
     *
     * @param string $libelle
     *
     * @return Produit
     */
    public function setLibelle($libelle)
    {
        $this->libelle = $libelle;

        return $this;
    }

    /**
     * Get libelle
     *
     * @return string
     */
    public function getLibelle()
    {
        return $this->libelle;
    }

    /**
     * Set descCourt
     *
     * @param string $descCourt
     *
     * @return Produit
     */
    public function setDescCourt($descCourt)
    {
        $this->descCourt = $descCourt;

        return $this;
    }

    /**
     * Get descCourt
     *
     * @return string
     */
    public function getDescCourt()
    {
        return $this->descCourt;
    }

    /**
     * Set descLong
     *
     * @param string $descLong
     *
     * @return Produit
     */
    public function setDescLong($descLong)
    {
        $this->descLong = $descLong;

        return $this;
    }

    /**
     * Get descLong
     *
     * @return string
     */
    public function getDescLong()
    {
        return $this->descLong;
    }

    /**
     * Set imagePrinc
     *
     * @param string $imagePrinc
     *
     * @return Produit
     */
    public function setImagePrinc($imagePrinc)
    {
        $this->imagePrinc = $imagePrinc;

        return $this;
    }

    /**
     * Get imagePrinc
     *
     * @return string
     */
    public function getImagePrinc()
    {
        return $this->imagePrinc;
    }

    /**
     * Set image1
     *
     * @param string $image1
     *
     * @return Produit
     */
    public function setImage1($image1)
    {
        $this->image1 = $image1;

        return $this;
    }

    /**
     * Get image1
     *
     * @return string
     */
    public function getImage1()
    {
        return $this->image1;
    }

    /**
     * Set image2
     *
     * @param string $image2
     *
     * @return Produit
     */
    public function setImage2($image2)
    {
        $this->image2 = $image2;

        return $this;
    }

    /**
     * Get image2
     *
     * @return string
     */
    public function getImage2()
    {
        return $this->image2;
    }

    /**
     * Set prix
     *
     * @param string $prix
     *
     * @return Produit
     */
    public function setPrix($prix)
    {
        $this->prix = $prix;

        return $this;
    }

    /**
     * Get prix
     *
     * @return string
     */
    public function getPrix()
    {
        return $this->prix;
    }

    /**
     * Add category
     *
     * @param \AppBundle\Entity\Categorie $category
     *
     * @return Produit
     */
    public function addCategory(\AppBundle\Entity\Categorie $category)
    {
        $this->categories[] = $category;

        return $this;
    }

    /**
     * Remove category
     *
     * @param \AppBundle\Entity\Categorie $category
     */
    public function removeCategory(\AppBundle\Entity\Categorie $category)
    {
        $this->categories->removeElement($category);
    }

    /**
     * Get categories
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getCategories()
    {
        return $this->categories;
    }

    /**
     * Set slug
     *
     * @param string $slug
     *
     * @return Produit
     */
    public function setSlug($slug)
    {
        $this->slug = $slug;

        return $this;
    }

    /**
     * Get slug
     *
     * @return string
     */
    public function getSlug()
    {
        return $this->slug;
    }
    public function __toString()
    {
        return $this->getLibelle();
    }

    /**
     * Set inStock
     *
     * @param boolean $inStock
     *
     * @return Produit
     */
    public function setInStock($inStock)
    {
        $this->inStock = $inStock;

        return $this;
    }

    /**
     * Get inStock
     *
     * @return boolean
     */
    public function getInStock()
    {
        return $this->inStock;
    }
    public function getProduit(){
        return $this;
    }

    /**
     * Add avi
     *
     * @param \AppBundle\Entity\Avis $avi
     *
     * @return Produit
     */
    public function addAvi(\AppBundle\Entity\Avis $avi)
    {
        $this->Avis[] = $avi;

        return $this;
    }

    /**
     * Remove avi
     *
     * @param \AppBundle\Entity\Avis $avi
     */
    public function removeAvi(\AppBundle\Entity\Avis $avi)
    {
        $this->Avis->removeElement($avi);
    }

    /**
     * Get avis
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getAvis()
    {
        return $this->Avis;
    }
}
