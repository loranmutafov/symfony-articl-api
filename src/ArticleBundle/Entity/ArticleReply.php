<?php

namespace ArticleBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use JMS\Serializer\Annotation as Serializer;

/**
 * ArticleReply
 *
 * @ORM\Table(name="article_reply")
 * @ORM\Entity(repositoryClass="ArticleBundle\Repository\ArticleReplyRepository")
 */
class ArticleReply
{
    /**
     * @var int
     *
     * @ORM\Column(name="articleReplyId", type="integer", options={"unsigned": true})
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var Article
     *
     * @ORM\ManyToOne(targetEntity="Article", inversedBy="replies")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="articleId", referencedColumnName="articleId")
     * })
     */
    private $article;

    /**
     * @var string
     *
     * @ORM\Column(name="title", type="string", length=255, nullable=true)
     * @Serializer\Groups({"details"})
     */
    private $title;

    /**
     * @var string
     *
     * @ORM\Column(name="body", type="text")
     * @Assert\NotBlank(groups={"articleReply"})
     * @Serializer\Groups({"details"})
     */
    private $body;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="createdAt", type="datetime", nullable=true)
     * @Serializer\Groups({"details"})
     */
    private $createdAt;

    /**
     * @var int
     *
     * @ORM\Column(name="createdBy", type="integer", nullable=true)
     */
    private $createdBy;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="modifiedAt", type="datetime", nullable=true)
     * @Serializer\Groups({"details"})
     */
    private $modifiedAt;

    /**
     * @var int
     *
     * @ORM\Column(name="modifiedBy", type="integer", nullable=true)
     */
    private $modifiedBy;

    public function __construct()
    {
        $this->setCreatedAt(new \DateTime);
        $this->setModifiedAt(new \DateTime);
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
     * Set title
     *
     * @param string $title
     *
     * @return ArticleReply
     */
    public function setTitle($title)
    {
        $this->title = $title;

        return $this;
    }

    /**
     * Get title
     *
     * @return string
     */
    public function getTitle()
    {
        return $this->title;
    }

    /**
     * Set body
     *
     * @param string $body
     *
     * @return ArticleReply
     */
    public function setBody($body)
    {
        $this->body = $body;

        return $this;
    }

    /**
     * Get body
     *
     * @return string
     */
    public function getBody()
    {
        return $this->body;
    }

    /**
     * Set createdAt
     *
     * @param \DateTime $createdAt
     *
     * @return ArticleReply
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
     * @return ArticleReply
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
     * Set modifiedAt
     *
     * @param \DateTime $modifiedAt
     *
     * @return ArticleReply
     */
    public function setModifiedAt($modifiedAt)
    {
        $this->modifiedAt = $modifiedAt;

        return $this;
    }

    /**
     * Get modifiedAt
     *
     * @return \DateTime
     */
    public function getModifiedAt()
    {
        return $this->modifiedAt;
    }

    /**
     * Set modifiedBy
     *
     * @param integer $modifiedBy
     *
     * @return ArticleReply
     */
    public function setModifiedBy($modifiedBy)
    {
        $this->modifiedBy = $modifiedBy;

        return $this;
    }

    /**
     * Get modifiedBy
     *
     * @return integer
     */
    public function getModifiedBy()
    {
        return $this->modifiedBy;
    }

    /**
     * Set article
     *
     * @param \ArticleBundle\Entity\Article $article
     *
     * @return ArticleReply
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
