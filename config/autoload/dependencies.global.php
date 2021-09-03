<?php

declare(strict_types=1);

use Mezzio\Authentication\UserRepositoryInterface;
use Mezzio\Authentication\UserRepository\PdoDatabase;
use Mezzio\Authorization\AuthorizationInterface;
use Mezzio\Authorization\Acl\LaminasAcl;
use Mezzio\Authentication\AuthenticationInterface;
use Mezzio\Authentication\Session\PhpSessionFactory;

return [
    // Provides application-wide services.
    // We recommend using fully-qualified class names whenever possible as
    // service names.
    'dependencies' => [
        // Use 'aliases' to alias a service name to another service. The
        // key is the alias name, the value is the service to which it points.
        'aliases' => [
            UserRepositoryInterface::class
                => PdoDatabase::class,

            AuthorizationInterface::class
                => LaminasAcl::class,
            // Fully\Qualified\ClassOrInterfaceName::class => Fully\Qualified\ClassName::class,
        ],
        // Use 'invokables' for constructor-less services, or services that do
        // not require arguments to the constructor. Map a service name to the
        // class name.
        'invokables' => [
            // Fully\Qualified\InterfaceName::class => Fully\Qualified\ClassName::class,
        ],
        // Use 'factories' for services provided by callbacks/factory classes.
        'factories' => [
            AuthenticationInterface::class
                => PhpSessionFactory::class,
            // Fully\Qualified\ClassName::class => Fully\Qualified\FactoryName::class,
        ],
    ],
];
