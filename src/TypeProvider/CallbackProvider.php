<?php

namespace FlexSession\TypeProvider;

/**
 * Class CallbackProvider
 * @author Aleksandr Arofikin <sashaaro@gmail.com>
 */
class CallbackProvider implements TypeProviderInterface
{
    /** @var callable */
    private $callback;

    public function __construct(callable $callback)
    {
        $this->callback = $callback;
    }
    public function provide(): array
    {
        return call_user_func($this->callback);
    }
}