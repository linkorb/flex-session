<?php

namespace FlexSession\Type\File;

use FlexSession\Type\SessionHandlerFactoryInterface;
use Symfony\Component\HttpFoundation\Session\Storage\Handler\AbstractSessionHandler;
use Symfony\Component\HttpFoundation\Session\Storage\Handler\NativeFileSessionHandler;
use Symfony\Component\HttpFoundation\Session\Storage\Handler\StrictSessionHandler;

/**
 * Class FileSessionHandlerFactory
 * @author Aleksandr Arofikin <sashaaro@gmail.com>
 */
class FileSessionHandlerFactory implements SessionHandlerFactoryInterface
{
    public function create(array $params): AbstractSessionHandler
    {
        $path = $params['path'] ?? null;

        return new StrictSessionHandler(new NativeFileSessionHandler($path));
    }
}