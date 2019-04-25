<?php

namespace FlexSession\Type;

use Symfony\Component\HttpFoundation\Session\Storage\Handler\AbstractSessionHandler;

/**
 * Class SessionHandlerFactoryInterface
 * @author Aleksandr Arofikin <sashaaro@gmail.com>
 */
interface SessionHandlerFactoryInterface
{
    public function create(array $params): AbstractSessionHandler;
}