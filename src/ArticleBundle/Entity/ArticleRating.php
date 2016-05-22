<?php

namespace ArticleBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * ArticleRating
 *
 * @ORM\Table(name="article_rating")
 * @ORM\Entity(repositoryClass="ArticleBundle\Repository\ArticleRatingRepository")
 */
class ArticleRating
{
    /**
     * @var int
     *
     * @ORM\Column(name="articleRatingId", type="integer", options={"unsigned": true})
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var Article
     *
     * @ORM\ManyToOne(targetEntity="Article", inversedBy="ratings")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="articleId", referencedColumnName="articleId")
     * })
     */
    private $article;

    /**
     * @var int
     *
     * @ORM\Column(name="rating", type="smallint", options={"unsigned": true})
     * @Assert\Range(min=0, max=5, groups={"articleRating"})
     */
    private $rating;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="createdAt", type="datetime", nullable=true)
     */
    private $createdAt;

    /**
     * @var int
     *
     * @ORM\Column(name="createdBy", type="integer")
     */
    private $createdBy;

    public function __construct()
    {
        $this->setCreatedAt(new \DateTime);
        $this->setCreatedBy(1); // @todo Users
    }


    /**
     * Get id
     *
     * @return integer
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set rating
     *
     * @param integer $rating
     *
     * @return ArticleRating
     */
    public function setRating($rating)
    {
        $this->rating = $rating;

        return $this;
    }

    /**
     * Get rating
     *
     * @return integer
     */
    public function getRating()
    {
        return $this->rating;
    }

    /**
     * Set createdAt
     *
     * @param \DateTime $createdAt
     *
     * @return ArticleRating
     */
    public function setCreatedAt($createdAt)
    {
        $this->createdAt = $createdAt;

        return $this;
    }

    /**
     * Get createdAt
     *
     * @return \DateTime
     */
    public function getCreatedAt()
    {
        return $this->createdAt;
    }

    /**
     * Set createdBy
     *
     * @param integer $createdBy
     *
     * @return ArticleRating
     */
    public function setCreatedBy($createdBy)
    {
        $this->createdBy = $createdBy;

        return $this;
    }

    /**
     * Get createdBy
     *
     * @return integer
     */
    public function getCreatedBy()
    {
        return $this->createdBy;
    }

    /**
     * Set article
     *
     * @param \ArticleBundle\Entity\Article $article
     *
     * @return ArticleRating
     */
    public function setArticle(\ArticleBundle\Entity\Article $article = null)
    {
        $this->article = $article;

        return $this;
    }

    /**
     * Get article
     *
     * @return \ArticleBundle\Entity\Article
     */
    public function getArticle()
    {
        return $this->article;
    }
}
