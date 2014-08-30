<?php

namespace FXL\Component\Consumer\Driver;

class WikipediaDriver extends ConsumerDriver
{
    private $uri = "http://fr.wikipedia.org/w/api.php?%s";

    public function search($term)
    {
        $query = array(
            'action' => 'opensearch',
            'format' => 'json',
            'search' => $term
        );

        $call = file_get_contents(sprintf($this->uri, http_build_query($query)));

        $returns = json_decode($call);

        foreach ($returns as $return) {

            if (is_array($return)) {

                return $return;
            }
        }
    }

    public function find($id)
    {
        $query = array(
            'action' => 'query',
            'format' => 'json',
            'prop' => 'extracts',
            'redirects' => true,
            'titles' => $id,
        );

        $call = file_get_contents(sprintf($this->uri, http_build_query($query)));

        $return = json_decode($call);

        if (!empty($return)) {

            $page = (array)$return->query->pages;
            $info = array_shift($page);
        }

        return $info;
    }

}
