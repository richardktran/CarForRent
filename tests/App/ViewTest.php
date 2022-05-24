<?php

namespace Khoatran\Tests\App;

use Khoatran\CarForRent\App\Route;
use Khoatran\CarForRent\App\View;
use Khoatran\CarForRent\Http\Request;
use Khoatran\CarForRent\Http\Response;
use PHPUnit\Framework\TestCase;

class ViewTest extends TestCase
{
    /**
     * @runInSeparateProcess
     */
    public function testRedirectSuccess()
    {
        View::redirect('/login');
        $this->assertContains(
            'location: /login', xdebug_get_headers()
        );
    }

    /**
     * @runInSeparateProcess
     * @return void
     */
    public function testDisplayWithRedirectResponse()
    {
        $response = new Response();
        $response = $response->redirect('/login');

        View::display($response);
        $this->assertContains(
            'location: /login', xdebug_get_headers()
        );
    }

}
