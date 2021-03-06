<?php

use AppBundle\Entity\Avis;
use AppBundle\Entity\Categorie;
use AppBundle\Entity\Produit;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;

/**
 * Created by IntelliJ IDEA.
 * User: moxched
 * Date: 21/12/18
 * Time: 19:30
 */

class AppFixtures extends Fixture
{

    /**
     * Load data fixtures with the passed EntityManager
     *
     * @param \Doctrine\Common\Persistence\ObjectManager $manager
     */
    public function load(ObjectManager $manager)
    {
        // TODO: Implement load() method.
        $c = new Categorie();
        $p = new Produit();
        $catlib = array('Samrtphones','ordinateurs','voitures');
        $i = 0;

            $prod = opendir($this->getParameter('fixture_prod'));
            $cat = opendir($this->getParameter('fixture_cat'));
            while (false !== ($file = readdir($cat))){
                if(( $file != '.' ) && ( $file != '..' )) {
                    copy($this->getParameter('fixture_cat') . '/' . $file, $this->getParameter('uploads_directory_cat') . '/' . $file);
                    $c->setImage($file);
                    $c->setDescription('Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua');
                    $c->setLibelle($catlib[$i]);
                    $c->setSlug($c->getLibelle());
                    $manager->persist($c);
                    $i = $i +1;
                }
            }
            $manager->flush();
            $i=1;
            $j=1;
            while(false !== ($file =readdir($prod))){
                if(($file != '.') && ($file != '..')){
                    copy($this->getParameter('fixture_prod') . '/' . $file, $this->getParameter('uploads_directory_prod') . '/' . $file);
                    $p->setLibelle(str_replace('.jpg','',$file));
                    $p->setDescCourt('Ut enim ad minim veniam, quis nostrud exercitation ullamc');
                    $p->setDescLong('Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.');
                    $p->setSlug($p->getLibelle());
                    $p->setPrix($this->getPrix());
                    $p->setImagePrinc($file);
                    $p->setImage1($file);
                    $p->setImage2($file);
                    $p->setInStock(1);
                    $p->addCategory($manager->getRepository(Categorie::class)->find($i));
                    $manager->persist($p);

                    $j=$j+1;
                    if($j=6){
                        $i=$i+1;
                        $j=1;
                    }
                }
        }
        $manager->flush();
        for($z=0;$z<5;$z++){
            $avis = new Avis();
            $avis->setProduitId($z);
            $avis->setDate(new \DateTime());
            $avis->setAvis('ce ci un bon produit');
            $avis->setProp('user '.$z);
            $avis->setRate(rand(1,5));
            $manager->persist($avis);
        }
        $manager->flush();
    }
    private function generateUniqueFileName()
    {
        // md5() reduces the similarity of the file names generated by
        // uniqid(), which is based on timestamps
        return md5(uniqid());
    }

    private function getPrix(){
        return rand(12.67*10,986.64*10)/10;
    }
}