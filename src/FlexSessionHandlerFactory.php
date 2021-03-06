<?php

namespace FlexSession;

use FlexSession\TypeProvider\TypeProviderInterface;
use FlexSession\Type\SessionHandlerFactoryInterface;
use Symfony\Component\HttpFoundation\Session\Storage\Handler\AbstractSessionHandler;

/**
 * Class FlexSessionHandlerFactory
 * @author Aleksandr Arofikin <sashaaro@gmail.com>
 */
class FlexSessionHandlerFactory
{
    /** @var SessionHandlerFactoryInterface[] */
    protected $factories = [];

    protected $typeProvider;

    public function __construct(TypeProviderInterface $typeProvider)
    {
        $this->typeProvider = $typeProvider;
    }

    public function addType($typeKey, SessionHandlerFactoryInterface $userFactory)
    {
        if (array_key_exists($typeKey, $this->factories)) {
            throw new \InvalidArgumentException(sprintf('Flex session type "%s" was added already', $typeKey));
        }

        $this->factories[$typeKey] = $userFactory;
    }

    /**
     * Create by current flex session type. Usually from env
     */
    public function create(): AbstractSessionHandler
    {
        $params = $this->typeProvider->provide();
        $factory = $this->createTypeFactory($params['type']);

        return $factory->create($params);
    }

    public function createTypeFactory($type): SessionHandlerFactoryInterface
    {
        return $this->factories[$type];
    }
}