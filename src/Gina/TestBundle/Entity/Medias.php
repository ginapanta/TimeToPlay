<?php

namespace Gina\TestBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\HttpFoundation\File\File;





/**
 * Medias
 *@ORM\HasLifecycleCallbacks
 * @ORM\Table()
 * @ORM\Entity(repositoryClass="Gina\TestBundle\Entity\MediasRepository")
 */
class Medias
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
     * @var string
     *
     * @ORM\Column(name="titre", type="string", length=255, nullable=false)
     */
    private $titre;

    /**
     * @var string
     *
     * @ORM\Column(name="description", type="string", length=255,nullable=true)
     */
    private $description;

   

   
    
    /**
     * @var string
     *
     * @ORM\Column(name="genres", type="string", length=255,nullable=false)
     */
    private $genres;
    
     
    
    
    /**
     * @ORM\Column( nullable=true)
     */
    private $path;
    
    
    
     /**
     * Audio file
     *
     * @var File
     * @Assert\File(
     *     
     *     maxSize = "10M",
     *     
     *    
     * )
     */
    public $file;
    

    
     /**
     * @ORM\OneToMany(targetEntity="Gina\TestBundle\Entity\MediasTelechargements",mappedBy="medias",cascade={"persist"})
     * @ORM\JoinColumn(nullable=false)
     */
    private $mediastelechargements;
    
    
    
   /**
     * @ORM\ManyToMany(targetEntity="Gina\TestBundle\Entity\Playlists",mappedBy="medias",cascade={"persist"})
     * @ORM\JoinColumn(nullable=false)
     */ 
    private $playlists;
    
    
    
    
      /**
     * 
     * @ORM\ManyToOne (targetEntity="Gina\UserBundle\Entity\Musiciens", inversedBy="medias")
     * @ORM\JoinColumn(nullable=false)
     *  
     */
    private $musiciens;
    
    
    
//     /**
//     * @ORM\OneToMany (targetEntity="Gina\TestBundle\Entity\MediasPosts", mappedBy="medias")
//     */
//    private $mediasPosts;
//    
 

    /**
     * Get id
     *
     * @return integer 
     */
    public function getId()
    {
        return $this->id;
    }

   
    
       public function getFile() {
        return $this->file;
    }

    public function setFile(File $file) {
        $this->file = $file;
    }
    
    
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
     * Set description
     *
     * @param string $description
     * @return Medias
     */
    public function setDescription($description)
    {
        $this->description = $description;

        return $this;
    }

    /**
     * Get description
     *
     * @return string 
     */
    public function getDescription()
    {
        return $this->description;
    }

 
    
     /**
     * Set genres
     *
     * @param string $genres
     * @return Medias
     */
    public function setGenres( $genres)
    {
        $this->genres = $genres;

        return $this;
    }
    
    
    /**
     * Get genres
     *
     * @return string 
     */
    public function getGenres()
    {
        return $this->genres;
    }

    
 
    
     /**
     * Constructor
     */
    public function __construct()
    {
        $this->telechargements = new \Doctrine\Common\Collections\ArrayCollection();    
        $this->playlist = new \Doctrine\Common\Collections\ArrayCollection();    
//        $this->posts = new \Doctrine\Common\Collections\ArrayCollection();

    }

    function getMediastelechargements() {
        return $this->mediastelechargements;
    }

    function setMediastelechargements($mediastelechargements) {
        $this->mediastelechargements = $mediastelechargements;
    }

    

    
    /**
     * Set musiciens
     *
     * @param \Gina\UserBundle\Entity\Musiciens $musiciens
     * @return Medias
     */
    public function setMusiciens(\Gina\UserBundle\Entity\Musiciens $musiciens)
    {        
        $this->musiciens = $musiciens;    
        
    }

    /**
     * Get musiciens
     *
     * @return \Gina\UserBundle\Entity\Musiciens 
     */
    public function getMusiciens()
    {
        return $this->musiciens;
    }



    /**
     * Set path
     *
     * @param string $path
     * @return Medias
     */
    public function setPath($path)
    {
        $this->path = $path;

        return $this;
    }

    /**
     * Get path
     *
     * @return string 
     */
    public function getPath()
    {
        return $this->path;
    }

   
    
    
   
  public function getAbsolutePath()
    {
        return null === $this->path ? null : $this->getUploadRootDir().'/'.$this->path;
    }

    public function getWebPath()
    {
        return null === $this->path ? null : $this->getUploadDir().'/'.$this->path;
    }

    protected function getUploadRootDir()
    {
        // le chemin absolu du répertoire où les documents uploadés doivent être sauvegardés
        return __DIR__.'/../../../../web/'.$this->getUploadDir();
    }

    protected function getUploadDir()
    {
        // get rid of the __DIR__ so it doesn't screw up
        // when displaying uploaded doc/image in the view.
        return 'uploads/medias';
    }



    /**
     * @ORM\PostPersist()
     * @ORM\PostUpdate()
     */
    public function upload()
    {
        
        if (null === $this->file) {
            return;
        }
         // Nous utilisons le nom de fichier original, donc il est dans la pratique
        // nécessaire de le nettoyer pour éviter les problèmes de sécurité

        // move copie le fichier présent chez le client dans le répertoire indiqué.
        $this->file->move($this->getUploadRootDir(), $this->file->getClientOriginalName());

        // On sauvegarde le nom de fichier
        $this->path = $this->file->getClientOriginalName();
       
        // La propriété file ne servira plus
        $this->file = null;
        
     

    }

    /**
     * @ORM\PostRemove()
     */
    public function removeUpload()
    {
        if ($file = $this->getAbsolutePath()) {
            unlink($file);
        }
    }

 
  
 

    /**
     * Add playlists
     *
     * @param \Gina\TestBundle\Entity\Playlists $playlists
     * @return Medias
     */
    public function addPlaylist(\Gina\TestBundle\Entity\Playlists $playlists)
    {
        $this->playlists[] = $playlists;
    
        return $this;
    }

    /**
     * Remove playlists
     *
     * @param \Gina\TestBundle\Entity\Playlists $playlists
     */
    public function removePlaylist(\Gina\TestBundle\Entity\Playlists $playlists)
    {
        $this->playlists->removeElement($playlists);
    }

    /**
     * Get playlists
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getPlaylists()
    {
        return $this->playlists;
    }

 

//    /**
//     * Add mediasPosts
//     *
//     * @param \Gina\TestBundle\Entity\MediasPosts $mediasPosts
//     * @return Medias
//     */
//    public function addMediasPost(\Gina\TestBundle\Entity\MediasPosts $mediasPosts)
//    {
//        $this->mediasPosts[] = $mediasPosts;
//    
//        return $this;
//    }
//
//    /**
//     * Remove mediasPosts
//     *
//     * @param \Gina\TestBundle\Entity\MediasPosts $mediasPosts
//     */
//    public function removeMediasPost(\Gina\TestBundle\Entity\MediasPosts $mediasPosts)
//    {
//        $this->mediasPosts->removeElement($mediasPosts);
//    }
//
//    /**
//     * Get mediasPosts
//     *
//     * @return \Doctrine\Common\Collections\Collection 
//     */
//    public function getMediasPosts()
//    {
//        return $this->mediasPosts;
//    }
}
