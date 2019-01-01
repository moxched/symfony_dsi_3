<?php
/**
 * Created by IntelliJ IDEA.
 * User: moxched
 * Date: 21/12/18
 * Time: 18:59
 */

namespace AppBundle\Services;

 class MakeSlug
{
    /**
     * Vérifie si le texte est un spam ou non
     *
     * @param string $text
     * @return bool
     */
    public function makeSlug($text)
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