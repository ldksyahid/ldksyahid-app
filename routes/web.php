<?php

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\JumbotronController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\VisitorAnalyticsController;
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
use App\Http\Controllers\CatalogBooksController;
use App\Http\Controllers\ITSupportController;
use App\Http\Controllers\TestimonyController;
use App\Http\Controllers\CelenganSyahidController;
use App\Http\Controllers\FinanceReportController;
use App\Http\Controllers\MsKTALDKSyahidController;
use App\Http\Controllers\ReportController;
use App\Http\Controllers\ShortLinkController;
use App\Http\Controllers\SubscriptionController;
use App\Http\Controllers\GenerateEmailController;
use App\Http\Controllers\SettingController;

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

// Strict throttle for login: max 5 attempts per minute
Route::middleware('throttle:5,1')->group(function () {
    Route::post('/login', [\App\Http\Controllers\Auth\LoginController::class, 'login'])->name('login');
    Route::post('/password/email', [\App\Http\Controllers\Auth\ForgotPasswordController::class, 'sendResetLinkEmail'])->name('password.email');
});

// Throttle for register: max 5 accounts per 10 minutes
Route::middleware('throttle:5,10')->group(function () {
    Route::post('/register', [\App\Http\Controllers\Auth\RegisterController::class, 'register'])->name('register');
});

// Route Template
Route::get('/welcome', function () {
    return view('welcome');
});

// ======================================= START ROUTE LANDING PAGE =======================================
// Route LandingPage Home
Route::get('/', [HomeController::class, 'index'])->name('home');

// Route LandingPage MyProfile
Route::get('/profile', [ProfileController::class, 'indexprofilecheck'])->name('profile.indexcheck')->middleware('auth');
Route::get('/profile/{id}/edit', [ProfileController::class, 'edit'])->name('profile.edit')->middleware('auth');
Route::put('/profile/{id}/update', [ProfileController::class, 'update'])->name('profile.update')->middleware('auth');
Route::get('/profile/{id}/create', [ProfileController::class, 'create'])->name('profile.create')->middleware('auth');
Route::post('/profile/{id}/store', [ProfileController::class, 'store'])->name('profile.store')->middleware('auth');
Route::put('/profile/{profilepicture}/destroy', [ProfileController::class, 'destroy'])->name('profile.destroy.profilepicture')->middleware('auth');

// Route LandingPage Layanan => Hitung Proker Kestari
Route::get('/kalkulatorkestari', function () {
    return view('landing-page.service.proker-counter.index', ["title" => "Layanan"]);
});

// Route LandingPage Layanan => Kalkulator Zakat
Route::get('/service/zakat-calculator', function () {
    return view('landing-page.service.zakat-calculator.index', ["title" => "Kalkulator Zakat"]);
})->name('zakat-calculator');

// Route LandingPage Layanan
Route::get('/service', function () {
    return view('landing-page.service.index', ["title" => "Layanan"]);
});

// Route LandingPage Artikel
Route::get('/articles', [ArticleController::class, 'index'])->name('article.index');
Route::get('/articles/{article}', [ArticleController::class, 'show'])->name('article.show');

// Route LandingPage Event
Route::get('/events', [EventController::class, 'index'])->name('event.index');
Route::get('/events/{event}', [EventController::class, 'show'])->name('event.show');

//Route LandingPage Schedule
Route::get('/schedule', [ScheduleController::class, 'index'])->name('schedule.index');

// Route LandingPage Tentang Kami
Route::get('/about/contact', function () {
    return view('landing-page.about.contact-us.index', ["title" => "Tentang Kami"]);
})->name('aboutus');

//Route LandingPage Structure
Route::get('/about/structure', [StructureController::class, 'index'])->name('structure.index');

//Route LandingPage Gallery
Route::get('/about/gallery', [GalleryController::class, 'index'])->name('gallery.index');

//Route LandingPage IT Support
Route::get('/itsupport', [ITSupportController::class, 'index'])->name('itsupport.index');

// Route Landing Page Contact Us
// Throttle for contact form: max 5 messages per 10 minutes
Route::middleware('throttle:5,10')->group(function () {
    Route::post('/about/contact/message/store', [MessageContactController::class, 'store'])->name('messagecontact');
});

// Route Newsletter Subscription
// Throttle for newsletter: max 5 subscriptions per 10 minutes
Route::middleware('throttle:5,10')->group(function () {
    Route::post('/subscribers/store', [SubscriptionController::class, 'store'])->name('newsletter.store');
    Route::post('/subscribers/unsubscribe', [SubscriptionController::class, 'unsubscribe'])->name('subscribers.unsubscribe');
});
Route::get('/unsubscribe', [SubscriptionController::class, 'unsubscribePage'])->name('unsubscribe.page');

// Route Article Comment
Route::post('/articlecomment', [ArticleCommentController::class, 'addarticlecomment'])->name('articlecomment')->middleware('auth');
Route::delete('/articlecomment/{id}/destroy', [ArticleCommentController::class, 'destroy'])->name('articlecomment.destroy')->middleware('auth');

