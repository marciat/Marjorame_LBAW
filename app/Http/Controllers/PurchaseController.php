<?php

namespace App\Http\Controllers;

use App\Billing_address;
use App\Purchase_status;
use App\Purchased_product;
use DateTime;
use Illuminate\Http\Request;
use App\Cart;
use App\Address;
use App\City;
use App\Card;
use App\Product;
use App\Purchase;
use App\Country;
use App\Shipping_address;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class PurchaseController extends Controller
{
    public function cart()
    {

        if (!Auth::check()) {
            return view('pages.cart', ['cart_prods' => []]);
        }

        $user = Auth::user();

        if ($user->admin) {
            return view('pages.cart', ['cart_prods' => []]);
        }

        $cart_prods = $user->buyer->cart;
        return view('pages.cart', ['cart_prods' => $cart_prods]);
    }

    public function cart_items()
    {

        if (!Auth::check()) {
            return view('partials.cart', ['cart_prods' => []]);
        }

        $user = Auth::user();

        if ($user->admin) {
            return view('partials.cart', ['cart_prods' => []]);
        }

        $cart_prods = $user->buyer->cart;
        return view('partials.cart', ['cart_prods' => $cart_prods]);
    }


    /**
     * Change quantity of product in cart.
     *
     * @param int $id
     * @return Response
     */
    public function update_cart_quantity(Request $request, $id)
    {


        $user = Auth::user();

        $this->authorize('showPrivate', $user);

        $update_cart = DB::table('cart')
            ->where('buyer', $user->buyer->id)
            ->where('id', $id)
            ->update(
                [
                    'quantity' => $request->input('quantity')
                ]
            );

        if($update_cart != NULL){
            return response('', 200)->header('Content-Type', 'text/plain');
        }
        else{
            return response('', 404)->header('Content-Type', 'text/plain');
        }
    }

    /**
     * Deletes an individual item from the cart.
     *
     * @param int $id
     * @return Response
     */
    public function delete_cart(Request $request, $id)
    {

        $cart = Cart::find($id);

        $this->authorize('delete', [Cart::class, $cart]);

        $cart->delete();

    }

    /**
     * Deletes an individual item from the cart.
     *
     * @param int $id
     * @return Response
     */
    public function add_to_cart(Request $request, $product_id){
        $user = Auth::user();
        //add check if there is the attribute buyer

        $existingInstances = DB::table('cart')
                            ->where('product', $product_id)
                            ->where('buyer', $user->buyer->id)
                            ->get();
        
        if(count($existingInstances) == 0){
            $insertResult = DB::table('cart')
                            ->insertGetId(
                                [
                                    'product' => $product_id,
                                    'buyer' => $user->buyer->id,
                                    'quantity' => $request->input('quantity')
                                ]
                            );

            if($insertResult){
                return response('', 201)->header('Content-Type', 'text/plain');
            }
            else{
                return response('', 500)->header('Content-Type', 'text/plain');
            }
        }

        return response('', 400)->header('Content-Type', 'text/plain');
    }

    public function checkout()
    {
        
        $user = Auth::user();

        $this->authorize('showPrivate', $user);


        if ($user->admin)
            return redirect('/');

        if(count($user->buyer->cart) == 0){
            return redirect()->back()->with('empty', 'Please add products to cart before proceeding to checkout');
        }

        $cart_prods = $user->buyer->cart;


        $price = 0;

        foreach($cart_prods as $product) {
            $price += $product->price * $product->pivot->quantity;
        }


        $buyer = DB::table('buyer')
            ->where('user_id', $user->id)
            ->first();


        if ($buyer->country_id != null)
            $country = Country::find($buyer->country_id);
        else {
            $country = new Country();
            $country->name = "";
        }

        if ($buyer->shipping_address != null) {
            $shipping_address = Shipping_address::find($buyer->shipping_address);
            $address = Address::find($shipping_address->address);
            $city = City::find($address->city);
        } else {
            //creates an Address and that aren't save in the database
            $address = new Address();
            $address->street = " ";
            $address->residence_number = "";
            $address->zip_code = "";
            $address->country = "";
            $address->city = "";

            $city = new City();
            $city->name = "";
        }
        

        return view('pages.checkout', ['user' => $user, 'buyer' => $buyer, 'country' => $country, 'address' => $address, 'city' => $city, 'products' => $cart_prods, 'price' => $price]);
    }

    /**
     * Deletes an individual item from the cart.
     *
     */
    public function checkout_action(Request $request)
    {
        $user = Auth::user();

        $this->authorize('showPrivate', $user);

        //admins can't buy products
        if ($user->admin)
            return redirect('/');

        $validator = $this->shippingValidator($request->all());

        $extraValidator = $this->billingValidator($request->all());

        if($validator->fails() || $extraValidator->fails()){
            $errors = $validator->messages()->merge($extraValidator->messages());

            return redirect()->back()
                ->withErrors($errors)
                ->withInput();
        }


        DB::beginTransaction();

        try{
            $cart_prods = $user->buyer->cart;


            $prod_id = array();
            $prod_quantity = array();


            foreach($cart_prods as $product) {
                array_push($prod_id, $product->id);
                array_push($prod_quantity, $product->pivot->quantity);
            }

            $card = new Card();
            $card->name = $request->input('cc-name');
            $card->card_number = $request->input('cc-number');
            $card->card_type = $request->input('paymentMethod');
            $card->save();

            $buyer = DB::table('buyer')
                ->where('user_id', $user->id)
                ->first();

            $city = DB::table('city')->where('name', "=", $request->input('city'))->first();

            $country = DB::table('country')->where('name', "=", $request->input('country'))->first();

            if ($city == null) {
                //creates city
                $city = new City();
                $city->name = $request->input('city');
                $city->save();
            }

            //zip is unique
            $address = DB::table('address')->where('zip_code', "=", $request->input('zip'))->first();

            if ($address == null) {
                //creates Address
                $address = new Address();
                $address->street = $request->input('address');
                $address->residence_number = $request->input('residence_number');
                $address->zip_code = $request->input('zip');
                $address->country = $country->id;
                $address->city = $city->id;
                $address->additional_information = $request->input('address2');
                $address->save();
            }

            $shipping_address = null;
            $shipping_address = DB::table('shipping_address')->where('address', "=", $address->id)->first();
            if($shipping_address == null){
                $shipping_address = new Shipping_address();
                $shipping_address->address = $address->id;
                $shipping_address->save();
            }

            $billing_address = null;
            $billing_address = DB::table('billing_address')->where('address', "=", $address->id)->first();
            if($billing_address == null){
                $billing_address = new Billing_address();
                $billing_address->address = $address->id;
                $billing_address->save();
            }

            DB::table('buyer')->where('user_id', $user->id)
                ->update(
                    [
                        'shipping_address' => $shipping_address->id
                    ]
                );

            $purchase = new Purchase();
            $purchase->card = $card->id;
            $purchase->shipping_address = $shipping_address->id;
            $purchase->billing_address = $billing_address->id;
            $purchase->buyer = $buyer->id;

            if ($buyer->shipping_address == null)
                $purchase->billing_address =  $shipping_address->id;
            else $purchase->shipping_address =  $shipping_address->id;

            $purchase_status = new Purchase_status();
            $purchase_status->save();


            $purchase->status = $purchase_status->id;
            $dt = new DateTime(now()->addDays(3));
            $purchase->delivery_date = $dt->format('Y-m-d');

            $dtNow = new DateTime(now());
            $purchase->date = $dtNow->format('Y-m-d');
            $purchase->save();

            for($i = 0; $i < count($prod_id); $i = $i + 1){
                $purchased_product = new Purchased_product();
                $purchased_product->purchase = $purchase->id;
                $purchased_product->product = $prod_id[$i];
                $purchased_product->quantity = $prod_quantity[$i];
                $purchased_product->save();
            }


        }catch(\Exception $e) {
            DB::rollback();
            return redirect()->back();
            //throw $e;
        }

        DB::commit();

        return redirect('user/'.Auth::User()->id.'/purchase_history');
    }

    /**
     * Get a validator for an incoming request.
     *
     * @param array $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function billingValidator(array $data)
    {
        $data['paymentMethod'] = trim(htmlspecialchars($data['paymentMethod']));
        $data['cc-name'] = trim(htmlspecialchars($data['cc-name']));
        $data['phone_number'] = trim(htmlspecialchars($data['phone_number']));
        $data['cc-cvv'] = trim(htmlspecialchars($data['cc-cvv']));
        $data['cc-number'] = trim(htmlspecialchars($data['cc-number']));
        $data['cc-expiration'] = trim(htmlspecialchars($data['cc-expiration']));


        return Validator::make($data, [
            'paymentMethod' => 'required|in:Debit,Credit',
            'cc-name' => 'required|string|regex:/^[\pL\s-\d]+$/|max:255',
            'vat-number' => 'required|numeric|max:99999999999999999999',
            'cc-number' => 'required|numeric|max:99999999999999999999',
            'cc-expiration' => 'required|string|max:5',
            'cc-cvv' => 'required|integer|max:999',
        ]);
    }

    /**
     * Get a validator for an incoming request.
     *
     * @param array $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function shippingValidator(array $data)
    {
        $data['full_name'] = trim(htmlspecialchars($data['full_name']));
        $data['country'] = trim(htmlspecialchars($data['country']));
        $data['phone_number'] = trim(htmlspecialchars($data['phone_number']));
        $data['address'] = trim(htmlspecialchars($data['address']));
        $data['residence_number'] = trim(htmlspecialchars($data['residence_number']));
        $data['address2'] = trim(htmlspecialchars($data['address2']));
        $data['city'] = trim(htmlspecialchars($data['city']));
        $data['zip'] = trim(htmlspecialchars($data['zip']));


        return Validator::make($data, [
            'full_name' => 'required|string|regex:/^[\pL\s-\d]+$/|max:255',
            'country' => 'required|string|in:Portugal,Italy,Germany,Netherlands,Spain,France',
            'phone_number' => 'required|numeric',
            'address' => 'required|regex:/^[\pL\s-\d]+$/|max:255',
            'residence_number' => 'required|integer',
            'address2' => 'regex:/^[\pL\s-\d]+$/|max:255',
            'city' => 'required|alpha',
            'zip' => 'required|alpha_dash',
        ]);
    }

}
