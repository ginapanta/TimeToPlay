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

class DefaultController extends Controller {




    public function indexAction() {
        return $this->render('GinaTestBundle:Default:index.html.twig');
    }
    
    public function choixRegisterAction() {
        return $this->render('GinaTestBundle:Default:choix.html.twig');
    }

    
     public function inclureAction(User $user) {
    
        return $this->render('GinaTestBundle:Default:inclure.html.twig', array(
            'user'=>$user
        ));
    }
    
    
    public function rechercheArtisteAction() {
        return $this->render('GinaTestBundle:Default:index.html.twig');
    }

    public function rechercheMediaAction() {
        return $this->render('GinaTestBundle:Default:index.html.twig');
    }

    public function rechercheGenreAction() {
        return $this->render('GinaTestBundle:Default:index.html.twig');
    }


}