// Route LandingPage News
Route::get('/news', [NewsController::class, 'index'])->name('news.index');
Route::get('/news/{news}', [NewsController::class, 'show'])->name('news.show');

// Route Article Comment
Route::post('/newscomment', [NewsCommentController::class, 'addnewscomment'])->name('newscomment')->middleware('auth');
Route::delete('/newscomment/{id}/destroy', [NewsCommentController::class, 'destroy'])->name('newscomment.destroy')->middleware('auth');

// Route Landing Page  Request Service Shortlink
Route::get('/shortlink', [RequestShortlinkController::class, 'create'])->name('service.shortlink.create');
Route::post('/shortlink/store', [RequestShortlinkController::class, 'store'])->name('service.shortlink.strore');

// Route LandingPage Layanan Call Kestari
Route::get('/callkestari', [CallKestariController::class, 'index'])->name('service.callkestari');

// Route KTA LDK Syahid
Route::get('/kta/{link}', [MsKTALDKSyahidController::class, 'show'])->name('kta.show');

// Route LandingPage Layanan CelenganLDKSyahid
Route::get('/celengansyahid', [CelenganSyahidController::class, 'indexLanding'])->name('service.celengansyahid');
Route::get('/celengansyahid/{link}', [CelenganSyahidController::class, 'showLanding'])->name('service.celengansyahid.detail');
Route::get('/celengansyahid/yuk-donasi/{link}', [CelenganSyahidController::class, 'donateNow'])->name('service.celengansyahid.detail.donatenow');
Route::get('/celengansyahid/yuk-donasi/{link}/status/{id}', [CelenganSyahidController::class, 'donationStatus'])->name('service.celengansyahid.detail.donateNow.status');
Route::get('/celengansyahid/payment/{id}', [CelenganSyahidController::class, 'openPaymentGateway'])->name('service.celengansyahid.detail.donateNow.gateway');
Route::get('/celengansyahid/simpan-bukti/{link}/{id}', [CelenganSyahidController::class, 'savePaymentDonation'])->name('service.celengansyahid.savePayment');

// API: max 60 req/min per IP (Select2 + polling)
Route::middleware('throttle:60,1')->group(function () {
    Route::get('/celengansyahid/api/jobs', [CelenganSyahidController::class, 'getJobs'])->name('service.celengansyahid.api.jobs');
    Route::get('/celengansyahid/api/check-payment/{id}', [CelenganSyahidController::class, 'checkPaymentStatus'])->name('service.celengansyahid.api.checkPayment');
});

// Donation store: max 10 submissions/minute per IP
Route::middleware('throttle:10,1')->post('/celengansyahid/donation/store', [CelenganSyahidController::class, 'storeDonationCampaign'])->name('service.store.donation.campaign');

// Xendit webhook: max 120 callbacks/minute (Xendit retries are frequent)
Route::middleware('throttle:120,1')->post('/celengansyahid/donation/callback', [CelenganSyahidController::class, 'callbackDonation'])->name('service.callback.donation.campaign');

// Route LandingPage Catalog Books
Route::get('/perpustakaan', [CatalogBooksController::class, 'index'])->name('catalog.books.index');
Route::get('/perpustakaan/buku/{slug}', [CatalogBooksController::class, 'show'])->name('catalog.books.show');
Route::post('/perpustakaan/buku/{id}/like', [CatalogBooksController::class, 'likeBook'])->name('catalog.books.like');
Route::get('/perpustakaan/buku/{slug}/baca', [CatalogBooksController::class, 'pdfReader'])->name('catalog.books.reader');

// Route LandingPage Report
Route::get('/laporan', [ReportController::class, 'index'])->name('report.index');
Route::get('/laporan-keuangan', [ReportController::class, 'financeReport'])->name('report.finance.index');

// Route LandingPage EKSPRESI
Route::get('/ekspresi', function () {
    return view('landing-page.ekspresi.index');
});
// ======================================= END ROUTE LANDING PAGE =======================================






// ======================================= START ROUTE ADMIN PAGE =======================================
// Route AdminPage First Dashboard
Route::get('/admin', [HomeController::class, 'adminHome'])->name('admin')->middleware(['role:Superadmin|HelperAdmin|HelperCelsyahid|HelperEventMart|HelperSPAM|HelperMedia|HelperLetter']);

// Route AdminPage Dashboard
Route::get('/admin/dashboard', [DashboardController::class, 'index'])->name('admin.dashboard')->middleware(['role:Superadmin|HelperAdmin|HelperCelsyahid|HelperEventMart|HelperSPAM|HelperMedia|HelperLetter']);

