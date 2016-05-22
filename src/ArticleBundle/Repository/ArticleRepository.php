<?php

namespace ArticleBundle\Repository;

use Doctrine\ORM\EntityRepository;

use ArticleBundle\Entity\Article;

/**
 * ArticleRepository
 *
 * This class was generated by the Doctrine ORM. Add your own custom
 * repository methods below.
 */
class ArticleRepository extends EntityRepository
{
	public function getAverageRating(Article $article)
	{
		return $this
			->createQueryBuilder('t')
			->select('AVG(t.rating)')
			->where('t.article = :article')
			->setParameter('article', $article)
			->getQuery()
			->getSingleScalarResult();
	}
}
