<?php

namespace FXL\Component\XML;

class XPathDOMQuery
{

    public $document;

    static public function get($content)
    {
        try {

            $dom = new \DOMDocument();
            @$dom->loadHTML($content);

        } catch (Exception $e) {

            throw $e->getMessage();
        }

        return new \DOMXpath($dom);
    }

    static public function toArray($nodeList)
    {
        $list = array();
        foreach ($nodeList as $node) {
            $list[] = $node->nodeValue;
        }
        return $list;
    }

}
