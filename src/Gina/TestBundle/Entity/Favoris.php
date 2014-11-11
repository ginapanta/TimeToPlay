<?php

namespace Gina\TestBundle\Entity;

use Doctrine\ORM\Mapping as ORM;


/**
 * Favoris
 *
 * @ORM\Table()
 * @ORM\Entity(repositoryClass="Gina\TestBundle\Entity\FavorisRepository")
 */
class Favoris
{
    

      /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;
    

    
     /**
     * @ORM\ManyToMany (targetEntity="Gina\UserBundle\Entity\Musiciens", inversedBy="favoris")
     */
    private $musiciens;
    
    
//   /**
//     * @ORM\OneToOne (targetEntity="Gina\TestBundle\Entity\FavorisVisiteurs")
//     */
//    private $FavorisVisiteurs;
    
    

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
     * Add musiciens
     *
     * @param \Gina\UserBundle\Entity\Musiciens $musiciens
     * @return Favoris
     */
    public function addMusicien(\Gina\UserBundle\Entity\Musiciens $musiciens)
    {
        $this->musiciens[] = $musiciens;

        return $this;
    }

    /**
     * Remove musiciens
     *
     * @param \Gina\UserBundle\Entity\Musiciens $musiciens
     */
    public function removeMusicien(\Gina\UserBundle\Entity\Musiciens $musiciens)
    {
        $this->musiciens->removeElement($musiciens);
    }

    /**
     * Get musiciens
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getMusiciens()
    {
        return $this->musiciens;
    }

//    function getFavorisVisiteurs() {
//        return $this->FavorisVisiteurs;
//    }
//
//    function setFavorisVisiteurs($FavorisVisiteurs) {
//        $this->FavorisVisiteurs = $FavorisVisiteurs;
//    }


}
