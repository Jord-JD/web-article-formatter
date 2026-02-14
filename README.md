# 🌐🔀📰 Web Article Formatter

[![StyleCI](https://styleci.io/repos/126647242/shield?branch=master)](https://styleci.io/repos/126647242)

The web article formatter can extract and convert an article from a webpage into a number of other formats, 
including PDF, markdown, JSON, plain text and more.

## Installation

You can install Web Article Formatter via Composer. Just run the following command.

```
composer require jord-jd/web-article-formatter
```

## Usage

To retrieve a web page article and convert it into a different format, first create a new `WebArticleFormatter`
passing it the URL of the web page. Then, simply call the formatter's `get` method, passing it a valid format constant.

A list of all format constants can be found in the [`Format` class](src/Format.php).

```php
$formatter = new WebArticleFormatter($url);

echo $formatter->get(Format::PLAINTEXT);
echo $formatter->get(Format::MARKDOWN);
echo $formatter->get(Format::HTML);
echo $formatter->get(Format::JSON);

file_put_contents('article.pdf', $formatter->get(Format::PDF));

```