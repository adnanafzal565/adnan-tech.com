<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class SubDomainController extends Controller
{
    public function home(string $sub_domain)
    {
        return $sub_domain;
    }
}
