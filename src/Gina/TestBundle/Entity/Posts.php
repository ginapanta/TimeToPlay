<?php

namespace Gina\TestBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Posts
 *
 * @ORM\Table()
 * @ORM\Entity(repositoryClass="Gina\TestBundle\Entity\PostsRepository")
 */
class Posts
{
    
    
      /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;
    
  

    /**
     * @var string
     *
     * @ORM\Column(name="titre", type="string", length=255)
     */
    private $titre;

    /**
     * @var string
     *
     * @ORM\Column(name="contenu", type="string", length=255)
     */
    private $contenu;
    
    
    
  /**
     * @ORM\ManyToOne (targetEntity="Gina\UserBundle\Entity\Visiteurs", inversedBy="posts", cascade= {"persist"})
     */
    private $visiteurs;
    
    
//      /**
//     * @ORM\OneToOne (targetEntity="Gina\TestBundle\Entity\MediasPosts", cascade={"persist"} )
//     * 
//     */
//    private $mediasPosts;
    
    

  
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
     * Set titre
     *
     * @param string $titre
     * @return Posts
     */
    public function setTitre($titre)
    {
        $this->titre = $titre;

        return $this;
    }

    /**
     * Get titre
     *
     * @return string 
     */
    public function getTitre()
    {
        return $this->titre;
    }

    /**
     * Set contenu
     *
     * @param string $contenu
     * @return Posts
     */
    public function setContenu($contenu)
    {
        $this->contenu = $contenu;

        return $this;
    }

    /**
     * Get contenu
     *
     * @return string 
     */
    public function getContenu()
    {
        return $this->contenu;
    }

   
  /**
     * Set visiteurs
     *
     * @param \Gina\UserBundle\Entity\Visiteurs $visiteurs
     * @return Posts
     */
    public function setVisiteurs(\Gina\UserBundle\Entity\Visiteurs $visiteurs )
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
//     * Set mediasPosts
//     *
//     * @param \Gina\TestBundle\Entity\MediasPosts $mediasPosts
//     * @return Posts
//     */
//    public function setMediasPosts(\Gina\TestBundle\Entity\MediasPosts $mediasPosts = null)
//    {
//        $this->mediasPosts = $mediasPosts;
//    
//        return $this;
//    }
//
//    /**
//     * Get mediasPosts
//     *
//     * @return \Gina\TestBundle\Entity\MediasPosts 
//     */
//    public function getMediasPosts()
//    {
//        return $this->mediasPosts;
//    }
}
