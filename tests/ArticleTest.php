<?php

namespace JordJD\WebArticleFormatter\Tests;

use JordJD\WebArticleFormatter\Article;
use JordJD\WebArticleFormatter\ArticleParts\Heading;
use JordJD\WebArticleFormatter\ArticleParts\Paragraph;
use JordJD\WebArticleFormatter\Exceptions\InvalidFormatException;
use JordJD\WebArticleFormatter\Format;
use PHPUnit\Framework\TestCase;

class ArticleTest extends TestCase
{
    public function testFormatsArticleWithoutMutatingParts()
    {
        $heading = new Heading('Title');
        $heading->setLevel(2);
        $paragraph = new Paragraph('Fish & chips');

        $article = new Article();
        $article->addPart($heading);
        $article->addPart($paragraph);

        $this->assertSame("## Title\n\nFish & chips", $article->format(Format::MARKDOWN));
        $this->assertSame("<h2>Title</h2>\n<p>Fish &amp; chips</p>", $article->format(Format::HTML));

        $json = json_decode($article->format(Format::JSON), true);
        $this->assertSame('Heading', $json[0]['type']);
        $this->assertSame('Paragraph', $json[1]['type']);
        $this->assertFalse(property_exists($heading, 'type'));
        $this->assertFalse(property_exists($paragraph, 'type'));
    }

    public function testHeadingThrowsPackageExceptionForInvalidFormat()
    {
        if (method_exists($this, 'expectException')) {
            $this->expectException(InvalidFormatException::class);
        } else {
            $this->setExpectedException(InvalidFormatException::class);
        }

        (new Heading('Title'))->format('invalid');
    }
}
