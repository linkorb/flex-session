<?php

namespace FlexSession;

use FlexSession\Type\File\FileSessionHandlerFactory;
use FlexSession\Type\SessionHandlerFactoryInterface;
use Symfony\Component\HttpFoundation\Session\Storage\Handler\AbstractSessionHandler;


/**
 * Class FlexSessionHandlerFactory
 * @author Aleksandr Arofikin <sashaaro@gmail.com>
 */
class FlexSessionHandlerFactory
{
    /**
     * Create by current flex session type. Usually from env
     */
    public function create(): AbstractSessionHandler
    {
        $type = 'file';

        $factory = $this->createTypeFactory($type);
        $params = []; // TODO resolve params

        return $factory->create($params);
    }

    public function createTypeFactory($type): SessionHandlerFactoryInterface
    {
        // TODO resolve factory
        $factory = new FileSessionHandlerFactory();

        return $factory;
    }
}