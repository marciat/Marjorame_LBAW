<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Mail\ContactMail;
use Illuminate\Support\Facades\Mail;

class StaticPageController extends Controller {

    /**
     * R402: About Us [/about_us]
     */
    public function listAboutUs() {
        return view('pages.about_us');
    }

    /**
     * R403: Privacy Policy [/privacy_policy]
     */
    public function listPrivacyPolicy() {
        return view('pages.privacy_policy');
    }

    /**
     * R404: Contacts Form [/contacts]
     */
    public function listContacts() {
        return view('pages.contacts');
    }

    /**
     * R405: Contacts Form Action [/contacts]
     */
    public function sendContactsEmail(Request $request) {
        Mail::send(new ContactMail($request));
        return redirect('/');
    }

    /**
     * R406: Sell your Product Form [/sell_your_product]
     */
    public function listSellProduct() {
        return view('pages.sell_your_product');
    }

    /**
     * R407: Sell your Product Form Action [/sell_your_product]
     */
    public function SellProductAction() {

    }

}

?>
