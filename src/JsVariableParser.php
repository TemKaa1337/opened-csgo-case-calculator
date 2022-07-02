<?php declare(strict_types = 1);

namespace TemKaa1337\CSGOCasesCalculator;

use InvalidArgumentException;

class JsVariableParser
{
    public function __construct(
        private readonly string $html, 
        private readonly string $variableName,
        private readonly array $replaceCharacters = []
    ) {}

    public function parse(): string
    {
        $jsVariablePosition = strpos($this->html, $this->variableName);

        if ($jsVariablePosition === false) {
            throw new InvalidArgumentException('The provided html doesnt contain session id');
        }

        $lineEndPosition = strpos($this->html, ';', $jsVariablePosition);
        $lineContents = substr($this->html, $jsVariablePosition, $lineEndPosition - $jsVariablePosition);

        $variableAssertion = explode('=', $lineContents)[1];
        if (!empty($this->replaceCharacters)) {
            $variableAssertion = str_replace('"', '', $variableAssertion);
        }

        return trim($variableAssertion);
    }
}