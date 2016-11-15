<?php

namespace ProjectBundle\Controller;

use ProjectBundle\Entity\Alpha;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

/**
 * Alpha controller.
 *
 */
class AlphaController extends Controller
{
    /**
     * Lists all alpha entities.
     *
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $alphas = $em->getRepository('ProjectBundle:Alpha')->findAll();

        return $this->render('ProjectBundle:alpha:index.html.twig', array(
            'alphas' => $alphas,
        ));
    }

    /**
     * Creates a new alpha entity.
     *
     */
    public function newAction(Request $request)
    {
        $alpha = new Alpha();
        $form = $this->createForm('ProjectBundle\Form\AlphaType', $alpha);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($alpha);
            $em->flush($alpha);

            return $this->redirectToRoute('alpha_show', array('id' => $alpha->getId()));
        }

        return $this->render('ProjectBundle:alpha:new.html.twig', array(
            'alpha' => $alpha,
            'form' => $form->createView(),
        ));
    }

    /**
     * Finds and displays a alpha entity.
     *
     */
    public function showAction(Alpha $alpha)
    {
        $deleteForm = $this->createDeleteForm($alpha);

        return $this->render('ProjectBundle:alpha:show.html.twig', array(
            'alpha' => $alpha,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing alpha entity.
     *
     */
    public function editAction(Request $request, Alpha $alpha)
    {
        $deleteForm = $this->createDeleteForm($alpha);
        $editForm = $this->createForm('ProjectBundle\Form\AlphaType', $alpha);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('alpha_edit', array('id' => $alpha->getId()));
        }

        return $this->render('ProjectBundle:alpha:edit.html.twig', array(
            'alpha' => $alpha,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Deletes a alpha entity.
     *
     */
    public function deleteAction(Request $request, Alpha $alpha)
    {
        $form = $this->createDeleteForm($alpha);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($alpha);
            $em->flush($alpha);
        }

        return $this->redirectToRoute('alpha_index');
    }

    /**
     * Creates a form to delete a alpha entity.
     *
     * @param Alpha $alpha The alpha entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(Alpha $alpha)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('alpha_delete', array('id' => $alpha->getId())))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }
}
