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

class ArtisteController extends Controller {

    //Index


   public function pageArtisteAction($id) {

        $id = $this->get('security.context')->getToken()->getUser()->getId();
        $em = $this->getDoctrine()->getManager();
        $musicien = $em->getRepository('GinaUserBundle:Musiciens')->findOneById($id);
        return $this->render('GinaTestBundle:Artiste:pageArtiste.html.twig', array(
                    'id' => $id,
                    'musicien' => $musicien
        ));
    }


    public function listeArtistesAction() {

        $em = $this->getDoctrine()->getManager();
        $musiciens = $em->getRepository("GinaUserBundle:Musiciens")->findAll();

        return $this->render('GinaTestBundle:Artiste:listeArtistes.html.twig', array(
                    'musiciens' => $musiciens,
        ));
    }

//    public function formEditMusicienAction(Request $request, Musiciens $musicien) {
//
//        $em = $this->getDoctrine()->getManager();
//        $form = $this->createForm(new RegisMusiciensFormType(), $musicien);
//
//        if ($request->isMethod('POST')) {
//            $form->handleRequest($request);
//
//            if ($form->isValid()) {
//                $m = $form->getData();
//
//                $em->persist($m);
//                $em->flush();
//
//                return $this->redirect($this->generateUrl('gina_test_pageArtiste', array(
//                                    'id' => $musicien->getId(),
//                                    'musicien' => $musicien
//                )));
//            }
//        }
//        return $this->render('GinaTestBundle:Artiste:formMusicien.html.twig', array(
//                    'id' => $musicien->getId(),
//                    'form' => $form->createView())
//        );
//    }
//    
        public function publicArtisteAction($id) {

                $em = $this->getDoctrine()->getManager();
                $musicien = $em->getRepository("GinaUserBundle:Musiciens")->findOneById(array('id' => $id));

                return $this->render('GinaTestBundle:Artiste:publicArtiste.html.twig', array(
                    'id' => $id,
                    'musicien' => $musicien,
                 ));
         }
                
        public function tableFavAction($id) {

        $em = $this->getDoctrine()->getManager();
        $musicien = $em->getRepository("GinaUserBundle:Musiciens")->findOneById( $id);
        $favoris= $musicien->getFavoris();

        return $this->render('GinaTestBundle:Artiste:tableFav.html.twig', array(
                    'musicien' => $musicien,
                    'favoris'=>$favoris
        ));
    }

}
