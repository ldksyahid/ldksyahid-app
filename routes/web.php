<?php

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\JumbotronController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ArticleController;
use App\Http\Controllers\EventController;
use App\Http\Controllers\ScheduleController;
use App\Http\Controllers\ArticleCommentController;
use App\Http\Controllers\NewsController;
use App\Http\Controllers\NewsCommentController;
use App\Http\Controllers\MessageContactController;
use App\Http\Controllers\RequestShortlinkController;
use App\Http\Controllers\GalleryController;
use App\Http\Controllers\StructureController;
use App\Http\Controllers\CallKestariController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/
Auth::routes(['verify' => true]);

// Route Template
Route::get('/welcome', function () {
    return view('welcome');
});

// Route Basic
Route::get('/', [HomeController::class, 'index'])->name('home');
Route::get('/home', [HomeController::class, 'index'])->name('home')->middleware('verified');
Route::get('/admin', [HomeController::class, 'adminHome'])->name('admin')->middleware('is_admin');


// Route AdminPage Dashboard
Route::get('/admin/dashboard', [DashboardController::class, 'index'])->name('admin.dashboard')->middleware('is_admin');

// Route AdminPage User
Route::get('/admin/user', [UserController::class, 'index'])->name('admin.user.index')->middleware('is_admin');
Route::get('admin/user/read', [UserController::class, 'read'])->name('admin.user.read')->middleware('is_admin');
Route::get('/admin/user/create', [UserController::class, 'create'])->name('admin.user.create')->middleware('is_admin');
Route::get('/admin/user/store', [UserController::class, 'store'])->name('admin.user.store')->middleware('is_admin');
Route::get('/admin/user/edit/{id}', [UserController::class, 'edit'])->name('admin.user.edit')->middleware('is_admin');
Route::get('/admin/user/update/{id}', [UserController::class, 'update'])->name('admin.user.update')->middleware('is_admin');
Route::get('/admin/user/destroy/{id}', [UserController::class, 'destroy'])->name('admin.user.destroy')->middleware('is_admin');
Route::get('/admin/user/preview/{id}', [UserController::class, 'preview'])->name('admin.user.preview')->middleware('is_admin');

// Route AdminPage AboutUs in Contact Message
Route::get('/admin/about/contact/message', [MessageContactController::class, 'index'])->name('admin.about.contact.index')->middleware('is_admin');
Route::get('/admin/about/contact/message/{id}/destroy', [MessageContactController::class, 'destroy'])->name('admin.about.contact.destroy')->middleware('is_admin');
Route::get('/admin/about/contact/message/{id}/preview', [MessageContactController::class, 'show'])->name('admin.about.contact.show')->middleware('is_admin');

// Route AdminPage Home Jumbotron
Route::get('/admin/jumbotron', [JumbotronController::class, 'index'])->name('admin.jumbotron.index')->middleware('is_admin');
Route::get('/admin/jumbotron/create', [JumbotronController::class, 'create'])->name('admin.jumbotron.create')->middleware('is_admin');
Route::post('/admin/jumbotron/store', [JumbotronController::class, 'store'])->name('admin.jumbotron.store')->middleware('is_admin');
Route::get('/admin/jumbotron/{id}/edit', [JumbotronController::class, 'edit'])->name('admin.jumbotron.edit')->middleware('is_admin');
Route::put('/admin/jumbotron/{id}/update', [JumbotronController::class, 'update'])->name('admin.jumbotron.update')->middleware('is_admin');
Route::get('/admin/jumbotron/{id}/destroy', [JumbotronController::class, 'destroy'])->name('admin.jumbotron.destroy')->middleware('is_admin');
Route::get('/admin/jumbotron/{id}/preview', [JumbotronController::class, 'show'])->name('admin.jumbotron.preview')->middleware('is_admin');

