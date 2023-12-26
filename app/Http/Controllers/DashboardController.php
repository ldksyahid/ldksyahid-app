<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\News;
use App\Models\Article;
use App\Models\Event;

class DashboardController extends Controller
{
    public function index()
    {
        $userCount = User::count();
        $newsCount = News::count();
        $articleCount = Article::count();
        $eventCount = Event::count();

        return view('admin-page.dashboard.index', [
            'title' => 'Dashboard',
            'userCount' => $userCount,
            'newsCount' => $newsCount,
            'articleCount' => $articleCount,
            'eventCount' => $eventCount,
        ]);

    }
}
