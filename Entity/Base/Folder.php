<?php

namespace FXL\Component\Entity\Base;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\MappedSuperclass
 */
class Folder extends Base
{

    /**
     * @ORM\OneToMany(targetEntity="Attached", mappedBy="project", cascade={"persist", "remove"})
     * @ORM\JoinColumn(name="id", referencedColumnName="folder_id", nullable=true)
     */
    private $files;

    private $picture;

    private $date;

    public function __construct()
    {

        $this->files = new \Doctrine\Common\Collections\ArrayCollection();
    }

    public function getFiles()
    {
        return $this->files;
    }

    public function addFile($file)
    {
        if (!$this->files->contains($file)) {
            $this->files[] = $file;
        }
    }

    public function setFiles($file)
    {
        $this->files = $file;
    }

    public function getPicture()
    {
        return $this->picture;
    }

    public function setPicture($picture)
    {
        $this->picture = $picture;
    }

    public function getDate()
    {
        return $this->date;
    }

    public function setDate($date)
    {
        $this->date = $date;
    }


}
