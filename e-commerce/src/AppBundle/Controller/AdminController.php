<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Avis;
use AppBundle\Entity\Categorie;
use AppBundle\Entity\Client;
use AppBundle\Entity\Produit;
use AppBundle\Entity\produit_commande;
use Psr\Log\LoggerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;

class AdminController extends Controller
{
    /**
     * @Route("/admin/dashboard",name="dashboard")
     */
    public function dashboardAction(LoggerInterface $logger)
    {
        $em = $this->getDoctrine()->getManager();
        $p=0;
        $prod = sizeof($em->getRepository(Produit::class)->findAll());
        $cat = sizeof($em->getRepository(Categorie::class)->findAll());
        $com = sizeof($em->getRepository(Client::class)->findAll());
        $tot = $em->getRepository(Client::class)->getByTot();
        foreach ($tot as $t){
            $logger->info($t);
        }
        $tot = reset($tot);
        $avis = sizeof($em->getRepository(Avis::class)->findAll());

        return $this->render('default/dashboard.html.twig',array('prod' => $prod,'cat' => $cat, 'com' => $com,'tot' => $tot,'avis' => $avis));
    }

    /**
     * @Route("/admin/categories",name="categories")
     */
    public function categoriesAction(LoggerInterface $logger)
    {
        $em = $this->getDoctrine()->getManager();

        $categories = $em->getRepository('AppBundle:Categorie')->findAll();

        return $this->render('categorie/index.html.twig', array(
            'categories' => $categories,
        ));
    }

    /**
     * @Route("/admin/produits",name="produits")
     */
    public function produitsAction(LoggerInterface $logger)
    {
        $em = $this->getDoctrine()->getManager();

        $produits = $em->getRepository('AppBundle:Produit')->findAll();

        return $this->render('produit/index.html.twig', array(
            'produits' => $produits,
        ));
    }

    /**
     * Lists all avi entities.
     *
     * @Route("/admin/avis", name="avis")
     *
     */
    public function avisAction()
    {
        $em = $this->getDoctrine()->getManager();

        $avis = $em->getRepository('AppBundle:Avis')->findAll();

        return $this->render('avis/index.html.twig', array(
            'avis' => $avis,
        ));
    }

    /**
     * @Route("/admin/commandes",name="commandes")
     */
    public function commandesAction(LoggerInterface $logger)
    {
        $em = $this->getDoctrine()->getManager();

        $client = $em->getRepository('AppBundle:Client')->findAll();

        return $this->render('client/commandes.html.twig', array(
            'client' => $client,
        ));
    }

    /**
     * @Route("/admin/commandes/{id}",name="commande")
     */
    public function commandeAction(LoggerInterface $logger,$id)
    {
        $em = $this->getDoctrine()->getManager();

        $client = $em->getRepository('AppBundle:Client')->find($id);
        $com = $em->getRepository(produit_commande::class)->findByClient($id);
        $ar=array();
        foreach ($com as $c ){
            $logger->info($c->getProduit()->getLibelle());
        }
        return $this->render('client/commande.html.twig', array(
            'client' => $client,'commande' => $com));
    }
}
