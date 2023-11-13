<?php


namespace Dorcas\ModulesMarketplace\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Order;
use GoogleMapClass;
use Illuminate\Http\Request;
use Hostville\Dorcas\Sdk;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Str;
use KingFlamez\Rave\Facades\Rave as Flutterwave;


class ModulesMarketplaceStore extends Controller {


    public  $gmaps;

    public function __construct()
    {
        $this->data['isAuthenticated'] = is_string(session()->get('token'));
        $this->data['core_url'] = env("CORE_URL");
        $this->gmaps = new \yidas\googleMaps\Client(['key'=>env('CREDENTIAL_GOOGLE_API_KEY')]);
        $this->data['logistics_settings'] = config('delivery.providers');
    }



    public function storeIndex()
    {

        $this->data['isAuthenticated'] ? $this->data['view'] = 'ecommerce-store.index' :$this->data['view'] = 'ecommerce-store.unauthorized';

        if($this->data['isAuthenticated']){

             $token = session()->get('token');

             $url =  $this->data['core_url'].'all_products';

             $this->data['flash_sales'] = $this->getData($token,$url);

             $this->data['flash_sales'] = $this->data['flash_sales']->data;

         }

        return view('modules-marketplace::'.$this->data['view'] ,$this->data);
    }

    public function addToCart($product_id){

        $this->data['isAuthenticated'] ? $this->data['view'] = 'ecommerce-store.index' :$this->data['view'] = 'ecommerce-store.unauthorized';

        if($this->data['isAuthenticated'])
        {

            $token = session()->get('token');

            $url =  $this->data['core_url'].'single_product/'.$product_id;

            $this->data['product'] = $this->getData($token,$url);

           $cart = session()->get('cart', []);


            if(isset($cart[$product_id])) {

                is_null(request()->quantity) ? $cart[$product_id]['quantity']++ : $cart[$product_id]['quantity'] += request()->quantity;

            } else {

                $cart[$product_id] = [
                    "name"       => $this->data['product']->data->name,
                    "quantity"   => is_null(request()->quantity)  ? 1 : request()->quantity,
                    'company_id' => $this->data['product']->data->company->uuid,
                    "price"      => $this->data['product']->data->prices->data[0]->unit_price->raw,
                    "image"      => $this->data['product']->product_images[0]->url ?? null ,
                    'product_id' => $product_id
                ];

            }

            session()->put('cart', $cart);

            if(request()->expectsJson()){
                return response()->json([
                    'success' => true,
                    'message' => 'Item added to cart.',
                    'cart' => $cart,
                    'cart_count' => config('app.cart_count')
                ]);
            }else{
                toastr()->success('Added to cart successfully');
                return back();
            }


        }


       return view('modules-marketplace::'.$this->data['view'] ,$this->data);

    }


    public function viewCart()
    {

        $this->data['isAuthenticated'] ? $this->data['view'] = 'ecommerce-store.cart' :$this->data['view'] = 'ecommerce-store.unauthorized';

        if($this->data['isAuthenticated']){

            $cart = session()->get('cart');

            $this->data['carts'] = $cart;

        }

        return view('modules-marketplace::'.$this->data['view'] ,$this->data);
    }


    public function checkout()
    {


        $this->data['isAuthenticated'] ? $this->data['view'] = 'ecommerce-store.checkout' :$this->data['view'] = 'ecommerce-store.unauthorized';

        if($this->data['isAuthenticated']){

            $cart = session()->get('cart');

            $this->data['carts'] = $cart;

        }

        return view('modules-marketplace::'.$this->data['view'] ,$this->data);
    }


    public function getAddress($address)
    {

        $geocodeResult = $this->gmaps->geocode($address);

        $addressData = [];

        if (count($geocodeResult) > 0) {

            foreach ($geocodeResult as $index => $fAddress) {

                $data = ['address' => $fAddress['formatted_address'] ,
                        'lat' => $fAddress['geometry']['location']['lat'] ,
                        'lng' => $fAddress['geometry']['location']['lng']];

                $addressData  = $data;
            }
            return [
                'success' => true,
                'data' =>  $addressData
            ];
        }

        return [
            'success' => false,
            'data' => $addressData
        ];
    }


