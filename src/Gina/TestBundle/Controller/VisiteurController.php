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
use Gina\TestBundle\Entity\Telechargements;
use Gina\TestBundle\Entity\TelechargementsRepository;
use Gina\UserBundle\Entity\User;
use Gina\UserBundle\Entity\UserRepository;
use Gina\UserBundle\Entity\Musiciens;
use Gina\UserBundle\Entity\Visiteurs;
use Gina\UserBundle\Entity\VisiteursRepository;
use JMS\SecurityExtraBundle\Annotation\Secure;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;

class VisiteurController extends Controller {

    /**
     * 
     *
     *
     * @ParamConverter("medias", options={"mapping": {"medias_id": "id"}})
     */
    public function addToPlaylistAction($id) {

        $user = $this->container->get('security.context')->getToken()->getUser()->getId();

        $em = $this->getDoctrine()->getManager();
        $visiteur = $em->getRepository('GinaUserBundle:Visiteurs')->find($user);

        $media = $em->getRepository('GinaTestBundle:Medias')->find($id);
        if (!$media) {
            throw $this->createNotFoundException(
                    'Aucun media trouvé pour cet id : ' . $id
            );
        }

        $playlist = $visiteur->getPlaylists();

        if (!$playlist) {
            $playlist = new Playlists();
            $playlist->setVisiteurs($visiteur);
            $visiteur->setPlaylists($playlist);
        }

        $playlist->addMedia($media);

        $em->persist($visiteur);
        $em->persist($playlist);
        $em->persist($media);
        $em->flush();
        return $this->redirect($this->generateUrl('gina_test_pageVisiteur', array(
                    'id' => $visiteur->getId(),
                    'playlists_id' => $playlist,
            )));

    }

    public function afficherPlaylistAction($id) {

        $id = $this->container->get('security.context')->getToken()->getUser()->getId();
        $em = $this->getDoctrine()->getManager();
        $playlist = $em->getRepository('GinaTestBundle:Playlists')->findByVisiteurs($id);
        $media = $em->getRepository('GinaTestBundle:Medias')->findByPlaylists($playlist);

        return $this->render('GinaTestBundle:Visiteur:afficherPlaylist.html.twig', array(
                    'media' => $media
        ));
    }

    public function delPlaylistAction(Medias $media) {

        $em = $this->getDoctrine()->getManager();
        $em->remove($media);
        $em->flush();

        return $this->redirect($this->generateUrl('gina_test_afficherPlaylist', array(
                            'media' => $media,
                            
        )));
    }

    /*
     *  @Secure(roles="ROLE_VISITEUR")
     */

    public function telechargerAction($id) {
        $user = $this->container->get('security.context')->getToken()->getUser()->getId();

        $em = $this->getDoctrine()->getManager();
        $visiteur = $em->getRepository('GinaUserBundle:Visiteurs')->find($user);

        $media = $em->getRepository('GinaTestBundle:Medias')->find($id);
        if (!$media) {
            throw $this->createNotFoundException(
                    'Aucun media trouvé pour cet id : ' . $id
            );
        }
        $telechargement = $visiteur->getTelechargements();

        if (!$telechargement) {
            $telechargement = new Telechargements();
            $visiteur->setTelechargements($telechargement);
            $telechargement->setVisiteurs($visiteur);
        }

        $telechargement->addMedia($media);

        $em->persist($telechargement);
        $em->persist($visiteur);
        $em->flush();

        return $this->redirect($this->generateUrl('gina_test_pageVisiteur', array(
                    'id' => $visiteur->getId(),
                    'playlists_id' => $playlist,
            )));      
    }

    public function afficherTelechargementsAction($id) {

        $user = $this->container->get('security.context')->getToken()->getUser()->getId();
        $em = $this->getDoctrine()->getManager();
        $telechargement = $em->getRepository('GinaTestBundle:Telechargements')->findByVisiteurs($user);
        $mediatelechargement = $em->getRepository('GinaTestBundle:MediasTelechargements')->findByTelechargements($telechargement);

        return $this->render('GinaTestBundle:Visiteur:afficherTelechargements.html.twig', array(
                    'mediatelechargement' => $mediatelechargement
        ));
    }

//    Users


    public function pageVisiteurAction($id) {

        $id = $this->get('security.context')->getToken()->getUser()->getId();
        $em = $this->getDoctrine()->getManager();
        $visiteur = $em->getRepository('GinaUserBundle:Visiteurs')->findOneById($id);
        $playlist = $visiteur->getPlaylists();


        return $this->render('GinaTestBundle:Visiteur:pageVisiteur.html.twig', array(
                    'visiteur' => $visiteur,
                    'playlists_id' => $playlist,
        ));
    }

    /**
     * 
     */
    public function addFavAction($id) {
        $user = $this->container->get('security.context')->getToken()->getUser()->getId();

        $em = $this->getDoctrine()->getManager();
        $visiteur = $em->getRepository('GinaUserBundle:Visiteurs')->find($user);

        $musicien = $em->getRepository('GinaUserBundle:Musiciens')->find($id);
        if (!$musicien) {
            throw $this->createNotFoundException(
                    'Aucun musicien trouvé pour cet id : ' . $id
            );
        }

        $favoris = $visiteur->getFavoris();

        if (!$favoris) {
            $favoris = new Favoris();
            $visiteur->setFavoris($favoris);
            $favoris->setVisiteurs($visiteur);
        }

        $favoris->addMusicien($musicien);

        $em->persist($visiteur);
        $em->persist($favoris);
        $em->persist($musicien);
        $em->flush();


        return $this->redirect($this->generateUrl('gina_test_pageVisiteur', array(
                    'id' => $visiteur->getId(),
                    'musicien'=>$musicien
            )));
    }

    public function afficherFavorisAction($id) {

        $user = $this->container->get('security.context')->getToken()->getUser()->getId();
        $em = $this->getDoctrine()->getManager();
        $favorisvisiteurs = $em->getRepository('GinaTestBundle:FavorisVisiteurs')->findByVisiteurs($user);
        $favoris=$em->getRepository('GinaTestBundle:Favoris')->findByFavorisVisiteurs($favorisvisiteurs);
        $musicien = $em->getRepository('GinaUserBundle:Musiciens')->findByFavoris($favoris);


        return $this->render('GinaTestBundle:Visiteur:afficherFavoris.html.twig', array(
                    'favorisvisiteurs' => $id,
                    'musicien' => $musicien
        ));
    }

    public function delFavAction() {

        return $this->render('GinaTestBundle:Visiteur:pageVisiteur.html.twig');
    }

}
