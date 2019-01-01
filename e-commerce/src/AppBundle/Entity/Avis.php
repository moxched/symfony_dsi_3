<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Avis
 *
 * @ORM\Table(name="avis")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\AvisRepository")
 */
class Avis
{
    /**
     * @var int
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var string
     *
     * @ORM\Column(name="avis", type="text")
     */
    private $avis;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="date", type="datetime")
     */
    private $date;

    /**
     * @var int
     *
     * @ORM\Column(name="rate", type="integer")
     */
    private $rate;

    /**
     * @var string
     *
     * @ORM\Column(name="prop", type="string", length=255)
     */
    private $prop;

    /**
     * @ORM\ManyToOne(targetEntity="Produit",inversedBy="Avis")
     */
    private $produit_id;

    /**
     * Get id
     *
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set avis
     *
     * @param string $avis
     *
     * @return Avis
     */
    public function setAvis($avis)
    {
        $this->avis = $avis;

        return $this;
    }

    /**
     * Get avis
     *
     * @return string
     */
    public function getAvis()
    {
        return $this->avis;
    }

    /**
     * Set date
     *
     * @param \DateTime $date
     *
     * @return Avis
     */
    public function setDate($date)
    {
        $this->date = $date;

        return $this;
    }

    /**
     * Get date
     *
     * @return \DateTime
     */
    public function getDate()
    {
        return $this->date;
    }

    /**
     * Set rate
     *
     * @param integer $rate
     *
     * @return Avis
     */
    public function setRate($rate)
    {
        $this->rate = $rate;

        return $this;
    }

    /**
     * Get rate
     *
     * @return int
     */
    public function getRate()
    {
        return $this->rate;
    }

    /**
     * Set prop
     *
     * @param string $prop
     *
     * @return Avis
     */
    public function setProp($prop)
    {
        $this->prop = $prop;

        return $this;
    }

    /**
     * Get prop
     *
     * @return string
     */
    public function getProp()
    {
        return $this->prop;
    }

    /**
     * Set produitId
     *
     * @param \AppBundle\Entity\Produit $produitId
     *
     * @return Avis
     */
    public function setProduitId(\AppBundle\Entity\Produit $produitId = null)
    {
        $this->produit_id = $produitId;

        return $this;
    }

    /**
     * Get produitId
     *
     * @return \AppBundle\Entity\Produit
     */
    public function getProduitId()
    {
        return $this->produit_id;
    }
    public function __toString()
    {
        return $this->avis.'__'.$this->prop.'__'.'__'.$this->id.'__'.$this->produit_id;
    }
    public function __construct()
    {
        $this->date = new \DateTime();
    }
}
