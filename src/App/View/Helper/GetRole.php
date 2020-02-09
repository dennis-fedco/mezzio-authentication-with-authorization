<?php

declare(strict_types=1);

namespace App\View\Helper;

use Laminas\View\Helper\AbstractHelper;
use Mezzio\Authentication\UserInterface;
use Mezzio\Session\Session;

use function current;

class GetRole extends AbstractHelper
{
    public function __invoke(): string
    {
        $session     = new Session($_SESSION);
        $hasLoggedIn = $session->has(UserInterface::class);

        if (! $hasLoggedIn) {
            return 'guest';
        }

        return current($session->get(UserInterface::class)['roles']);
    }
}