// Route AdminPage Event
Route::get('/admin/event', [EventController::class, 'indexadmin'])->name('admin.event.index')->middleware('is_admin');
Route::get('/admin/event/create', [EventController::class, 'create'])->name('admin.event.create')->middleware('is_admin');
Route::post('/admin/event/store', [EventController::class, 'store'])->name('admin.event.store')->middleware('is_admin');
Route::get('/admin/event/{id}/edit', [EventController::class, 'edit'])->name('admin.event.edit')->middleware('is_admin');
Route::put('/admin/event/{id}/update', [EventController::class, 'update'])->name('admin.event.update')->middleware('is_admin');
Route::get('/admin/event/{id}/destroy', [EventController::class, 'destroy'])->name('admin.event.destroy')->middleware('is_admin');


// Route AdminPage Article
Route::get('/admin/article', [ArticleController::class, 'indexadmin'])->name('admin.article.index')->middleware('is_admin');
Route::get('/admin/article/create', [ArticleController::class, 'create'])->name('admin.article.create')->middleware('is_admin');
Route::post('/admin/article/store', [ArticleController::class, 'store'])->name('admin.article.store')->middleware('is_admin');
Route::get('/admin/article/{id}/edit', [ArticleController::class, 'edit'])->name('admin.article.edit')->middleware('is_admin');
Route::put('/admin/article/{id}/update', [ArticleController::class, 'update'])->name('admin.article.update')->middleware('is_admin');
Route::get('/admin/article/{id}/destroy', [ArticleController::class, 'destroy'])->name('admin.article.destroy')->middleware('is_admin');

// Route AdminPage News
Route::get('/admin/news', [NewsController::class, 'indexadmin'])->name('admin.news.index')->middleware('is_admin');
Route::get('/admin/news/create', [NewsController::class, 'create'])->name('admin.news.create')->middleware('is_admin');
Route::post('/admin/news/store', [NewsController::class, 'store'])->name('admin.news.store')->middleware('is_admin');
Route::get('/admin/news/{id}/edit', [NewsController::class, 'edit'])->name('admin.news.edit')->middleware('is_admin');
Route::put('/admin/news/{id}/update', [NewsController::class, 'update'])->name('admin.news.update')->middleware('is_admin');
Route::get('/admin/news/{id}/destroy', [NewsController::class, 'destroy'])->name('admin.news.destroy')->middleware('is_admin');

// Route AdminPage Schedule
Route::get('/admin/schedule', [ScheduleController::class, 'indexadmin'])->name('admin.schedule.index')->middleware('is_admin');
Route::get('/admin/schedule/create', [ScheduleController::class, 'create'])->name('admin.schedule.create')->middleware('is_admin');
Route::post('/admin/schedule/store', [ScheduleController::class, 'store'])->name('admin.schedule.store')->middleware('is_admin');
Route::get('/admin/schedule/{id}/edit', [ScheduleController::class, 'edit'])->name('admin.schedule.edit')->middleware('is_admin');
Route::put('/admin/schedule/{id}/update', [ScheduleController::class, 'update'])->name('admin.schedule.update')->middleware('is_admin');
Route::get('/admin/schedule/{id}/destroy', [ScheduleController::class, 'destroy'])->name('admin.schedule.destroy')->middleware('is_admin');

// Route LandingPage MyProfile
Route::get('/profile', [ProfileController::class, 'indexprofilecheck'])->name('profile.indexcheck')->middleware('auth');
Route::get('/profile/{id}/edit', [ProfileController::class, 'edit'])->name('profile.edit')->middleware('auth');
Route::put('/profile/{id}/update', [ProfileController::class, 'update'])->name('profile.update')->middleware('auth');
Route::get('/profile/{id}/create', [ProfileController::class, 'create'])->name('profile.create')->middleware('auth');
Route::post('/profile/{id}/store', [ProfileController::class, 'store'])->name('profile.store')->middleware('auth');

