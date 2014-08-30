<?php

namespace FXL\Component\Literacy\Word;

use Symfony\Component\HttpKernel\Bundle\Bundle;

class Syllable extends Bundle
{
    var $pureWord;
    var $word;
    var $encodedWord = "";
    var $syllableWord = "";
    var $wordSyllable = "";

    var $letters = array(
        "v" => array("a", "e", "i", "o", "u", "y"),
        "c" => array("b", "c", "d", "f", "g", "h",
            "j", "k", "l", "m", "n", "p",
            "q", "r", "s", "t", "v", "w", "x", "z")
    );

    var $obligations = array(
        "(u)(a)()", "(o)(a)()", "(a)(y)()", "(u)(é)()", "(u)(è)()", "(u)(e)(u)", "(é)(a)()"
    );

    var $exceptions = array(
        "bl", "cl", "fl", "gl", "pl",
        "br", "cr", "dr", "fr", "gr", "pr", "tr", "vr",
        "ch", "ph", "gn", "th"
    );

    var $insecables = array(
        "mp/s" => "mps"
    );

    var $rules = array(
        "vcv" => "v/cv",
        "vccv" => "vc/cv",
        "ccc" => "cc/c",
    );

    public function __construct($word)
    {

        $this->pureWord = utf8_decode($word);
        $this->word = $this->syllableWord = $this->stripAccents($word);
    }

    public function getSyllables()
    {

        $this->checkExceptions();
        $this->encode();
        $this->match();
        $this->decode();
        $this->checkInsecables();

        return utf8_encode($this->wordSyllable);
    }

    public function getArraySyllables()
    {

        $syllables = $this->getSyllables();

        return explode("/", $syllables);
    }

    protected function checkExceptions()
    {

        foreach ($this->exceptions as $exception) {

            $pattern = "/([aeiouy])(" . $exception . "[aeiouy])/i";
            $replacement = '$1/$2';
            $this->word = preg_replace($pattern, $replacement, $this->word);
            // vccv => ex "bl"

            $pattern = "/([" . $this->getConsonant() . "])(" . $exception . ")/i";
            $replacement = '$1/$2';
            $this->word = preg_replace($pattern, $replacement, $this->word);

            $pattern = "/(" . $exception . ")([" . $this->getConsonant() . "])/i";
            $replacement = '$1/$2';
            $this->word = preg_replace($pattern, $replacement, $this->word);
        }

    }

    protected function checkInsecables()
    {

        $pattern = "#/([a-z])$#i";
        $replacement = '$1';

        $this->wordSyllable = preg_replace($pattern, $replacement, $this->wordSyllable);


        foreach ($this->obligations as $obligation) {

            $pattern = utf8_decode("/$obligation/i");
            $replacement = '$1/$2$3';

            $this->wordSyllable = preg_replace($pattern, $replacement, $this->wordSyllable);
        }
    }

    protected function match()
    {

        $this->syllableWord = $this->encodedWord;

        foreach ($this->rules as $pattern => $rule) {

            // ?
            $this->syllableWord = str_replace($pattern, $rule, $this->syllableWord);
            $this->syllableWord = str_replace($pattern, $rule, $this->syllableWord);
        }
    }

    protected function decode()
    {

        $countSyllable = 0;
        for ($i = 0; $i < strlen($this->syllableWord); $i++) {

            if ($this->syllableWord[$i] == "/") {

                $this->wordSyllable .= "/";
                $countSyllable++;
            } else {

                $this->wordSyllable .= $this->pureWord[$i - $countSyllable];
            }
        }
    }

    protected function encode()
    {

        $this->encodedWord = str_replace($this->letters['c'], "c", $this->word);
        $this->encodedWord = str_replace($this->letters['v'], "v", $this->encodedWord);

        return $this->encodedWord;
    }


    protected function getConsonant()
    {

        return implode($this->letters['c']);
    }

    protected function getVoyelles()
    {

        return implode($this->letters['v']);
    }

    protected function stripAccents($string)
    {

        $string = str_replace(
            array(
                'à', 'â', 'ä', 'á', 'ã', 'å',
                'î', 'ï', 'ì', 'í',
                'ô', 'ö', 'ò', 'ó', 'õ', 'ø',
                'ù', 'û', 'ü', 'ú',
                'é', 'è', 'ê', 'ë',
                'ç', 'ÿ', 'ñ',
            ),
            array(
                'a', 'a', 'a', 'a', 'a', 'a',
                'i', 'i', 'i', 'i',
                'o', 'o', 'o', 'o', 'o', 'o',
                'u', 'u', 'u', 'u',
                'e', 'e', 'e', 'e',
                'c', 'y', 'n',
            ),
            $string
        );

        return $string;
    }
}