// Proxy: Motivational Quotes (avoids CORS from quotes.liupurnomo.com)
Route::get('/admin/api/motivasi-quotes', function () {
    try {
        $response = \Illuminate\Support\Facades\Http::timeout(8)
            ->get('https://quotes.liupurnomo.com/api/quotes/random');
        if ($response->successful()) {
            return response()->json($response->json());
        }
        return response()->json(['error' => true, 'message' => 'Upstream error'], 502);
    } catch (\Exception $e) {
        return response()->json(['error' => true, 'message' => 'Request failed'], 500);
    }
})->name('admin.api.motivasi-quotes')->middleware(['auth']);

// Route AdminPage Visitor Analytics
Route::get('/admin/api/visitor-stats', [VisitorAnalyticsController::class, 'apiStats'])->name('admin.api.visitor-stats')->middleware(['auth']);
Route::get('/admin/api/visitor-top-pages', [VisitorAnalyticsController::class, 'topPagesAjax'])->name('admin.api.visitor-top-pages')->middleware(['auth']);

// Route AdminPage User
Route::get('/admin/user', [UserController::class, 'indexAdmin'])->name('admin.user.index')->middleware(['role:Superadmin']);
Route::get('/admin/user/create', [UserController::class, 'create'])->name('admin.user.create')->middleware(['role:Superadmin']);
Route::post('/admin/user/store', [UserController::class, 'store'])->name('admin.user.store')->middleware(['role:Superadmin']);
Route::get('/admin/user/{id}/edit', [UserController::class, 'edit'])->name('admin.user.edit')->middleware(['role:Superadmin']);
Route::put('/admin/user/{id}/update', [UserController::class, 'update'])->name('admin.user.update')->middleware(['role:Superadmin']);
Route::delete('/admin/user/{id}', [UserController::class, 'destroy'])->name('admin.user.destroy')->middleware(['role:Superadmin']);
Route::post('/admin/user/bulk-delete', [UserController::class, 'bulkDelete'])->name('admin.user.bulk-delete')->middleware(['role:Superadmin']);
Route::get('/admin/user/{id}/preview', [UserController::class, 'showAdmin'])->name('admin.user.preview')->middleware(['role:Superadmin']);

// Route AdminPage AboutUs in Contact Message
Route::get('/admin/about/contact/message', [MessageContactController::class, 'indexAdmin'])->name('admin.about.contact.index')->middleware(['role:Superadmin|HelperMedia|HelperSPAM']);
Route::delete('/admin/about/contact/message/{id}', [MessageContactController::class, 'destroy'])->name('admin.about.contact.destroy')->middleware(['role:Superadmin|HelperMedia|HelperSPAM']);
Route::post('/admin/about/contact/message/bulk-delete', [MessageContactController::class, 'bulkDelete'])->name('admin.about.contact.bulk-delete')->middleware(['role:Superadmin']);
Route::get('/admin/about/contact/message/{id}/preview', [MessageContactController::class, 'showAdmin'])->name('admin.about.contact.show')->middleware(['role:Superadmin|HelperMedia|HelperSPAM']);

// Route AdminPage Home Jumbotron
Route::get('/admin/jumbotron', [JumbotronController::class, 'indexAdmin'])->name('admin.jumbotron.index')->middleware(['role:Superadmin|HelperAdmin|HelperCelsyahid|HelperEventMart|HelperSPAM|HelperMedia']);
Route::get('/admin/jumbotron/create', [JumbotronController::class, 'create'])->name('admin.jumbotron.create')->middleware(['role:Superadmin|HelperAdmin|HelperCelsyahid|HelperEventMart|HelperSPAM|HelperMedia']);
Route::post('/admin/jumbotron/store', [JumbotronController::class, 'store'])->name('admin.jumbotron.store')->middleware(['role:Superadmin|HelperAdmin|HelperCelsyahid|HelperEventMart|HelperSPAM|HelperMedia']);
Route::get('/admin/jumbotron/{id}/edit', [JumbotronController::class, 'edit'])->name('admin.jumbotron.edit')->middleware(['role:Superadmin|HelperAdmin|HelperCelsyahid|HelperEventMart|HelperSPAM|HelperMedia']);
Route::put('/admin/jumbotron/{id}/update', [JumbotronController::class, 'update'])->name('admin.jumbotron.update')->middleware(['role:Superadmin|HelperAdmin|HelperCelsyahid|HelperEventMart|HelperSPAM|HelperMedia']);
Route::delete('/admin/jumbotron/{id}', [JumbotronController::class, 'destroy'])->name('admin.jumbotron.destroy')->middleware(['role:Superadmin|HelperAdmin|HelperCelsyahid|HelperEventMart|HelperSPAM|HelperMedia']);
Route::post('/admin/jumbotron/bulk-delete', [JumbotronController::class, 'bulkDelete'])->name('admin.jumbotron.bulk-delete')->middleware(['role:Superadmin']);
Route::get('/admin/jumbotron/{id}/preview', [JumbotronController::class, 'showAdmin'])->name('admin.jumbotron.preview')->middleware(['role:Superadmin|HelperAdmin|HelperCelsyahid|HelperEventMart|HelperSPAM|HelperMedia']);

