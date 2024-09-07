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
use App\Http\Controllers\ITSupportController;
use App\Http\Controllers\TestimonyController;
use App\Http\Controllers\CelenganSyahidController;
use App\Http\Controllers\MsKTALDKSyahidController;
use App\Http\Controllers\ShortLinkController;

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

// Route LandingPage Layanan
Route::get('/service', function () {
    return view('landing-page.service.index', ["title" => "Layanan"]);
});

// Route LandingPage Artikel
Route::get('/articles', [ArticleController::class, 'index'])->name('article.index');
Route::get('/articles/{id}', [ArticleController::class, 'show'])->name('article.show');

// Route LandingPage Event
Route::get('/events', [EventController::class, 'index'])->name('event.index');
Route::get('/events/{id}', [EventController::class, 'show'])->name('event.show');

//Route LandingPage Schedule
Route::get('/schedule', [ScheduleController::class, 'index'])->name('schedule.index');

// Route LandingPage Tentang Kami
Route::get('/about/contact', function () {
    return view('landing-page.about.contact-us', ["title" => "Tentang Kami"]);
})->name('aboutus');

//Route LandingPage Structure
Route::get('/about/structure', [StructureController::class, 'index'])->name('structure.index');

//Route LandingPage Gallery
Route::get('/about/gallery', [GalleryController::class, 'index'])->name('gallery.index');

//Route LandingPage IT Support
Route::get('/itsupport', [ITSupportController::class, 'index'])->name('itsupport.index');

// Route Landing Page Contact Us Hubungi Kami di Tentang Kami
Route::post('/about/contact/message/store', [MessageContactController::class, 'store'])->name('messagecontact');

// Route Article Comment
Route::post('/articlecomment', [ArticleCommentController::class, 'addarticlecomment'])->name('articlecomment')->middleware('auth');
Route::delete('/articlecomment/{id}/destroy', [ArticleCommentController::class, 'destroy'])->name('articlecomment.destroy')->middleware('auth');

// Route LandingPage News
Route::get('/news', [NewsController::class, 'index'])->name('news.index');
Route::get('/news/{id}', [NewsController::class, 'show'])->name('news.show');

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

Route::post('/celengansyahid/donation/store', [CelenganSyahidController::class, 'storeDonationCampaign'])->name('service.store.donation.campaign');
Route::post('/celengansyahid/donation/callback', [CelenganSyahidController::class, 'callbackDonation'])->name('service.callback.donation.campaign');

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

// Route AdminPage User
Route::get('/admin/user', [UserController::class, 'index'])->name('admin.user.index')->middleware(['role:Superadmin']);
Route::get('/admin/user/read', [UserController::class, 'read'])->name('admin.user.read')->middleware(['role:Superadmin']);
Route::get('/admin/user/create', [UserController::class, 'create'])->name('admin.user.create')->middleware(['role:Superadmin']);
Route::get('/admin/user/store', [UserController::class, 'store'])->name('admin.user.store')->middleware(['role:Superadmin']);
Route::get('/admin/user/edit/{id}', [UserController::class, 'edit'])->name('admin.user.edit')->middleware(['role:Superadmin']);
Route::get('/admin/user/update/{id}', [UserController::class, 'update'])->name('admin.user.update')->middleware(['role:Superadmin']);
Route::get('/admin/user/destroy/{id}', [UserController::class, 'destroy'])->name('admin.user.destroy')->middleware(['role:Superadmin']);
Route::get('/admin/user/preview/{id}', [UserController::class, 'preview'])->name('admin.user.preview')->middleware(['role:Superadmin']);

// Route AdminPage AboutUs in Contact Message
Route::get('/admin/about/contact/message', [MessageContactController::class, 'index'])->name('admin.about.contact.index')->middleware(['role:Superadmin|HelperMedia|HelperSPAM']);
Route::get('/admin/about/contact/message/{id}/destroy', [MessageContactController::class, 'destroy'])->name('admin.about.contact.destroy')->middleware(['role:Superadmin|HelperMedia|HelperSPAM']);
Route::get('/admin/about/contact/message/{id}/preview', [MessageContactController::class, 'show'])->name('admin.about.contact.show')->middleware(['role:Superadmin|HelperMedia|HelperSPAM']);

