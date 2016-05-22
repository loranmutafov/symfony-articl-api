<?php

namespace ArticleBundle\Api;

use FOS\RestBundle\Controller\FOSRestController;
use FOS\RestBundle\Controller\Annotations as Rest;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Request;
use JMS\Serializer\SerializationContext;

use ArticleBundle\Entity\Article;
use ArticleBundle\Entity\ArticleReply;
use ArticleBundle\Form\ArticleReplyType;

/**
 * RESTful ArticleReply API
 *
 * @Rest\NamePrefix("api_rest_v1_article_reply_")
 */
class ArticleReplyController extends FOSRestController
{
    /**
     * Get a Form instance
     *
     * @param ArticleReply|null $articleReply
     *
     * @return Form
     */
    protected function getForm(ArticleReply $articleReply)
    {
        $options = [
            'csrf_protection' => false
        ];

        return $this->createForm(ArticleReplyType::class, $articleReply, $options);
    }

    /**
     * Create article / display creation form
     *
     * @Rest\Route("/create", methods="GET|POST")
     */
    public function createAction(Request $request, Article $article)
    {
        $articleReply = new ArticleReply;
        $articleReply->setArticle($article);

        $form = $this->getForm($articleReply);

        $view = $this->view($form, 200)
            ->setTemplate("ArticleBundle:ArticleReply:create.html.twig")
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

                $objectManager->persist($articleReply);
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
