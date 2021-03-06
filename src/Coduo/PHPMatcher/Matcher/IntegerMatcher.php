<?php

namespace Coduo\PHPMatcher\Matcher;

use Coduo\PHPMatcher\Parser;
use Coduo\ToString\String;

class IntegerMatcher extends Matcher
{
    /**
     * @var Parser
     */
    private $parser;

    /**
     * @param Parser $parser
     */
    public function __construct(Parser $parser)
    {
        $this->parser = $parser;
    }

    /**
     * {@inheritDoc}
     */
    public function match($value, $pattern)
    {
        if (!is_integer($value)) {
            $this->error = sprintf("%s \"%s\" is not a valid integer.", gettype($value), new String($value));
            return false;
        }

        $typePattern = $this->parser->parse($pattern);
        if (!$typePattern->matchExpanders($value)) {
            $this->error = $typePattern->getError();
            return false;
        }

        return true;
    }

    /**
     * {@inheritDoc}
     */
    public function canMatch($pattern)
    {
        if (!is_string($pattern)) {
            return false;
        }

        return $this->parser->hasValidSyntax($pattern) && $this->parser->parse($pattern)->is('integer');
    }
}
