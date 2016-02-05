<?php

namespace Bolt\Extension\GeevCookie\BoltCloudFlare\Tests;

use Bolt\Tests\BoltUnitTest;
use Bolt\Extension\GeevCookie\BoltCloudFlare\Extension;
use Symfony\Component\HttpFoundation\Request;

/**
 * Class ExtensionTest
 * @package Bolt\Extension\GeevCookie\BoltCloudFlare\Tests
 */
class ExtensionTest extends BoltUnitTest
{
    /**
     * Ensure that the BoltCloudFlare extension loads correctly.
     *
     */
    public function testExtensionRegister()
    {
        $app = $this->getApp();
        $extension = new Extension($app);

        $app['extensions']->register($extension);
        $name = $extension->getName();

        $this->assertSame($name, 'BoltCloudFlare');
        $this->assertSame($extension, $app["extensions.$name"]);
    }

    /**
     * Ensures that the plugin changes the user IP when request is from trusted proxy.
     *
     */
    public function testIpChange()
    {
        // App Setup
        $app = $this->getApp();
        $extension = new Extension($app);
        $app['extensions']->register($extension);
        $this->addDefaultUser($app);
        $this->resetDb();

        // Perform a request while simulating the CloudFlare proxy.
        $request = Request::create('/bolt/login', 'GET', array(), array(), array(), array(
            'HTTP_CF_CONNECTING_IP' => '123.123.123.123',
            'REMOTE_ADDR' => '103.21.244.2',
        ));

        // Handle the request which should trigger the extension.
        $response = $app->handle($request);

        // Check if IP was changed by the extensions.
        $this->assertSame($response->getStatusCode(), 200);
        $this->assertSame('123.123.123.123', $request->getClientIp());
    }
}
