<?php

namespace Gina\TestBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use DateTime;
/**
 * MediasPosts
 *
 * @ORM\Table()
 * @ORM\Entity
 */
class MediasPosts
{
   
      /**
      *  @ORM\Id
     * @ORM\ManyToOne (targetEntity="Gina\TestBundle\Entity\Medias")
     */
    private $medias;
    
      /**
      *  @ORM\Id
     * @ORM\OneToOne (targetEntity="Gina\TestBundle\Entity\Posts")
     */
    private $posts;
    
    

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="dateAjout", type="date")
     */
    private $dateAjout ;

//     public function __date(){
//         
//        $this->dateAjout=new \DateTime();
//    }

    public function __construct() {
        $this->dateAjout = new DateTime();
    }
    
    
    public function getDateAjout() {
        return $this->dateAjout;
    }

    public function setDateAjout(DateTime $dateAjout) {
        $this->dateAjout = $dateAjout;
    }

    
    /**
     * Set medias
     *
     * @param \Gina\TestBundle\Entity\Medias $medias
     * @return MediasPosts
     */
    public function setMedias(\Gina\TestBundle\Entity\Medias $medias = null)
    {
        $this->medias = $medias;
    
        return $this;
    }

    /**
     * Get medias
     *
     * @return \Gina\TestBundle\Entity\Medias 
     */
    public function getMedias()
    {
        return $this->medias;
    }

    /**
     * Set posts
     *
     * @param \Gina\TestBundle\Entity\Posts $posts
     * @return MediasPosts
     */
    public function setPosts(\Gina\TestBundle\Entity\Posts $posts = null)
    {
        $this->posts = $posts;
    
        return $this;
    }

    /**
     * Get posts
     *
     * @return \Gina\TestBundle\Entity\Posts 
     */
    public function getPosts()
    {
        return $this->posts;
    }
}
