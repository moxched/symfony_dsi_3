<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Produit;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\File\Exception\FileException;
use Symfony\Component\HttpFoundation\Request;
use AppBundle\Services\MakeSlug;

/**
 * Produit controller.
 *
 * @Route("admin/produit",service="make_slug")
 */
class ProduitController extends Controller
{
    /**
     * Lists all produit entities.
     *
     * @Route("/", name="admin_produit_index")
     * @Method("GET")
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $produits = $em->getRepository('AppBundle:Produit')->findAll();

        return $this->render('produit/index.html.twig', array(
            'produits' => $produits,
        ));
    }

    /**
     * Creates a new produit entity.
     *
     * @Route("/new", name="admin_produit_new")
     * @Method({"GET", "POST"})
     *
     */
    public function newAction(Request $request,MakeSlug $makeSlug)
    {
        $produit = new Produit();
        $form = $this->createForm('AppBundle\Form\ProduitType', $produit);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $img_prin = $produit->getImagePrinc();
            $img_1 = $produit->getImage1();
            $img_2 = $produit->getImage2();
            $fileName_princ= $this->generateUniqueFileName().'.'.$img_prin->guessExtension();
            $fileName_1= $this->generateUniqueFileName().'.'.$img_1->guessExtension();
            $fileName_2= $this->generateUniqueFileName().'.'.$img_2->guessExtension();
            try{
                $img_prin->move(
                    $this->getParameter('uploads_directory_prod'),
                    $fileName_princ
                );
                $img_1->move(
                    $this->getParameter('uploads_directory_prod'),
                    $fileName_1
                );
                $img_2->move(
                    $this->getParameter('uploads_directory_prod'),
                    $fileName_2
                );
            }
            catch (FileException $e) {
                // ... handle exception if something happens during file upload
            }
            $produit->setImagePrinc($fileName_princ);
            $produit->setImage1($fileName_1);
            $produit->setImage2($fileName_2);
            $slug = $makeSlug->makeSlug($produit->getLibelle());
            $produit->setSlug($slug);
            foreach ($form->get('categories')->getData() as $cat) {
                $produit->addCategory($cat);
            }
            $em = $this->getDoctrine()->getManager();
            $em->persist($produit);
            $em->flush();

            return $this->redirectToRoute('admin_produit_show', array('id' => $produit->getId()));
        }

        return $this->render('produit/new.html.twig', array(
            'produit' => $produit,
            'form' => $form->createView(),
        ));
    }

    /**
     * Finds and displays a produit entity.
     *
     * @Route("/{id}", name="admin_produit_show")
     * @Method("GET")
     */
    public function showAction(Produit $produit)
    {
        $deleteForm = $this->createDeleteForm($produit);

        return $this->render('produit/show.html.twig', array(
            'produit' => $produit,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing produit entity.
     *
     * @Route("/{id}/edit", name="admin_produit_edit")
     * @Method({"GET", "POST"})
     */
    public function editAction(Request $request, Produit $produit)
    {
        $produit->setImagePrinc(null);
        $produit->setImage1(null);
        $produit->setImage2(null);
        $deleteForm = $this->createDeleteForm($produit);
        $editForm = $this->createForm('AppBundle\Form\ProduitType', $produit);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {


            $img_prin = $produit->getImagePrinc();
            $img_1 = $produit->getImage1();
            $img_2 = $produit->getImage2();
            $fileName_princ= $this->generateUniqueFileName().'.'.$img_prin->guessExtension();
            $fileName_1= $this->generateUniqueFileName().'.'.$img_1->guessExtension();
            $fileName_2= $this->generateUniqueFileName().'.'.$img_2->guessExtension();
            try{
                $img_prin->move(
                    $this->getParameter('uploads_directory_prod'),
                    $fileName_princ
                );
                $img_1->move(
                    $this->getParameter('uploads_directory_prod'),
                    $fileName_1
                );
                $img_2->move(
                    $this->getParameter('uploads_directory_prod'),
                    $fileName_1
                );
            }
            catch (FileException $e) {
                // ... handle exception if something happens during file upload
            }
            $produit->setImagePrinc($fileName_princ);
            $produit->setImage1($fileName_1);
            $produit->setImage2($fileName_2);
            $slug = $this->get('make_slug')->makeSlug($produit->getLibelle());
            $produit->setSlug($slug);
            foreach ($editForm->get('categories')->getData() as $cat) {
                $produit->addCategory($cat);
            }
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('admin_produit_edit', array('id' => $produit->getId()));
        }

        return $this->render('produit/edit.html.twig', array(
            'produit' => $produit,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Deletes a produit entity.
     *
     * @Route("del/{id}", name="admin_produit_delete")
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, Produit $produit)
    {
        $form = $this->createDeleteForm($produit);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($produit);
            $em->flush();
        }

        return $this->redirectToRoute('admin_produit_index');
    }

    /**
     * Creates a form to delete a produit entity.
     *
     * @param Produit $produit The produit entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(Produit $produit)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('admin_produit_delete', array('id' => $produit->getId())))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }
    private function generateUniqueFileName()
    {
        // md5() reduces the similarity of the file names generated by
        // uniqid(), which is based on timestamps
        return md5(uniqid());
    }
}
