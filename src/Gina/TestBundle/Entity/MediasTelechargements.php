<?php

namespace Gina\TestBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * MediasTelechargements
 *
 * @ORM\Table()
 * @ORM\Entity(repositoryClass="Gina\TestBundle\Entity\MediasTelechargementsRepository")
 */
class MediasTelechargements
{   
    
     /**
     *  @ORM\Id
     * @ORM\ManyToOne (targetEntity="Gina\TestBundle\Entity\Medias",inversedBy="mediastelechargements", cascade= {"persist"})
     */
    private $medias;
    
    
     /**
     *  @ORM\Id
     * @ORM\OneToOne (targetEntity="Gina\TestBundle\Entity\Telechargements",  cascade= {"persist"})
     */
    private $telechargements;
    
    

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="dateAjout", type="date")
     */
    private $dateTelechargement;

    
     function __construct() {
        $this->dateTelechargement = new \DateTime();
    }
    
 
   
    function getMedias() {
        return $this->medias;
    }

   

    function setMedias($medias) {
        $this->medias = $medias;
    }
    
    
    

        

    /**
     * Set dateTelechargement
     *
     * @param \DateTime $dateTelechargement
     * @return MediasTelechargements
     */
    public function setDateTelechargement($dateTelechargement)
    {
        $this->dateTelechargement = $dateTelechargement;
    
        return $this;
    }

    /**
     * Get dateTelechargement
     *
     * @return \DateTime 
     */
    public function getDateTelechargement()
    {
        return $this->dateTelechargement;
    }
    
    
    
         function getTelechargements() {
        return $this->telechargements;
    }

    function setTelechargements($telechargements) {
        $this->telechargements = $telechargements;
    }

}