// Route AdminPage Home Testimony
Route::get('/admin/testimony', [TestimonyController::class, 'indexAdmin'])->name('admin.testimony.index')->middleware(['role:Superadmin|HelperAdmin|HelperSPAM|HelperMedia']);
Route::get('/admin/testimony/create', [TestimonyController::class, 'create'])->name('admin.testimony.create')->middleware(['role:Superadmin|HelperAdmin|HelperSPAM|HelperMedia']);
Route::post('/admin/testimony/store', [TestimonyController::class, 'store'])->name('admin.testimony.store')->middleware(['role:Superadmin|HelperAdmin|HelperSPAM|HelperMedia']);
Route::get('/admin/testimony/{id}/edit', [TestimonyController::class, 'edit'])->name('admin.testimony.edit')->middleware(['role:Superadmin|HelperAdmin|HelperSPAM|HelperMedia']);
Route::put('/admin/testimony/{id}/update', [TestimonyController::class, 'update'])->name('admin.testimony.update')->middleware(['role:Superadmin|HelperAdmin|HelperSPAM|HelperMedia']);
Route::delete('/admin/testimony/{id}', [TestimonyController::class, 'destroy'])->name('admin.testimony.destroy')->middleware(['role:Superadmin|HelperAdmin|HelperSPAM|HelperMedia']);
Route::post('/admin/testimony/bulk-delete', [TestimonyController::class, 'bulkDelete'])->name('admin.testimony.bulk-delete')->middleware(['role:Superadmin']);
Route::get('/admin/testimony/{id}/preview', [TestimonyController::class, 'showAdmin'])->name('admin.testimony.preview')->middleware(['role:Superadmin|HelperAdmin|HelperSPAM|HelperMedia']);

// Route AdminPage Event
Route::get('/admin/event', [EventController::class, 'indexAdmin'])->name('admin.event.index')->middleware(['role:Superadmin|HelperAdmin|HelperSPAM|HelperMedia|HelperCelsyahid']);
Route::get('/admin/event/create', [EventController::class, 'create'])->name('admin.event.create')->middleware(['role:Superadmin|HelperAdmin|HelperSPAM|HelperMedia|HelperCelsyahid']);
Route::post('/admin/event/store', [EventController::class, 'store'])->name('admin.event.store')->middleware(['role:Superadmin|HelperAdmin|HelperSPAM|HelperMedia|HelperCelsyahid']);
Route::get('/admin/event/{id}/edit', [EventController::class, 'edit'])->name('admin.event.edit')->middleware(['role:Superadmin|HelperAdmin|HelperSPAM|HelperMedia|HelperCelsyahid']);
Route::put('/admin/event/{id}/update', [EventController::class, 'update'])->name('admin.event.update')->middleware(['role:Superadmin|HelperAdmin|HelperSPAM|HelperMedia|HelperCelsyahid']);
Route::delete('/admin/event/{id}', [EventController::class, 'destroy'])->name('admin.event.destroy')->middleware(['role:Superadmin|HelperAdmin|HelperSPAM|HelperMedia|HelperCelsyahid']);
Route::post('/admin/event/bulk-delete', [EventController::class, 'bulkDelete'])->name('admin.event.bulk-delete')->middleware(['role:Superadmin']);
Route::get('/admin/event/{id}/preview', [EventController::class, 'showAdmin'])->name('admin.event.preview')->middleware(['role:Superadmin|HelperAdmin|HelperSPAM|HelperMedia|HelperCelsyahid']);


// Route AdminPage Article
Route::get('/admin/article', [ArticleController::class, 'indexAdmin'])->name('admin.article.index')->middleware(['role:Superadmin|HelperCelsyahid|HelperMedia']);
Route::get('/admin/article/create', [ArticleController::class, 'create'])->name('admin.article.create')->middleware(['role:Superadmin|HelperCelsyahid|HelperMedia']);
Route::post('/admin/article/store', [ArticleController::class, 'store'])->name('admin.article.store')->middleware(['role:Superadmin|HelperCelsyahid|HelperMedia']);
Route::get('/admin/article/{id}/edit', [ArticleController::class, 'edit'])->name('admin.article.edit')->middleware(['role:Superadmin|HelperCelsyahid|HelperMedia']);
Route::put('/admin/article/{id}/update', [ArticleController::class, 'update'])->name('admin.article.update')->middleware(['role:Superadmin|HelperCelsyahid|HelperMedia']);
Route::delete('/admin/article/{id}', [ArticleController::class, 'destroy'])->name('admin.article.destroy')->middleware(['role:Superadmin|HelperCelsyahid|HelperMedia']);
Route::post('/admin/article/bulk-delete', [ArticleController::class, 'bulkDelete'])->name('admin.article.bulk-delete')->middleware(['role:Superadmin']);
Route::get('/admin/article/{id}/preview', [ArticleController::class, 'showAdmin'])->name('admin.article.preview')->middleware(['role:Superadmin|HelperCelsyahid|HelperMedia']);

