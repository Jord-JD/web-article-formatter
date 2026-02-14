<?php

use JordJD\WebArticleFormatter\Format;
use JordJD\WebArticleFormatter\WebArticleFormatter;

require_once __DIR__.'/vendor/autoload.php';

$formatter = new WebArticleFormatter('https://www.theguardian.com/politics/2018/mar/24/keir-starmer-we-cannot-allow-labour-to-break-apart-over-brexit');

echo $formatter->get(Format::JSON);
