<?php

namespace FlexSession\TypeProvider;

/**
 * Class TypeProviderInterface
 * @author Aleksandr Arofikin <sashaaro@gmail.com>
 */
interface TypeProviderInterface
{
    /**
     * Return arrays with required key "type"
     * @return array
     */
    public function provide(): array;
}