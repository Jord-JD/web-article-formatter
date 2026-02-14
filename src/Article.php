<?php

namespace JordJD\WebArticleFormatter;

use JordJD\WebArticleFormatter\Interfaces\ArticlePartInterface;
use Dompdf\Dompdf;

class Article
{
    public $parts = [];

    public function addPart(ArticlePartInterface $part)
    {
        $this->parts[] = $part;
    }

    public function format($format)
    {
        switch ($format) {
            case Format::PDF:
                return $this->formatPDF();

            case Format::JSON:
                return $this->formatJSON();
        }

        $output = '';

        foreach ($this->parts as $part) {
            $output .= $part->format($format);
        }

        return trim($output);
    }

    private function formatPDF()
    {
        $dompdf = new Dompdf();
        $dompdf->loadHtml($this->format(Format::HTML));
        $dompdf->render();

        return $dompdf->output();
    }

    private function formatJSON()
    {
        $jsonObjs = [];

        foreach ($this->parts as $part) {
            $jsonObj = $part;
            $jsonObj->type = (new \ReflectionClass($part))->getShortName();
            $jsonObjs[] = $jsonObj;
        }

        return json_encode($jsonObjs, JSON_PRETTY_PRINT);
    }
}
