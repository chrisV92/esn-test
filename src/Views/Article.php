<?php

namespace EsnTest\Views;

use EsnTest\Routing\Router;
use EsnTest\TestController;

/**
 * Class Articles.
 *
 * By extending this class from AbstractView, we have available the
 * render() method, that will load the desired twig template with the
 * variables needed.
 */
class Article extends AbstractView
{

    /**
     * Articles view.
     *
     * @route("articles")
     *
     * @alias("articles")
     */
    public function index()
    {
        // We call our test controller for the data we need later in twig.
        $testController = new TestController();

        // And we render the data.
        $this->render('articles.twig', [
            'articles' => $testController->getNews(),
            'num_articles' => $testController->countNews(),
        ]);
    }

    /**
     * Article view.
     *
     * @route("article/{slug}")
     *
     * @alias("article")
     */
    public function article($slug = null)
    {

        // We call our test controller for the data we need later in twig.
        $testController = new TestController();

        foreach ($testController->getNews() as $item) {

            if ($item['slug'] == $slug) {
                $article[] = $item;

                $this->render('single-article.twig', [
                    'article' => $article
                ]);
                return;
            }
        }

        $this->render('404.twig', [
            'request_uri' => $slug
        ]);
    }
}