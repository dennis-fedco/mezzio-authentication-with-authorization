<?php

declare(strict_types=1);

namespace AppTest\Integration;

use Laminas\Diactoros\ServerRequest;
use Laminas\Diactoros\Uri;
use Mezzio\Application;
use Mezzio\Authentication\UserInterface;
use PHPUnit\Framework\TestCase;

class AdminPageTest extends TestCase
{
    /** @var Application */
    private $app;

    protected function setUp(): void
    {
        $this->app = AppFactory::create();
    }

    public function testOpenAdminPageAsAguestRedirectToLoginPage(): void
    {
        $uri           = new Uri('/admin');
        $serverRequest = new ServerRequest([], [], $uri);

        $response = $this->app->handle($serverRequest);
        $this->assertEquals(302, $response->getStatusCode());
        $this->assertEquals('/login', $response->getHeaderLine('Location'));
    }

    public function testOpenAdminPageAsAuserGot403Forbidden(): void
    {
        $sessionData                    = [
            'username' => 'samsonasik',
            'roles'    => [
                'user',
            ],
        ];
        $_SESSION[UserInterface::class] = $sessionData;

        $uri           = new Uri('/admin');
        $serverRequest = new ServerRequest([], [], $uri);

        $response = $this->app->handle($serverRequest);
        $this->assertEquals(403, $response->getStatusCode());
    }

    public function testOpenAdminPageAsAnAdminGot200Ok(): void
    {
        $sessionData                    = [
            'username' => 'admin',
            'roles'    => [
                'admin',
            ],
        ];
        $_SESSION[UserInterface::class] = $sessionData;

        $uri           = new Uri('/admin');
        $serverRequest = new ServerRequest([], [], $uri);

        $response = $this->app->handle($serverRequest);
        $this->assertEquals(200, $response->getStatusCode());
    }
}
