<?php

namespace FXL\Component\Entity\Feature\Qcm;

use Symfony\Component\HttpKernel\Bundle\Bundle;
use Doctrine\ORM\Mapping as ORM;
use FXL\Component\Entity\AttachedDate;

/**
 *
 * @ORM\Entity(repositoryClass="FXL\Bundle\QCMBundle\Repository\QCMRepository")
 * @ORM\Table(name="qcm__answer")
 */
class Answer extends AttachedDate
{

    /**
     * @ORM\Column(type="text", nullable=true)
     */
    protected $content;

    /**
     * @ORM\Column(name="value", type="boolean", nullable=true)
     */
    protected $right = false;

    /**
     * @ORM\ManyToOne(targetEntity="Question")
     * @ORM\JoinColumn(name="question_id", referencedColumnName="id")
     */
    protected $question;

    /**
     * @ORM\ManyToMany(targetEntity="Review", mappedBy="questions", cascade={"persist"})
     */
    private $reviews;

    /**
     * @var selected
     */
    protected $selected = false;

    public function __toString()
    {

        return $this->content;
    }

    /**
     * Set qcm
     *
     * @param \FXL\Component\Entity\Feature\Qcm\Question $question
     * @return Answer
     */
    public function setQuestion(\FXL\Component\Entity\Feature\Qcm\Question $question = null)
    {
        $this->question = $question;

        return $this;
    }

    /**
     * Get qcm
     *
     * @return \FXL\Component\Entity\Feature\Qcm\Question
     */
    public function getQuestion()
    {
        return $this->question;
    }

    /**
     * Set content
     *
     * @param string $content
     * @return Answer
     */
    public function setContent($content)
    {
        $this->content = $content;

        return $this;
    }

    /**
     * Get content
     *
     * @return string
     */
    public function getContent()
    {
        return $this->content;
    }

    /**
     * Set right
     *
     * @param boolean $right
     * @return Answer
     */
    public function setRight($right)
    {
        $this->right = $right;

        return $this;
    }

    /**
     * Get right
     *
     * @return boolean
     */
    public function getRight()
    {
        return $this->right;
    }

    /**
     * Add reviews
     *
     * @param \FXL\Component\Entity\Feature\Qcm\Review $reviews
     * @return Question
     */
    public function addReview(\FXL\Component\Entity\Feature\Qcm\Review $reviews)
    {
        $this->reviews[] = $reviews;

        return $this;
    }

    /**
     * Remove $reviews
     *
     * @param \FXL\Component\Entity\Feature\Qcm\Review $reviews
     */
    public function removeReview(\FXL\Component\Entity\Feature\Qcm\Review $reviews)
    {
        $this->reviews->removeElement($reviews);
    }

    /**
     * Get reviews
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getReviews()
    {
        return $this->reviews;
    }

    public function getSelected()
    {
        return $this->selected;
    }

    public function setSelected($selected)
    {
        $this->selected = $selected;
    }

    public function setReviews($reviews)
    {
        $this->reviews = $reviews;
    }

}