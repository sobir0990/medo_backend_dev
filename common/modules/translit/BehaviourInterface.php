<?php

namespace common\modules\translit;

interface BehaviourInterface
{
    /**
     * @param LatinTokenizer $text
     * @return object | null
     */
    public function next($text);
}