// Route AdminPage Subscription
Route::middleware(['role:Superadmin'])
    ->prefix('/admin/subscription')
    ->name('admin.subscription.')
    ->group(function () {
        Route::get('/', [SubscriptionController::class, 'indexAdmin'])->name('index');
        Route::get('/create', [SubscriptionController::class, 'create'])->name('create');
        Route::post('/store', [SubscriptionController::class, 'adminStore'])->name('store');
        Route::get('/{id}', [SubscriptionController::class, 'showAdmin'])->name('show');
        Route::get('/{id}/edit', [SubscriptionController::class, 'edit'])->name('edit');
        Route::put('/{id}/update', [SubscriptionController::class, 'update'])->name('update');
        Route::delete('/{id}', [SubscriptionController::class, 'destroy'])->name('destroy');
        Route::post('/bulk-delete', [SubscriptionController::class, 'bulkDelete'])->name('bulk-delete');
    });

// Route AdminPage Email Config - Generate Email
Route::middleware(['role:Superadmin'])
    ->prefix('/admin/email-config/generate')
    ->name('admin.email-config.generate.')
    ->group(function () {
        Route::get('/', [GenerateEmailController::class, 'index'])->name('index');   // → admin.email-config.generate.index
        Route::post('/send', [GenerateEmailController::class, 'send'])->name('send'); // → admin.email-config.generate.send
    });

// Route AdminPage News
Route::get('/admin/news', [NewsController::class, 'indexAdmin'])->name('admin.news.index')->middleware(['role:Superadmin|HelperCelsyahid|HelperMedia']);
Route::get('/admin/news/create', [NewsController::class, 'create'])->name('admin.news.create')->middleware(['role:Superadmin|HelperCelsyahid|HelperMedia']);
Route::post('/admin/news/store', [NewsController::class, 'store'])->name('admin.news.store')->middleware(['role:Superadmin|HelperCelsyahid|HelperMedia']);
Route::get('/admin/news/{id}/edit', [NewsController::class, 'edit'])->name('admin.news.edit')->middleware(['role:Superadmin|HelperCelsyahid|HelperMedia']);
Route::put('/admin/news/{id}/update', [NewsController::class, 'update'])->name('admin.news.update')->middleware(['role:Superadmin|HelperCelsyahid|HelperMedia']);
Route::delete('/admin/news/{id}', [NewsController::class, 'destroy'])->name('admin.news.destroy')->middleware(['role:Superadmin|HelperCelsyahid|HelperMedia']);
Route::post('/admin/news/bulk-delete', [NewsController::class, 'bulkDelete'])->name('admin.news.bulk-delete')->middleware(['role:Superadmin']);
Route::get('/admin/news/{id}/preview', [NewsController::class, 'showAdmin'])->name('admin.news.preview')->middleware(['role:Superadmin|HelperCelsyahid|HelperMedia']);

// Route AdminPage Schedule
Route::get('/admin/schedule', [ScheduleController::class, 'indexAdmin'])->name('admin.schedule.index')->middleware(['role:Superadmin|HelperSPAM|HelperMedia']);
Route::get('/admin/schedule/create', [ScheduleController::class, 'create'])->name('admin.schedule.create')->middleware(['role:Superadmin|HelperSPAM|HelperMedia']);
Route::post('/admin/schedule/store', [ScheduleController::class, 'store'])->name('admin.schedule.store')->middleware(['role:Superadmin|HelperSPAM|HelperMedia']);
Route::get('/admin/schedule/{id}/edit', [ScheduleController::class, 'edit'])->name('admin.schedule.edit')->middleware(['role:Superadmin|HelperSPAM|HelperMedia']);
Route::put('/admin/schedule/{id}/update', [ScheduleController::class, 'update'])->name('admin.schedule.update')->middleware(['role:Superadmin|HelperSPAM|HelperMedia']);
Route::delete('/admin/schedule/{id}', [ScheduleController::class, 'destroy'])->name('admin.schedule.destroy')->middleware(['role:Superadmin|HelperSPAM|HelperMedia']);
Route::post('/admin/schedule/bulk-delete', [ScheduleController::class, 'bulkDelete'])->name('admin.schedule.bulk-delete')->middleware(['role:Superadmin']);
Route::get('/admin/schedule/{id}/preview', [ScheduleController::class, 'showAdmin'])->name('admin.schedule.preview')->middleware(['role:Superadmin|HelperSPAM|HelperMedia']);

