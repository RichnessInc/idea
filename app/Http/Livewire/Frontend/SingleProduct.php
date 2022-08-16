<?php

namespace App\Http\Livewire\Frontend;

use App\Http\Traits\BillTrait;
use App\Models\Address;
use App\Models\billsCollection;
use App\Models\Client;
use App\Models\Country;
use App\Models\Favourite;
use App\Models\GeneralInfo;
use App\Models\Government;
use App\Models\Product;
use App\Models\productExtra;
use App\Models\ShippingMethod;
use App\Models\Testimonial;
use Illuminate\Support\Facades\Auth;
use Jantinnerezo\LivewireAlert\LivewireAlert;
use Livewire\Component;
use Livewire\WithPagination;

class SingleProduct extends Component
{
    use BillTrait;
    use LivewireAlert;
    use WithPagination;
    public $slug;
    public $address_id;
    public $store_government_id;
    public $shipping_method_q;
    public $shipping_cost   = 0;
    public $discount        = 0;
    public $items = [];
    public $totalPrice = 0;
    public $extraQtyModel;

    public $createAddressVisible = false;
    public $street;
    public $sector;
    public $build_no;
    public $floor;
    public $modelId;
    public $country_id;
    public $government_id;
    public $unit_no;
    public $details;
    public $governorates;
    public $productQty = 1;
    public $productQtyModel = 1;
    public $rating_message;
    public $rate;
    public $branch_id;
    public function get_available_branches($product) {
        $available = explode(',', $product->branches);
        if (($key = array_search('', $available)) !== false) {
            unset($available[$key]);
        }
        return Address::with('government')->whereIn('id', $available)->get();
    }

