<?php

/*
 * This file is part of the Swagger package.
 *
 * (c) EXSyst
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace EXSyst\Component\Swagger;

use EXSyst\Component\Swagger\Parts\DescriptionPart;
use EXSyst\Component\Swagger\Parts\ExtensionPart;
use EXSyst\Component\Swagger\Parts\ItemsPart;
use EXSyst\Component\Swagger\Parts\RefPart;
use EXSyst\Component\Swagger\Parts\TypePart;

final class Items extends AbstractModel
{
    const REQUIRED = false;

    use RefPart;
    use TypePart;
    use ItemsPart;
    use ExtensionPart;
    use DescriptionPart;

    public function __construct($data = [])
    {
        $this->merge($data);
    }

    protected function doMerge($data, $overwrite = false)
    {
        $this->mergeExtensions($data, $overwrite);
        $this->mergeItems($data, $overwrite);
        $this->mergeRef($data, $overwrite);
        $this->mergeType($data, $overwrite);
    }

    protected function doExport()
    {
        if ($this->hasRef()) {
            return ['$ref' => $this->getRef()];
        }

        return array_merge([
            'items' => $this->items,
        ], $this->doExportType());
    }
}
