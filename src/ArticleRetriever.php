<?php

namespace JordJD\WebArticleFormatter;

use JordJD\WebArticleFormatter\ArticleParts\Heading;
use JordJD\WebArticleFormatter\ArticleParts\Paragraph;
use GuzzleHttp\Client;

class ArticleRetriever
{
    private $client;

    public function __construct()
    {
        $this->client = new Client([
            'timeout'  => 10,
        ]);
    }

    public function get($url)
    {
        $response = $this->client->request('GET', $url);
        $body = (string) $response->getBody();

        libxml_use_internal_errors(true);

        $domDoc = new \DOMDocument();
        $domDoc->loadHTML('<?xml version="1.0" encoding="UTF-8"?>'.$body);

        $article = new Article();

        $this->parseDomNodes($domDoc, $article);

        return $article;
    }

    private function parseDomNodes(\DOMNode $domNode, Article &$article)
    {
        if ($domNode->childNodes == null) {
            return;
        }

        foreach ($domNode->childNodes as $childDomNode) {
            if (trim($childDomNode->nodeValue)) {
                if ($childDomNode->nodeName == 'p') {
                    $article->addPart(new Paragraph($childDomNode->nodeValue));
                } elseif (strlen($childDomNode->nodeName) == 2 && substr($childDomNode->nodeName, 0, 1) == 'h' && is_numeric(substr($childDomNode->nodeName, 1, 1))) {
                    $heading = new Heading($childDomNode->nodeValue);
                    $heading->setLevel(substr($childDomNode->nodeName, 1, 1));
                    $article->addPart($heading);
                }
            }

            if ($domNode->hasChildNodes()) {
                $this->parseDomNodes($childDomNode, $article);
            }
        }
    }
}
