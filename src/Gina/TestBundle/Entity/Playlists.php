<?php

namespace Gina\TestBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Playlists
 *
 * @ORM\Table()
 * @ORM\Entity(repositoryClass="Gina\TestBundle\Entity\PlaylistsRepository")
 */
class Playlists
{
    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;
   
  
    
     /**
     * 
     * @ORM\ManyToMany(targetEntity="Gina\TestBundle\Entity\Medias",inversedBy="playlists",cascade={"persist"})
     * @ORM\JoinTable(name= "playlists_medias",
      *              joinColumns= {@ORM\JoinColumn(name="playlists_id", referencedColumnName="id" )},
      *               inverseJoinColumns={@ORM\JoinColumn(name="medias_id", referencedColumnName="id") } )
     */   
    private $medias;
    
    
     /**
     * 
     * @ORM\OneToOne(targetEntity="Gina\UserBundle\Entity\Visiteurs", cascade={"persist"})
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
     * Add medias
     *
     * @param \Gina\TestBundle\Entity\Medias $medias
     * @return Playlists
     */
    public function addMedia(\Gina\TestBundle\Entity\Medias $medias)
    {
        $this->medias[] = $medias;
        
        $medias->addPlaylist($this);

        return $this;
    }

    /**
     * Remove medias
     *
     * @param \Gina\TestBundle\Entity\Medias $medias
     */
    public function removeMedia(\Gina\TestBundle\Entity\Medias $medias)
    {
        $this->medias->removeElement($medias);
    }

    /**
     * Get medias
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getMedias()
    {
        return $this->medias;
    }

    

    /**
     * Set visiteurs
     *
     * @param \Gina\UserBundle\Entity\Visiteurs $visiteurs
     * @return Playlists
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
}
