<?php

namespace JordJD\WebArticleFormatter\ArticleParts;

use JordJD\WebArticleFormatter\Format;
use JordJD\WebArticleFormatter\Interfaces\ArticlePartInterface;

class Heading implements ArticlePartInterface
{
    public $content;
    public $level;

    public function __construct($content)
    {
        $this->content = trim($content);
    }

    public function setLevel($level)
    {
        $this->level = (int) $level;
    }

    public function format($format)
    {
        switch ($format) {

            case Format::MARKDOWN:
                return str_repeat('#', $this->level).' '.$this->content.PHP_EOL.PHP_EOL;
                break;

            case Format::PLAINTEXT:
                return $this->content.PHP_EOL.PHP_EOL;
                break;

            case Format::HTML:
                return '<h'.$this->level.'>'.htmlentities($this->content).'</h'.$this->level.'>'.PHP_EOL;
                break;

            default:
                throw new InvalidFormatException();
                break;
        }
    }
}
