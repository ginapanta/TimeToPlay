<?php

namespace Gina\TestBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Telechargements
 *
 * @ORM\Table()
 * @ORM\Entity(repositoryClass="Gina\TestBundle\Entity\TelechargementsRepository")
 */
class Telechargements
{
    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;
    
//       /**
//     * 
//     * @ORM\ManyToMany(targetEntity="Gina\TestBundle\Entity\Medias",inversedBy="telechargements",cascade={"persist"})
//     * @ORM\JoinTable(name= "telechargements_medias",
//      *              joinColumns= {@ORM\JoinColumn(name="telechargements_id", referencedColumnName="id" )},
//      *               inverseJoinColumns={@ORM\JoinColumn(name="medias_id", referencedColumnName="id") } )
//     */   
//    private $medias;
    
    
    
    /**
     *
     * @ORM\OneToOne(targetEntity="Gina\UserBundle\Entity\Visiteurs")
     * 
     */  
    private $visiteurs;
    
    


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
     * Set visiteurs
     *
     * @param \Gina\UserBundle\Entity\Visiteurs $visiteurs
     * @return Telechargements
     */
    public function setVisiteurs(\Gina\UserBundle\Entity\Visiteurs $visiteurs = null)
    {
        $this->visiteurs = $visiteurs;
    
        return $this;
    }

    /**
     * Get visiteurs
     *
     * @return \Gina\UserBundle\Entity\Visiteurs 
     */
    public function getVisiteurs()
    {
        return $this->visiteurs;
    }

//    /**
//     * Add medias
//     *
//     * @param \Gina\TestBundle\Entity\Medias $medias
//     * @return Telechargements
//     */
//    public function addMedia(\Gina\TestBundle\Entity\Medias $medias)
//    {
//        $this->medias[] = $medias;
//    
//        return $this;
//    }
//
//    /**
//     * Remove medias
//     *
//     * @param \Gina\TestBundle\Entity\Medias $medias
//     */
//    public function removeMedia(\Gina\TestBundle\Entity\Medias $medias)
//    {
//        $this->medias->removeElement($medias);
//    }
//
//    /**
//     * Get medias
//     *
//     * @return \Doctrine\Common\Collections\Collection 
//     */
//    public function getMedias()
//    {
//        return $this->medias;
//    }
}
