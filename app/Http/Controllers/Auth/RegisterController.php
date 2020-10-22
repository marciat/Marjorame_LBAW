<?php

namespace App\Http\Controllers\Auth;

use App\Buyer;
use App\Http\Controllers\Controller;
use App\Photo;
use App\Profile_picture;
use App\User;
use Auth;
use Illuminate\Auth\Events\Registered;
use Illuminate\Foundation\Auth\RegistersUsers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class RegisterController extends Controller {
    /*
    |--------------------------------------------------------------------------
    | Register Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles the registration of new users as well as their
    | validation and creation. By default this controller uses a trait to
    | provide this functionality without requiring any additional code.
    |
    */

    use RegistersUsers;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct() {
        $this->middleware('guest');
    }

    /**
     * Where to redirect users after registration.
     *
     * @var string
     */
    public function redirectTo() {
        $user = Auth::user();
        return '/user/' . $user->id;
    }

    public function register(Request $request) {

        $validator = $this->validator($request->all());

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput()
                ->with('error_code', 'bad_register');
        }

        $validator->validate();

        event(new Registered($user = $this->create($request->all())));

        $this->guard()->login($user);

        return $this->registered($request, $user)
            ?: redirect($this->redirectPath());
    }

    /**
     * Get a validator for an incoming registration request.
     *
     * @param array $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function validator(array $data) {

        $data['register_password'] = trim(htmlspecialchars($data['register_password']));
        $data['register_email'] = trim(htmlspecialchars($data['register_email']));

        $validator = Validator::make($data, [
            'register_username' => 'required|string|alpha_dash|min:3|max:10|unique:user,username',
            'first_name' => 'required|string|alpha|max:255',
            'last_name' => 'required|string|alpha|max:255',
            'register_email' => 'required|string|email:filter|max:255|unique:user,email',
            'birthdate' => 'required|date|date_format:"Y-m-d|before:' . now()->subDays(5844)->setTime(0, 0, 0),
            'register_password' => 'required|string|min:6|confirmed',
        ]);

        return $validator;
    }

    /**
     * Create a new user instance after a valid registration.
     *
     * @param array $data
     * @return User
     * @throws \Exception
     */
    protected function create(array $data) {

        DB::beginTransaction();

        try{
            $user = User::create([
                'username' => $data['register_username'],
                'password' => bcrypt($data['register_password']),
                'first_name' => $data['first_name'],
                'last_name' => $data['last_name'],
                'email' => $data['register_email'],
                'date_of_birth' => $data['birthdate'],
            ]);

            $photo = Photo::create();

            $user_picture = Profile_picture::create([
                'photo_id' => $photo->id,
            ]);

            Buyer::create([
                'user_id' => $user->id,
                'status' => 'Active',
                'picture_id' => $user_picture->id,
            ]);
        }catch(\Exception $e)
        {
            DB::rollback();
            throw $e;
        }

        DB::commit();

        return $user;
    }

}