// Route AdminPage Gallery
Route::get('/admin/about/gallery', [GalleryController::class, 'indexadmin'])->name('admin.about.gallery.index')->middleware('is_admin');
Route::get('/admin/about/gallery/create', [GalleryController::class, 'create'])->name('admin.about.gallery.create')->middleware('is_admin');
Route::post('/admin/about/gallery/store', [GalleryController::class, 'store'])->name('admin.about.gallery.store')->middleware('is_admin');
Route::get('/admin/about/gallery/{id}/edit', [GalleryController::class, 'edit'])->name('admin.about.gallery.edit')->middleware('is_admin');
Route::put('/admin/about/gallery/{id}/update', [GalleryController::class, 'update'])->name('admin.about.gallery.update')->middleware('is_admin');
Route::get('/admin/about/gallery/{id}/destroy', [GalleryController::class, 'destroy'])->name('admin.about.gallery.destroy')->middleware('is_admin');

// Route AdminPage Structure
Route::get('/admin/about/structure', [StructureController::class, 'indexadmin'])->name('admin.about.structure.index')->middleware('is_admin');
Route::get('/admin/about/structure/create', [StructureController::class, 'create'])->name('admin.about.structure.create')->middleware('is_admin');
Route::post('/admin/about/structure/store', [StructureController::class, 'store'])->name('admin.about.structure.store')->middleware('is_admin');
Route::get('/admin/about/structure/{id}/edit', [StructureController::class, 'edit'])->name('admin.about.structure.edit')->middleware('is_admin');
Route::put('/admin/about/structure/{id}/update', [StructureController::class, 'update'])->name('admin.about.structure.update')->middleware('is_admin');
Route::get('/admin/about/structure/{id}/destroy', [StructureController::class, 'destroy'])->name('admin.about.structure.destroy')->middleware('is_admin');

// Route LandingPage Layanan => Hitung Proker Kestari
Route::get('/service/hitungproker', function () {
    return view('LandingPageView.LandingPageViewLayanan.LandingPageViewLayananHitungProker.KestariHitungPersentaseProgramKerja', ["title" => "Layanan"]);
});

// Route LandingPage Artikel
Route::get('/article', [ArticleController::class, 'index'])->name('article.index');
Route::get('/article/{id}/show', [ArticleController::class, 'show'])->name('article.show');

// Route LandingPage Event
Route::get('/event', [EventController::class, 'index'])->name('event.index');
Route::get('/event/{id}/show', [EventController::class, 'show'])->name('event.show');

//Route LandingPage Schedule
Route::get('/schedule', [ScheduleController::class, 'index'])->name('schedule.index');

// Route LandingPage Tentang Kami
Route::get('/about/contact', function () {
    return view('LandingPageView.LandingPageViewTentang.landingpageviewtentanghubungikami', ["title" => "Tentang Kami"]);
})->name('aboutus');

//Route LandingPage Structure
Route::get('/about/structure', [StructureController::class, 'index'])->name('structure.index');

//Route LandingPage Gallery
Route::get('/about/gallery', [GalleryController::class, 'index'])->name('gallery.index');

// Route Landing Page Contact Us Hubungi Kami di Tentang Kami
Route::post('/about/contact/message/store', [MessageContactController::class, 'store'])->name('messagecontact');

// Route Article Comment
Route::post('/articlecomment', [ArticleCommentController::class, 'addarticlecomment'])->name('articlecomment')->middleware('auth');

// Route LandingPage News
Route::get('/news', [NewsController::class, 'index'])->name('news.index');
Route::get('/news/{id}/show', [NewsController::class, 'show'])->name('news.show');

// Route Article Comment
Route::post('/newscomment', [NewsCommentController::class, 'addnewscomment'])->name('newscomment')->middleware('auth');