// Route AdminPage Gallery
Route::get('/admin/about/gallery', [GalleryController::class, 'indexAdmin'])->name('admin.about.gallery.index')->middleware(['role:Superadmin|HelperMedia']);
Route::get('/admin/about/gallery/create', [GalleryController::class, 'create'])->name('admin.about.gallery.create')->middleware(['role:Superadmin|HelperMedia']);
Route::post('/admin/about/gallery/store', [GalleryController::class, 'store'])->name('admin.about.gallery.store')->middleware(['role:Superadmin|HelperMedia']);
Route::get('/admin/about/gallery/{id}/edit', [GalleryController::class, 'edit'])->name('admin.about.gallery.edit')->middleware(['role:Superadmin|HelperMedia']);
Route::put('/admin/about/gallery/{id}/update', [GalleryController::class, 'update'])->name('admin.about.gallery.update')->middleware(['role:Superadmin|HelperMedia']);
Route::delete('/admin/about/gallery/{id}', [GalleryController::class, 'destroy'])->name('admin.about.gallery.destroy')->middleware(['role:Superadmin|HelperMedia']);
Route::post('/admin/about/gallery/bulk-delete', [GalleryController::class, 'bulkDelete'])->name('admin.about.gallery.bulk-delete')->middleware(['role:Superadmin']);
Route::get('/admin/about/gallery/{id}/preview', [GalleryController::class, 'showAdmin'])->name('admin.gallery.preview')->middleware(['role:Superadmin|HelperMedia']);

// Route AdminPage Structure
// Route AdminPage Structure
Route::get('/admin/about/structure', [StructureController::class, 'indexAdmin'])->name('admin.about.structure.index')->middleware(['role:Superadmin|HelperMedia']);
Route::get('/admin/about/structure/create', [StructureController::class, 'create'])->name('admin.about.structure.create')->middleware(['role:Superadmin|HelperMedia']);
Route::post('/admin/about/structure/store', [StructureController::class, 'store'])->name('admin.about.structure.store')->middleware(['role:Superadmin|HelperMedia']);
Route::get('/admin/about/structure/{id}/edit', [StructureController::class, 'edit'])->name('admin.about.structure.edit')->middleware(['role:Superadmin|HelperMedia']);
Route::put('/admin/about/structure/{id}/update', [StructureController::class, 'update'])->name('admin.about.structure.update')->middleware(['role:Superadmin|HelperMedia']);
Route::delete('/admin/about/structure/{id}', [StructureController::class, 'destroy'])->name('admin.about.structure.destroy')->middleware(['role:Superadmin|HelperMedia']);
Route::post('/admin/about/structure/bulk-delete', [StructureController::class, 'bulkDelete'])->name('admin.about.structure.bulk-delete')->middleware(['role:Superadmin']);
Route::get('/admin/about/structure/{id}/preview', [StructureController::class, 'showAdmin'])->name('admin.about.structure.preview')->middleware(['role:Superadmin|HelperMedia']);

// Route AdminPage Request Service Shortlink
Route::get('/admin/reqservice/shortlink', [RequestShortlinkController::class, 'indexAdmin'])->name('admin.reqservice.shortlink.index')->middleware(['role:Superadmin|HelperMedia']);
Route::get('/admin/reqservice/shortlink/{id}/edit', [RequestShortlinkController::class, 'edit'])->name('admin.reqservice.shortlink.edit')->middleware(['role:Superadmin|HelperMedia']);
Route::put('/admin/reqservice/shortlink/{id}/update', [RequestShortlinkController::class, 'update'])->name('admin.reqservice.shortlink.update')->middleware(['role:Superadmin|HelperMedia']);
Route::delete('/admin/reqservice/shortlink/{id}', [RequestShortlinkController::class, 'destroy'])->name('admin.reqservice.shortlink.destroy')->middleware(['role:Superadmin|HelperMedia']);
Route::post('/admin/reqservice/shortlink/bulk-delete', [RequestShortlinkController::class, 'bulkDelete'])->name('admin.reqservice.shortlink.bulk-delete')->middleware(['role:Superadmin']);
Route::get('/admin/reqservice/shortlink/{id}/preview', [RequestShortlinkController::class, 'showAdmin'])->name('admin.reqservice.shortlink.show')->middleware(['role:Superadmin|HelperMedia']);

// Route AdminPage Service Call Kestari
Route::middleware(['role:Superadmin|HelperLetter|HelperMedia'])
    ->prefix('/admin/service/callkestari')
    ->name('admin.service.callkestari.')
    ->group(function () {
        Route::get('/', [CallKestariController::class, 'indexAdmin'])->name('index');
        Route::get('/create', [CallKestariController::class, 'create'])->name('create');
        Route::post('/', [CallKestariController::class, 'store'])->name('store');
        Route::get('/{callKestari}', [CallKestariController::class, 'showAdmin'])->name('show');
        Route::get('/{callKestari}/edit', [CallKestariController::class, 'edit'])->name('edit');
        Route::put('/{callKestari}', [CallKestariController::class, 'update'])->name('update');
        Route::delete('/{callKestari}', [CallKestariController::class, 'destroy'])->name('destroy');
        Route::post('/bulk-delete', [CallKestariController::class, 'bulkDelete'])->name('bulk-delete');
    });

