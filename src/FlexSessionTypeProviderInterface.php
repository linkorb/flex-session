<?php

namespace FlexSession;

/**
 * Class FlexSessionTypeProviderInterface
 * @author Aleksandr Arofikin <sashaaro@gmail.com>
 */
interface FlexSessionTypeProviderInterface
{
    /**
     * Return arrays with required key "type"
     * @return array
     */
    public function provide(): array;
}