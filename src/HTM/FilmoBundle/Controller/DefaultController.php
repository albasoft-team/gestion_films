<?php

namespace HTM\FilmoBundle\Controller;

use HTM\FilmoBundle\HTMFilmoBundle;
use HTM\FilmoBundle\Repository\CategorieRepository;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Request;

class DefaultController extends Controller
{
    /**
     * @Route("/", name="acceuil")
     */
    public function indexAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        $listeFilms = $em->getRepository("HTMFilmoBundle:Film")
            ->findAll();
        $paginator  = $this->get('knp_paginator');
        $films = $paginator->paginate(
            $listeFilms,
            $request->query->get('page', 1)/*page number*/,
            6/*limit per page*/
        );
        $cats = $this->getDoctrine()->getRepository("HTMFilmoBundle:Categorie");
        $categories = $cats->getCategories();
        return $this->render('HTMFilmoBundle:Default:index.html.twig', array(
            'films' => $films,
            'categories' => $categories
        ));
    }
}
