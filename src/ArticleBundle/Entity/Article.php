<?php

namespace ArticleBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use JMS\Serializer\Annotation as Serializer;

/**
 * Article
 *
 * @ORM\Table(name="article")
 * @ORM\Entity(repositoryClass="ArticleBundle\Repository\ArticleRepository")
 */
class Article
{
    /**
     * @var int
     *
     * @ORM\Column(name="articleId", type="integer", options={"unsigned": true})
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     * @Serializer\Groups({"list", "details"})
     */
    private $id;

    /**
     * @var string
     *
     * @ORM\Column(name="title", type="string", length=255)
     * @Assert\NotBlank(groups={"article"})
     * @Serializer\Groups({"list", "details"})
     */
    private $title;

    /**
     * @var string
     *
     * @ORM\Column(name="body", type="text")
     * @Assert\NotBlank(groups={"article"})
     * @Serializer\Groups({"details"})
     */
    private $body;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="createdAt", type="datetime", nullable=true)
     * @Serializer\Groups({"list", "details"})
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
     * @Serializer\Groups({"list", "details"})
     */
    private $modifiedAt;

    /**
     * @var int
     *
     * @ORM\Column(name="modifiedBy", type="integer", nullable=true)
     */
    private $modifiedBy;

    /**
     * @ORM\OneToMany(targetEntity="ArticleReply", mappedBy="article", cascade={"persist", "remove"}, fetch="EXTRA_LAZY")
     * @ORM\OrderBy({"createdAt" = "DESC"})
     * @Serializer\Groups({"details"})
     */
    protected $replies;

    /**
     * @ORM\OneToMany(targetEntity="ArticleRating", mappedBy="article", cascade={"persist", "remove"}, fetch="EAGER")
     */
    protected $ratings;

    public function __construct()
    {
        $this->setCreatedAt(new \DateTime);
        $this->setModifiedAt(new \DateTime);
    }

    /**
     * @Serializer\VirtualProperty
     * @Serializer\SerializedName("rating")
     * @Serializer\Groups({"list", "details"})
     */
    public function getAverageRating()
    {
        $ratingCount = 0;
        $totalRating = 0;

        foreach ($this->getRatings() as $rating)
        {
            $ratingCount++;
            $totalRating += $rating->getRating();
        }

        if (!$ratingCount)
        {
            return null;
        }
        else
        {
            return number_format($totalRating / $ratingCount, 1);
        }
    }

    /**
     * @Serializer\VirtualProperty
     * @Serializer\SerializedName("replyCount")
     * @Serializer\Groups({"list", "details"})
     */
    public function getReplyCount()
    {
        return count($this->getReplies());
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
     * @return Article
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
     * @return Article
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
     * @return Article
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
     * @return Article
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
     * @return Article
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
     * @return Article
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
     * Add reply
     *
     * @param \ArticleBundle\Entity\ArticleReply $reply
     *
     * @return Article
     */
    public function addReply(\ArticleBundle\Entity\ArticleReply $reply)
    {
        $this->replies[] = $reply;

        return $this;
    }

    /**
     * Remove reply
     *
     * @param \ArticleBundle\Entity\ArticleReply $reply
     */
    public function removeReply(\ArticleBundle\Entity\ArticleReply $reply)
    {
        $this->replies->removeElement($reply);
    }

    /**
     * Get replies
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getReplies()
    {
        return $this->replies;
    }

    /**
     * Add rating
     *
     * @param \ArticleBundle\Entity\ArticleRating $rating
     *
     * @return Article
     */
    public function addRating(\ArticleBundle\Entity\ArticleRating $rating)
    {
        $this->ratings[] = $rating;

        return $this;
    }

    /**
     * Remove rating
     *
     * @param \ArticleBundle\Entity\ArticleRating $rating
     */
    public function removeRating(\ArticleBundle\Entity\ArticleRating $rating)
    {
        $this->ratings->removeElement($rating);
    }

    /**
     * Get ratings
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getRatings()
    {
        return $this->ratings;
    }
}
