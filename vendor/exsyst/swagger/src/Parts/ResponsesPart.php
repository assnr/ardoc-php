<?php

/*
 * This file is part of the Swagger package.
 *
 * (c) EXSyst
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace EXSyst\Component\Swagger\Parts;

use EXSyst\Component\Swagger\Collections\Responses;

/**
 * @internal
 */
trait ResponsesPart
{
    /** @var Responses */
    private $responses;

    private function mergeResponses(array $data, $overwrite)
    {
        if (isset($data['responses'])) {
            $this->getResponses()->merge($data['responses'], $overwrite);
        }
    }

    /**
     * Return responses.
     *
     * @return Responses
     */
    public function getResponses()
    {
        if (null === $this->responses) {
            $this->responses = new Responses();
        }

        return $this->responses;
    }
}