// Route AdminPage Home Jumbotron
Route::get('/admin/jumbotron', [JumbotronController::class, 'index'])->name('admin.jumbotron.index')->middleware(['role:Superadmin|HelperAdmin|HelperCelsyahid|HelperEventMart|HelperSPAM|HelperMedia']);
Route::get('/admin/jumbotron/create', [JumbotronController::class, 'create'])->name('admin.jumbotron.create')->middleware(['role:Superadmin|HelperAdmin|HelperCelsyahid|HelperEventMart|HelperSPAM|HelperMedia']);
Route::post('/admin/jumbotron/store', [JumbotronController::class, 'store'])->name('admin.jumbotron.store')->middleware(['role:Superadmin|HelperAdmin|HelperCelsyahid|HelperEventMart|HelperSPAM|HelperMedia']);
Route::get('/admin/jumbotron/{id}/edit', [JumbotronController::class, 'edit'])->name('admin.jumbotron.edit')->middleware(['role:Superadmin|HelperAdmin|HelperCelsyahid|HelperEventMart|HelperSPAM|HelperMedia']);
Route::put('/admin/jumbotron/{id}/update', [JumbotronController::class, 'update'])->name('admin.jumbotron.update')->middleware(['role:Superadmin|HelperAdmin|HelperCelsyahid|HelperEventMart|HelperSPAM|HelperMedia']);
Route::get('/admin/jumbotron/{id}/destroy', [JumbotronController::class, 'destroy'])->name('admin.jumbotron.destroy')->middleware(['role:Superadmin|HelperAdmin|HelperCelsyahid|HelperEventMart|HelperSPAM|HelperMedia']);
Route::get('/admin/jumbotron/{id}/preview', [JumbotronController::class, 'show'])->name('admin.jumbotron.preview')->middleware(['role:Superadmin|HelperAdmin|HelperCelsyahid|HelperEventMart|HelperSPAM|HelperMedia']);

// Route AdminPage Home Testimony
Route::get('/admin/testimony', [TestimonyController::class, 'index'])->name('admin.testimony.index')->middleware(['role:Superadmin|HelperAdmin|HelperSPAM|HelperMedia']);
Route::get('/admin/testimony/create', [TestimonyController::class, 'create'])->name('admin.testimony.create')->middleware(['role:Superadmin|HelperAdmin|HelperSPAM|HelperMedia']);
Route::post('/admin/testimony/store', [TestimonyController::class, 'store'])->name('admin.testimony.store')->middleware(['role:Superadmin|HelperAdmin|HelperSPAM|HelperMedia']);
Route::get('/admin/testimony/{id}/edit', [TestimonyController::class, 'edit'])->name('admin.testimony.edit')->middleware(['role:Superadmin|HelperAdmin|HelperSPAM|HelperMedia']);
Route::put('/admin/testimony/{id}/update', [TestimonyController::class, 'update'])->name('admin.testimony.update')->middleware(['role:Superadmin|HelperAdmin|HelperSPAM|HelperMedia']);
Route::get('/admin/testimony/{id}/destroy', [TestimonyController::class, 'destroy'])->name('admin.testimony.destroy')->middleware(['role:Superadmin|HelperAdmin|HelperSPAM|HelperMedia']);
Route::get('/admin/testimony/{id}/preview', [TestimonyController::class, 'show'])->name('admin.testimony.preview')->middleware(['role:Superadmin|HelperAdmin|HelperSPAM|HelperMedia']);

// Route AdminPage Event
Route::get('/admin/event', [EventController::class, 'indexadmin'])->name('admin.event.index')->middleware(['role:Superadmin|HelperAdmin|HelperSPAM|HelperMedia|HelperCelsyahid']);
Route::get('/admin/event/create', [EventController::class, 'create'])->name('admin.event.create')->middleware(['role:Superadmin|HelperAdmin|HelperSPAM|HelperMedia|HelperCelsyahid']);
Route::post('/admin/event/store', [EventController::class, 'store'])->name('admin.event.store')->middleware(['role:Superadmin|HelperAdmin|HelperSPAM|HelperMedia|HelperCelsyahid']);
Route::get('/admin/event/{id}/edit', [EventController::class, 'edit'])->name('admin.event.edit')->middleware(['role:Superadmin|HelperAdmin|HelperSPAM|HelperMedia|HelperCelsyahid']);
Route::put('/admin/event/{id}/update', [EventController::class, 'update'])->name('admin.event.update')->middleware(['role:Superadmin|HelperAdmin|HelperSPAM|HelperMedia|HelperCelsyahid']);
Route::get('/admin/event/{id}/destroy', [EventController::class, 'destroy'])->name('admin.event.destroy')->middleware(['role:Superadmin|HelperAdmin|HelperSPAM|HelperMedia|HelperCelsyahid']);
Route::get('/admin/event/{id}/preview', [EventController::class, 'showInAdmin'])->name('admin.event.preview')->middleware(['role:Superadmin|HelperAdmin|HelperSPAM|HelperMedia|HelperCelsyahid']);


