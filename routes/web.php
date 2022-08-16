<?php

use App\Events\MessageSent;
use App\Events\MyEventNon;
use App\Http\Controllers\Dashboard;
use App\Http\Controllers\PaypalController;
use App\Http\Controllers\TestingController;
use App\Http\Controllers\SoundsController;
use App\Models\altaawusVip as ModelsAltaawusVip;
use App\Models\Client;
use App\Models\mainPage;
use App\Models\Page;
use App\Models\PaymentSetting;
use App\Models\ProductsCategory;
use App\Models\singleRoomMessage;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Mail;
use Illuminate\Foundation\Auth\EmailVerificationRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\File;

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

Route::get('/sitemap.xml', [\App\Http\Controllers\SitemapXmlController::class, 'index']);


Route::get('/reset-password-new/{token}', function ($token) {
    return view('frontend.reset-password',compact('token'));
})->name('reset_password.new');


Route::get('reset-password/{token}', [TestingController::class, 'reset_password'])->name('reset_password');
Route::get('testing', [TestingController::class, 'sendMessage']);
Route::get('urway-response', [\App\Http\Controllers\urwayController::class, 'urway_response']);
Route::get('urway-response-tow', [\App\Http\Controllers\urwayController::class, 'urway_response_tow']);
Route::get('paypal/redirect', [PaypalController::class, 'paypal_redirect'])->name('paypal-redirect');
Route::get('paypal/cancel', [PaypalController::class, 'paypal_cancel'])->name('paypal-cancel');

Route::get('paylink/redirect', [\App\Http\Controllers\Paylink::class, 'paylink_redirect'])->name('paylink-redirect');
Route::get('paylink/redirect-tow', [\App\Http\Controllers\Paylink::class, 'paylink_redirect_tow'])->name('paylink-redirect-tow');

Route::get('paylink/get-amount', [\App\Http\Controllers\Paylink::class, 'get_amount'])->name('get_amount');
Route::get('paylink/get-amount-tow', [\App\Http\Controllers\Paylink::class, 'get_amount_tow'])->name('get_amount_tow');


Route::get('tickets', function () {
    return view('frontend.ticket');
})->name('frontend.ticket')->middleware('clint-auth');


Route::post('logout',  [\App\Http\Controllers\logout::class, 'logout'])->middleware('clint-auth');


Route::get('/', function () {
    return view('frontend.home');
})->name('frontend.home');

Route::get('/receipts-for-user/{id}', function ($id) {
    $row = \App\Models\Receipt::with('client:id,name')->findOrFail($id);
    return view('frontend.single-receipt', compact('row'));
});
Route::get('/receipts-for-provider/{id}', function ($id) {
    $row = \App\Models\ProductRequests::with('payment_method','bill','buyer', 'provider', 'sender', 'product')->findOrFail($id);
    return view('frontend.single-receipt-provider', compact('row'));
});






Route::patch('/update-receipts-for-user/{id}', function (Request $request, $id) {
    $row = \App\Models\Receipt::with('client:id,name')->findOrFail($id);
    $row->update(['qr_code' => $request->qrcode]);
});
Route::patch('/update-receipts-for-provider/{id}', function (Request $request, $id) {
    $row = \App\Models\ProductRequests::with('payment_method','bill','buyer', 'provider', 'sender', 'product')->findOrFail($id);
    $row->update(['qr_code' => $request->qrcode]);
});


Route::get('login', function () {

    return view('frontend.login');

})->name('frontend.login')->middleware('client-unauth');


Route::get('register', function () {

    return view('frontend.register');

})->name('frontend.register')->middleware('client-unauth');

Route::get('verify-email/{token}', function ($token) {

    $clint = Client::where('verify_email_token', '=', $token)->first();

    if ($clint != null) {
        $clint->update([
            'email_verified_at'     => now(),
            'verify_email_token'    => null
        ]);
    }

    return redirect('/');

});

Route::get('profile', function () {
    $row = Client::findOrFail(Auth::guard('clients')->user()->id);
    return view('frontend.profile', compact('row'));

})->name('frontend.profile')->middleware('clint-auth');

Route::get('receipts', function () {
    $row = Client::findOrFail(Auth::guard('clients')->user()->id);
    return view('frontend.profile-collection', compact('row'));

})->name('frontend.receipts')->middleware('clint-auth');