    public function fetchUserData()
    {
        $user = \App\Models\User::where('email',request()->email)->first();

        if(!$user){
            return [
                'success' => false,
                'data' => []
            ];
        }

        return [
            'success' => true,
            'data' =>  $user
        ];
    }


    public function calculateDelivery(Request $request)
    {

        $this->data['isAuthenticated'] ? $this->data['view'] = 'ecommerce-store.delivery' :$this->data['view'] = 'ecommerce-store.unauthorized';

        if($this->data['isAuthenticated']) {

            if (!is_null($request->create_account) && $request->create_account == "on") {

                $createUser = new \App\Models\User();
                $createUser->first_name = $request->first_name;
                $createUser->last_name = $request->last_name;
                $createUser->email = $request->email;
                $createUser->phone = $request->phone;
                $createUser->password = Hash::make($request->password);
                $createUser->save();
            }



            $password = 'password';

            $buyerData = array_filter($request->except('_token'), function ($item) use ($password) {
                return $item !== $password;
            });


            session()->put('buyer_data', $buyerData);


            $this->data['buyer_data'] = $buyerData;
            $this->data['buyer_carts'] = session()->get('cart');

            $companyIds = [];

            foreach( $this->data['buyer_carts'] as $index => $cart ){
                $companyIds[] = $cart['company_id'];
            }

            $uniqueCompanyId =   array_unique($companyIds);

            $headers = [
                'Accept' => 'application/json',
                "Content-Type" => "application/json"
            ];


                $response =  Http::withoutVerifying()->withHeaders($headers)
                    ->post(env('CORE_URL').'manage-delivery',['company_ids' => $uniqueCompanyId ,'state' => $request->state] );

                $this->data['routes_sme'] =  json_decode($response);


        }

        return view('modules-marketplace::'.$this->data['view'] ,$this->data);

    }