// Route AdminPage Article
Route::get('/admin/article', [ArticleController::class, 'indexadmin'])->name('admin.article.index')->middleware(['role:Superadmin|HelperCelsyahid|HelperMedia']);
Route::get('/admin/article/create', [ArticleController::class, 'create'])->name('admin.article.create')->middleware(['role:Superadmin|HelperCelsyahid|HelperMedia']);
Route::post('/admin/article/store', [ArticleController::class, 'store'])->name('admin.article.store')->middleware(['role:Superadmin|HelperCelsyahid|HelperMedia']);
Route::get('/admin/article/{id}/edit', [ArticleController::class, 'edit'])->name('admin.article.edit')->middleware(['role:Superadmin|HelperCelsyahid|HelperMedia']);
Route::put('/admin/article/{id}/update', [ArticleController::class, 'update'])->name('admin.article.update')->middleware(['role:Superadmin|HelperCelsyahid|HelperMedia']);
Route::get('/admin/article/{id}/destroy', [ArticleController::class, 'destroy'])->name('admin.article.destroy')->middleware(['role:Superadmin|HelperCelsyahid|HelperMedia']);
Route::get('/admin/article/{id}/preview', [ArticleController::class, 'showInAdmin'])->name('admin.article.preview')->middleware(['role:Superadmin|HelperCelsyahid|HelperMedia']);

// Route AdminPage News
Route::get('/admin/news', [NewsController::class, 'indexadmin'])->name('admin.news.index')->middleware(['role:Superadmin|HelperCelsyahid|HelperMedia']);
Route::get('/admin/news/create', [NewsController::class, 'create'])->name('admin.news.create')->middleware(['role:Superadmin|HelperCelsyahid|HelperMedia']);
Route::post('/admin/news/store', [NewsController::class, 'store'])->name('admin.news.store')->middleware(['role:Superadmin|HelperCelsyahid|HelperMedia']);
Route::get('/admin/news/{id}/edit', [NewsController::class, 'edit'])->name('admin.news.edit')->middleware(['role:Superadmin|HelperCelsyahid|HelperMedia']);
Route::put('/admin/news/{id}/update', [NewsController::class, 'update'])->name('admin.news.update')->middleware(['role:Superadmin|HelperCelsyahid|HelperMedia']);
Route::get('/admin/news/{id}/destroy', [NewsController::class, 'destroy'])->name('admin.news.destroy')->middleware(['role:Superadmin|HelperCelsyahid|HelperMedia']);
Route::get('/admin/news/{id}/preview', [NewsController::class, 'showInAdmin'])->name('admin.news.preview')->middleware(['role:Superadmin|HelperCelsyahid|HelperMedia']);

// Route AdminPage Schedule
Route::get('/admin/schedule', [ScheduleController::class, 'indexadmin'])->name('admin.schedule.index')->middleware(['role:Superadmin|HelperSPAM|HelperMedia']);
Route::get('/admin/schedule/create', [ScheduleController::class, 'create'])->name('admin.schedule.create')->middleware(['role:Superadmin|HelperSPAM|HelperMedia']);
Route::post('/admin/schedule/store', [ScheduleController::class, 'store'])->name('admin.schedule.store')->middleware(['role:Superadmin|HelperSPAM|HelperMedia']);
Route::get('/admin/schedule/{id}/edit', [ScheduleController::class, 'edit'])->name('admin.schedule.edit')->middleware(['role:Superadmin|HelperSPAM|HelperMedia']);
Route::put('/admin/schedule/{id}/update', [ScheduleController::class, 'update'])->name('admin.schedule.update')->middleware(['role:Superadmin|HelperSPAM|HelperMedia']);
Route::get('/admin/schedule/{id}/destroy', [ScheduleController::class, 'destroy'])->name('admin.schedule.destroy')->middleware(['role:Superadmin|HelperSPAM|HelperMedia']);
Route::get('/admin/schedule/{id}/preview', [ScheduleController::class, 'showInAdmin'])->name('admin.schedule.preview')->middleware(['role:Superadmin|HelperSPAM|HelperMedia']);