// Route AdminPage Request Service Shortlink
Route::get('/admin/reqservice/shortlink', [RequestShortlinkController::class, 'index'])->name('admin.reqservice.shortlink.index')->middleware('is_admin');
Route::get('/admin/reqservice/shortlink/read', [RequestShortlinkController::class, 'read'])->name('admin.reqservice.shortlink.read')->middleware('is_admin');
Route::get('/admin/reqservice/shortlink/{id}/destroy', [RequestShortlinkController::class, 'destroy'])->name('admin.reqservice.shortlink.destroy')->middleware('is_admin');
Route::get('/admin/reqservice/shortlink/{id}/preview', [RequestShortlinkController::class, 'show'])->name('admin.reqservice.shortlink.show')->middleware('is_admin');
Route::get('/admin/reqservice/shortlink/{id}/addcustomlink', [RequestShortlinkController::class, 'addFixCustomLinkEdit'])->name('admin.reqservice.shortlink.addFixCustomLinkEdit')->middleware('is_admin');
Route::get('/admin/reqservice/shortlink/{id}/addcustomlink/update', [RequestShortlinkController::class, 'addFixCustomLinkUpdate'])->name('admin.reqservice.shortlink.addFixCustomLinkUpdate')->middleware('is_admin');

// Route Landing Page  Request Service Shortlink
Route::get('/service/shortlink', [RequestShortlinkController::class, 'create'])->name('service.shortlink.create');
Route::post('/service/shortlink/store', [RequestShortlinkController::class, 'store'])->name('service.shortlink.strore');


// Route AdminPage Service Call Kestari
Route::get('/admin/service/callkestari', [CallKestariController::class, 'indexadmin'])->name('admin.service.callkestari.index')->middleware('is_admin');
Route::get('/admin/service/callkestari/read', [CallKestariController::class, 'read'])->name('admin.service.callkestari.read')->middleware('is_admin');
Route::get('/admin/service/callkestari/create', [CallKestariController::class, 'create'])->name('admin.service.callkestari.create')->middleware('is_admin');
Route::get('/admin/service/callkestari/store', [CallKestariController::class, 'store'])->name('admin.service.callkestari.store')->middleware('is_admin');
Route::get('/admin/service/callkestari/edit/{id}', [CallKestariController::class, 'edit'])->name('admin.service.callkestari.edit')->middleware('is_admin');
Route::get('/admin/service/callkestari/update/{id}', [CallKestariController::class, 'update'])->name('admin.service.callkestari.update')->middleware('is_admin');
Route::get('/admin/service/callkestari/destroy/{id}', [CallKestariController::class, 'destroy'])->name('admin.service.callkestari.destroy')->middleware('is_admin');
// Route LandingPage Layanan Call Kestari
Route::get('/service/callkestari', [CallKestariController::class, 'index'])->name('service.callkestari');

// START Route AdminPage Service Shortlink
Route::get('/admin/service/shortlink', function () {
    $urls = \AshAllenDesign\ShortURL\Models\ShortURL::latest()->get();
    return view('AdminPageView.AdminPageViewService.AdminPageViewServiceShortlink.adminPageviewserviceshortlink', compact('urls'), ["title" => "Services"]);
});

Route::post('/', function () {
    $builder = new \AshAllenDesign\ShortURL\Classes\Builder();

    $shortURLObject = $builder->destinationUrl(request()->url)->make();
    $shortURL = $shortURLObject->default_short_url;

    return back()->with('success','URL shortened successfully. ');

})->name('url.shorten');

Route::post('{id}', function ($id) {
    $url = \AshAllenDesign\ShortURL\Models\ShortURL::find($id);
    $url->url_key = request()->url;
    $url->destination_url = request()->destination;
    $url->default_short_url = config('app.url').'/'.request()->url;
    $url->save();

    return back()->with('success','URL updated successfully. ');
})->name('update');

Route::get('/{shortURLKey}', '\AshAllenDesign\ShortURL\Controllers\ShortURLController');
// END Route AdminPage Service Shortlink
