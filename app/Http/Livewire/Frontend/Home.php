<?php

namespace App\Http\Livewire\Frontend;

use App\Models\Ads;
use App\Models\Ads2;
use App\Models\Bill;
use App\Models\Client;
use App\Models\Country;
use App\Models\GiftTicket;
use App\Models\Government;
use App\Models\homepageSetting;
use App\Models\Product;
use App\Models\ProductsCategory;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Jantinnerezo\LivewireAlert\LivewireAlert;
use Livewire\Component;
use Livewire\WithPagination;

class Home extends Component
{
    use LivewireAlert;
    use WithPagination;
    public $homepageSettings;
    public $name;
    public $price;
    public $category_id;
    public $country_id;
    public $government_id;
    public $fire_search = false;
    public $governorates = null;
    public $store_id;

    public $value;
    public $password;
    public $repassword;


    public function __construct()
    {
        $this->homepageSettings = homepageSetting::first();
    }
    public function country_change() {
        $this->governorates = Government::where('country_id', '=', $this->country_id)->where('soft_deleted', '=', 0)->get();
    }
    public function get_upper_ads_slider() {
        $upperAds = Ads::findOrFail(1);
        return $upperAds;
    }

    public function get_down_ads_slider() {
        $upperAds = Ads2::findOrFail(1);
        return $upperAds;
    }
    public function get_top_sales_products() {

        if ($this->homepageSettings->slider_1 == 0) {
            $products = Product::withCount('requests')
                ->with('category:id,name', 'client:id,name')
                ->where('status', '>', 0)
                ->where('soft_deleted', '=', 0)
                // ->having('requests_count', '>', 0)
                ->orderBy('requests_count', 'ASC')
                ->limit(40)
                ->get();
            $allProductsArray = [];
            $loopq = 0;
            $arrayNumber = [];
            foreach ($products as $product) {
                $arrayNumber[] = [
                    'id' =>       $product->id,
                    'name' =>       $product->name,
                    'category'   => $product->category->name,
                    'price'         => $product->price,
                    'main_image'    => $product->main_image,
                    'store'     => $product->client->name,
                    'slug'     => $product->slug
                ];
                $loopq++;
                if ($loopq % 4 == 0) {
                    $allProductsArray[] = $arrayNumber;
                    $arrayNumber = [];
                }

            }
            return $allProductsArray;
        } else {
            $products = Product::withCount('requests')
                ->with('category:id,name', 'client:id,name')
                ->where('status', '>', 0)
                ->where('soft_deleted', '=', 0)
                ->orderBy('requests_count', 'ASC')
                ->limit(4)
                ->get();

            return $products;
        }

    }
    public function get_down_price_products()
    {

        if ($this->homepageSettings->slider_2 == 0) {
            $products = Product::with('category:id,name', 'client:id,name')
                ->select('id', 'name', 'category_id', 'price', 'main_image', 'client_id', 'aval_count', 'status', 'slug')
                ->where('status', '>', 0)
                ->where('soft_deleted', '=', 0)
                ->orderBy('price', 'ASC')
                ->limit(40)
                ->get();
            $allProductsArray = [];
            $loopq = 0;
            $arrayNumber = [];
            foreach ($products as $product) {
                $arrayNumber[] = [
                    'id' => $product->id,
                    'name' => $product->name,
                    'category' => $product->category->name,
                    'price' => $product->price,
                    'main_image' => $product->main_image,
                    'store' => $product->client->name,
                    'slug' => $product->slug

                ];
                $loopq++;
                if ($loopq % 4 == 0) {
                    $allProductsArray[] = $arrayNumber;
                    $arrayNumber = [];
                }

            }

            return $allProductsArray;
        } else {
            $products = Product::with('category:id,name', 'client:id,name')
                ->select('id', 'name', 'category_id', 'price', 'main_image', 'client_id', 'aval_count', 'status', 'slug')
                ->where('soft_deleted', '=', 0)
                ->where('status', '>', 0)
                ->orderBy('price', 'ASC')
                ->limit(4)
                ->get();
            return $products;
        }
    }

    public function get_top_price_products()
    {

        if ($this->homepageSettings->slider_3 == 0) {
            $products = Product::with('category:id,name', 'client:id,name')
                ->select('id', 'name', 'category_id', 'price', 'main_image', 'client_id', 'aval_count', 'status', 'slug')
                ->where('soft_deleted', '=', 0)
                ->where('status', '>', 0)
                ->orderBy('price', 'DESC')
                ->limit(40)
                ->get();
            $allProductsArray = [];
            $loopq = 0;
            $arrayNumber = [];
            foreach ($products as $product) {
                $arrayNumber[] = [
                    'id' => $product->id,
                    'name' => $product->name,
                    'category' => $product->category->name,
                    'price' => $product->price,
                    'main_image' => $product->main_image,
                    'store' => $product->client->name,
                    'slug' => $product->slug
                ];
                $loopq++;
                if ($loopq % 4 == 0) {
                    $allProductsArray[] = $arrayNumber;
                    $arrayNumber = [];
                }

            }
            return $allProductsArray;

        } else {
            $products = Product::with('category:id,name', 'client:id,name')
                ->select('id', 'name', 'category_id', 'price', 'main_image', 'client_id', 'aval_count', 'status', 'slug')
                ->where('soft_deleted', '=', 0)
                ->where('status', '>', 0)
                ->orderBy('price', 'DESC')
                ->limit(40)
                ->get();

            return $products;

        }
    }

