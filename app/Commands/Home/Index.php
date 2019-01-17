<?php

namespace App\Commands\Home;

use Jetea\Framework\Routing\Controller;

class Index extends Controller
{
    public function index()
    {
        return 'console: hello world.' . "\n";
    }
}