Route::get('cards/{slug}', function ($slug) {
    $row = \App\Models\Card::with('video', 'background', 'sound')
    ->where('slug', '=', $slug)->firstOrFail();
    return view('frontend.cards.single', compact('row'));
})->name('frontend.cards.single');
// Start Cards
Route::prefix('my-cards')->group(function () {
    // Index
    Route::get('/', function () {
        $cards = \App\Models\Card::where('client_id', '=', Auth::guard('clients')->user()->id)->get();
        return view('frontend.cards.index', compact('cards'));
    })->name('frontend.cards.index')->middleware('clint-auth');
    // Create
    Route::get('/create', function () {
        $backgrounds = \App\Models\CardsBackground::get();
        $sounds = \App\Models\CardsSound::get();
        $videos = \App\Models\CardsVideo::get();
        $categories = \App\Models\VideosCategory::get();

        return view('frontend.cards.create', compact('videos','backgrounds', 'sounds', 'categories'));
    })->name('frontend.cards.create')->middleware('clint-auth');
    // Edit
    Route::get('/edit/{id}', function ($id) {
        $backgrounds = \App\Models\CardsBackground::get();
        $sounds = \App\Models\CardsSound::get();
        $videos = \App\Models\CardsVideo::get();
        $row = \App\Models\Card::where('id', '=', $id)
            ->where('client_id', '=', Auth::guard('clients')->user()->id)->firstOrFail();
        return view('frontend.cards.edit', compact('row', 'backgrounds', 'sounds', 'videos'));
    })->name('frontend.cards.edit')->middleware('clint-auth');

    /////////////////// Process /////////////////////////////////////////////
    Route::post('/create', [\App\Http\Controllers\FrontendCards::class, 'store'])->name('frontend.cards.process.create')->middleware('clint-auth');
    Route::post('/edit/{id}', [\App\Http\Controllers\FrontendCards::class, 'update'])->name('frontend.cards.process.edit')->middleware('clint-auth');
    Route::post('/delete/{id}', [\App\Http\Controllers\FrontendCards::class, 'destroy'])->name('frontend.cards.process.delete')->middleware('clint-auth');
});
// End Cards



Route::get('test-page', function () {

    return view('test-page');
})->name('test-page')->middleware('clint-auth', 'can-sell');


Route::get('products/create', function () {

    return view('frontend.product.create');
})->name('frontend.product.create')->middleware('clint-auth', 'can-sell');

Route::get('products/edit/{id}', function ($id) {
    $row = \App\Models\Product::findOrFail($id);
    return view('frontend.product.edit', compact('row'));
})->name('frontend.product.edit')->middleware('clint-auth', 'can-sell');


Route::patch('products/edit/{id}', [\App\Http\Controllers\Products::class, 'update'])->name('frontend.product.patch')->middleware('clint-auth', 'can-sell');






Route::get('products/create/extra/{id}', function ($id) {
    $proName = \App\Models\Product::findOrFail($id)->name;
    return view('frontend.product.create-extra', compact('proName', 'id'));
})->name('frontend.product.create-extra')->middleware('clint-auth', 'can-sell');

Route::get('products/edit/extra/{id}', function ($id) {
    $proName = \App\Models\productExtra::with('product:id,name')->findOrFail($id)->product->name;
    return view('frontend.product.edit-extra', compact('proName', 'id'));
})->name('frontend.product.edit-extra')->middleware('clint-auth', 'can-sell');














Route::get('notifications', function () {
    return view('frontend.notifications');
})->name('frontend.notifications');

Route::get('single-chat', function () {
    return view('frontend.single-chat');

})->name('frontend.single-chat')->middleware('clint-auth');

Route::get('group-chat/{id}', function ($id) {
    return view('frontend.group-chat', compact('id'));
})->name('frontend.group-chat')->middleware('clint-auth')->middleware('enter-to-group');



Route::get('download/file/{file}', function ($file) {

    if (File::exists('uploads/'.$file)) {
        return response()->download(public_path('uploads/'.$file));
    } else {
        return back();
    }
});




Route::get('lucky-boxes', function () {

    return view('frontend.gifts');

})->name('frontend.gifts');

Route::get('fun-feather', function () {

    return view('frontend.reesh');

})->name('frontend.reesh');

Route::get('cart', function () {

    return view('frontend.cart');

})->name('frontend.cart')->middleware('clint-auth');


Route::get('cart-collection', function () {

    return view('frontend.cart-collection');

})->name('frontend.cart-collection')->middleware('clint-auth');



Route::get('favourites', function () {

    return view('frontend.favourites');

})->name('frontend.favourites')->middleware('clint-auth');

Route::get('altaawus-vip', function () {

    return view('frontend.altaawus-vip');

})->name('frontend.altaawus-vip');


