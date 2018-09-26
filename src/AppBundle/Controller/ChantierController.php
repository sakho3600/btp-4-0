<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Chantier;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;use Symfony\Component\HttpFoundation\Request;

/**
 * Chantier controller.
 *
 * @Route("lab/chantier")
 */
class ChantierController extends Controller
{
    /**
     * Lists all chantier entities.
     *
     * @Route("s/", name="chantier_index")
     * @Method("GET")
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $chantiers = $em->getRepository('AppBundle:Chantier')->findAll();

        return $this->render('chantier/index.html.twig', array(
            'chantiers' => $chantiers,
        ));
    }

    /**
     * Creates a new chantier entity.
     *
     * @Route("/ajouter", name="chantier_new")
     * @Method({"GET", "POST"})
     */
    public function newAction(Request $request)
    {
        $chantier = new Chantier();
        $form = $this->createForm('AppBundle\Form\ChantierType', $chantier);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($chantier);
            $em->flush();

            return $this->redirectToRoute('chantier_show', array('slug' => $chantier->getSlug()));
        }

        return $this->render('chantier/new.html.twig', array(
            'chantier' => $chantier,
            'form' => $form->createView(),
        ));
    }

    /**
     * Finds and displays a chantier entity.
     *
     * @Route("/{slug}", name="chantier_show")
     * @Method("GET")
     */
    public function showAction(Chantier $chantier)
    {
        $deleteForm = $this->createDeleteForm($chantier);

        return $this->render('chantier/show.html.twig', array(
            'chantier' => $chantier,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing chantier entity.
     *
     * @Route("/{slug}/modifier", name="chantier_edit")
     * @Method({"GET", "POST"})
     */
    public function editAction(Request $request, Chantier $chantier)
    {
        $deleteForm = $this->createDeleteForm($chantier);
        $editForm = $this->createForm('AppBundle\Form\ChantierType', $chantier);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('chantier_edit', array('slug' => $chantier->getSlug()));
        }

        return $this->render('chantier/edit.html.twig', array(
            'chantier' => $chantier,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Deletes a chantier entity.
     *
     * @Route("/{slug}/supprimer", name="chantier_delete")
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, Chantier $chantier)
    {
        $form = $this->createDeleteForm($chantier);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($chantier);
            $em->flush();
        }

        return $this->redirectToRoute('chantier_index');
    }

    /**
     * Creates a form to delete a chantier entity.
     *
     * @param Chantier $chantier The chantier entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(Chantier $chantier)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('chantier_delete', array('slug' => $chantier->getSlug())))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }
}
