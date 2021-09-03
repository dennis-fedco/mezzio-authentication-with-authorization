<?php

declare(strict_types=1);

namespace AppTest\Unit\View\Helper;

use App\View\Helper\GetRole;
use App\View\Helper\IsGranted;
use App\View\Helper\IsGrantedFactory;
use Laminas\View\HelperPluginManager;
use Mezzio\Authorization\Acl\LaminasAcl;
use Mezzio\LaminasView\UrlHelper;
use Mezzio\Router\LaminasRouter;
use PHPUnit\Framework\TestCase;
use Prophecy\PhpUnit\ProphecyTrait;
use Psr\Container\ContainerInterface;

class IsGrantedFactoryTest extends TestCase
{
    use ProphecyTrait;

    /** @var ContainerInterface|ObjectProphecy */
    protected $container;

    protected function setUp(): void
    {
        $this->container = $this->prophesize(ContainerInterface::class);
    }

    public function testFactory(): void
    {
        $this->container
            ->get(LaminasAcl::class)
            ->willReturn($this->prophesize(LaminasAcl::class));

        $helperPluginManager = $this->prophesize(HelperPluginManager::class);
        $helperPluginManager->get('getRole')
                            ->willReturn(new GetRole());
        $helperPluginManager->get('url')
                            ->willReturn($this->prophesize(UrlHelper::class)->reveal());
        $this->container->get(HelperPluginManager::class)
                        ->willReturn($helperPluginManager);

        $this->container->get(LaminasRouter::class)
                        ->willReturn($this->prophesize(LaminasRouter::class)->reveal());

        $factory = new IsGrantedFactory();

        $isGranted = $factory($this->container->reveal());

        $this->assertInstanceOf(IsGranted::class, $isGranted);
    }
}
