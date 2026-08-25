<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class PublicController extends Controller
{
    public function home()
    {
        return view('public.home');
    }

    public function about()
    {
        return view('public.about');
    }

    public function gallery()
    {
        return view('public.gallery');
    }

    public function news()
    {
        return view('public.news');
    }

    public function contact()
    {
        return view('public.contact');
    }

    public function donation()
    {
        return view('public.donation');
    }
}