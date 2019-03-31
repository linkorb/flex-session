<?php

namespace FlexSessionTest\Stubs;

use FlexSession\FlexSessionTypeProviderInterface;

class FlexSessionTypeProvider implements FlexSessionTypeProviderInterface
{
    /** @var array */
    public $type;

    public function provide(): array
    {
        return $this->type;
    }
}