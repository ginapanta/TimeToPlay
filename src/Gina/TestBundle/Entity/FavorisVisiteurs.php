<?php

namespace Gina\TestBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * FavorisVisiteurs
 *
 * @ORM\Table()
 * @ORM\Entity(repositoryClass="Gina\TestBundle\Entity\FavorisVisiteursRepository")
 */
class FavorisVisiteurs
{
  
      /**
       * @ORM\Id
     * @ORM\OneToOne (targetEntity="Gina\UserBundle\Entity\Visiteurs",  cascade= {"persist"})
     */
    private $Visiteurs;
    
     /**
      * @ORM\Id
     * @ORM\OneToOne (targetEntity="Gina\TestBundle\Entity\Favoris",  cascade= {"persist"})
     */
    private $Favoris;

    /**
     * @var string
     *
     * @ORM\Column(name="dateAjout", type="string", length=255)
     */
    private $dateAjout;
    

     public function __construct() {
        $this->dateAjout = new DateTime();
    }


    /**
     * Set dateAjout
     *
     * @param string $dateAjout
     * @return FavorisVisiteurs
     */
    public function setDateAjout($dateAjout)
    {
        $this->dateAjout = $dateAjout;
    
        return $this;
    }

    /**
     * Get dateAjout
     *
     * @return string 
     */
    public function getDateAjout()
    {
        return $this->dateAjout;
    }

    /**
     * Set Visiteurs
     *
     * @param \Gina\UserBundle\Entity\Visiteurs $visiteurs
     * @return FavorisVisiteurs
     */
    public function setVisiteurs(\Gina\UserBundle\Entity\Visiteurs $visiteurs = null)
    {
        $this->Visiteurs = $visiteurs;
    
        return $this;
    }

    /**
     * Get Visiteurs
     *
     * @return \Gina\UserBundle\Entity\Visiteurs 
     */
    public function getVisiteurs()
    {
        return $this->Visiteurs;
    }

    /**
     * Set Favoris
     *
     * @param \Gina\UserBundle\Entity\Favoris $favoris
     * @return FavorisVisiteurs
     */
    public function setFavoris(\Gina\UserBundle\Entity\Favoris $favoris = null)
    {
        $this->Favoris = $favoris;
    
        return $this;
    }

    /**
     * Get Favoris
     *
     * @return \Gina\UserBundle\Entity\Favoris 
     */
    public function getFavoris()
    {
        return $this->Favoris;
    }
}
