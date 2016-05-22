<?php

namespace ArticleBundle\Api;

use FOS\RestBundle\Controller\FOSRestController;
use FOS\RestBundle\Controller\Annotations as Rest;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Request;
use JMS\Serializer\SerializationContext;

use ArticleBundle\Entity\Article;
use ArticleBundle\Form\ArticleType;

/**
 * RESTful Article API
 *
 * @Rest\NamePrefix("api_rest_v1_article_")
 */
class ArticleController extends FOSRestController
{
    /**
     * Get a Form instance
     *
     * @param Article|null $article
     *
     * @return Form
     */
    protected function getForm(Article $article = null)
    {
        $options = [
            'csrf_protection' => false
        ];

        if (null === $article)
        {
            $article = new Article;
        }

        return $this->createForm(ArticleType::class, $article, $options);
    }

    /**
     * List all articles
     *
     * @todo Pagination
     *
     * @Rest\Get("/list")
     */
    public function listAction()
    {
        $articles = $this
            ->getDoctrine()
            ->getRepository('ArticleBundle:Article')
            ->findAll();

        $context = SerializationContext::create()->setGroups([ 'list' ]);
        $view    = $this->view($articles, 200)
            ->setSerializationContext($context)
            ->setTemplate("ArticleBundle:Article:list.html.twig")
            ->setTemplateVar('articles');

        return $this->handleView($view);
    }

    /**
     * Create article / display creation form
     *
     * @Rest\Route("/create", methods="GET|POST")
     */
    public function createAction(Request $request)
    {
        $article = new Article;

        $form = $this->getForm($article);

        $view = $this->view($form, 200)
            ->setTemplate("ArticleBundle:Article:create.html.twig")
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

                $objectManager->persist($article);
                $objectManager->flush();

                $view = $this->routeRedirectView('api_rest_v1_article_get_article', [
                    'article' => $article->getId(),
                    '_format' => $request->get('_format')
                ]);
            }
        }

        return $this->handleView($view);
    }

    /**
     * Get a single article
     *
     * @Rest\Get("/{article}")
     */
    public function getArticleAction(Article $article)
    {
        $context = SerializationContext::create()->setGroups([ 'details' ]);
        $view    = $this->view($article, 200)
            ->setSerializationContext($context)
            ->setTemplate("ArticleBundle:Article:profile.html.twig")
            ->setTemplateVar('article');

        return $this->handleView($view);
    }
}