// Route AdminPage IT Support
Route::get('/admin/about/itsupport', [ITSupportController::class, 'indexAdmin'])->name('admin.about.itsupport.index')->middleware(['role:Superadmin']);
Route::get('/admin/about/itsupport/create', [ITSupportController::class, 'create'])->name('admin.about.itsupport.create')->middleware(['role:Superadmin']);
Route::post('/admin/about/itsupport/store', [ITSupportController::class, 'store'])->name('admin.about.itsupport.store')->middleware(['role:Superadmin']);
Route::get('/admin/about/itsupport/{id}/edit', [ITSupportController::class, 'edit'])->name('admin.about.itsupport.edit')->middleware(['role:Superadmin']);
Route::put('/admin/about/itsupport/{id}/update', [ITSupportController::class, 'update'])->name('admin.about.itsupport.update')->middleware(['role:Superadmin']);
Route::delete('/admin/about/itsupport/{id}', [ITSupportController::class, 'destroy'])->name('admin.about.itsupport.destroy')->middleware(['role:Superadmin']);
Route::post('/admin/about/itsupport/bulk-delete', [ITSupportController::class, 'bulkDelete'])->name('admin.about.itsupport.bulk-delete')->middleware(['role:Superadmin']);
Route::get('/admin/about/itsupport/{id}/preview', [ITSupportController::class, 'showAdmin'])->name('admin.about.itsupport.preview')->middleware(['role:Superadmin']);

// Route AdminPage Service Campaign
Route::get('/admin/service/celengansyahid/dashboard', [CelenganSyahidController::class, 'dashboardCelenganSyahid'])->name('admin.service.index.campaign')->middleware(['role:Superadmin|HelperCelsyahid']);
Route::get('/admin/service/celengansyahid/campaigns', [CelenganSyahidController::class, 'indexAdminCampaign'])->name('admin.service.index.celsyahid.dashboard')->middleware(['role:Superadmin|HelperCelsyahid']);
Route::get('/admin/service/celengansyahid/campaign/create', [CelenganSyahidController::class, 'createAdminCampaign'])->name('admin.service.create.campaign')->middleware(['role:Superadmin|HelperCelsyahid']);
Route::post('/admin/service/celengansyahid/campaign/store', [CelenganSyahidController::class, 'storeAdminCampaign'])->name('admin.service.store.campaign')->middleware(['role:Superadmin|HelperCelsyahid']);
Route::get('/admin/service/celengansyahid/campaign/{id}/edit', [CelenganSyahidController::class, 'editAdminCampaign'])->name('admin.service.edit.campaign')->middleware(['role:Superadmin|HelperCelsyahid']);
Route::put('/admin/service/celengansyahid/campaign/{id}/update', [CelenganSyahidController::class, 'updateAdminCampaign'])->name('admin.service.update.campaign')->middleware(['role:Superadmin|HelperCelsyahid']);
Route::get('/admin/service/celengansyahid/campaign/{id}/preview', [CelenganSyahidController::class, 'previewAdminCampaign'])->name('admin.service.preview.campaign')->middleware(['role:Superadmin|HelperCelsyahid']);
Route::delete('/admin/service/celengansyahid/campaign/{id}', [CelenganSyahidController::class, 'destroyAdminCampaign'])->name('admin.service.destroy.campaign')->middleware(['role:Superadmin|HelperCelsyahid']);
Route::post('/admin/service/celengansyahid/campaign/bulk-delete', [CelenganSyahidController::class, 'bulkDeleteCampaign'])->name('admin.service.campaign.bulk-delete')->middleware(['role:Superadmin']);
Route::post('/admin/service/celengansyahid/campaign/get-city', [CelenganSyahidController::class, 'storeCity'])->name('dependent-dropdown.store.city')->middleware(['role:Superadmin|HelperCelsyahid']);

// Route AdminPage Service Campaign -> donation
Route::get('/admin/service/celengansyahid/donations', [CelenganSyahidController::class, 'indexAdminDonation'])->name('admin.service.index.donation')->middleware(['role:Superadmin|HelperCelsyahid']);
Route::delete('/admin/service/celengansyahid/donation/{id}', [CelenganSyahidController::class, 'destroyAdminDonation'])->name('admin.service.destroy.donation')->middleware(['role:Superadmin|HelperCelsyahid']);
Route::post('/admin/service/celengansyahid/donation/bulk-delete', [CelenganSyahidController::class, 'bulkDeleteDonation'])->name('admin.service.donation.bulk-delete')->middleware(['role:Superadmin']);

