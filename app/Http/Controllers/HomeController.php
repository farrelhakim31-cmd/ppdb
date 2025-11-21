<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function index()
    {
        return view('home-minimal');
    }

    public function about()
    {
        return view('about');
    }

    public function courses()
    {
        return view('cources');
    }

    public function team()
    {
        return view('team');
    }

    public function testimonial()
    {
        return view('testimonial');
    }

    public function contact()
    {
        return view('contact');
    }
}
