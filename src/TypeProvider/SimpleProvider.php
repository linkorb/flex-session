<?php

namespace FlexSession\TypeProvider;

/**
 * Class SimpleProvider
 * @author Aleksandr Arofikin <sashaaro@gmail.com>
 */
class SimpleProvider implements TypeProviderInterface
{
    /** @var array */
    public $type;

    public function provide(): array
    {
        return $this->type;
    }
}