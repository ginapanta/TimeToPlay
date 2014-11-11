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
use Gina\UserBundle\Entity\Photo;
use Gina\UserBundle\Form\PhotoType;
use JMS\SecurityExtraBundle\Annotation\Secure;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;

class AdminController extends Controller {

    //Index


    public function indexAction() {
        return $this->render('GinaTestBundle:Default:index.html.twig');
    }
    
    public function choixRegisterAction() {
        return $this->render('GinaTestBundle:Default:choix.html.twig');
    }

    public function indexConnectedAction($id) {
         $user = $this->get('security.context')->getToken()->getUser();
          $id= $user->getId();
    
        if ( $this->get('security.context')->isGranted('IS_AUTHENTICATED_REMEMBERED')) {
            return $this->render('GinaTestBundle:Default:indexConnected.html.twig',array(
                    'user' =>$user));    
            
         } 
//         
//        if  ( $this->get('security.context')->isGranted('ROLE_VISITEUR')) {
//                              $visiteur = $em->getRepository('GinaUserBundle:Visiteurs')->findOneById($id);
//        }
        
        
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

// Musiciens

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

    public function formEditMusicienAction(Request $request, Musiciens $musicien) {

        $em = $this->getDoctrine()->getManager();
        $form = $this->createForm(new RegisMusiciensFormType(), $musicien);

        if ($request->isMethod('POST')) {
            $form->handleRequest($request);

            if ($form->isValid()) {
                $m = $form->getData();

                $em->persist($m);
                $em->flush();

                return $this->redirect($this->generateUrl('gina_test_pageArtiste', array(
                                    'id' => $musicien->getId(),
                                    'musicien' => $musicien
                )));
            }
        }
        return $this->render('GinaTestBundle:Artiste:formMusicien.html.twig', array(
                    'id' => $musicien->getId(),
                    'form' => $form->createView())
        );
    }

    public function ajouterMediaAction(Request $request, Musiciens $musicien) {

        $media = new Medias();
        $em = $this->getDoctrine()->getManager();
        $form = $this->createForm(new MediasType(), $media);

        if ($request->isMethod('POST')) {
            $form->handleRequest($request);

            if ($form->isValid()) {
                $media->upload();

                $musicien->addMedia($media);
                $em->persist($musicien);
                $em->persist($media);
                $em->flush();

                return $this->redirect($this->generateUrl('gina_test_pageArtiste', array(
                                    'id' => $musicien->getId(),
                                    'media' => $media,
                )));
            }
        }
        return $this->render('GinaTestBundle:Medias:ajouterMedia.html.twig', array(
                    'id' => $musicien->getId(),
                    'form' => $form->createView()));
    }

    public function indexMediasAction($id) {

        $id = $this->get('security.context')->getToken()->getUser()->getId();
        $em = $this->getDoctrine()->getManager();  
        $musicien= $em->getRepository('GinaUserBundle:Musiciens')->findById($id);
        $media = $em->getRepository('GinaTestBundle:Medias')->findByMusicien($id);

        return $this->render('GinaTestBundle:Medias:indexMedias.html.twig', array(
                    'musicien' => $musicien,
                    'media' => $media,
                        )
        );
    }

    public function suppMediaAction(Medias $media) {

        $em = $this->getDoctrine()->getManager();
        $em->remove($media);
        $em->flush();

        return $this->redirect($this->generateUrl('gina_Medias_indexMedias', array(
                            'media' => $media,
        )));
    }

    public function publicArtisteAction($id) {

        $em = $this->getDoctrine()->getManager();
        $musicien = $em->getRepository("GinaUserBundle:Musiciens")->findOneById(array('id' => $id));

        return $this->render('GinaTestBundle:Artiste:publicArtiste.html.twig', array(
                    'id' => $id,
                    'musicien' => $musicien,
        ));
    }

//    Medias

    /**
     * 
     * @ParamConverter("medias", options={"mapping": {"medias_id": "id"}})
     */
    public function listeMediasAction() {

        $em = $this->getDoctrine()->getManager();
        $media = $em->getRepository("GinaTestBundle:Medias")->findAll();
        $musicien = $em->getRepository("GinaUserBundle:Musiciens")->findAll();

        return $this->render('GinaTestBundle:Medias:listeMedias.html.twig', array(
                    'media' => $media,
                    'musicien' => $musicien
        ));
    }

    /**
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
            $visiteur->setPlaylists($playlist);
        }

        $playlist->addMedia($media);

        $em->persist($visiteur);
        $em->persist($playlist);
        $em->persist($media);
        $em->flush();


        return $this->redirect($this->generateUrl('gina_test_afficherPlaylist', array(
                            'playlist' => $playlist,
                            'media' => $media
        )));
    }

    public function afficherPlaylistAction($id) {

        $user = $this->container->get('security.context')->getToken()->getUser()->getId();
        $em = $this->getDoctrine()->getManager();
        $visiteur = $em->getRepository('GinaUserBundle:Visiteurs')->find($user);

        $playlist = $visiteur->getPlaylist();
        $id = $playlist->getId();
        $media = $playlist - getMedias();


        return $this->render('GinaTestBundle:Visiteur:afficherPlaylist.html.twig', array(
                    'playlist' => $id,
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
        $telechargement = $visiteur->addTelechargement();

        if (!$telechargement) {
            $telechargement = new Telechargements();
            $visiteur->setPlaylists($playlist);
        }

        $telechargement->addMedia($media);

        $em->persist($visiteur);
        $em->persist($telechargement);
        $em->persist($media);
        $em->flush();


        return $this->redirect($this->generateUrl('gina_test_afficherTelechargement', array(
                            'telechargement' => $telechargement,
                            'media' => $media
        )));
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
        }
        $favoris->addMusicien($musicien);

        $em->persist($visiteur);
        $em->persist($favoris);
        $em->persist($musicien);
        $em->flush();


        return $this->redirect($this->generateUrl('gina_test_afficherFavoris', array(
                            'musicien' => $musicien,
        )));
    }

    public function afficherFavorisAction($id) {

        $user = $this->container->get('security.context')->getToken()->getUser()->getId();
        $em = $this->getDoctrine()->getManager();
        $visiteur = $em->getRepository('GinaUserBundle:Visiteurs')->find($user);

        $favoris = $visiteur->getFavoris();
        $id = $favoris->getId();
        $musicien = $favoris->getMusiciens();


        return $this->render('GinaTestBundle:Visiteur:afficherFavoris.html.twig', array(
                    'favoris' => $id,
                    'musicien' => $musicien
        ));
    }

    public function delFavAction() {


        return $this->render('GinaTestBundle:Visiteur:pageUser.html.twig');
    }

}
