<?php

namespace Khoatran\CarForRent;

class Application
{
    /**
     * @return void
     */
    public function run(): void
    {
        print_r(Route::handle());
    }
}
