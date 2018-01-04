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

use EXSyst\Component\Swagger\ExternalDocs;

/**
 * @internal
 */
trait ExternalDocsPart
{
    private $externalDocs;

    private function mergeExternalDocs(array $data, $overwrite)
    {
        if (isset($data['externalDocs'])) {
            $this->getExternalDocs()->merge($data['externalDocs']);
        }
    }

    /**
     * @return ExternalDocs
     */
    public function getExternalDocs()
    {
        if (null === $this->externalDocs) {
            $this->externalDocs = new ExternalDocs();
        }

        return $this->externalDocs;
    }

    /**
     * @param ExternalDocs $externalDocs
     *
     * @return $this
     */
    public function setExternalDocs(ExternalDocs $externalDocs)
    {
        $this->externalDocs = $externalDocs;

        return $this;
    }
}
