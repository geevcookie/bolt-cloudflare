<?php

namespace Bolt\Extension\GeevCookie\BoltCloudFlare;

if (isset($app)) {
    $app['extensions']->register(new Extension($app));
}