    public function getDeliveryCost(Request $request)
    {

        $this->data['isAuthenticated'] ? $this->data['view'] = 'ecommerce-store.payment' :$this->data['view'] = 'ecommerce-store.unauthorized';

        if($this->data['isAuthenticated']) {
            //TODO:: Route a user to a page to select the type of delivery system the wish to use
            //TODO:: If Kwik is selected then calculate base on the provider selected
            //TODO:: store buyer details in a session and send to the core as customer details during purchase
            //TODO:: Get the Vendors delivery system either deliver by himself or using a provider
            $headers = [
                'Accept' => 'application/json',
                "Content-Type" => "application/json"
            ];

            $buyer_data = session()->get('buyer_data');
            $address    = $buyer_data['address'];
            $lat        = $buyer_data['latitude'];
            $lng        = $buyer_data['longitude'];

            $eachProviderFare = [];

            $eachSmeFare = [];


            if(!is_null($request->provider)){

                $total = 0;
                $extraData = [];

                foreach(session('cart') as $id => $details){
                    $total += $details['price'] * $details['quantity'];

                    if(in_array($details['company_id'],$request->sme_ids)){
                        $extraData[] = ['company_id' => $details['company_id'] , 'amount' => $details['price'] , 'product_id' => $details['product_id']];
                    }
                }


                $data = [
                    'first_name'      =>  $buyer_data['first_name'],
                    'last_name'      =>  $buyer_data['last_name'],
                    'email'          =>  $buyer_data['email'],
                    'phone_number'   =>  $buyer_data['phone'],
                    'number_of_task' =>  count($request->provider),
                    'address'        => $address,
                    'latitude'       => $lat,
                    'longitude'      => $lng,
                    'smeIds'         => $request->sme_ids,
                    'parcel_amount'  =>  $total,
                    'carted_items'   => $extraData,
                ];


                try {

                    switch($request->logistics){
                        case 'kwik':
                            $response =  Http::withoutVerifying()->withHeaders($headers)
                                ->post(env('HUB_URL').'msl/get-cost',$data);
                            break;
                        case 'gig':
                            $response = null;
                            break;
                        default:
                            $response = Http::withoutVerifying()->withHeaders($headers)
                                                   ->post(env('HUB_URL').'msl/get-cost',$data);
                    }
                }catch (\Exception $exception){
                    toastr()->error('Oops! '.$exception->getMessage());
                    return back();
                }


                 if(is_null($response)){
                     toastr()->error('Oops! GIG Logistics implementation out of service opt for other options for delivery!');
                     return redirect('checkout');
                 }


                $routes = json_decode($response);




                if(isset($routes->success) && $routes->success){

                    $shippingPaymentEstimate = 0;

                    foreach($routes->billBreakDown_estimatedPrice as $index => $billBreakdown){

                        $shippingPaymentEstimate +=  $billBreakdown->billBreakdown->ACTUAL_ORDER_PAYABLE_AMOUNT;

                        if(in_array($billBreakdown->company_id,$request->sme_ids)){

                            $eachProviderFare[] = [ 'delivery_amount' => $billBreakdown->billBreakdown->ACTUAL_ORDER_PAYABLE_AMOUNT ,
                                'company_uuid'    => $billBreakdown->company_id,
                                'company_name'    => '',
                                'delivery_type'   => 'provider',
                                'product_id'      => $billBreakdown->product_id,
                            ];
                        }
                    }
                    $this->data['providerAmount'] = $shippingPaymentEstimate;// $routes->data->payload->data->ACTUAL_ORDER_PAYABLE_AMOUNT;


                    session()->put('smeIds', $request->sme_ids);
                    session()->put('billBreakDown_estimatedPrice',$routes->billBreakDown_estimatedPrice);
                    session()->put('providerAmount', $this->data['providerAmount']);

                }else{

                    $this->data['providerAmount'] =  0;

                    toastr()->error('Oops! something went wrong : ' . $routes->message);

                    return redirect('checkout');
                }

            }else{

                $this->data['providerAmount'] = 0;
            }



            if(!is_null($request->routes)){

                try{
                    $response =  Http::withoutVerifying()->withHeaders($headers)
                        ->post(env('CORE_URL').'calculate-delivery',['product_ids' => $request->routes ] );
                }catch (\Exception $e){
                    toastr()->error('Oops!'.$e->getMessage());
                    return back();
                }

                $routes = json_decode($response);

                $routeTotal = [];

                foreach($routes as $index => $route){

                    foreach(session('cart') as $id => $details){

                        if($details['company_id'] === $route->company->uuid){
                            $eachSmeFare[] = [
                                'delivery_amount' => $route->prices[0]->unit_price,
                                'company_uuid'    => $route->company->uuid ,
                                'company_name'    => $route->company->name ,
                                'delivery_type'   => 'sme' ,
                                'product_id'      => $details['product_id'],
                            ];
                            ;
                        }
                    }
                    $routeTotal[] = $route->prices[0]->unit_price;
                }


                $this->data['sumEachDeliveryAmount'] = array_sum($routeTotal);

                session()->put('deliveryTotal',$this->data['sumEachDeliveryAmount']);
                session()->put('deliveryRouteIds', $request->routes);
                session()->put('selectedSmeRoutesObject', $routes);

            }else{
                $this->data['sumEachDeliveryAmount'] = 0;
            }

            $eachFare  = null;
            if(!empty($eachSmeFare) && !empty($eachProviderFare)){

                $eachFare = array_merge($eachSmeFare,$eachProviderFare);

            }elseif(!empty($eachSmeFare) && empty($eachProviderFare) ){

                $eachFare = $eachSmeFare;

            }elseif(empty($eachSmeFare) && !empty($eachProviderFare) ){

                $eachFare = $eachProviderFare;
            }


            session()->put('eachSmeDeliveryFare', $eachFare);

            $this->data['sumDeliveryAmount'] =  $this->data['sumEachDeliveryAmount'] + $this->data['providerAmount'];


            $total = 0;

            foreach(session('cart') as $id => $details){

                $total += $details['price'] * $details['quantity'];

            }

            $this->data['calculate_vat'] = $total + $this->data['sumDeliveryAmount'];

            if(config('vat.type') === 'percentage'){

                $this->data['calculate_vat'] = $total * config('vat.value')/100;

            }elseif(config('vat.type') === 'value'){

                $this->data['calculate_vat'] = config('vat.value');

            }

            $this->data['vat_value'] = config('vat.value');

            session()->put('deliveryTotal',$this->data['sumDeliveryAmount']);
//            +$this->data['calculate_vat']

        }

        return view('modules-marketplace::'.$this->data['view'] ,$this->data);

    }


