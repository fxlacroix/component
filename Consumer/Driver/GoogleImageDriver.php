<?php

namespace FXL\Component\Consumer\Driver;

class GoogleImageDriver extends ConsumerDriver
{
    private $uri = "https://www.google.com/search?tbm=isch&q=%s";

    // driver google image

    public function search($term)
    {

    }

    public function find($id)
    {

        $googleImageHtmls = \FXL\Component\Request\Curl::getInstance(sprintf($this->uri, urlencode($id)))->execute();

        $xpath = "//table[@class='images_table']//img/@src";

        $domNodeimageUrls = \FXL\Component\XML\XPathDOMQuery::get($googleImageHtmls)->query($xpath);

        $imageUrls = \FXL\Component\XML\XPathDOMQuery::toArray($domNodeimageUrls);

        return $imageUrls;
    }
}
