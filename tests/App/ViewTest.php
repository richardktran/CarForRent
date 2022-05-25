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

    /**
     * @runInSeparateProcess
     * @return void
     */
    public function testDisplayWithGetTemplateHaveDataResponse()
    {
        $_SERVER["REQUEST_URI"] = '/login';
        $response = new Response();
        $response = $response->renderView('login', ['username' => 'richardktran', 'password' => '123456']);

        View::display($response);
        $template = $response->getTemplate();
        $data = $response->getData();
        $this->assertEquals('login', $template);
        $this->assertEquals(['username' => 'richardktran', 'password' => '123456'], $data);
    }

    /**
     * @runInSeparateProcess
     * @return void
     */
    public function testDisplayWithGetTemplateWithDataHaveErrorResponse()
    {
        $_SERVER["REQUEST_URI"] = '/login';
        $response = new Response();
        $response = $response->renderView('login',
            ['username' => 'richardktran', 'password' => '123456', 'error' => 'error']);

        View::display($response);
        $template = $response->getTemplate();
        $data = $response->getData();
        $this->assertEquals('login', $template);
        $this->assertEquals(['username' => 'richardktran', 'password' => '123456', 'error' => 'error'], $data);
    }

}
