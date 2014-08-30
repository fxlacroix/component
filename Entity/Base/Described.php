<?php

namespace FXL\Component\Entity\Base;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\MappedSuperclass
 */
class Described extends Base
{
    /**
     * @ORM\Column(type="text", nullable=true)
     */
    protected $description;


    public function getDescription()
    {
        return $this->description;
    }

    public function setDescription($description)
    {
        $this->description = $description;
    }

}
