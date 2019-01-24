<?php

namespace App\Controllers\Home;

use App\Controllers\Controller;

class Index extends Controller
{
    public function index()
    {
//        echo count(get_included_files());
//        return ' hello Jetea';
        $name = 'Jetea';

        return $this->render(
            '/Home/index.html',
            compact('name')
        );
    }
}
