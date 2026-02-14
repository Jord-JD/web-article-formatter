<?php

namespace JordJD\WebArticleFormatter;

class WebArticleFormatter
{
    private $article;

    public function __construct($url)
    {
        $this->article = (new ArticleRetriever())->get($url);
    }

    public function get($format)
    {
        return $this->article->format($format);
    }
}
