<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Avis;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;use Symfony\Component\HttpFoundation\Request;

/**
 * Avi controller.
 *
 * @Route("avis")
 */
class AvisController extends Controller
{
    /**
     * Lists all avi entities.
     *
     * @Route("/", name="avis_index")
     * @Method("GET")
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $avis = $em->getRepository('AppBundle:Avis')->findAll();

        return $this->render('avis/index.html.twig', array(
            'avis' => $avis,
        ));
    }



    /**
     * Finds and displays a avi entity.
     *
     * @Route("/{id}", name="avis_show")
     * @Method("GET")
     */
    public function showAction(Avis $avi)
    {
        $deleteForm = $this->createDeleteForm($avi);

        return $this->render('avis/show.html.twig', array(
            'avi' => $avi,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing avi entity.
     *
     * @Route("/{id}/edit", name="avis_edit")
     * @Method({"GET", "POST"})
     */
    public function editAction(Request $request, Avis $avi)
    {
        $deleteForm = $this->createDeleteForm($avi);
        $editForm = $this->createForm('AppBundle\Form\AvisType', $avi);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('avis_edit', array('id' => $avi->getId()));
        }

        return $this->render('avis/edit.html.twig', array(
            'avi' => $avi,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Deletes a avi entity.
     *
     * @Route("/delete/{id}", name="avis_delete")
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, Avis $avi)
    {
        $form = $this->createDeleteForm($avi);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($avi);
            $em->flush();
        }

        return $this->redirectToRoute('avis_index');
    }

    /**
     * Creates a form to delete a avi entity.
     *
     * @param Avis $avi The avi entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(Avis $avi)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('avis_delete', array('id' => $avi->getId())))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }
}