// Route AdminPage KTA LDK Syahid
Route::middleware(['role:Superadmin|HelperLetter'])->prefix('/admin/ktaldksyahid')->group(function () {
    Route::get('/', [MsKTALDKSyahidController::class, 'indexAdmin'])->name('admin.ktaldksyahid.index');
    Route::get('/create', [MsKTALDKSyahidController::class, 'create'])->name('admin.ktaldksyahid.create');
    Route::post('/get-major', [MsKTALDKSyahidController::class, 'getMajor'])->name('admin.ktaldksyahid.getMajor');
    Route::post('/store', [MsKTALDKSyahidController::class, 'store'])->name('admin.ktaldksyahid.store');
    Route::delete('/{id}', [MsKTALDKSyahidController::class, 'destroy'])->name('admin.ktaldksyahid.destroy');
    Route::post('/bulk-delete', [MsKTALDKSyahidController::class, 'bulkDelete'])->name('admin.ktaldksyahid.bulk-delete')->middleware(['role:Superadmin']);
    Route::get('/{id}/preview', [MsKTALDKSyahidController::class, 'preview'])->name('admin.ktaldksyahid.preview');
    Route::get('/{id}/edit', [MsKTALDKSyahidController::class, 'edit'])->name('admin.ktaldksyahid.edit');
    Route::put('/{id}/update', [MsKTALDKSyahidController::class, 'update'])->name('admin.ktaldksyahid.update');
});

// START Route AdminPage Service Shortlink
Route::prefix('admin/service/shortlink')->group(function () {
    Route::get('/', [ShortLinkController::class, 'index'])
        ->name('admin.service.shortlink.index')
        ->middleware(['role:Superadmin|HelperAdmin|HelperCelsyahid|HelperEventMart|HelperSPAM|HelperMedia|HelperLetter']);

    Route::post('/', [ShortLinkController::class, 'shorten'])
        ->name('admin.service.shortlink.shorten')
        ->middleware(['role:Superadmin|HelperAdmin|HelperCelsyahid|HelperEventMart|HelperSPAM|HelperMedia|HelperLetter']);

    Route::put('/{shortLink}', [ShortLinkController::class, 'update'])
        ->name('admin.service.shortlink.update')
        ->middleware(['role:Superadmin|HelperAdmin|HelperCelsyahid|HelperEventMart|HelperSPAM|HelperMedia|HelperLetter']);

    Route::delete('/{shortLink}', [ShortLinkController::class, 'destroy'])
        ->name('admin.service.shortlink.destroy')
        ->middleware(['role:Superadmin']);

    Route::post('/bulk-delete', [ShortLinkController::class, 'bulkDelete'])
        ->name('admin.service.shortlink.bulkDelete')
        ->middleware(['role:Superadmin']);
});

Route::get('/{shortURLKey}', [ShortLinkController::class, 'redirect']);;
// END Route AdminPage Service Shortlink

// Route AdminPage Catalog Books
Route::middleware(['role:Superadmin|HelperLetter|HelperMedia'])
    ->prefix('/admin/catalog/books')
    ->name('admin.catalog.books.')
    ->group(function () {
        Route::get('/', [CatalogBooksController::class, 'indexAdmin'])->name('indexAdmin');
        Route::get('/create', [CatalogBooksController::class, 'create'])->name('create');
        Route::post('/', [CatalogBooksController::class, 'store'])->name('store');
        Route::get('/{book}', [CatalogBooksController::class, 'showAdmin'])->name('show');
        Route::get('/{book}/edit', [CatalogBooksController::class, 'edit'])->name('edit');
        Route::put('/{book}', [CatalogBooksController::class, 'update'])->name('update');
        Route::delete('/{book}', [CatalogBooksController::class, 'destroy'])->name('destroy');
        Route::post('/bulk-delete', [CatalogBooksController::class, 'bulkDelete'])->name('bulkDelete');
    });

Route::middleware(['role:Superadmin|HelperAdmin|HelperCelsyahid|HelperEventMart|HelperSPAM|HelperMedia|HelperLetter'])
    ->prefix('/admin/finance-report')
    ->name('admin.finance-report.')
    ->group(function () {
        Route::get('/', [FinanceReportController::class, 'indexAdmin'])->name('index');
        Route::get('/create', [FinanceReportController::class, 'create'])->name('create');
        Route::post('/', [FinanceReportController::class, 'store'])->name('store');
        Route::get('/{financeReport}', [FinanceReportController::class, 'showAdmin'])->name('show');
        Route::get('/{financeReport}/edit', [FinanceReportController::class, 'edit'])->name('edit');
        Route::put('/{financeReport}', [FinanceReportController::class, 'update'])->name('update');
        Route::delete('/{financeReport}', [FinanceReportController::class, 'destroy'])->name('destroy');
        Route::post('/bulk-delete', [FinanceReportController::class, 'bulkDelete'])->name('bulk-delete');
    });

Route::middleware(['role:Superadmin'])
    ->prefix('/admin/setting')
    ->name('admin.setting.')
    ->group(function () {
        Route::get('/', [SettingController::class, 'index'])->name('index');
        Route::post('/update', [SettingController::class, 'update'])->name('update');
    });

// ======================================= END ROUTE ADMIN PAGE =======================================