    public function get_latest_products() {

        if ($this->homepageSettings->slider_4 == 0) {
            $products = Product::with('category:id,name', 'client:id,name')
                ->select('id', 'name', 'category_id', 'price', 'main_image', 'client_id', 'aval_count', 'status', 'slug')
                ->where('soft_deleted', '=', 0)
                ->where('status', '>', 0)
                ->orderBy('created_at', 'DESC')
                ->limit(40)
                ->get();
            $allProductsArray = [];
            $loopq = 0;
            $arrayNumber = [];
            foreach ($products as $product) {
                $arrayNumber[] = [
                    'id' => $product->id,
                    'name' => $product->name,
                    'category' => $product->category->name,
                    'price' => $product->price,
                    'main_image' => $product->main_image,
                    'store' => $product->client->name,
                    'slug' => $product->slug
                ];
                $loopq++;
                if ($loopq % 4 == 0) {
                    $allProductsArray[] = $arrayNumber;
                    $arrayNumber = [];
                }

            }

            return $allProductsArray;
        } else {
            $products = Product::with('category:id,name', 'client:id,name')
                ->select('id', 'name', 'category_id', 'price', 'main_image', 'client_id', 'aval_count', 'status', 'slug')
                ->where('soft_deleted', '=', 0)
                ->where('status', '>', 0)
                ->orderBy('created_at', 'DESC')
                ->limit(4)
                ->get();
            return $products;
        }
    }
    public function search_value() {
        if ($this->name != null || $this->category_id != null || $this->price != null || $this->country_id != null || $this->government_id != null ||  $this->store_id != null) {
            $products = Product::with('category:id,name', 'client:id,name')
                ->where('soft_deleted', '=', 0)
                ->where('status', '>', 0)
                ->select('id', 'name', 'category_id', 'price', 'main_image', 'client_id', 'aval_count', 'status', 'slug');
            if ($this->store_id != null) {
                $cid = $this->store_id;
                $products->whereHas('client', function ($query) use ($cid) {
                    return $query->where('id', '=', $cid);
                });
            }
            if ($this->country_id != null) {
                $products->whereHas('client', function ($query) {
                    return $query->where('country_id', '=', $this->country_id);
                });
            }
            if ($this->government_id != null) {
                $products->whereHas('client', function ($query) {
                    return $query->where('government_id', '=', $this->government_id);
                });
            }
            if ($this->name != null) {
                $name = $this->name;
                $products = $products->where('name', 'LIKE', "%{$name}%")
                ->orWhere('tags', 'LIKE', "%{$name}%");
            }
            if ($this->category_id != null) {
                $products = $products->where('category_id', '=', $this->category_id);
            }
            if ($this->price != null) {
                if ($this->price == 1) {
                    $products = $products->orderBy('price', 'ASC');
                } else {
                    $products = $products->orderBy('price', 'DESC');
                }
            }
            $products = $products->paginate(40);
        } else {
            $products = null;
        }
        return $products;
    }
    public function search() {
        if ($this->name != null || $this->category_id != null || $this->price != null || $this->country_id != null || $this->government_id != null || $this->store_id != null) {
            $this->fire_search = true;
        } else {
            $this->fire_search = false;
        }
    }
    public function close_search() {
        $this->fire_search      = false;
        $this->name             = null;
        $this->category_id      = null;
        $this->price            = null;
        $this->country_id       = null;
        $this->government_id    = null;
        $this->store_id         = null;
    }

    public function render()
    {
        if ($this->fire_search == true) {
            $search_data = $this->search_value();
        } else {
            $search_data = null;
        }

        $categories = ProductsCategory::where('soft_deleted', '=', 0)->get();
        $countries  = Country::where('soft_deleted', '=', 0)->get();
        $stores     = Client::select('id', 'name')->where('soft_deleted', '=', 0)->where('type', '=', 1)->orWhere('type', '=', 2)->get();
        return view('livewire.frontend.home', [
            'search_data'           => $search_data,
            'upper_ads'             => $this->get_upper_ads_slider(),
            'down_ads'              => $this->get_down_ads_slider(),
            'categories'            => $categories,
            'top_price_products'    => $this->get_top_price_products(),
            'down_price_products'   => $this->get_down_price_products(),
            'top_sales_products'    => $this->get_top_sales_products(),
            'Latest_products'       => $this->get_latest_products(),
            'countries'             => $countries,
            'stores'                => $stores
        ]);
    }
}
