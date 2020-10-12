<?php

namespace Jaybizzle\DocToText;

use Jaybizzle\DocToText\Exceptions\CouldNotExtractText;
use Jaybizzle\DocToText\Exceptions\DocNotFound;
use Symfony\Component\Process\Process;

class Doc
{
    protected $doc;

    protected $binPath;

    protected $options = [];

    public function __construct(string $binPath = null)
    {
        $this->binPath = $binPath ?? '/usr/bin/antiword';
    }

    public function setDoc(string $doc) : self
    {
        if (! is_readable($doc)) {
            throw new DocNotFound(sprintf('could not find or read doc `%s`', $doc));
        }

        $this->doc = $doc;

        return $this;
    }

    public function setOptions(array $options) : self
    {
        $mapper = function (string $content) : array {
            $content = trim($content);
            if ('-' !== ($content[0] ?? '')) {
                $content = '-'.$content;
            }

            return explode(' ', $content, 2);
        };

        $reducer = function (array $carry, array $option) : array {
            return array_merge($carry, $option);
        };

        $this->options = array_reduce(array_map($mapper, $options), $reducer, []);

        return $this;
    }

    public function text() : string
    {
        $process = new Process(array_merge([$this->binPath], $this->options, [$this->doc]));
        $process->run();
        if (! $process->isSuccessful()) {
            throw new CouldNotExtractText($process);
        }

        return trim($process->getOutput(), " \t\n\r\0\x0B\x0C");
    }

    public static function getText(string $doc, string $binPath = null, array $options = []) : string
    {
        return (new static($binPath))
            ->setOptions($options)
            ->setDoc($doc)
            ->text();
    }
}
