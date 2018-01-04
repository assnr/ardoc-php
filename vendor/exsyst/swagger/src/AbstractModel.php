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

/**
 * @internal
 */
abstract class AbstractModel
{
    const REQUIRED = true;

    public function merge($data, $overwrite = false)
    {
        return $this->doMerge($this->normalize($data), $overwrite);
    }

    protected function doMerge($data, $overwrite = false)
    {
        $this->parse($data);
    }

    public function toArray()
    {
        $return = [];
        foreach ($this->doExport() as $key => $value) {
            $value = $this->resolve($value);
            if (null === $value) {
                continue;
            }

            $return[$key] = $value;
        }

        if (method_exists($this, 'getExtensions')) {
            foreach ($this->getExtensions() as $name => $value) {
                $return['x-'.$name] = $value;
            }
        }

        if (is_array($return) && 0 === count($return) && !static::REQUIRED) {
            $return = null;
        }

        return $return;
    }

    protected function normalize($data)
    {
        if ($data instanceof \stdClass || $data instanceof \ArrayAccess) {
            return (array) $data;
        }

        return $data;
    }

    private function resolve($value)
    {
        if (is_array($value)) {
            foreach ($value as &$v) {
                $v = $this->resolve($v);
            }
        } elseif ($value instanceof self) {
            $value = $value->toArray();
        }

        return $value;
    }
}
