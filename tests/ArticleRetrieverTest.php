<?php

namespace JordJD\WebArticleFormatter\Tests;

use GuzzleHttp\Client;
use GuzzleHttp\Handler\MockHandler;
use GuzzleHttp\HandlerStack;
use GuzzleHttp\Psr7\Response;
use JordJD\WebArticleFormatter\ArticleRetriever;
use JordJD\WebArticleFormatter\Format;
use PHPUnit\Framework\TestCase;

class ArticleRetrieverTest extends TestCase
{
    public function testRetrievesAndParsesHeadingsAndParagraphs()
    {
        $mock = new MockHandler([
            new Response(200, [], '<html><body><h1>Example</h1><p>First paragraph.</p></body></html>'),
        ]);
        $client = new Client(['handler' => HandlerStack::create($mock)]);

        $article = (new ArticleRetriever($client))->get('https://example.com/article');

        $this->assertSame("# Example\n\nFirst paragraph.", $article->format(Format::MARKDOWN));
    }
}
