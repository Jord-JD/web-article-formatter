<?php

namespace JordJD\WebArticleFormatter\Interfaces;

interface ArticlePartInterface
{
    public function __construct($content);

    public function format($format);
}
