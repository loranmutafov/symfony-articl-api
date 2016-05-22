<?php

namespace ArticleBundle\Tests\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class DefaultControllerTest extends WebTestCase
{
    /**
     * @var \Doctrine\ORM\EntityManager
     */
    private $objectManager;

    /**
     * {@inheritDoc}
     */
    protected function setUp()
    {
        self::bootKernel();

        $this->objectManager = static::$kernel
            ->getContainer()
            ->get('doctrine')
            ->getManager();
    }

    private function getArticleCount()
    {
        return $this
            ->objectManager
            ->getRepository('ArticleBundle:Article')
            ->createQueryBuilder('t')
            ->select('COUNT(t.id)')
            ->getQuery()
            ->getSingleScalarResult();
    }

    public function testArticleListHtmlResponse()
    {
        $client = static::createClient();

        $crawler = $client->request('GET', '/api/articles/list.html');

        $this->assertEquals(200, $client->getResponse()->getStatusCode());
        $this->assertContains('text/html', $client->getResponse()->headers->get('Content-Type'));
    }

    public function testArticleListXmlResponse()
    {
        $client = static::createClient();

        $crawler = $client->request('GET', '/api/articles/list.xml');

        $this->assertEquals(200, $client->getResponse()->getStatusCode());
        $this->assertContains('text/xml', $client->getResponse()->headers->get('Content-Type'));
    }

    public function testArticleListJsonResponse()
    {
        $client = static::createClient();

        $crawler = $client->request('GET', '/api/articles/list.json');

        $this->assertEquals(200, $client->getResponse()->getStatusCode());
        $this->assertEquals('application/json', $client->getResponse()->headers->get('Content-Type'));
    }

    public function testArticleCreateHtmlResponse()
    {
        $client = static::createClient();

        $crawler = $client->request('GET', '/api/articles/create.html');

        $this->assertEquals(200, $client->getResponse()->getStatusCode());
        $this->assertContains('text/html', $client->getResponse()->headers->get('Content-Type'));
    }

    public function testArticleCreateXmlResponse()
    {
        $client = static::createClient();

        $crawler = $client->request('GET', '/api/articles/create.xml');

        $this->assertEquals(200, $client->getResponse()->getStatusCode());
        $this->assertContains('text/xml', $client->getResponse()->headers->get('Content-Type'));
    }

    public function testArticleCreateJsonResponse()
    {
        $client = static::createClient();

        $crawler = $client->request('GET', '/api/articles/create.json');

        $this->assertEquals(200, $client->getResponse()->getStatusCode());
        $this->assertEquals('application/json', $client->getResponse()->headers->get('Content-Type'));
    }

    public function testSuccessfulArticleCreation()
    {
        $client = static::createClient();

        $articleCount = $this->getArticleCount();

        $crawler = $client->request('POST', '/api/articles/create.json', [ ], [ ], [
            'CONTENT_TYPE' => 'application/json'
        ],
        json_encode([
            'article' => [
                'title'  => 'Test article',
                'body'   => '<p>Test article</p>'
            ]
        ]));

        $this->assertTrue($client->getResponse()->isRedirect());
        $this->assertEquals($this->getArticleCount(), $articleCount + 1);
    }

    public function testArticleFormDisallowsAdditionalFields()
    {
        $client = static::createClient();

        $articleCount = $this->getArticleCount();

        $crawler = $client->request('POST', '/api/articles/create.json', [ ], [ ], [
            'CONTENT_TYPE' => 'application/json'
        ],
        json_encode([
            'article' => [
                'title'  => 'This article shall not exist',
                'body'   => '<p>If it does exist, call the police</p>',
                'badguy' => 'Criminal'
            ]
        ]));

        $this->assertEquals(400, $client->getResponse()->getStatusCode());
        $this->assertEquals($this->getArticleCount(), $articleCount);
    }

    public function testArticleFormValidationTitleIsRequired()
    {
        $client = static::createClient();

        $articleCount = $this->getArticleCount();

        $crawler = $client->request('POST', '/api/articles/create.json', [ ], [ ], [
            'CONTENT_TYPE' => 'application/json'
        ],
        json_encode([
            'article' => [
                'body'   => '<p>An article without a title is not a real article.</p>'
            ]
        ]));

        $this->assertEquals(400, $client->getResponse()->getStatusCode());
        $this->assertEquals($this->getArticleCount(), $articleCount);
    }

    public function testArticleFormValidationBodyIsRequired()
    {
        $client = static::createClient();

        $articleCount = $this->getArticleCount();

        $crawler = $client->request('POST', '/api/articles/create.json', [ ], [ ], [
            'CONTENT_TYPE' => 'application/json'
        ],
        json_encode([
            'article' => [
                'title'   => 'An article without a body is not a real article'
            ]
        ]));

        $this->assertEquals(400, $client->getResponse()->getStatusCode());
        $this->assertEquals($this->getArticleCount(), $articleCount);
    }
}
