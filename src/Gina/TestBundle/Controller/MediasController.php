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
use Gina\TestBundle\Entity\MediasPosts;
use Gina\TestBundle\Entity\MediasPostsRepository;
use Gina\TestBundle\Entity\Posts;
use Gina\TestBundle\Form\PostsType;
use Gina\TestBundle\Entity\PostsRepository;
use Gina\UserBundle\Entity\User;
use Gina\UserBundle\Entity\UserRepository;
use Gina\UserBundle\Entity\Musiciens;
use Gina\UserBundle\Entity\Visiteurs;
use JMS\SecurityExtraBundle\Annotation\Secure;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;

class MediasController extends Controller {

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
        $musicien = $em->getRepository('GinaUserBundle:Musiciens')->findById($id);
        $media = $em->getRepository('GinaTestBundle:Medias')->findByMusicien($id);

        return $this->render('GinaTestBundle:Medias:indexMedias.html.twig', array(
                    'id' => $id,
                    'musicien' => $musicien,
                    'media' => $media,
                        )
        );
    }

    public function indexMediasPublicAction($id) {

        $em = $this->getDoctrine()->getManager();
        $musicien = $em->getRepository('GinaUserBundle:Musiciens')->findOneById($id);
        $media = $em->getRepository('GinaTestBundle:Medias')->findByMusicien($id);

        return $this->render('GinaTestBundle:Medias:indexMediasPublic.html.twig', array(
                    'id' => $id,
                    'musicien' => $musicien,
                    'media' => $media,
                        )
        );
    }

    public function suppMediaAction(Medias $media) {

        $em = $this->getDoctrine()->getManager();
        $em->remove($media);
        $em->flush();

        return $this->redirect($this->generateUrl('gina_test_indexMedias', array(
                            'id' => $media->getId(),
                            'media' => $media,
        )));
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

    public function ajouterPostAction($id, Request $request) {

        $post = new Posts();
        $mediapost = new MediasPosts();
        $em = $this->getDoctrine()->getManager();
        $visiteur = $this->container->get('security.context')->getToken()->getUser();
        $media = $em->getRepository("GinaTestBundle:Medias")->findOneById($id);
        $form = $this->createForm(new PostsType(), $post);

        if ($request->isMethod('POST')) {
            $form->handleRequest($request);

            if ($form->isValid()) {
                $visiteur->addPost($post);
                $mediapost->setMedias($media);
                $mediapost->setPosts($post);
                $em->persist($post);
                $em->flush();
                $em->persist($mediapost);
                $em->flush();

                return $this->redirect($this->generateUrl('gina_test_listeMedias', array(
                                    'id' => $visiteur->getId(),
                                    'media' => $media,
                )));
            }
        }
        return $this->render('GinaTestBundle:Medias:ajouterPost.html.twig', array(
                    'id' => $visiteur->getId(),
                    'form' => $form->createView()));
    }

    public function afficherPostsAction() {
        
        $em = $this->getDoctrine()->getManager();
        $media = $em->getRepository('GinaTestBundle:Medias')->findAll();
        $mediasposts = $em->getRepository('GinaTestBundle:MediasPosts')->findAll();
//       var_dump($mediasposts);
//       exit();
        
        

        return $this->render('GinaTestBundle:Medias:afficherPosts.html.twig', array(
                    'media' => $media,
                    'mediasposts'=>$mediasposts
        ));
    }

}
