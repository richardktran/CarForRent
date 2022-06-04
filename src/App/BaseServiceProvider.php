<?php

namespace Khoatran\CarForRent\App;

abstract class BaseServiceProvider
{
    protected Container $provider;

    public function __construct()
    {
        $this->provider = new Container();
    }

    /**
     * @return void
     */
    abstract public function register(): void;

    /**
     * @return Container
     */
    public function getContainer(): Container
    {
        $this->register();
        return $this->provider;
    }
}