    public function addProductQty() {
        $this->productQty = $this->productQtyModel;
    }
    public function addExtra($extra_id) {
        $extra = productExtra::findOrFail($extra_id);
        $item = [
            'id'        => $extra->id,
            'name'      => $extra->name,
            'price'     => $extra->price,
            'qty'       => 0,
            'model'     => productExtra::class
        ];
        if (!array_key_exists($extra->id, $this->items)) {
            $this->items[$extra->id] = $item;
            $this->totalPrice += ($this->extraQtyModel *$extra->price);

        } else {
            $this->totalPrice -= ($this->items[$extra->id]['qty'] * $extra->price);
            $this->totalPrice += ($this->extraQtyModel *$extra->price);
        }
        $this->items[$extra->id]['qty'] = $this->extraQtyModel;


        $this->alert('success', 'تمت الاضافة للفاتورة بنجاح', [
            'position' =>  'cenetr',
            'timer' =>  3000,
            'toast' =>  true,
            'text' =>  '',
            'confirmButtonText' =>  'Ok',
            'cancelButtonText' =>  'Cancel',
            'showCancelButton' =>  false,
            'showConfirmButton' =>  false,
        ]);
    }
    public function getAddress() {
        if (Auth::guard('clients')->check()) {
            return Address::with( 'government')->where('client_id', '=', Auth::guard('clients')->user()->id)
            ->where('status', '=', 1)
            ->orderBy('created_at', 'DESC')
            ->get();
        } else {
            return null;
        }
    }
    public function get_shipping_methods() {
        if ($this->address_id != null) {
            $clientAddress  = Address::findOrFail($this->address_id);
            $storeAddress  = Address::findOrFail($this->branch_id);
            if ($clientAddress->country_id != $storeAddress->country_id) {
                $methods = ShippingMethod::where('status', '=', 1)->where('id', '=', 8)->where('soft_deleted', '=', 0);
                return $methods->get();
            } else {
                $methods = ShippingMethod::where('status', '=', 1)->where('id', '!=', 8)->where('soft_deleted', '=', 0);
                if (GeneralInfo::findOrFail(1)->senders_status == 1) {

                    $isSender = Client::where('type', '=', 3)
                    ->where('soft_deleted', '=', 0)
                    ->where('serv_aval_in','LIKE', "%{$clientAddress->government_id}%")
                    ->where('serv_aval_in', "LIKE", "%{$storeAddress->government_id}%")->first();
                    if ($isSender != null) {
                        if ($clientAddress->government_id == $storeAddress->government_id) {
                            $methods = $methods->where('id', '!=', 2);
                        } else {
                            $methods = $methods->where('id', '!=', 1);
                        }
                    } else {
                        $methods = $methods->where('id', '!=', 2);
                        $methods = $methods->where('id', '!=', 1);
                    }
                } else {
                    $methods = $methods->where('id', '!=', 1)->where('id', '!=', 2);
                }
                return $methods->get();
            }
        } else {
            return [];
        }

    }
    public function chooseBranch($id) {
        $this->branch_id = $id;
    }
    public function chooseAddress($id) {
        if($this->branch_id != null) {
            $this->address_id = $id;
        } else {
            $this->alert('error', 'يجب اختيار فرع', [
                'position' =>  'cenetr',
                'timer' =>  3000,
                'toast' =>  true,
                'text' =>  '',
                'confirmButtonText' =>  'Ok',
                'cancelButtonText' =>  'Cancel',
                'showCancelButton' =>  false,
                'showConfirmButton' =>  false,
            ]);
        }

    }
    public function choose_shipping_method($id) {
        $this->shipping_method_q  = ShippingMethod::findOrFail($id);
        $this->shipping_cost    = $this->shipping_method_q->price;
    }
    public function buy() {
        if ($this->branch_id != null) {
            if ($this->address_id != null) {
                if ($this->shipping_method_q != null) {
                    $product = Product::where('slug', '=', $this->slug)->first();

                    $item_data = [
                        'id'            => $product->id,
                        'name'          => $product->name,
                        'address_id'    => $this->address_id,
                        'price'         => ($product->price * $this->productQty),
                        'receipt_days'  => $product->receipt_days,
                        'qty'           => $this->productQty,
                        'model'         => Product::class
                    ];
                    $data = [
                        'product'   => $item_data,
                        'extra'     => $this->items,
                        'model'     => Product::class
                    ];
                    if ($this->discount > 0) {
                        $total = $this->totalPrice + (($product->price * $this->productQty) - (($product->price * $this->discount) / 100 ));
                    } else {
                        $total = $this->totalPrice + ($product->price * $this->productQty);

                    }
                    $shippingData = [
                        'address_id'            => $this->address_id,
                        'branch_id'             => $this->branch_id,
                        'shipping_method_id'    => $this->shipping_method_q->id
                    ];
                    $this->createBill($data, $total, $this->shipping_cost, $shippingData, $this->address_id, $product->id);
                    return redirect()->route('frontend.cart');

                } else {
                    $this->alert('error', 'يجب اختيار وسيلة شحن', [
                        'position' =>  'cenetr',
                        'timer' =>  3000,
                        'toast' =>  true,
                        'text' =>  '',
                        'confirmButtonText' =>  'Ok',
                        'cancelButtonText' =>  'Cancel',
                        'showCancelButton' =>  false,
                        'showConfirmButton' =>  false,
                    ]);
                }
            } else {
                $this->alert('error', 'يجب اختيار عنوان', [
                    'position' =>  'cenetr',
                    'timer' =>  3000,
                    'toast' =>  true,
                    'text' =>  '',
                    'confirmButtonText' =>  'Ok',
                    'cancelButtonText' =>  'Cancel',
                    'showCancelButton' =>  false,
                    'showConfirmButton' =>  false,
                ]);
            }
        } else {
            $this->alert('error', 'يجب اختيار فرع', [
                'position' =>  'cenetr',
                'timer' =>  3000,
                'toast' =>  true,
                'text' =>  '',
                'confirmButtonText' =>  'Ok',
                'cancelButtonText' =>  'Cancel',
                'showCancelButton' =>  false,
                'showConfirmButton' =>  false,
            ]);
        }
    }

