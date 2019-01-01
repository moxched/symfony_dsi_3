<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Categorie;
use AppBundle\Entity\Produit;
use Psr\Log\LoggerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Session\Session;


class PanierController extends Controller
{
    /**
     * @Route("/Cart",name="Cart")
     */
    public function addtocartAction(Request $request,LoggerInterface $logger)
    {
        $session = new Session();
        $cats = $this->getDoctrine()->getManager()->getRepository(Categorie::class)->findAll();

        if($request->get('action') == 'add') {
            $logger->info($request->get('qte'));
            $logger->info($request->get('id'));

            @$panier = $session->get('panier');
            $p = $this->getDoctrine()->getManager()->getRepository(Produit::class)->find($request->get('id'));
            $tot = $request->get('qte') * $p->getPrix();
            @$panier[] = array('qte' => $request->get('qte'), 'produit' => $p, 'tot' => $tot );
            $session->set('panier', $panier);
            return $this->render('Front/panier.html.twig', array('cats' => $cats));
        }
        if($request->get('action')=='clear'){
            $session->set('panier',array());
            $cats = $this->getDoctrine()->getManager()->getRepository(Categorie::class)->findAll();
            return $this->render('Front/panier.html.twig', array('cats' => $cats,));
        }
        if($request->get('action')=='remove'){

            $cats = $this->getDoctrine()->getManager()->getRepository(Categorie::class)->findAll();
            return $this->render('Front/panier.html.twig', array('cats' => $cats));

        }
        if($request->get('id')!=null){
            $v = array("+","-");
            $panier = $session->get('panier');
            if(mb_strpos($request->get('id'),"+")!=false){
                $p = str_replace($v,'',$request->get('id'));
                $logger->info('hedh noumrou'.$p.'w plus');
                $logger->info(sizeof($panier));

                $panier[$p-1]['qte']++;

            }
            else{
                $p = str_replace($v,'',$request->get('id'));
                $panier[$p-1]['qte']--;
                $logger->info('hedh noumrou'.$p.'w moin');
            }
            $session->set('panier',$panier);

            return $this->render('Front/panier.html.twig', array('cats' => $cats));

        }

        return $this->render('Front/panier.html.twig', array('cats' => $cats));
    }

    /**
     * @Route("/Cart_Remove/{id}",name="CartRemove")
     */
    public function removeAction(int $id,LoggerInterface $logger){
        $session = new Session();
        $cats = $this->getDoctrine()->getManager()->getRepository(Categorie::class)->findAll();
        $panier = $session->get('panier');
        $logger->info(sizeof($panier).'kkldf'.$id);
        unset($panier[$id-1]);
        $session->set('panier',$panier);
        return $this->redirectToRoute('Cart');

    }


}