    public function initialize()
    {
        //This generates a payment reference
        $reference = Flutterwave::generateReference();

       $buyer_data = session()->get('buyer_data');
       $logistics_payment = session()->get('deliveryTotal');
//       dd(session()->get('deliveryTotal') );
        // Enter the details of the payment


        $total = 0;

        foreach(session('cart') as $id => $details){
            $total += $details['price'] * $details['quantity'];
        }

        $totalAmount = $total +  $logistics_payment;

        $partnerAdmin = DB::connection('core_mysql')->table("companies")->where('id', 1)->first();

        $company_data = (array) $partnerAdmin->extra_data;

        $partnerData = json_decode($company_data[0]);

        $dorcasPayment = [];
        $partnerPayment = [];
        $amount_sales_sme = 0;

        if (isset($partnerData->global_partner_settings->ecommerce) && !empty($partnerData->global_partner_settings->ecommerce) ) {

            $partnerECommerce = $partnerData->global_partner_settings->ecommerce;
            $transactionFees =  $partnerECommerce->transaction_fees;

            foreach(session('cart') as $id => $details){
                $eachSmeTotal = $details['price'] * $details['quantity'];
                $dorcasPayment[] =  $eachSmeTotal *  $transactionFees->dorcas/100;
                $partnerPayment[] =  $eachSmeTotal *  $transactionFees->partner/100;
//                $amount_sales_sme += $details['price'] * $details['quantity'];
            }

            $amount_total_partner = array_sum($partnerPayment);
            $amount_total_dorcas = array_sum($dorcasPayment);
            $amount_sales_sme = $totalAmount;
        }



        //company payments_settings for invididual smes
//        dd(  $company_data   );
        $data = [
            'payment_options' => 'card,banktransfer',
            'amount' => $totalAmount,
            'email' =>  $buyer_data['email'],
            'tx_ref' => $reference,
            'currency' => "NGN",
            'redirect_url' => route('payment-callback'),
            'customer' => [
                'email' =>  $buyer_data['email'],
                "phone_number" =>  $buyer_data['phone'],
                "name" =>  $buyer_data['first_name'] . '' .  $buyer_data['last_name']
            ],

            "customizations" => [
                "title" => 'Item purchase',
                "description" => now()
            ],
             "subaccounts" => [
                [
                    "id" =>  $partnerECommerce->subaccounts->sales_sme,
                    "transaction_charge_type" => "flat_subaccount",
                    "transaction_charge" => $amount_sales_sme,
                ],
                [
                    "id" =>  $partnerECommerce->subaccounts->logistics,
                    "transaction_charge_type" => "flat_subaccount",
                    "transaction_charge" =>  $logistics_payment,
                ],
                [
                    "id" =>  $partnerECommerce->subaccounts->partner,
                    "transaction_charge_type" => "flat_subaccount",
                    "transaction_charge" => $amount_total_partner,
                ],
                [
                    "id" =>  $partnerECommerce->subaccounts->dorcas,
                    "transaction_charge_type" => "flat_subaccount",
                    "transaction_charge" =>  $amount_total_dorcas,
                ],
            ]
        ];

        $payment = Flutterwave::initializePayment($data);


        if ($payment['status'] !== 'success') {
            // notify something went wrong
            return;
        }

        return redirect($payment['data']['link']);
    }

