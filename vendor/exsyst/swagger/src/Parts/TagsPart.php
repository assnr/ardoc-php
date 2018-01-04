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

use EXSyst\Component\Swagger\Tag;

/**
 * @internal
 */
trait TagsPart
{
    private $tags = [];

    private function mergeTags(array $data, $overwrite)
    {
        foreach ($data['tags'] ?? [] as $value) {
            $tag = new Tag($value);
            $this->tags[$tag->getName()] = $tag;
        }
    }

    /**
     * Return tags.
     *
     * @return array
     */
    public function getTags()
    {
        return array_values($this->tags);
    }

    protected function exportTags()
    {
        $out = [];
        foreach ($this->tags as $tag) {
            $out[] = $tag->toArray();
        }

        return $out;
    }
}
