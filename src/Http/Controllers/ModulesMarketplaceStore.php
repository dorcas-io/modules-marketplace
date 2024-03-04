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
        $this->data['marketplace_config'] = config('marketPlaceConfig');
    }



    public function storeIndex()
    {

        $this->data['isAuthenticated'] ? $this->data['view'] = 'ecommerce-store.index' :$this->data['view'] = 'ecommerce-store.unauthorized';

        if($this->data['isAuthenticated']){

             $token = session()->get('token');

             $topSidePromotions  = [];

            $this->data['hasDiscount']= null;

             $url =  $this->data['core_url'].'feature-product';

             $top_side_promotions = $this->data['marketplace_config']['mainContent_HomePageAsExample']['productsSection1']['parameters']['position'];

             $topSidePromotionsCheck = \App\Models\Promotion::where('promotions_space',$top_side_promotions)->where('status','active')->first();

             $this->data['topSidePromo'] = $this->data['marketplace_config']['mainContent_HomePageAsExample']['productsSection1']['parameters']['title'] = !is_null($topSidePromotionsCheck) ? $topSidePromotionsCheck->promotions_name : 'Flash Sale';

             $this->data['counter'] = $this->data['marketplace_config']['mainContent_HomePageAsExample']['counter']['counter'];

             if($topSidePromotionsCheck){
                 $topSidePromotions = \App\Models\PromotionProduct::where('promotions_id',$topSidePromotionsCheck->id)->where('status','active')->pluck('product_id')->toArray();
             }


             if(!empty($topSidePromotions )){

                 $product_ids =  ['product_ids' => $topSidePromotions];

                 $this->data['topSideProducts'] =  $this->postData($token,$url,$product_ids);

                 $this->data['topSideProducts'] =  $this->data['topSideProducts']->data;

             }else{

                 $this->data['topSideProducts'] =  [];

             }



            $midSidePromotions  = [];

            $this->data['midPromo_hasDiscount']= null;
            $this->data['midPromo_DiscountValue'] = 0;

            $mid_side_promotions = $this->data['marketplace_config']['mainContent_HomePageAsExample']['productsSection2']['parameters']['position'];

            $midSidePromotionsCheck = \App\Models\Promotion::where('promotions_space',$mid_side_promotions)->where('status','active')->first();

            $this->data['midSidePromo'] = $this->data['marketplace_config']['mainContent_HomePageAsExample']['productsSection2']['parameters']['title'] = !is_null($midSidePromotionsCheck) ? $midSidePromotionsCheck->promotions_name : 'What\'s New';

            if($midSidePromotionsCheck){

                $midSidePromotions = \App\Models\PromotionProduct::where('promotions_id',$midSidePromotionsCheck->id)->where('status','active')->pluck('product_id')->toArray();

            }


            if(!empty($midSidePromotions )){

                $product_ids =  ['product_ids' => $midSidePromotions];

                $this->data['midSideProducts'] =  $this->postData($token,$url,$product_ids);

                $this->data['midSideProducts'] =  $this->data['midSideProducts']->data;

            }else{

                $this->data['midSideProducts'] =  [];

            }


            $leftSidePromotions  = [];

            $this->data['leftPromo_hasDiscount']= null;
            $this->data['leftPromo_DiscountValue'] = 0;

            $left_side_promotions = $this->data['marketplace_config']['mainContent_HomePageAsExample']['productsSectionSpecial']['parametersLeft']['position'];

            $leftSidePromotionsCheck = \App\Models\Promotion::where('promotions_space',$left_side_promotions)->where('status','active')->first();

            $this->data['leftSidePromo'] = $this->data['marketplace_config']['mainContent_HomePageAsExample']['productsSectionSpecial']['parametersLeft']['title'] = !is_null($leftSidePromotionsCheck) ? $leftSidePromotionsCheck->promotions_name : 'Last Chance To Buy';

            if($leftSidePromotionsCheck){

                $leftSidePromotions = \App\Models\PromotionProduct::where('promotions_id',$leftSidePromotionsCheck->id)->where('status','active')->pluck('product_id')->toArray();

                $this->data['leftPromo_hasDiscount'] = $leftSidePromotionsCheck->discount;

                $this->data['leftPromo_DiscountValue'] = (int) $leftSidePromotionsCheck->discount_value;

            }

            if(!empty($leftSidePromotions)){

                $limitByTwoLeft = [];
                $limitByTwoRight = [];
                foreach($leftSidePromotions as $index =>  $PromotionsId){

                    if($index < 2){
                        $limitByTwoLeft[] = $PromotionsId;
                    }else{
                        $limitByTwoRight[] = $PromotionsId;
                    }

                }
                $product_ids_left =  ['product_ids' => $limitByTwoLeft];
                $product_ids_right =  ['product_ids' => $limitByTwoRight];

                $url =  $this->data['core_url'].'feature-product?limit=2';

                $this->data['leftSideProductsLeft'] = [];
                $this->data['leftSideProductsRight'] = [];

                if(!empty($limitByTwoLeft)) {
                    $this->data['leftSideProductsLeft'] = $this->postData($token, $url, $product_ids_left);
                    $this->data['leftSideProductsLeft'] =  $this->data['leftSideProductsLeft']->data;
                }

                if(!empty($limitByTwoRight)){
                    $this->data['leftSideProductsRight'] = $this->postData($token, $url, $product_ids_right);
                    $this->data['leftSideProductsRight'] =  $this->data['leftSideProductsRight']->data;
                }

            }else{

                $this->data['leftSideProductsLeft'] =  [];
                $this->data['leftSideProductsRight'] =  [];

            }


            $rightSidePromotions  = [];

            $this->data['rightPromo_hasDiscount']= null;
            $this->data['rightPromo_DiscountValue'] = 0;

            $right_side_promotions = $this->data['marketplace_config']['mainContent_HomePageAsExample']['productsSectionSpecial']['parametersLeft']['position'];

            $rightSidePromotionsCheck = \App\Models\Promotion::where('promotions_space',$right_side_promotions)->where('status','active')->first();

            $this->data['rightSidePromo'] = $this->data['marketplace_config']['mainContent_HomePageAsExample']['productsSectionSpecial']['parametersLeft']['title'] = !is_null($rightSidePromotionsCheck) ? $rightSidePromotionsCheck->promotions_name : 'Editor\'s Pick';

            if($rightSidePromotionsCheck){

                $rightSidePromotions = \App\Models\PromotionProduct::where('promotions_id',$rightSidePromotionsCheck->id)->where('status','active')->pluck('product_id')->toArray();


            }

            if(!empty($rightSidePromotions)){

                $limitByTwoLeft = [];
                $limitByTwoRight = [];
                foreach($rightSidePromotions as $index =>  $PromotionsId){

                    if($index < 2){
                        $limitByTwoLeft[] = $PromotionsId;
                    }else{
                        $limitByTwoRight[] = $PromotionsId;
                    }

                }
                $product_ids_left =  ['product_ids' => $limitByTwoLeft];
                $product_ids_right =  ['product_ids' => $limitByTwoRight];

                $url =  $this->data['core_url'].'feature-product?limit=3';

                $this->data['rightSideProductsLeft'] = [];
                $this->data['rightSideProductsRight'] = [];

                if(!empty($limitByTwoLeft)) {
                    $this->data['rightSideProductsLeft'] = $this->postData($token, $url, $product_ids_left);
                    $this->data['rightSideProductsLeft'] =  $this->data['rightSideProductsLeft']->data;
                }

                if(!empty($limitByTwoRight)){
                    $this->data['rightSideProductsRight'] = $this->postData($token, $url, $product_ids_right);
                    $this->data['rightSideProductsRight'] =  $this->data['rightSideProductsRight']->data;
                }

            }else{

                $this->data['rightSideProductsLeft'] =  [];
                $this->data['rightSideProductsRight'] =  [];

            }


            $hero_banner_one = \App\Models\Setting::where('settings_name','hero_banner_one')->first();
            $heroBannerOneUrl = $hero_banner_one->image_url ?? null;

            $hero_banner_two = \App\Models\Setting::where('settings_name','hero_banner_two')->first();
            $heroBannerTwoUrl = $hero_banner_two->image_url ?? null;


            $side_banner_one = \App\Models\Setting::where('settings_name','side_banner_one')->first();
            $sideBannerOne = $side_banner_one->image_url ?? null;

            $side_banner_two = \App\Models\Setting::where('settings_name','side_banner_two')->first();
            $sideBannerTwo = $side_banner_two->image_url ?? null;

            $side_banner_three = \App\Models\Setting::where('settings_name','side_banner_three')->first();
            $sideBannerThree = $side_banner_three->image_url ?? null;

            $mid_left_Banners = \App\Models\Setting::where('settings_name','mid_left_Banners')->first();
            $midLeftBannersUrl = $mid_left_Banners->image_url ?? null;

            $mid_right_Banners = \App\Models\Setting::where('settings_name','mid_right_Banners')->first();
            $midRightBannersUrl = $mid_right_Banners->image_url ?? null;

            $productsBanner = \App\Models\Setting::where('settings_name','productsBanner')->first();
            $productsBannerUrl = $productsBanner->image_url ?? null;




            $this->data['main_banner1'] = $this->data['marketplace_config']['mainContent_HomePageAsExample']['hero']['mainBanner1'] =   !is_null($heroBannerOneUrl) ? $heroBannerOneUrl : 'assets/hero/hero1.jpeg';
            $this->data['main_banner2'] = $this->data['marketplace_config']['mainContent_HomePageAsExample']['hero']['mainBanner2'] = !is_null( $heroBannerTwoUrl) ?  $heroBannerTwoUrl :'assets/hero/hero1.jpeg';

            $this->data['sideBanner1'] = $this->data['marketplace_config']['mainContent_HomePageAsExample']['hero']['sideBanner1'] =   !is_null($sideBannerOne) ? $sideBannerOne : 'assets/hero/side-img1.jpeg';
            $this->data['sideBanner2'] = $this->data['marketplace_config']['mainContent_HomePageAsExample']['hero']['sideBanner2'] = !is_null($sideBannerTwo) ?  $sideBannerTwo :'assets/hero/side-img2.jpeg';
            $this->data['sideBanner3'] = $this->data['marketplace_config']['mainContent_HomePageAsExample']['hero']['sideBanner3'] =   !is_null($sideBannerThree) ? $sideBannerThree : 'assets/hero/side-img3.jpeg';

            $this->data['midBannersLeft'] = $this->data['marketplace_config']['mainContent_HomePageAsExample']['midBanners']['leftBanner'] = !is_null($midLeftBannersUrl) ?  $midLeftBannersUrl :'assets/hero/hero_footer_1.jpeg';
            $this->data['midBannersRight'] = $this->data['marketplace_config']['mainContent_HomePageAsExample']['midBanners']['rightBanner'] =   !is_null( $midRightBannersUrl) ? $midRightBannersUrl : 'assets/hero/hero_footer_2.jpeg';


            $this->data['productsSectionSpecial'] = $this->data['marketplace_config']['mainContent_HomePageAsExample']['productsSectionSpecial']['productsBanner'] = !is_null($productsBannerUrl) ?  $productsBannerUrl :'assets/hero/hero_footer.jpeg';


//            $this->data['main_banner1'] = $this->data['marketplace_config']['mainContent_HomePageAsExample']['hero']['mainBanner1'] =   !is_null($heroBannerOneUrl) ? $heroBannerOneUrl : 'assets/hero/hero1.jpeg';
//            $this->data['main_banner2'] = $this->data['marketplace_config']['mainContent_HomePageAsExample']['hero']['mainBanner2'] = !is_null( $heroBannerTwoUrl) ?  $heroBannerTwoUrl :'assets/hero/hero1.jpeg';






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

            $this->data['product_amount'] = $this->data['product']->data->prices->data[0]->unit_price->raw ?? 0;

            $this->data['hasDiscount'] = (int) $this->data['product']->data->has_discount  === 1;


           $cart = session()->get('cart', []);

            if(!is_null(request()->promo_name)){
                $promotion = \App\Models\Promotion::where('promotions_name',request()->promo_name)->first();
            }

            if($this->data['hasDiscount']){

                $this->data['discount_amount'] = $this->applyDiscount($this->data['product']->data->discount_value ,$this->data['product']->data->prices->data[0]->unit_price->raw);

                $this->data['product_amount'] =  $this->data['discount_amount'] ;
            }



            if(isset($cart[$product_id])) {

                is_null(request()->quantity) ? $cart[$product_id]['quantity']++ : $cart[$product_id]['quantity'] += request()->quantity;

            } else {

                $cart[$product_id] = [
                    "name"       => $this->data['product']->data->name,
                    "quantity"   => is_null(request()->quantity)  ? 1 : request()->quantity,
                    'company_id' => $this->data['product']->data->company->uuid,
                    "price"      => $this->data['product_amount'],
                    "image"      => $this->data['product']->data->images->data[0]->url ?? null ,
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

        $slug = $this->data['product']->data->categories->data[0]->slug ?? null;

        $url =  $this->data['core_url'].'related_product/'.$slug;

        $this->data['related_products'] =  $this->getData($token,$url);

        $this->data['related_products'] =  $this->data['related_products']->data ?? [];
//        dd($this->data['related_products']);


        $this->data['promo_name'] = request()->promotions;

        $this->data['promotions'] = !is_null(request()->promotions) ? request()->promotions : null;
        $this->data['hasDiscount'] = false;
        $this->data['discount_amount'] = 0;


        if(!is_null( $this->data['promotions'])){
            $promotion = \App\Models\Promotion::where('promotions_name',request()->promotions)->first();
            if( $promotion){
                $this->data['hasDiscount'] = $promotion->discount === 'active';
            }
        }
       if($this->data['hasDiscount']){
          $this->data['discount_amount'] = $this->applyDiscount($promotion->discount_value,$this->data['product']->data->prices->data[0]->unit_price->raw);
           $this->data['hasDiscount_value'] = $promotion->discount_value;
       }

        return view('modules-marketplace::'.$this->data['view'] ,$this->data);
    }


    private function applyDiscount($value, $amount)
    {
       $discountedValue =  $value /100 * $amount;

       return $amount -  $discountedValue;
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

    public function addToWishList($product_id)
    {
        $token = session()->get('token');

        $url =  $this->data['core_url'].'single_product/'.$product_id;

        $this->data['product'] = $this->getData($token,$url);

        $wishlist = session()->get('wishlist', []);


        if(isset($wishlist[$product_id])) {

            is_null(request()->quantity) ? $wishlist[$product_id]['quantity']++ : $wishlist[$product_id]['quantity'] += request()->quantity;

        } else {

            $wishlist[$product_id] = [
                "name"       => $this->data['product']->data->name,
                "quantity"   => is_null(request()->quantity)  ? 1 : request()->quantity,
                'company_id' => $this->data['product']->data->company->uuid,
                "price"      => $this->data['product']->data->prices->data[0]->unit_price->raw,
                "image"      => $this->data['product']->product_images[0]->url ?? null ,
                'product_id' => $product_id
            ];

        }

        session()->put('wishlist', $wishlist);


        return response()->json([
            'success' => true,
            'message' => 'Item added to wishlist.',
            'cart' => $wishlist,
        ]);

    }

    public function addWishListToCart(){

        $cart = session()->get('cart',[]);

        $wishlist = session()->get('wishlist');

        $mergedCart_wishlist_Array = collect($cart)->merge($wishlist)->all();


        session()->forget('cart');

        session()->put('cart',$mergedCart_wishlist_Array);

        session()->forget('wishlist');

        toastr()->success('Wishlist Added to cart successfully');

        return back();


    }

    public function removeCart(Request $request)
    {
        if($request->id) {
            $cart = session()->get('cart');
            if(isset($cart[$request->id])) {
                unset($cart[$request->id]);
                session()->put('cart', $cart);
            }
//            session()->flash('success', 'Product removed successfully');
            toastr()->success('Product removed successfully');
        }
    }

    public function updateCart(Request $request)
    {
        if($request->id && $request->quantity){
            $cart = session()->get('cart');
            $cart[$request->id]["quantity"] = $request->quantity;
            session()->put('cart', $cart);
//            session()->flash('success', 'Cart updated successfully');
            toastr()->success('Cart updated successfully');
        }
    }

}