    public function callback()
    {

        $status = request()->status;

        //if payment is successful
        if ($status ==  'successful') {

            $transactionID = Flutterwave::getTransactionIDFromCallback();
            $data = Flutterwave::verifyTransaction($transactionID);


            $headersCore = [
                'Accept' => 'application/json' ,
                'Content-Type' => 'application/json'
            ];

            $buyer_data = session()->get('buyer_data');


            $urlCore = env('CORE_URL').'manage-cart-transaction';

            $paymentGroup = session()->get('payment_group');


            try{

                $cart = session()->get('cart');

                $response = Http::withoutVerifying()->withHeaders($headersCore)->post($urlCore, [
                    'email'            => $buyer_data['email'],
                    'firstname'         => $buyer_data['first_name'],
                    'lastname'         => $buyer_data['last_name'],
                    'phone'            => $buyer_data['phone'],
                    'customer_consent' => $buyer_data['consent'] ?? null,
                    'carts'            => $cart,
                ]);
            }catch(\Exception $e){

                toastr()->error($e->getMessage());
                return back();

            }

            $checkResponse  = json_decode($response);


            $kwikDeliveryData = session()->get('billBreakDown_estimatedPrice');


            if(isset($checkResponse->success) && $checkResponse->success) {

                foreach ($checkResponse->data as $i => $data) {

                    if (isset($data->order->company->extra_data->logistics_settings)

                        && $data->order->company->extra_data->logistics_settings->logistics_shipping === 'shipping_provider') {
                        $paymentGroup = Str::orderedUuid();
                        //rand(1,20);
                        foreach ($kwikDeliveryData as $kwikData) {
                            if ($kwikData->company_id === $data->order->company->uuid) {
                                $recordOrder = new \App\Models\Order();
                                $recordOrder->core_order_id = $data->order->uuid;
                                $recordOrder->delivery_billBreakdown = json_encode($kwikData->billBreakdown);
                                $recordOrder->delivery_estimatedPrice = json_encode($kwikData->estimatedPrice);
                                $recordOrder->payment_group = $paymentGroup;
                                $recordOrder->order = json_encode($data);
                                $recordOrder->user_id = auth()->user() ? auth()->user()->id : null;
                                $recordOrder->save();
                            }
                        }
                    }
                }
            }

            toastr()->success('Payment made successfully');

            session()->forget('cart');
            session()->forget('deliveryTotal');
            session()->forget('deliveryRouteIds');
            session()->forget('customerDetails');
            session()->forget('selectedSmeRoutesObject');
            session()->forget('smeIds');
            session()->forget('billBreakDown_estimatedPrice');
            session()->forget('payment_group');
            session()->forget('eachSmeDeliveryFare');

            return redirect('/payment-success');
        }
        elseif ($status ==  'cancelled'){
            //Put desired action/code after transaction has been cancelled here
        }
        else{
            //Put desired action/code after transaction has failed here
        }
        // Get the transaction from your DB using the transaction reference (txref)
        // Check if you have previously given value for the transaction. If you have, redirect to your successpage else, continue
        // Confirm that the currency on your db transaction is equal to the returned currency
        // Confirm that the db transaction amount is equal to the returned amount
        // Update the db transaction record (including parameters that didn't exist before the transaction is completed. for audit purpose)
        // Give value for the transaction
        // Update the transaction to note that you have given value for the transaction
        // You can also redirect to your success page from here

    }


    public function singleProduct($product_id)
    {

        $this->data['isAuthenticated'] ? $this->data['view'] = 'ecommerce-store.single-product':
                                        $this->data['view'] = 'ecommerce-store.unauthorized';

        $url =  $this->data['core_url'].'single_product/'.$product_id;

        $token = session()->get('token');

        $this->data['product'] =  $this->getData($token,$url);
//        dd($this->data['product']);


        return view('modules-marketplace::'.$this->data['view'] ,$this->data);
    }



    public function paymentSuccess()
    {
        $this->data['isAuthenticated'] ? $this->data['view'] = 'ecommerce-store.payment-success' :
                                        $this->data['view'] = 'ecommerce-store.unauthorized';

        return view('modules-marketplace::'.$this->data['view'] ,$this->data);
    }

    public function addReview(Request $request , $product_id){

        $headers = [
            'Accept' => 'application/json',
            "Content-Type" => "application/json"
        ];

        $response =  Http::withoutVerifying()->withHeaders($headers)
            ->post(env('CORE_URL').'create-product-review', [
                'full_name' => $request->full_name,
                'email'     => $request->email,
                'reviews'   => $request->reviews,
                'rating'    => $request->rating,
                'product_id'=> $product_id]);

        $reviews = json_decode($response);

        return response()->json(['success' => true , 'data' => $reviews]);
    }


