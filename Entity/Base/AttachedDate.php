<?php

namespace FXL\Component\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use Gedmo\Mapping\Annotation as Gedmo; // gedmo annotations

/**
 * @ORM\HasLifecycleCallbacks()
 * @ORM\MappedSuperclass
 */
class AttachedDate
{
    /**
     * @Assert\File(maxSize="20000000")
     */
    protected $file;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    protected $path;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    protected $type;

    /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;

    /**
     * @Gedmo\Timestampable(on="create")
     * @ORM\Column(type="datetime", name="created_at", nullable=false)
     */
    protected $createdAt;

    /**
     * @Gedmo\Timestampable(on="update")
     * @ORM\Column(type="datetime", name="updated_at", nullable=false)
     */
    protected $updatedAt;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    protected $url;

    public function exist()
    {
        return $this->id !== null;
    }

    public function getId()
    {
        return $this->id;
    }

    public function setId($id)
    {
        $this->id = $id;
    }

    /**
     * get created at
     *
     * @return \atetime
     */
    public function getCreatedAt()
    {
        return $this->createdAt;
    }

    /**
     * set created at
     *
     * @param \Datetime $createdAt
     */
    public function setCreatedAt($createdAt)
    {
        $this->createdAt = $createdAt;
    }

    /**
     * get updated at
     *
     * @return \Datetime
     */
    public function getUpdatedAt()
    {
        return $this->updatedAt;
    }

    /**
     * set updated at
     *
     * @param \Datetime $updatedAt
     */
    public function setUpdatedAt($updatedAt)
    {
        $this->updatedAt = $updatedAt;
    }


    public function getFile()
    {
        return $this->file;
    }

    public function setFile($file)
    {
        $this->file = $file;
    }

    public function getPath()
    {
        return $this->path;
    }

    public function setPath($path)
    {
        $this->path = $path;
    }

    public function getType()
    {
        return $this->type;
    }

    public function setType($type)
    {
        $this->type = $type;
    }

    public function getAbsolutePath()
    {
        return null === $this->path ? null : $this->getUploadRootDir() . '/' . $this->path;
    }

    public function getWebPath()
    {
        return null === $this->path ? null : $this->getUploadDir() . '/' . $this->path;
    }

    public function getUploadRootDir()
    {
        // the absolute directory path where uploaded documents should be saved
        return __DIR__ . '/../../../../web/' . $this->getUploadDir();
    }


    public function getUploadDir()
    {
        $class = str_replace(__NAMESPACE__ . "\\", "", __CLASS__);

        $classChild = (string)get_class($this);

        if ($classChild != __CLASS__) {

            $split = preg_split("#\\\\#", $classChild);
            $subFolder = array_pop($split);
        }

        if (isset($subFolder)) {

            return "/uploads/" . $class . "/" . $subFolder . "/";
        }

        return "/uploads/" . $class . "/";
    }

    public function getUrl()
    {
        return $this->url;
    }

    public function setUrl($url)
    {
        $this->url = $url;
    }


    /**
     * @ORM\PreUpdate
     * @ORM\PrePersist
     */
    public function preSave()
    {
        // the file property can be empty if the field is not required
        if (null === $this->file) {
            if ($this->url && !$this->path) {

                $fileName = rawurldecode(basename(parse_url($this->url, PHP_URL_PATH)));

                if (!file_exists($this->getUploadRootDir())) {
                    mkdir($this->getUploadRootDir(), 0777);
                }

                $uri = $this->getUploadRootDir() . $fileName;

                $fileContent = file_get_contents($this->url);

                file_put_contents($uri, $fileContent);

                $this->path = $this->getUploadDir() . $fileName;

                return;

            }
            return;
        }

        $this->file->move($this->getUploadRootDir(), $this->file->getClientOriginalName());

        $this->path = $this->getUploadDir() . $this->file->getClientOriginalName();
        $this->file = null;

        $this->setUpdatedAt(new \DateTime());

    }

    /**
     * @ORM\PreRemove
     */
    public function preRemove()
    {
        $uri = $this->getPath();

        if ($this->getPath() && file_exists($uri)) {

            unlink($uri);
        }
    }

}
