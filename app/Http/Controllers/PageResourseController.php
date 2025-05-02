<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\PageMain;

class PageResourseController extends Controller
{
    public function main()
    {
        return PageMain::find(1);
    }
}
