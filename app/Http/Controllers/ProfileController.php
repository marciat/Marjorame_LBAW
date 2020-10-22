<?php

namespace App\Http\Controllers;

use App\Address;
use App\City;
use App\Country;
use App\Shipping_address;
use App\User;
use App\Buyer;
use App\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class ProfileController extends Controller
{

    /**
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function user_profile($id)
    {

        $user = User::findOrFail($id);

        $this->authorize('showPublic', $user);

        $buyer = DB::table('buyer')
            ->where('user_id', $id)
            ->first();

        if ($user->admin)
            return redirect('/');

        if ($buyer->country_id != null)
            $country = Country::find($buyer->country_id);
        else {
            $country = new Country();
            $country->name = " ";
        }

        return view('pages.public_profile', ['user' => $user, 'buyer' => $buyer, 'country' => $country]);
    }

    /**
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function edit_profile($id)
    {

        $user = User::findOrFail($id);

        $this->authorize('showPrivate', $user);

        $buyer = DB::table('buyer')
            ->where('user_id', $id)
            ->first();

        if ($buyer->country_id != null)
            $country = Country::find($buyer->country_id);
        else {
            $country = new Country();
            $country->name = " ";
        }

        if ($buyer->shipping_address != null) {
            $shipping_address = Shipping_address::find($buyer->shipping_address);
            $address = Address::find($shipping_address->address);
            $city = City::find($address->city);
        } else {
            //creates an Address and that aren't save in the database
            $address = new Address();
            $address->street = " ";
            $address->residence_number = " ";
            $address->zip_code = " ";
            $address->country = " ";
            $address->city = " ";

            $city = new City();
            $city->name = " ";
        }

        return view('pages.user_profile', ['user' => $user, 'buyer' => $buyer, 'country' => $country, 'address' => $address, 'city' => $city]);
    }

    /**
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function edit_profile_action(Request $request)
    {

        $user = Auth::user();

        $this->authorize('showPrivate', $user);

        if(array_key_exists('username', $request->all()) || array_key_exists('user_email', $request->all()))
            return redirect()->back()
                ->withErrors('user_email',$request->input('user_email'))
                ->withErrors('username',$request->input('username'))
                ->withInput();

        $validator = $this->profileValidator($request->all());

        if($validator->fails()){
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }


        //username and email can't be change
        $user->first_name = $request->input('first_name');
        $user->last_name = $request->input('last_name');
        $user->save();

        $country = DB::table('country')->where('name', $request->input('country'))->first();

        DB::table('buyer')->where('user_id', $user->id)
            ->update(
                [
                    'phone_number' => $request->input('user_phone'),
                    'country_id' => $country->id
                ]
            );

        $buyer = DB::table('buyer')->where('user_id', $user->id)->first();

        if ($buyer->country_id != null)
            $country = Country::find($buyer->country_id);
        else {
            $country = new Country();
            $country->name = " ";
        }

        if ($buyer->shipping_address != null) {
            $shipping_address = Shipping_address::find($buyer->shipping_address);
            $address = Address::find($shipping_address->address);
            $city = City::find($address->city);
        } else {
            //creates an Address and that aren't save in the database
            $address = new Address();
            $address->street = "";
            $address->residence_number = "";
            $address->zip_code = "";
            $address->country = "";
            $address->city = "";

            $city = new City();
            $city->name = " ";
        }

        return redirect('user/'.$user->id.'/edit_profile')
                        ->with('success_profile', 'User Profile edited successfully');
    }

    /**
     * Get a validator for an incoming request.
     *
     * @param array $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function profileValidator(array $data)
    {
        $data['first_name'] = trim(htmlspecialchars($data['first_name']));
        $data['last_name'] = trim(htmlspecialchars($data['last_name']));
        $data['country'] = trim(htmlspecialchars($data['country']));
        $data['user_phone'] = trim(htmlspecialchars($data['user_phone']));


        return Validator::make($data, [
            'first_name' => 'required|string|alpha|max:255',
            'last_name' => 'required|string|alpha|max:255',
            'country' => 'required|string|in:Portugal,Italy,Germany,Netherlands,Spain,France',
            'user_phone' => 'required|numeric',
        ]);
    }

    /**
     * Get a validator for an incoming request.
     *
     * @param array $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function addressValidator(array $data)
    {

        $data['vat_number'] = trim(htmlspecialchars($data['vat_number']));
        $data['user_address'] = trim(htmlspecialchars($data['user_address']));
        $data['country_address'] = trim(htmlspecialchars($data['country_address']));
        $data['user_residence_number'] = trim(htmlspecialchars($data['user_residence_number']));
        $data['address2'] = trim(htmlspecialchars($data['address2']));
        $data['user_city'] = trim(htmlspecialchars($data['user_city']));
        $data['user_zip'] = trim(htmlspecialchars($data['user_zip']));


        return Validator::make($data, [
            'vat_number' => 'required|numeric|max:99999999999999999999',
            'user_address' => 'required|regex:/^[\pL\s-\d]+$/|max:255',
            'country_address' => 'required|string|in:Portugal,Italy,Germany,Netherlands,Spain,France',
            'user_residence_number' => 'required|integer',
            'address2' => 'regex:/^[\pL\s-\d]+$/|max:255',
            'user_city' => 'required|alpha',
            'user_zip' => 'required|alpha_dash',
        ]);
    }

    /**
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function edit_address_profile_action(Request $request)
    {

        $user = Auth::user();

        $this->authorize('showPrivate', $user);

        $validator = $this->addressValidator($request->all());

        if($validator->fails()){
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        $country = DB::table('country')->where('name', $request->input('country_address'))->first();

        DB::table('buyer')->where('user_id', $user->id)
            ->update(
                [
                    'vat' => $request->input('vat_number')
                ]
            );

        $buyer = DB::table('buyer')->where('user_id', $user->id)->first();

        if (!is_null($buyer->shipping_address)) {
            $shipping_address = Shipping_address::find($buyer->shipping_address);
            //address in shipping_address can not be null
            $address = Address::find($shipping_address->address);
            //city in address can not be null
            $city = City::find($address->city);

            DB::table('address')->where('id', $shipping_address->address)
                ->update(
                    [
                        'street' => $request->input('user_address'),
                        'residence_number' => $request->input('user_residence_number'),
                        'zip_code' => $request->input('user_zip'),
                        'country' => $country->id,
                        'additional_information' => $request->input('address2')
                    ]
                );


            DB::table('city')->where('id', $address->city)
                ->update(
                    [
                        'name' =>  $request->input('user_city')
                    ]
                );
                
        } else {

            $city = DB::table('city')->where('name', $request->input('user_city'))->first();

            if ($city == null) {
                //creates city
                $city = new City;
                $city->name = $request->input('user_city');
                $city->save();
            }

            //creates Address
            $address = new Address();
            $address->street = $request->input('user_address');
            $address->residence_number = $request->input('user_residence_number');
            $address->zip_code = $request->input('user_zip');
            $address->country = $country->id;
            $address->city = $city->id;
            $address->additional_information = $request->input('address2');
            $address->save();

            $shipping_address = new Shipping_address();
            $shipping_address->address = $address->id;
            $shipping_address->save();

            DB::table('buyer')->where('user_id', $user->id)
                ->update(
                    [
                        'shipping_address' => $shipping_address->id
                    ]
                );
        }

        return redirect('user/'.$user->id.'/edit_profile')
                        ->with('success_address', 'Address edited successfully');
    }

    /**
     * shows deactivate account page
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function deactivate_account($id)
    {
        $user = User::findOrFail($id);

        $this->authorize('showPrivate', $user);

        return view('pages.deactivate_account', ['user' => $user]);
    }

    /**
     * Delete account is an action that updates instead of delete all data of the user
     * It removes the picture_id, first and last name and the address
     * It doesn't remove username and email to prevent it's been reused
     * And doesn't remove vat for legal reasons
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function delete_account(Request $request)
    {

        $user = Auth::user();

        $this->authorize('showPrivate', $user);

        if (!(Hash::check($request->get('password'), Auth::user()->password))) {
            return redirect()->back()
                ->with("password-error", "Wrong password input.")
                ->with('error_code', 'bad_delete');;
        }

        DB::table('buyer')->where('user_id', $user->id)
            ->update(
                [
                    'status' => 'Deleted'
                ]
            );


        //if the update is successful, logout and go back to main
        Auth::logout();
        return redirect('/');
    }

    /**
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function deactivate_account_action(Request $request)
    {

        $user = Auth::user();

        $this->authorize('showPrivate', $user);


        if (!(Hash::check($request->get('password'), Auth::user()->password))) {
            return redirect()->back()
                ->with("password-error", "Wrong password input.")
                ->with('error_code', 'bad_deactivate');;
        }

        DB::table('buyer')->where('user_id', $user->id)
            ->update(
                [
                    'status' => 'Deactivated'
                ]
            );


        //if the update is successful, logout and go back to main
        Auth::logout();
        return redirect('/');
    }

    /**
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function review_history($id)
    {

        $user = User::findOrFail($id);

        $this->authorize('showPublic', $user);

        if ($user->admin || !Auth::check())
            return redirect('/');

        $products = $user->buyer->review()->paginate(10);

        return view('pages.review_history', ['user' => $user, 'products' => $products]);
    }

    /**
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function purchase_history($id)
    {
        $user = User::findOrFail($id);

        $this->authorize('showOwnerAdmin', $user);

        $purchases = $user->buyer->purchases()->paginate(5);

        return view('pages.purchase_history', ['user' => $user, 'purchases' => $purchases]);
    }
}
