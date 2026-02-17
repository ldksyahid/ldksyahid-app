<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Jumbotron;
use App\Models\Article;
use App\Models\Testimony;
use App\Models\Gallery;
use App\Models\News;
use App\Models\Event;
use App\Models\MsKTALDKSyahid;
use App\Models\Schedule;
use Illuminate\Support\Facades\Auth;
use RealRashid\SweetAlert\Facades\Alert;
use Jenssegers\Agent\Agent;
use App\Models\User;
use AshAllenDesign\ShortURL\Models\ShortURL;
use Illuminate\Support\Facades\Http;

class HomeController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth')->except('index');
    }

    public function index()
    {
        $agent = new Agent();

        if ($agent->isMobile()) {
            $postnews= News::orderBy('datepublish','desc')->limit(5)->get();
            $postarticle= Article::orderBy('dateevent','desc')->limit(4)->get();
            $postevent= Event::orderBy('start','desc')->limit(4)->get();
        } else {
            $postnews= News::orderBy('datepublish','desc')->limit(4)->get();
            $postarticle= Article::orderBy('dateevent','desc')->limit(3)->get();
            $postevent= Event::orderBy('start','desc')->limit(4)->get();
        }

        $postgallery= Gallery::orderBy('created_at','desc')->limit(1)->get();
        $postnews= News::orderBy('datepublish','desc')->limit(4)->get();
        $postschedule= Schedule::orderBy('created_at','desc')->limit(1)->get();
        $postjumbotron= Jumbotron::orderBy('created_at','desc')->get();
        $posttestimony = Testimony::getAPITestimony()->orderBy('created_at','desc')->get();
        return view('landing-page.home.index', compact('postjumbotron', 'postarticle', 'posttestimony', 'postgallery', 'postnews', 'postevent', 'postschedule'), ['title' => "Beranda"]);
    }

    public function adminHome()
    {
        return redirect()->route('admin.dashboard');
    }
}
