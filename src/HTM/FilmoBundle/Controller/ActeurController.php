<?php
/**
 * Created by PhpStorm.
 * User: ibrahima
 * Date: 3/29/17
 * Time: 2:51 PM
 */

namespace HTM\FilmoBundle\Controller;


use HTM\FilmoBundle\Entity\Acteur;
use HTM\FilmoBundle\Form\ActeurType;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\HttpFoundation\Request;

class ActeurController extends Controller
{
    /**
     * @Route("/acteur", name="acteur.list")
     * @Method("GET")
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function indexAction(Request $request){
        $em = $this->getDoctrine()->getManager()
            ->getRepository('HTMFilmoBundle:Acteur');

        $acteurs = $em->findAll();
          return $this->render('Acteur/index.html.twig', array('acteurs' => $acteurs));
    }

    /**
     * @Route("/acteur/ajouter", name="acteur.ajout")
     * @Method({"GET","POST"})
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function ajoutAction(Request $request)
    {
        $acteur = new Acteur();
        $form = $this->createForm(ActeurType::class, $acteur);
        $form->add('Ajouter', SubmitType::class, array('attr' => array('class' => 'btn btn-success','style'=> 'margin-top:10px') ));
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid())
        {
            $em = $this->getDoctrine()->getManager();
            $em->persist($acteur);
            $em->flush();
            $this->addFlash('notice','Ajout reussi');
            return $this->redirectToRoute('acteur.list');
        }
         return $this->render('Acteur/ajout.html.twig', array(
             'form' => $form->createView()
         ));
    }


    /**
     * @Route("/acteur/edit/{id}", name="acteur.edit")
     * @Method({"GET","POST"})
     * @param Request $request
     * @param Acteur $acteur
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function editAction(Request $request, Acteur $acteur)
    {
        $form = $this->createForm(ActeurType::class, $acteur);

        $form->add('Modifier', SubmitType::class, array('attr' => array('class' => 'btn btn-success')));

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid())
        {
            $em = $this->getDoctrine()->getManager();
            $em->flush();
            $this->addFlash('notice','Modification succes');
            return $this->redirectToRoute('acteur.list');
        }
        return $this->render('Acteur/edit.html.twig', array(
            'form' => $form->createView(),
            'acteur' => $acteur
        ));
    }

    /**
     * @Route("/acteur/delete/{id}", name="acteur.delete")
     * @param Acteur $acteur
     * @return \Symfony\Component\HttpFoundation\RedirectResponse
     */
    public function delete($id)
    {
        $em = $this->getDoctrine()->getManager();
        $acteur = $em->getRepository('HTMFilmoBundle:Acteur')->find($id);
        if (!$acteur) {
            throw $this->createNotFoundException(
                'Acteur non trouve pour id '.$id
            );
        }
        $em->remove($acteur);
        $em->flush();
        $this->addFlash('notice','Suppression de l\'acteur reussi');
        return $this->redirectToRoute('acteur.list');
    }
}