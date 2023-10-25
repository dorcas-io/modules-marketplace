<?php


namespace Dorcas\ModulesMarketplace\Http\Controllers;

use App\Http\Controllers\Controller;
use GoogleMapClass;
use Illuminate\Http\Request;
use Hostville\Dorcas\Sdk;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Http;


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

            return response()->json([
                'success' => true,
                'message' => 'Item added to cart.',
                'cart' => $cart,
                'cart_count' => config('app.cart_count')
            ]);

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

            //TODO:: Route a user to a page to select the type of delivery system the wish to use
            //TODO:: If Kwik is selected then calculate base on the provider selected
            //TODO:: store buyer details in a session and send to the core as customer details during purchase
            //TODO:: Get the Vendors delivery system either deliver by himself or using a provider

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

}