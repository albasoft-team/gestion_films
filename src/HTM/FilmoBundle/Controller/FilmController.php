<?php

namespace HTM\FilmoBundle\Controller;

use HTM\FilmoBundle\Entity\Film;
use HTM\FilmoBundle\Entity\Categorie;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\File\File;

/**
 * Film controller.
 *
 * @Route("film")
 */
class FilmController extends Controller
{
    /**
     * Lists all film entities.
     *
     * @Route("/", name="film_index")
     * @Method("GET")
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $films = $em->getRepository('HTMFilmoBundle:Film')->findAll();

        return $this->render('film/index.html.twig', array(
            'films' => $films,
        ));
    }

    /**
     * Creates a new film entity.
     *
     * @Route("/new", name="film_new")
     * @Method({"GET", "POST"})
     */
    public function newAction(Request $request)
    {
        $film = new Film();
        $form = $this->createForm('HTM\FilmoBundle\Form\FilmType', $film);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $file = $film->getBrochure();
            $fileName = $this->get('app.brochure_uploader')->upload($file);
            $film->setBrochure($fileName);
            $em->persist($film);
            $em->flush($film);

            return $this->redirectToRoute('film_show', array('id' => $film->getId()));
        }

        return $this->render('film/new.html.twig', array(
            'film' => $film,
            'form' => $form->createView(),
        ));
    }

    /**
     * Finds and displays a film entity.
     *
     * @Route("/{id}", name="film_show")
     * @Method("GET")
     */
    public function showAction(Film $film)
    {
        $deleteForm = $this->createDeleteForm($film);

        return $this->render('film/show.html.twig', array(
            'film' => $film,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing film entity.
     *
     * @Route("/{id}/edit", name="film_edit")
     * @Method({"GET", "POST"})
     */
    public function editAction(Request $request, Film $film)
    {
//        $deleteForm = $this->createDeleteForm($film);
        $film->setBrochure(
            new File($this->getParameter('brochures_directory').'/'.$film->getBrochure())
        );
        $editForm = $this->createForm('HTM\FilmoBundle\Form\FilmType', $film);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('film_edit', array('id' => $film->getId()));
        }

        return $this->render('film/edit.html.twig', array(
            'film' => $film,
            'edit_form' => $editForm->createView()
        ));
    }

    /**
     * Deletes a film entity.
     *
     * @Route("/{id}", name="film_delete")
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, Film $film)
    {
        $form = $this->createDeleteForm($film);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($film);
            $em->flush();
        }

        return $this->redirectToRoute('film_index');
    }

    /**
     * Creates a form to delete a film entity.
     *
     * @param Film $film The film entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(Film $film)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('film_delete', array('id' => $film->getId())))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }

    /**
     * @Route("/categorie/{nom}", name="film_by_categorie")
     * @param Request $request
     * @param Categorie $categorie
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function filmsOfcategorieAction(Categorie $categorie)
    {
       // $em = $this->getDoctrine()->getManager();
//        $categorie = $em->getRepository("HTMFilmoBundle:Categorie")
//            ->findBy(array('non' => $nom));
        $cats = $this->getDoctrine()->getRepository("HTMFilmoBundle:Film");
        $films = $cats->getFilmsByCategorie($categorie);
        return $this->render('film/filmbycategorie.html.twig', array(
            'films' => $films,
            'cat' => $categorie
        ));
    }
}