    public function createAddressModel() {
        $this->resetAddressFormDate();
        $this->createAddressVisible = true;
    }
    public function resetAddressFormDate() {
        $this->street           = null;
        $this->sector           = null;
        $this->build_no         = null;
        $this->floor            = null;
        $this->government_id    = null;
        $this->country_id       = null;
        $this->unit_no          = null;
        $this->details          = null;
        $this->governorates     = null;
    }
    public function hideModel() {
        $this->createAddressVisible     = false;

    }
    public function store() {
        if ($this->address_id == null) {
            $validatedData = $this->validate([
                'government_id'     => 'required|numeric',
                'country_id'        => 'required|numeric',
                //////////////////////////////////////////////////////////////
                'street'            => 'required|string|max:255',
                'build_no'          => 'required|numeric',
                'sector'            => 'required|string|max:255',
                'floor'             => 'required|numeric',
                'unit_no'           => 'required|numeric',
                'details'           => 'required|string|max:255',
            ]);
            $data = [
                'government_id'     => $this->government_id,
                'country_id'        => $this->country_id,
                'street'            => $this->street,
                'build_no'          => $this->build_no,
                'sector'            => $this->sector,
                'floor'             => $this->floor,
                'unit_no'           => $this->unit_no,
                'details'           => $this->details,
            ];
            $add = Address::create($data + ['client_id' => Auth::guard('clients')->user()->id]);
            $this->address_id = $add->id;
        }
        $this->resetAddressFormDate();
        $this->hideModel();
        $this->alert('success', 'تم انشاء العنوان بنجاح', [
            'position' =>  'center',
            'timer' =>  3000,
            'toast' =>  true,
            'text' =>  null,
            'confirmButtonText' =>  'Ok',
            'cancelButtonText' =>  'Cancel',
            'showCancelButton' =>  false,
            'showConfirmButton' =>  false,
        ]);
        return redirect()->route('frontend.single-product', ['slug'=> $this->slug]);

    }
    public function country_change() {
        $this->governorates = Government::where('country_id', '=', $this->country_id)->where('soft_deleted', '=', 0)->get();
    }
    public function add_fev() {
        if (Auth::guard('clients')->check()) {
            $product    = Product::where('slug', '=', $this->slug)->firstOrFail();
            $check      = Favourite::where('product_id', '=', $product->id)->where('client_id', '=', Auth::guard('clients')->user()->id)->first();
            if ($check == null) {
                Favourite::create([
                    'product_id'    => $product->id,
                    'client_id'     => Auth::guard('clients')->user()->id
                ]);
                $this->alert('success', 'تم اضافة المنتج الى المفضلة بنجاح', [
                    'position' =>  'center',
                    'timer' =>  3000,
                    'toast' =>  true,
                    'text' =>  null,
                    'confirmButtonText' =>  'Ok',
                    'cancelButtonText' =>  'Cancel',
                    'showCancelButton' =>  false,
                    'showConfirmButton' =>  false,
                ]);
            } else {
                $this->alert('error', 'المنتج موجود في المفضلة بالفعل', [
                    'position' =>  'center',
                    'timer' =>  3000,
                    'toast' =>  true,
                    'text' =>  null,
                    'confirmButtonText' =>  'Ok',
                    'cancelButtonText' =>  'Cancel',
                    'showCancelButton' =>  false,
                    'showConfirmButton' =>  false,
                ]);
            }

        } else {
            return redirect()->route('frontend.login');
        }
    }
    public function render()
    {

        if (Auth::guard('clients')->check()) {
            if (Auth::guard('clients')->user()->type == 0) {
                $this->discount = Auth::guard('clients')->user()->spasial_com;
            }
        }

        $product = Product::with('category:id,name', 'client:id,name,government_id', 'client.government:id', 'extras')->where('slug', '=', $this->slug)->first();
        if ($product == null) {
            abort(404);
        }
        $branches = $this-> get_available_branches($product);
        $testimonials = Testimonial::with('client:id,name')
            ->where('soft_deleted', '=', 0)
            ->where('status', '=', 1)
            ->where('product_id', '=', $product->id)
            ->where('status', '=', 1)
            ->paginate(25);
        if (Auth::guard('clients')->check()) {
            $hasTestimonial = Testimonial::where('client_id', '=', Auth::guard('clients')->user()->id)
                ->where('product_id', '=', $product->id)
                ->where('token', '!=', null)
                ->first();
        } else {
            $hasTestimonial = null;
        }

        return view('livewire.frontend.single-product', [
            'product'           => $product,
            'address'           => $this->getAddress(),
            'shipping_methods'  => $this->get_shipping_methods(),
            'countries'         => Country::where('soft_deleted', '=', 0)->get(),
            'hasTestimonial'    => $hasTestimonial,
            'testimonials'      => $testimonials,
            'branches'          => $branches,
        ]);
    }
    public function submit_rate($id) {
        $this->validate([
            'rating_message'    => 'required|min:4|max:255',
            'rate'            => 'required|numeric|min:0|max:5',
        ]);
        $hasTestimonial = Testimonial::findOrFail($id)->update([
            'message'       => $this->rating_message,
            'rate'          => $this->rate,
            'token'         => null,
        ]);
        $this->alert('success', 'تم اضافة التقيم بنجاح', [
            'position' =>  'cenetr',
            'timer' =>  3000,
            'toast' =>  true,
            'text' =>  '',
            'confirmButtonText' =>  'Ok',
            'cancelButtonText' =>  'Cancel',
            'showCancelButton' =>  false,
            'showConfirmButton' =>  false,
        ]);
    }
    public function buyCollection() {
        if ($this->branch_id != null) {
            if ($this->address_id != null) {
                if ($this->shipping_method_q != null) {
                    $product        = Product::with('client')->where('slug', '=', $this->slug)->first();
                    $getLastBill    = billsCollection::with('product.client')->where('client_id', '=', Auth::guard('clients')->user()->id)
                        ->where('status', '=', 0)
                        ->where('soft_deleted', '!=', 1)
                        ->first();
                    if ($getLastBill != null) {
                        if ($getLastBill->product->client->id == $product->client_id) {
                            if ($this->address_id == $getLastBill->address_id) {
                                $shippingDataInfo = json_decode($getLastBill->shipping_data);
                                if ($this->branch_id == $shippingDataInfo->branch_id) {
                                    if ($this->shipping_method_q->id == $shippingDataInfo->shipping_method_id) {
                                        $this->createBillCollectionFunction($product);
                                        $this->alert('success', 'تمت الاضافة بنجاح', [
                                            'position' =>  'cenetr',
                                            'timer' =>  3000,
                                            'toast' =>  true,
                                            'text' =>  '',
                                            'confirmButtonText' =>  'Ok',
                                            'cancelButtonText' =>  'Cancel',
                                            'showCancelButton' =>  false,
                                            'showConfirmButton' =>  false,
                                        ]);
                                    } else {
                                        $this->alert('error', 'لا يمكن شراء منتجات بأكثر من وسيلة شحن في وقت واحد يجب تسديد الفواتير المجمعة اولا', [
                                            'position' =>  'cenetr',
                                            'timer' =>  5000,
                                            'toast' =>  true,
                                            'text' =>  '',
                                            'confirmButtonText' =>  'Ok',
                                            'cancelButtonText' =>  'Cancel',
                                            'showCancelButton' =>  false,
                                            'showConfirmButton' =>  false,
                                        ]);
                                    }
                                } else {
                                    $this->alert('error', 'لا يمكن شراء منتجات من اكثر من فرع في وقت واحد يجب تسديد الفواتير المجمعة اولا', [
                                        'position' =>  'cenetr',
                                        'timer' =>  5000,
                                        'toast' =>  true,
                                        'text' =>  '',
                                        'confirmButtonText' =>  'Ok',
                                        'cancelButtonText' =>  'Cancel',
                                        'showCancelButton' =>  false,
                                        'showConfirmButton' =>  false,
                                    ]);
                                }
                            } else {
                                $this->alert('error', 'لا يمكن شراء منتجات و الشحن الى اكثر من عنوان في وقت واحد يجب تسديد الفواتير المجمعة اولا', [
                                    'position' =>  'cenetr',
                                    'timer' =>  5000,
                                    'toast' =>  true,
                                    'text' =>  '',
                                    'confirmButtonText' =>  'Ok',
                                    'cancelButtonText' =>  'Cancel',
                                    'showCancelButton' =>  false,
                                    'showConfirmButton' =>  false,
                                ]);
                            }
                        } else {
                            $this->alert('error', 'لا يمكن شراء منتجات من اكثر من تاجر في وقت واحد يجب تسديد الفواتير المجمعة اولا', [
                                'position' =>  'cenetr',
                                'timer' =>  5000,
                                'toast' =>  true,
                                'text' =>  '',
                                'confirmButtonText' =>  'Ok',
                                'cancelButtonText' =>  'Cancel',
                                'showCancelButton' =>  false,
                                'showConfirmButton' =>  false,
                            ]);
                        }
                    } else {
                        $this->createBillCollectionFunction($product);
                        $this->alert('error', 'تمت الاضافة بنجاح', [
                            'position' =>  'cenetr',
                            'timer' =>  3000,
                            'toast' =>  true,
                            'text' =>  '',
                            'confirmButtonText' =>  'Ok',
                            'cancelButtonText' =>  'Cancel',
                            'showCancelButton' =>  false,
                            'showConfirmButton' =>  false,
                        ]);
                    }
                } else {
                    $this->alert('error', 'يجب اختيار وسيلة شحن', [
                        'position' =>  'cenetr',
                        'timer' =>  3000,
                        'toast' =>  true,
                        'text' =>  '',
                        'confirmButtonText' =>  'Ok',
                        'cancelButtonText' =>  'Cancel',
                        'showCancelButton' =>  false,
                        'showConfirmButton' =>  false,
                    ]);
                }
            } else {
                $this->alert('error', 'يجب اختيار عنوان', [
                    'position' =>  'cenetr',
                    'timer' =>  3000,
                    'toast' =>  true,
                    'text' =>  '',
                    'confirmButtonText' =>  'Ok',
                    'cancelButtonText' =>  'Cancel',
                    'showCancelButton' =>  false,
                    'showConfirmButton' =>  false,
                ]);
            }
        } else {
            $this->alert('error', 'يجب اختيار فرع', [
                'position' =>  'cenetr',
                'timer' =>  3000,
                'toast' =>  true,
                'text' =>  '',
                'confirmButtonText' =>  'Ok',
                'cancelButtonText' =>  'Cancel',
                'showCancelButton' =>  false,
                'showConfirmButton' =>  false,
            ]);
        }
    }

    public function get_items_data_to_bill($product) {
        return [
            'id'            => $product->id,
            'name'          => $product->name,
            'address_id'    => $this->address_id,
            'price'         => ($product->price * $this->productQty),
            'receipt_days'  => $product->receipt_days,
            'qty'           => $this->productQty,
            'model'         => Product::class
        ];
    }
    public function createBillCollectionFunction($product) {
        $item_data      = $this->get_items_data_to_bill($product);
        $data           = [
            'product'   => $item_data,
            'extra'     => $this->items,
            'model'     => Product::class
        ];
        if ($this->discount > 0) {
            $total = $this->totalPrice + (($product->price * $this->productQty) - (($product->price * $this->discount) / 100 ));
        } else {
            $total = $this->totalPrice + ($product->price * $this->productQty);

        }
        $shippingData = [
            'address_id'            => $this->address_id,
            'branch_id'             => $this->branch_id,
            'shipping_method_id'    => $this->shipping_method_q->id
        ];
        $this->createBillCollection($data, $total, $this->shipping_cost, $shippingData, $this->address_id, $product->id);
    }
}
