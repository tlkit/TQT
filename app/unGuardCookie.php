<?php
/**
 * Instead of Laravel Cookie Guard
 */

namespace Illuminate\Cookie;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\HttpKernelInterface;

class Guard implements HttpKernelInterface
{
    private $app;

    public function __construct(HttpKernelInterface $app, $unused = null)
    {
        $this->app = $app;
    }

    public function handle(Request $request, $type = HttpKernelInterface::MASTER_REQUEST, $catch = true)
    {
        return $this->app->handle($request, $type, $catch);
    }
}