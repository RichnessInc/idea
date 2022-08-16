<?php

namespace App\Http\Controllers;

use App\Models\Client;
use App\Models\Country;
use App\Models\Government;
use App\Models\ProductRequests;
use App\Models\Receipt;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class Dashboard extends Controller
{
    public function index() {
        $last_three_month = Carbon::now()->startOfMonth()->subMonth(3);
        $last_six_month = Carbon::now()->startOfMonth()->subMonth(6);
        $this_month = Carbon::now()->startOfMonth();
        // Total Clients From Goverment And Type
        $CountriesWithClientsCount = Country::withCount('clients')
            ->where('soft_deleted', '=', 0)
            ->get();
        $GovernmentsWithClientsCount = Government::withCount('clients')->where('soft_deleted', '=', 0)->get();
        $payers = Client::where('type', '=', 0)
        ->where('soft_deleted', '=', 0)
        ->count();
        $providors = Client::where('type', '=', 1)
        ->where('soft_deleted', '=', 0)
        ->count();
        $createor = Client::where('type', '=', 2)
        ->where('soft_deleted', '=', 0)
        ->count();
        $sender = Client::where('type', '=', 3)
        ->where('soft_deleted', '=', 0)
        ->count();

        // Requests
        $thisMonthRequests          = ProductRequests::whereMonth('created_at', Carbon::now()->month)->where('soft_deleted', '=', 0)->count();
        $lastMonthRequests          = ProductRequests::whereMonth('created_at', '=', Carbon::now()->subMonth()->month)->where('soft_deleted', '=', 0)->count();
        $lastThreeMonthsRequests    = ProductRequests::whereBetween('created_at',[$last_three_month,$this_month])->where('soft_deleted', '=', 0)->count();
        $thisYearRequests           = ProductRequests::whereBetween('created_at', [
            Carbon::now()->startOfYear(),
            Carbon::now()->endOfYear(),
        ])->where('soft_deleted', '=', 0)->count();
        // Payment Usage
        $paypalCountUsage           = Receipt::where('paymentmethod_id', '=', 1)->count();
        $onReciveCountUsage         = Receipt::where('paymentmethod_id', '=', 2)->count();
        $paylinkCountUsage          = Receipt::where('paymentmethod_id', '=', 3)->count();
        // Profits
        $thisMonthReceipts          = Receipt::whereMonth('created_at', Carbon::now()->month)->sum('total_price');
        $lastMonthReceipts          = Receipt::whereMonth('created_at', '=', Carbon::now()->subMonth()->month)->sum('total_price');
        $lastThreeMonthsReceipts           = Receipt::whereBetween('created_at', [
            $last_three_month,
            $this_month
        ])->sum('total_price');
        $thisYearReceipts           = Receipt::whereBetween('created_at', [
            Carbon::now()->startOfYear(),
            Carbon::now()->endOfYear(),
        ])->sum('total_price');
        return view('dashboard', compact(
            'payers',
            'providors',
            'createor',
            'sender',
            'thisMonthRequests',
            'lastMonthRequests',
            'lastThreeMonthsRequests',
            'thisYearRequests',
            'thisMonthReceipts',
            'lastMonthReceipts',
            'lastThreeMonthsReceipts',
            'thisYearReceipts',
            'paypalCountUsage',
            'onReciveCountUsage',
            'CountriesWithClientsCount',
            'GovernmentsWithClientsCount',
            'paylinkCountUsage'
        ));
    }

    public function update_password(Request $request, $id) {
        $request->validate([
            'password'          => 'required|max:255|min:8',
            'repassword'        => 'required|max:255|min:8|same:password',
        ]);
        if ($request->password != null) {
            $password = ['password' => Hash::make($request->password)];
        } else {
            $password = [];
        }
        Client::findOrFail($id)->update($password);
        session()->flash('message', 'تم تغير كلمة المرور بنجاح');
        return redirect()->route('dashboard.clients');
    }
}
