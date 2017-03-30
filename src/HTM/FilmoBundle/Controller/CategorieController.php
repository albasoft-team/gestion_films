<?php
/**
 * Created by PhpStorm.
 * User: ibrahima
 * Date: 3/28/17
 * Time: 5:11 PM
 */

namespace HTM\FilmoBundle\Controller;


use HTM\FilmoBundle\Entity\Categorie;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\HttpFoundation\Request;

class CategorieController extends Controller
{

    /**
     * @Route("/categorie", name="categorie.list")
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();
        $categories = $em->getRepository('HTMFilmoBundle:Categorie')
            ->findAll();

        return $this->render('Categorie/index.html.twig', array(
            'categories' => $categories
        ));
    }
    /**
     * @Route("/categorie/ajout", name="categorie.ajout")
     */
    public function ajoutAction(Request $request)
    {
        $categorie = new Categorie();
        $form = $this->createFormBuilder($categorie)
                     ->add('nom', TextType::class, array('attr' => array('class' => 'form-control', 'style' => 'margin-bottom: 10px')))
                     ->add('Ajout', SubmitType::class, array('label' => 'Ajouter', 'attr' => array('class' => 'btn btn-primary')))
                     ->getForm();
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid())
        {
            $em = $this->getDoctrine()->getManager();
            $em->persist($categorie);
            $em->flush();
            $this->addFlash('notice','Categorie ajoutee');

            return $this->redirectToRoute('categorie.list');
        }
        return $this->render('Categorie/ajout.html.twig', array(
            'form' => $form->createView()
        ));
    }

    /**
     * @Route("/categorie/edit/{id}", name="categorie.edit")
     * @return \Symfony\Component\HttpFoundation\Response
     */

    public function editAction ($id, Request $request)
    {
        return $this->render('Categorie/edit.html.twig');
    }

    /**
     * @Route("/categorie/supprime/{id}", name="categorie.delete")
     * @return \Symfony\Component\HttpFoundation\Response
     */

    public function deleteAction ($id, Request $request)
    {
        return $this->render('Categorie/delete.html.twig');
    }

}