// Route AdminPage Gallery
Route::get('/admin/about/gallery', [GalleryController::class, 'indexadmin'])->name('admin.about.gallery.index')->middleware(['role:Superadmin|HelperMedia']);
Route::get('/admin/about/gallery/create', [GalleryController::class, 'create'])->name('admin.about.gallery.create')->middleware(['role:Superadmin|HelperMedia']);
Route::post('/admin/about/gallery/store', [GalleryController::class, 'store'])->name('admin.about.gallery.store')->middleware(['role:Superadmin|HelperMedia']);
Route::get('/admin/about/gallery/{id}/edit', [GalleryController::class, 'edit'])->name('admin.about.gallery.edit')->middleware(['role:Superadmin|HelperMedia']);
Route::put('/admin/about/gallery/{id}/update', [GalleryController::class, 'update'])->name('admin.about.gallery.update')->middleware(['role:Superadmin|HelperMedia']);
Route::get('/admin/about/gallery/{id}/destroy', [GalleryController::class, 'destroy'])->name('admin.about.gallery.destroy')->middleware(['role:Superadmin|HelperMedia']);
Route::get('/admin/about/gallery/{id}/preview', [GalleryController::class, 'showInAdmin'])->name('admin.gallery.preview')->middleware(['role:Superadmin|HelperMedia']);

// Route AdminPage Structure
Route::get('/admin/about/structure', [StructureController::class, 'indexadmin'])->name('admin.about.structure.index')->middleware(['role:Superadmin|HelperMedia']);
Route::get('/admin/about/structure/create', [StructureController::class, 'create'])->name('admin.about.structure.create')->middleware(['role:Superadmin|HelperMedia']);
Route::post('/admin/about/structure/store', [StructureController::class, 'store'])->name('admin.about.structure.store')->middleware(['role:Superadmin|HelperMedia']);
Route::get('/admin/about/structure/{id}/edit', [StructureController::class, 'edit'])->name('admin.about.structure.edit')->middleware(['role:Superadmin|HelperMedia']);
Route::put('/admin/about/structure/{id}/update', [StructureController::class, 'update'])->name('admin.about.structure.update')->middleware(['role:Superadmin|HelperMedia']);
Route::get('/admin/about/structure/{id}/destroy', [StructureController::class, 'destroy'])->name('admin.about.structure.destroy')->middleware(['role:Superadmin|HelperMedia']);
Route::get('/admin/about/structure/{id}/preview', [StructureController::class, 'showInAdmin'])->name('admin.about.structure.preview')->middleware(['role:Superadmin|HelperMedia']);

// Route AdminPage Request Service Shortlink
Route::get('/admin/reqservice/shortlink', [RequestShortlinkController::class, 'index'])->name('admin.reqservice.shortlink.index')->middleware(['role:Superadmin|HelperMedia']);
Route::get('/admin/reqservice/shortlink/read', [RequestShortlinkController::class, 'read'])->name('admin.reqservice.shortlink.read')->middleware(['role:Superadmin|HelperMedia']);
Route::get('/admin/reqservice/shortlink/{id}/destroy', [RequestShortlinkController::class, 'destroy'])->name('admin.reqservice.shortlink.destroy')->middleware(['role:Superadmin|HelperMedia']);
Route::get('/admin/reqservice/shortlink/{id}/preview', [RequestShortlinkController::class, 'show'])->name('admin.reqservice.shortlink.show')->middleware(['role:Superadmin|HelperMedia']);
Route::get('/admin/reqservice/shortlink/{id}/addcustomlink', [RequestShortlinkController::class, 'addFixCustomLinkEdit'])->name('admin.reqservice.shortlink.addFixCustomLinkEdit')->middleware(['role:Superadmin|HelperMedia']);
Route::get('/admin/reqservice/shortlink/{id}/addcustomlink/update', [RequestShortlinkController::class, 'addFixCustomLinkUpdate'])->name('admin.reqservice.shortlink.addFixCustomLinkUpdate')->middleware(['role:Superadmin|HelperMedia']);

