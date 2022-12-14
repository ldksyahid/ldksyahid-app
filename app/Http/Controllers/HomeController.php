<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Jumbotron;
use App\Models\Article;
use App\Models\Testimony;
use App\Models\Gallery;
use App\Models\News;
use App\Models\Event;
use App\Models\Schedule;
use Illuminate\Support\Facades\Auth;
use RealRashid\SweetAlert\Facades\Alert;


class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth')->except('index');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $postarticle= Article::orderBy('dateevent','desc')->limit(3)->get();
        $postgallery= Gallery::orderBy('created_at','desc')->limit(1)->get();
        $postevent= Event::orderBy('dateevent','desc')->limit(3)->get();
        $postnews= News::orderBy('datepublish','desc')->limit(3)->get();
        $postschedule= Schedule::orderBy('created_at','desc')->limit(1)->get();
        $postjumbotron= Jumbotron::orderBy('created_at','desc')->get();
        $posttestimony = Testimony::getAPITestimony()->orderBy('created_at','desc')->get();
        if (Auth::User() == !null) {
            if (Auth::User()->email_verified_at == null) {
                toast('Email Kamu Belum Terverifikasi Oleh Kami', 'warning')->autoClose(10000)->position('bottom-start')->timerProgressBar()->hideCloseButton();
            }
        }
        return view('LandingPageView.LandingPageViewHome.landingpageviewhome', compact('postjumbotron', 'postarticle', 'posttestimony', 'postgallery', 'postnews', 'postevent', 'postschedule'), ['title' => "Beranda"]);
    }

    public function adminHome()
    {
        Alert::success('Selamat Datang Admin LDK Syahid UIN Jakarta', 'Bismillah, Berikan yang Terbaik untuk Dakwah');
        return view('AdminPageView.AdminPageViewDashboard.adminpageviewdashboard', ["title" => "Dashboard"]);
    }
}
