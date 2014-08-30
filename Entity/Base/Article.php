<?php

namespace FXL\Component\Entity\Base;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\MappedSuperclass
 */
class Article extends Described
{
    /**
     * @ORM\Column(type="text", nullable=true)
     */
    protected $content;


    public function getContent()
    {
        return $this->content;
    }

    public function setContent($content)
    {
        $this->content = $content;
    }

}