// Route AdminPage Service Call Kestari
Route::get('/admin/service/callkestari', [CallKestariController::class, 'indexadmin'])->name('admin.service.callkestari.index')->middleware(['role:Superadmin|HelperLetter|HelperMedia']);
Route::get('/admin/service/callkestari/read', [CallKestariController::class, 'read'])->name('admin.service.callkestari.read')->middleware(['role:Superadmin|HelperLetter|HelperMedia']);
Route::get('/admin/service/callkestari/create', [CallKestariController::class, 'create'])->name('admin.service.callkestari.create')->middleware(['role:Superadmin|HelperLetter|HelperMedia']);
Route::get('/admin/service/callkestari/store', [CallKestariController::class, 'store'])->name('admin.service.callkestari.store')->middleware(['role:Superadmin|HelperLetter|HelperMedia']);
Route::get('/admin/service/callkestari/edit/{id}', [CallKestariController::class, 'edit'])->name('admin.service.callkestari.edit')->middleware(['role:Superadmin|HelperLetter|HelperMedia']);
Route::get('/admin/service/callkestari/update/{id}', [CallKestariController::class, 'update'])->name('admin.service.callkestari.update')->middleware(['role:Superadmin|HelperLetter|HelperMedia']);
Route::get('/admin/service/callkestari/destroy/{id}', [CallKestariController::class, 'destroy'])->name('admin.service.callkestari.destroy')->middleware(['role:Superadmin|HelperLetter|HelperMedia']);
Route::get('/admin/service/callkestari/preview/{id}', [CallKestariController::class, 'showInAdmin'])->name('admin.service.callkestari.preview')->middleware(['role:Superadmin|HelperLetter|HelperMedia']);

// Route AdminPage IT Support
Route::get('/admin/about/itsupport', [ITSupportController::class, 'indexadmin'])->name('admin.about.itsupport.index')->middleware(['role:Superadmin']);
Route::get('/admin/about/itsupport/create', [ITSupportController::class, 'create'])->name('admin.about.itsupport.create')->middleware(['role:Superadmin']);
Route::post('/admin/about/itsupport/store', [ITSupportController::class, 'store'])->name('admin.about.itsupport.store')->middleware(['role:Superadmin']);
Route::get('/admin/about/itsupport/{id}/edit', [ITSupportController::class, 'edit'])->name('admin.about.itsupport.edit')->middleware(['role:Superadmin']);
Route::put('/admin/about/itsupport/{id}/update', [ITSupportController::class, 'update'])->name('admin.about.itsupport.update')->middleware(['role:Superadmin']);
Route::get('/admin/about/itsupport/{id}/destroy', [ITSupportController::class, 'destroy'])->name('admin.about.itsupport.destroy')->middleware(['role:Superadmin']);
Route::get('/admin/about/itsupport/{id}/preview', [ITSupportController::class, 'showInAdmin'])->name('admin.about.itsupport.preview')->middleware(['role:Superadmin']);

// Route AdminPage Service Campaign
Route::get('/admin/service/celengansyahid/dashboard', [CelenganSyahidController::class, 'dashboardCelenganSyahid'])->name('admin.service.index.campaign')->middleware(['role:Superadmin|HelperCelsyahid']);
Route::get('/admin/service/celengansyahid/campaigns', [CelenganSyahidController::class, 'indexAdminCampaign'])->name('admin.service.index.celsyahid.dashboard')->middleware(['role:Superadmin|HelperCelsyahid']);
Route::get('/admin/service/celengansyahid/campaign/create', [CelenganSyahidController::class, 'createAdminCampaign'])->name('admin.service.create.campaign')->middleware(['role:Superadmin|HelperCelsyahid']);
Route::post('/admin/service/celengansyahid/campaign/store', [CelenganSyahidController::class, 'storeAdminCampaign'])->name('admin.service.store.campaign')->middleware(['role:Superadmin|HelperCelsyahid']);
Route::get('/admin/service/celengansyahid/campaign/{id}/edit', [CelenganSyahidController::class, 'editAdminCampaign'])->name('admin.service.edit.campaign')->middleware(['role:Superadmin|HelperCelsyahid']);
Route::put('/admin/service/celengansyahid/campaign/{id}/update', [CelenganSyahidController::class, 'updateAdminCampaign'])->name('admin.service.update.campaign')->middleware(['role:Superadmin|HelperCelsyahid']);
Route::get('/admin/service/celengansyahid/campaign/{id}/preview', [CelenganSyahidController::class, 'previewAdminCampaign'])->name('admin.service.preview.campaign')->middleware(['role:Superadmin|HelperCelsyahid']);
Route::get('/admin/service/celengansyahid/campaign/{id}/destroy', [CelenganSyahidController::class, 'destroyAdminCampaign'])->name('admin.service.destroy.campaign')->middleware(['role:Superadmin|HelperCelsyahid']);
Route::post('/admin/service/celengansyahid/campaign/get-city', [CelenganSyahidController::class, 'storeCity'])->name('dependent-dropdown.store.city')->middleware(['role:Superadmin|HelperCelsyahid']);

