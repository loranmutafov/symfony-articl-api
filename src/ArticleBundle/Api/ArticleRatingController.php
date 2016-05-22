<?php

namespace ArticleBundle\Api;

use FOS\RestBundle\Controller\FOSRestController;
use FOS\RestBundle\Controller\Annotations as Rest;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Request;
use JMS\Serializer\SerializationContext;

use ArticleBundle\Entity\Article;
use ArticleBundle\Entity\ArticleRating;
use ArticleBundle\Form\ArticleRatingType;

/**
 * RESTful ArticleRating API
 *
 * @Rest\NamePrefix("api_rest_v1_article_rating_")
 */
class ArticleRatingController extends FOSRestController
{
    /**
     * Get a Form instance
     *
     * @param ArticleRating|null $articleRating
     *
     * @return Form
     */
    protected function getForm(ArticleRating $articleRating)
    {
        $options = [
            'csrf_protection' => false
        ];

        return $this->createForm(ArticleRatingType::class, $articleRating, $options);
    }

    /**
     * Create article / display creation form
     *
     * @Rest\Route("/create", methods="GET|POST")
     */
    public function createAction(Request $request, Article $article)
    {
        $articleRating = new ArticleRating;
        $articleRating->setArticle($article);

        $form = $this->getForm($articleRating);

        $view = $this->view($form, 200)
            ->setTemplate("ArticleBundle:ArticleRating:create.html.twig")
            ->setTemplateVar('form')
            ->setTemplateData([
                'article' => $article
            ]);

        if ($request->getMethod() == 'POST')
        {
            $form->handleRequest($request);

            if ($form->isValid())
            {
                $objectManager = $this->getDoctrine()->getManager();

                $objectManager->persist($articleRating);
                $objectManager->flush();

                $view = $this->routeRedirectView('api_rest_v1_article_get_article', [
                    'article' => $article->getId(),
                    '_format' => $request->get('_format')
                ]);
            }
        }

        return $this->handleView($view);
    }
}