    public function productCategories()
    {

        $this->data['isAuthenticated'] ? $this->data['view'] = 'ecommerce-store.category' :$this->data['view'] = 'ecommerce-store.unauthorized';

        if($this->data['isAuthenticated']) {
            $headers = [
                'Accept' => 'application/json',
                "Content-Type" => "application/json"

            ];
            $parentCategory = Http::withoutVerifying()->withHeaders($headers)
                ->get(env('CORE_URL') . 'parent_category');

            $parentCategories = json_decode($parentCategory);

            $modifiedArray = [];

            foreach ($parentCategories as $index => $cat) {

                $parts = explode(',', $cat);
                $parts = array_map('trim', $parts);
                $modifiedArray[] = $parts[0];

                $existingSubCategories = [];

                if (count($parts) > 1) {

                    foreach ($parts as $j => $part) {
                        $existingCat = str_replace(['[', ']'], '', $part);
                        if ($j !== 0) {
                            $subCat = str_replace('"', '', $existingCat);
                            $existingSubCategories[] = $subCat;
                        }
                    }
                    $modifiedArray[] = $existingSubCategories;
                }

            }

//        $this->data['categories'] =  json_decode($parentCategory);

            $this->data['categories'] = $modifiedArray;


            $parentCategory = Http::withoutVerifying()->withHeaders($headers)
                ->post(env('CORE_URL') . 'filter-product-parent-category/', ['category' => request()->category, 'page' => request()->page]);

            $this->data['products'] = json_decode($parentCategory);

            $this->data['category'] = request()->category;

            $this->data['pagination'] = $this->data['products']->meta->pagination;
//            dd( $this->data['pagination']);

            $this->data['pagination_total'] = $this->data['products']->meta->pagination->total_pages;


            $this->data['current_page'] = $this->data['pagination']->current_page;

            $this->data['per_page'] = $this->data['pagination']->per_page;

            $this->data['next'] = $this->data['pagination']->links->next ?? null;

            $this->data['previous'] = $this->data['pagination']->links->previous ?? null;

            $this->data['links'] = $this->data['pagination']->links == [] ? 0 : 1;

            if (!is_null($this->data['next'])) {

                $this->data['nextArray'] = explode("?", $this->data['next']);

                $this->data['nextString'] = '?' . $this->data['nextArray'][1];

            } else {

                $this->data['nextString'] = '';
            }


            if (!is_null($this->data['previous'])) {

                $this->data['previousArray'] = explode("?", $this->data['previous']);

                $this->data['previousString'] = '?' . $this->data['previousArray'][1];

            } else {

                $this->data['previousString'] = '';
            }
        }

        return view('modules-marketplace::'.$this->data['view'] ,$this->data);

    }


    public function userProfile($user_id)
    {

        $this->data['isAuthenticated'] ? $this->data['view'] = 'ecommerce-store.profile':
                                         $this->data['view'] = 'ecommerce-store.unauthorized';

        $this->data['user'] = \App\Models\User::where('id', $user_id)->first();

        return view('modules-marketplace::'.$this->data['view'] ,$this->data);
    }

    public function updateUserProfile(Request $request, $user_id)
    {
        $this->validate($request, [
            'first_name' => 'required|string',
            'last_name' => 'required|string',
            'phone' => 'required|regex:/^([0-9\s\-\+\(\)]*)$/|min:11',
        ]);
       $userProfile  = \App\Models\User::where('id', $user_id)->first();

       if($userProfile){

           $userProfile->update([
               'first_name' => $request->first_name,
               'last_name' => $request->last_name,
               'phone' => $request->phone,
           ]);

           toastr()->success('Profile updated successfully');

           return back();
       }

        toastr()->error('Profile update not successful');

        return back();
    }


    public function myOrders($user_id)
    {
        $this->data['isAuthenticated'] ? $this->data['view'] = 'ecommerce-store.order-history': $this->data['view'] = 'ecommerce-store.unauthorized';

        $this->data['orders']  = \App\Models\Order::where('user_id',$user_id)->get();

        return view('modules-marketplace::'.$this->data['view'] ,$this->data);
    }

}