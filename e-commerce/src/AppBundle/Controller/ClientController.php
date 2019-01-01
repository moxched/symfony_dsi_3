<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Categorie;
use AppBundle\Entity\Client;
use AppBundle\Entity\Produit;
use AppBundle\Entity\produit_commande;
use Psr\Log\LoggerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Session\Session;

class ClientController extends Controller
{

    /**
     * @Route("/new_client", name="Client")
     */
    public function newAction(Request $request,LoggerInterface $logger)
    {
        $cats = $this->getDoctrine()->getManager()->getRepository(Categorie::class)->findAll();

        $client = new Client();
        $form = $this->createForm('AppBundle\Form\ClientType', $client);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $em = $this->getDoctrine()->getManager();


            $session = new Session();
            $panier = $session->get('panier');
            $tot = 0;
            foreach ($panier as $p){
                $tot =$tot + floatval($p['tot']);
            }
            $client->setTotal($tot);
            $em->persist($client);
            $logger->info(sizeof($panier));
            $logger->info(key($panier));
            foreach ($panier as $p){
                $pc = new produit_commande();
                $pc->setPrix($p['produit']->getPrix());
                $logger->info($p['qte']);
                $logger->info($p['produit']->getId());
                $pc->setQte($p['qte']);
                $pc->setClient($client);

                $pc->setProduit($em->getRepository(Produit::class)->find($p['produit']->getId()));
                $em->persist($pc);
            }
            $em->flush();

            return $this->render('Front/commande.html.twig',array('cats' => $cats,'f' => true));
        }
        return $this->render('Front/commande.html.twig', array(
            'client' => $client,
            'f' => false,
            'form' => $form->createView(),
            'cats' => $cats

        ));
    }
}
