<?php

namespace Gina\TestBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Gina\TestBundle\Entity\Medias;
use Gina\TestBundle\Entity\MediasRepository;
use Gina\TestBundle\Form\MediasType;
use Gina\TestBundle\Entity\Playlists;
use Gina\TestBundle\Entity\PlaylistsRepository;
use Gina\TestBundle\Entity\Favoris;
use Gina\TestBundle\Entity\FavorisRepository;
use Gina\UserBundle\Entity\User;
use Gina\UserBundle\Entity\UserRepository;
use Gina\UserBundle\Entity\Musiciens;
use Gina\UserBundle\Entity\Visiteurs;
use JMS\SecurityExtraBundle\Annotation\Secure;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;

class TablesController extends Controller {




    public function plusTelechargesAction() {
        
        
        
        return $this->render('GinaTestBundle:Tables:plusTelecharges.html.twig');
    }
    
    public function plusFavorisAction() {
        
        
        return $this->render('GinaTestBundle:Tables:plusFavoris.html.twig');
    }

    
     public function derniersUploadsAction() {
         
    
        return $this->render('GinaTestBundle:Tables:derniersUploads.html.twig', array(
        ));
    }
    
    
    

}