Route::get('products/{slug}', function ($slug) {
    return view('frontend.single-product', compact('slug'));
})->name('frontend.single-product');


Route::get('pages/{slug}', function ($slug) {
    $page = \App\Models\mainPage::where('slug', '=', $slug)->first();
    return view('frontend.pages', compact('page'));

})->name('frontend.pages');

Route::get('dashboard', [Dashboard::class, 'index'])->middleware(['auth:sanctum', 'verified'])->name('dashboard');


Route::get('collections/receipts-collection-for-user/{id}', function ($id) {
    $row = \App\Models\receiptCollection::with('client:id,name')->findOrFail($id);
    return view('frontend.single-receipt-collection', compact('row'));
});

Route::patch('collections/update-receipts-for-user/{id}', function (Request $request, $id) {
    $row = \App\Models\receiptCollection::with('client:id,name')->findOrFail($id);
    $row->update(['qr_code' => $request->qrcode]);
});
Route::prefix('control-panel')->middleware(['auth:sanctum', 'verified'])->group(function () {

    Route::prefix('collections')->middleware(['auth:sanctum', 'verified'])->group(function () {

        Route::get('bills', function () {
            return view('admin.bills-collection');
        })->name('admin.bills.collection');

        Route::get('payment-page-collection', function () {
            return view('admin.payment-page-collection');
        })->name('dashboard.payment-page-collection');

        Route::get('profit-page', function () {
            if (session()->has('go_to_profits')) {
                if (session()->get('go_to_profits')[0] == true) {
                    return view('admin.profet.collection');
                } else {
                    return redirect()->route('admin.profit.login');
                }
            } else {
                return redirect()->route('admin.profit.login');
            }
        })->name('admin.collection.profit.index');

        Route::get('product-requests', function () {

            return view('admin.product-requests-collections');

        })->name('admin.product-requests-collections');
    });



        Route::get('logs', [\Rap2hpoutre\LaravelLogViewer\LogViewerController::class, 'index']);


    Route::get('profit-login', function () {
        if (session()->has('go_to_profits')) {
            if(session()->get('go_to_profits')[0] != true) {
                return view('admin.profet.login');
            } else {
                return redirect()->route('admin.profit.index');
            }
        } else {
            return view('admin.profet.login');
        }


    })->name('admin.profit.login');

    Route::get('profit-page', function () {

        if (session()->has('go_to_profits')) {
            if (session()->get('go_to_profits')[0] == true) {
                return view('admin.profet.index');
            } else {
                return redirect()->route('admin.profit.login');
            }
        } else {
            return redirect()->route('admin.profit.login');
        }
    })->name('admin.profit.index');


    Route::get('product-requests', function () {

        return view('admin.product-requests');

    })->name('admin.product-requests');


    Route::get('backups', function () {

        return view('admin.backups');

    })->name('admin.backups');


    Route::post('backups/{file}', function ($file) {

        return response()->download( storage_path('app/Altaawus/'.$file) );

    })->name('admin.backups-download');



    Route::get('homepage-settings', function () {

        return view('admin.homepage-settings');

    })->name('admin.homepage-settings');


    Route::get('clients/{id}/products', function ($id) {
        $client = Client::select('id', 'name')->findOrFail($id);
        return view('admin.client-products', compact('client'));

    })->name('admin.client-products');


    Route::get('testimonials', function () {

        return view('admin.testimonials');

    })->name('admin.testimonials');

    Route::get('packages', function () {

        return view('admin.packages');

    })->name('admin.packages');


Route::get('package-buyers', function () {

    return view('admin.package-buyers');

})->name('admin.package-buyers');


    Route::get('ads', function () {

        return view('admin.ads');

    })->name('admin.ads');

    Route::get('main-pages/{slug}', function ($slug) {
        $row = mainPage::where('slug', '=', $slug)->first();
        return view('admin.main-pages', compact('row'));

    })->name('admin.main-pages');

    Route::post('main-pages/update/{slug}', [\App\Http\Controllers\Pages::class, 'update']);
    Route::post('altaawus-vip/update', [\App\Http\Controllers\Pages::class, 'altaawus_vip']);
    Route::post('resh-page/update', [\App\Http\Controllers\Pages::class, 'updateReeshPageData']);
    Route::post('gifts-page/update', [\App\Http\Controllers\Pages::class, 'updatGiftsPageData']);

    Route::get('altaawus-vip', function () {
        $row = ModelsAltaawusVip::findOrFail(1);
        return view('admin.altaawus-vip', compact('row'));
    })->name('admin.altaawus-vip');

    Route::get('resh-page', function () {
        $row = Page::where('slug','=', 'reesh')->first();
        return view('admin.pages.resh', compact('row'));
    })->name('admin.resh-page');

    Route::get('gifts-page', function () {
        $row = Page::where('slug','=', 'gifts')->first();
        return view('admin.pages.gifts', compact('row'));
    })->name('admin.gifts-page');


    Route::get('altaawus-vip-requests', function () {

        return view('admin.altaawus-vip-requests');

    })->name('admin.altaawus-vip-requests');



    Route::get('users', function () {
        return view('admin.users');
    })->name('dashboard.users');

    Route::get('countries', function () {
        return view('admin.countries');
    })->name('dashboard.countries');

    Route::get('general-info', function () {
        return view('admin.general-info');
    })->name('dashboard.general-info');

    Route::get('governments', function () {
        return view('admin.governments');
    })->name('dashboard.governments');

    Route::get('payment/settings', function () {
        $data = PaymentSetting::findOrFail(1);
        return view('admin.payment-settings', compact('data'));
    })->name('dashboard.payment.settings');

    Route::post('payment/settings/update', [\App\Http\Controllers\PaymentSettings::class, 'update']);


    Route::get('clients', function () {
        return view('admin.clients');
    })->name('dashboard.clients');


    Route::patch('clients-update-password/{id}', [Dashboard::class, 'update_password'])->name('dashboard.clients-update-password');

    Route::get('verify-clients', function () {
        return view('admin.verify-clients');
    })->name('dashboard.verify-clients');

    Route::get('clients/band', function () {
        return view('admin.band-clients');
    })->name('dashboard.band-clients');

    Route::get('shipping', function () {
        return view('admin.shipping');
    })->name('dashboard.shipping');


    Route::get('payment-methods', function () {
        return view('admin.payment-method');
    })->name('dashboard.payment-method');

    Route::get('notifications', function () {
        return view('admin.notifications');
    })->name('dashboard.notifications');


    Route::get('gifts', function () {
        return view('admin.giftsbox');
    })->name('dashboard.giftsbox');

    Route::get('reesh', function () {
        return view('admin.reesh');
    })->name('dashboard.reesh');

    Route::get('ticket-gifts', function () {
        return view('admin.ticket-gifts');
    })->name('dashboard.ticket-gifts');

    Route::get('payment-page', function () {
        return view('admin.payment-page');
    })->name('dashboard.payment-page');

    Route::get('payment-debt', function () {
        return view('admin.payment-debt');
    })->name('dashboard.payment-debt');

    Route::get('chats/single-chats', function () {
        return view('admin.chat.single.all');
    })->name('dashboard.admin.chat.single.all');

    Route::get('chats/single-chats/{id}', function ($id) {
        $client_name = Client::findOrFail($id)->name;
        return view('admin.chat.single.single', compact('client_name', 'id'));
    })->name('dashboard.admin.chat.single.single');


    Route::get('chats/group-chat', function () {
        return view('admin.chat.group.all');
    })->name('dashboard.admin.group.all');


    Route::get('chats/group-chat/{id}', function ($id) {
        return view('admin.chat.group.single', compact('id'));
    })->name('dashboard.admin.group.single');



    Route::get('points-commissions', function () {
        return view('admin.points-commissions');
    })->name('dashboard.points-commissions');

    Route::get('points-commissions/requests', function () {
        return view('admin.points-commissions-requests');
    })->name('dashboard.points-commissions-requests');


    Route::get('backgrounds', function () {
        return view('admin.cards.backgrounds');
    })->name('admin.cards.backgrounds');

    Route::resource('sounds', SoundsController::class)->except('index');

    Route::get('sounds', function () {
        $rows = \App\Models\CardsSound::get();
        return view('admin.cards.sounds', compact('rows'));
    })->name('admin.cards.sounds');

    Route::resource('videos', \App\Http\Controllers\CardVideos::class)->except('index');


    Route::get('videos', function () {
        $rows = \App\Models\CardsVideo::get();
        $categories = \App\Models\VideosCategory::get();
        return view('admin.cards.videos', compact('rows', 'categories'));
    })->name('admin.cards.videos');


    Route::get('categories', function () {
        return view('admin.categories');
    })->name('dashboard.categories');

    Route::get('file-manager', function () {
        return view('admin.file-manager');
    })->name('dashboard.file-manager');



    Route::get('cards', function () {
        return view('admin.cards.index');
    })->name('admin.cards.index');

    Route::get('bills', function () {
        return view('admin.bills');
    })->name('admin.bills');

});