// Route AdminPage Service Campaign -> donation
Route::get('/admin/service/celengansyahid/donations', [CelenganSyahidController::class, 'indexAdminDonation'])->name('admin.service.index.donation')->middleware(['role:Superadmin|HelperCelsyahid']);
Route::get('/admin/service/celengansyahid/donation/{id}/destroy', [CelenganSyahidController::class, 'destroyAdminDonation'])->name('admin.service.destroy.donation')->middleware(['role:Superadmin|HelperCelsyahid']);

// Route AdminPage KTA LDK Syahid
Route::middleware(['role:Superadmin|HelperLetter'])->prefix('/admin/ktaldksyahid')->group(function () {
    Route::get('/', [MsKTALDKSyahidController::class, 'indexAdmin'])->name('admin.ktaldksyahid.index');
    Route::get('/create', [MsKTALDKSyahidController::class, 'create'])->name('admin.ktaldksyahid.create');
    Route::post('/get-major', [MsKTALDKSyahidController::class, 'getMajor'])->name('admin.ktaldksyahid.getMajor');
    Route::post('/store', [MsKTALDKSyahidController::class, 'store'])->name('admin.ktaldksyahid.store');
    Route::get('/{id}/destroy', [MsKTALDKSyahidController::class, 'destroy'])->name('admin.ktaldksyahid.destroy');
    Route::get('/{id}/preview', [MsKTALDKSyahidController::class, 'preview'])->name('admin.ktaldksyahid.preview');
    Route::get('/{id}/edit', [MsKTALDKSyahidController::class, 'edit'])->name('admin.ktaldksyahid.edit');
    Route::put('/{id}/update', [MsKTALDKSyahidController::class, 'update'])->name('admin.ktaldksyahid.update');
});

// START Route AdminPage Service Shortlink
Route::get('/admin/service/shortlink', [ShortLinkController::class, 'index'])
    ->name('admin.service.shortlink.index')
    ->middleware(['role:Superadmin|HelperAdmin|HelperCelsyahid|HelperEventMart|HelperSPAM|HelperMedia|HelperLetter']);

Route::post('/', [ShortLinkController::class, 'shorten'])
    ->name('admin.service.shortlink.shorten')
    ->middleware(['role:Superadmin|HelperAdmin|HelperCelsyahid|HelperEventMart|HelperSPAM|HelperMedia|HelperLetter']);

Route::post('{id}', [ShortLinkController::class, 'update'])
    ->name('admin.service.shortlink.update')
    ->middleware(['role:Superadmin|HelperAdmin|HelperCelsyahid|HelperEventMart|HelperSPAM|HelperMedia|HelperLetter']);

Route::get('{id}/destroy', [ShortLinkController::class, 'destroy'])
    ->name('admin.service.shortlink.destroy')
    ->middleware(['role:Superadmin']);

Route::post('/admin/service/shortlink/bulk-delete', [ShortLinkController::class, 'bulkDelete'])
    ->name('admin.service.shortlink.bulkDelete')
    ->middleware(['role:Superadmin']);

Route::get('/{shortURLKey}', [ShortLinkController::class, 'redirect']);
// END Route AdminPage Service Shortlink

// ======================================= END ROUTE ADMIN PAGE =======================================
