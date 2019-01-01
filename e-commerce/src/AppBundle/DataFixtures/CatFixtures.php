<?php
namespace AppBundle\DataFixtures;
use AppBundle\Entity\Categorie;
use AppBundle\Entity\Produit;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use Psr\Log\LoggerInterface;

class CatFixtures extends Fixture {

    public function load(ObjectManager $manager)
    {



        $catlib = array('Samrtphones', 'ordinateurs', 'voitures');
        $i = 0;
        $sc = scandir('/home/moxched/Bureau/e-commerce/src/DataFixtures/images/img_cat');
        foreach ($sc as $file) {
            if (($file != '.') && ($file != '..')) {
                copy('/home/moxched/Bureau/e-commerce/src/DataFixtures/images/img_cat' . '/' . $file, '/home/moxched/Bureau/e-commerce/web/uploads/cat_img' . '/' . $file);
                $c = new Categorie();
                $c->setImage($file);
                $c->setDescription('Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua');
                $c->setLibelle($catlib[$i]);
                $c->setSlug($c->getLibelle());
                $manager->persist($c);
                $i = $i + 1;
            }
        }
        $manager->flush();

        $y = 1;
        $j = 1;
        $sp = scandir('/home/moxched/Bureau/e-commerce/src/DataFixtures/images/img_prod');
        foreach ($sp as $file) {
            if (($file != '.') && ($file != '..')) {


                if ($j == 6) {
                    $y ++;
                    $j = 1;
                }

                copy('/home/moxched/Bureau/e-commerce/src/DataFixtures/images/img_prod' . '/' . $file, '/home/moxched/Bureau/e-commerce/web/uploads/prod_img' . '/' . $file);
                $p = new Produit();
                $p->setLibelle(str_replace('.jpg', '', $file));
                $p->setDescCourt('Ut enim ad minim veniam, quis nostrud exercitation ullamc');
                $p->setDescLong('Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.');
                $p->setSlug($this->makeSlug($p->getLibelle()));
                $p->setPrix($this->getPrix());
                $p->setInStock(true);
                $p->setImagePrinc($file);
                $p->setImage1($file);
                $p->setImage2($file);
                $p->addCategory($manager->getRepository(Categorie::class)->find($y));
                $manager->persist($p);
                $j = $j + 1;

            }
        }

        $manager->flush();
        }


    private function getPrix(){
        return rand(12.67*10,986.64*10)/10;
    }
    private function makeSlug($text)
    {
// Source : stackoverflow.com/questions/2955251/php-function-to-make-slug-url-string
// replace non letter or digits by -
        $text = preg_replace('~[^\pL\d]+~u', '-', $text);
        $text = iconv('utf-8', 'us-ascii//TRANSLIT', $text);
// remove unwanted characters
        $text = preg_replace('~[^-\w]+~', '', $text);
        $text = trim($text, '-');
// remove duplicate -
        $text = preg_replace('~-+~', '-', $text);
// lowercase
        $text = strtolower($text);
        if (empty($text))
            return 'n-a';
        return $text;
    }


}


