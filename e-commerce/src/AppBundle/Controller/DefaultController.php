<?php

namespace AppBundle\Controller;

use Psr\Log\LoggerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use AppBundle\Entity\Categorie;
use AppBundle\Entity\Produit;
/**
 * Dashboard controller.
 *
 * @Route("admin")
 */
class DefaultController extends Controller
{
    /**
     * @Route("/get", name="homepage")
     */
    public function indexAction(Request $request,LoggerInterface $logger)
    {
        // replace this example code with whatever you need
        $manager= $this->getDoctrine()->getManager();

        return $this->render('base.html.twig');
    }




private function getPrix(){
    return rand(12.67*10,986.64*10)/10;
}
}
