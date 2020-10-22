<?php

namespace App\Http\Controllers;

use App\User;
use App\Color;
use App\Extra_characteristic;
use App\Photo;
use App\Product;
use App\Category;
use App\Product_category;
use App\Product_color;
use App\Product_photo;
use App\Product_size;
use App\Review;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;

class ManagementController extends Controller
{

    public function add_product()
    {
        $this->authorize('showAdmin', User::class);

        return view('pages.add_product');
    }

    public function add_product_action(Request $request)
    {
        $this->authorize('showAdmin', User::class);

        $validator = $this->productValidator($request->all());

        $extraValidator = $this->extraValidator($request->all());

        if($validator->fails() || $extraValidator->fails()){
            $errors = $validator->messages()->merge($extraValidator->messages());

            return redirect()->back()
                ->withErrors($errors)
                ->withInput();
        }

        $extra = false;

        if(!empty($request->all()['option_title'])){
            $extra = true;
        }


        $photoArray = $my_array = array_fill(0, 5, null);
        $pathArray = array();

        DB::beginTransaction();

        try{
            $i = 0;
            foreach ($request->all()['files'] as $file){
                $storage_path_name = Storage::putFile('public/images/products', $file);
                $file_name = substr($storage_path_name, strrpos($storage_path_name, '/') + 1);
                $image_path = 'images/products/'.$file_name;
                array_push($pathArray, $storage_path_name);
                $photo = Photo::create([
                    'src' => $image_path,
                ]);


                $product_photo = Product_photo::create([
                    'photo_id' => $photo->id
                ])->id;
                $photoArray[$i] =  $product_photo;
                $i = $i + 1;
            }


            $category = DB::table('category')
                ->where('category', '=', trim(htmlspecialchars($request->input('product_category'))))
                ->get()[0]->id;

            $sub_category = DB::table('category')
                ->where('category', '=', trim(htmlspecialchars($request->input('product_subcategory'))))
                ->get()[0]->id;

            $sub_category2 = null;
            if($request->input('product_subcategory2') != null){
                $sub_category2 = DB::table('category')
                    ->where('category', '=', trim(htmlspecialchars($request->input('product_subcategory2'))))
                    ->get()[0]->id;
            }

            if($sub_category2 != null){
                $product_category = DB::table('product_category')
                    ->where('category', '=', $category)
                    ->where('subcategory1', '=', $sub_category)
                    ->where('subcategory2', '=', $sub_category2)
                    ->get()[0]->id;
            }else{
                $product_category = DB::table('product_category')
                    ->where('category', '=', $category)
                    ->where('subcategory1', '=', $sub_category)
                    ->get()[0]->id;
            }

            $extraId = null;

            if($extra){
                $option3 = null;
                $option4 = null;
                if(!empty($request->input('option_3'))){
                    $option3 = trim(htmlspecialchars($request->input('option_3')));
                }
                if(!empty($request->input('option_4'))){
                    $option4 = trim(htmlspecialchars($request->input('option_4')));
                }

                $extraId = Extra_characteristic::create([
                    'name' => trim(htmlspecialchars($request->input('option_title'))),
                    'option1' => trim(htmlspecialchars($request->input('option_1'))),
                    'option2' => trim(htmlspecialchars($request->input('option_2'))),
                    'option3' => $option3,
                    'option4' => $option4,
                ])->id;
            }

            $product = Product::create([
                'name' => trim(htmlspecialchars($request->input('product_name'))),
                'description' => trim(htmlspecialchars($request->input('product_description_textbox'))),
                'price' => trim(htmlspecialchars($request->input('product_price'))),
                'stock' => 100000,
                'extra_characteristic_id' => $extraId,
                'category_id' => $product_category,
                'photo_id' => $photoArray[0],
                'photo2_id' => $photoArray[1],
                'photo3_id' => $photoArray[2],
                'photo4_id' => $photoArray[3],
                'photo5_id' => $photoArray[4],
            ]);

            $productId = $product->id;



            if(!is_null($request->input('product_size'))) {
                for ($i = 0; $i < count($request->input('product_size')); $i++) {
                    $sizeId = null;

                    $size = DB::table('size')
                        ->where('size', '=', trim(htmlspecialchars($request->input('product_size')[$i])))
                        ->get();

                    $sizeId = $size[0]->id;

                    Product_size::create([
                        'size_id' => $sizeId,
                        'product_id' => $productId,
                    ]);
                }
            }

            if(!is_null($request->input('product_color'))) {
                for ($i = 0; $i < count($request->input('product_color')); $i++) {

                    $colorId = null;
                    $color = DB::table('color')
                        ->where('color', '=', trim(htmlspecialchars($request->input('product_color')[$i])))
                        ->get();

                    if(count($color) > 0){
                        $colorId = $color[0]->id;
                    }else{
                        $colorId = Color::create([
                            'color' => trim(htmlspecialchars($request->input('product_color'))),
                        ])->id;
                    }

                    Product_color::create([
                        'color_id' => $colorId,
                        'product_id' => $productId,
                    ]);
                }
            }


            $colorId = null;
            if($request->input('product_color_other') != null) {
                $color = DB::table('color')
                    ->where('color', '=',  ucwords(strtolower(trim(htmlspecialchars($request->input('product_color_other'))))))
                    ->get();

                if(count($color) > 0){
                    $colorId = $color[0]->id;
                }else{
                    $colorId = Color::create([
                        'color' =>  ucwords(strtolower(trim(htmlspecialchars($request->input('product_color_other'))))),
                    ])->id;
                }

                Product_color::create([
                    'color_id' => $colorId,
                    'product_id' => $productId,
                ]);
            }


        }catch(\Exception $e) {
            foreach ($pathArray as $path) {
                Storage::disk('local')->delete($path);
            }
            DB::rollback();
            return redirect()->back();
        }

        DB::commit();

        return redirect('/product/'.$productId);
    }


    /**
     * Get a validator for an incoming request.
     *
     * @param array $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function productValidator(array $data)
    {

        $data['product_name'] = trim(htmlspecialchars($data['product_name']));
        $data['product_description_textbox'] = trim(htmlspecialchars($data['product_description_textbox']));
        $data['product_price'] = trim(htmlspecialchars($data['product_price']));
        $data['product_category'] = trim(htmlspecialchars($data['product_category']));
        $data['product_subcategory'] = trim(htmlspecialchars($data['product_subcategory']));

        if (array_key_exists('product_subcategory2',$data))
            $data['product_subcategory2'] = trim(htmlspecialchars($data['product_subcategory2']));
        if (array_key_exists('product_color_other',$data))
            $data['product_color_other'] = ucwords(strtolower(trim(htmlspecialchars($data['product_color_other']))));

        if(array_key_exists('product_size', $data))
            if(!is_null($data['product_size'])){
                for($i = 0; $i < count($data['product_size']); $i++){
                    $data['product_size'][$i] = trim(htmlspecialchars($data['product_size'][$i]));
                }
            }


        if(array_key_exists('product_color', $data))
            if(!is_null($data['product_color'])){
                for($i = 0; $i < count($data['product_color']); $i++){
                    $data['product_color'][$i] = trim(htmlspecialchars($data['product_color'][$i]));
                }
            }

        return Validator::make($data, [
            'product_name' => 'required|string|regex:/^[\pL\s-\d]+$/|max:50|unique:product,name',
            'product_description_textbox' => 'required|string|regex:/^[\pL\s-\d]+$/|max:500',
            'product_price' => 'required|digits_between:1,10000000',
            'product_category' => 'required|string',
            'product_subcategory' => 'required|string',
            'product_subcategory2' => 'string|nullable',
            'product_color.*' => 'string|nullable|regex:/^[\pL\s-]+$/',
            'product_color_other' => 'string|not_in:Black,White,Brown,Blue,Red,Green|nullable|regex:/^[\pL\s-]+$/',
            'product_size.*' => 'string|alpha_dash|nullable',
            'files' => 'min:1|max:5|array|required',
            'files.*' => 'image|mimes:jpg,jpeg,png|max:10000',
        ]);
    }

    /**
     * Get a validator for an incoming request.
     *
     * @param array $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function extraValidator(array $data){

        $extra = false;

        if (array_key_exists('option_title',$data))
            $data['option_title'] = trim(htmlspecialchars($data['option_title']));
        if (array_key_exists('option_1',$data))
            $data['option_1'] = trim(htmlspecialchars($data['option_1']));
        if (array_key_exists('option_2',$data))
            $data['option_2'] = trim(htmlspecialchars($data['option_2']));
        if (array_key_exists('option_3',$data))
            $data['option_3'] = trim(htmlspecialchars($data['option_3']));
        if (array_key_exists('option_4',$data))
            $data['option_4'] = trim(htmlspecialchars($data['option_4']));

        if(!empty($data['option_title'])){
            $extra = true;
        }

        if($extra){
            $validator = Validator::make($data, [
                'option_title' => 'string|regex:/^[\pL\s-\d]+$/|max:50|required|different:option_1,option_2,option_3,option_4',
                'option_1' => 'string|regex:/^[\pL\s-\d]+$/|max:50|required|different:option_title,option_2,option_3,option_4',
                'option_2' => 'string|regex:/^[\pL\s-\d]+$/|max:50|required|different:option_1,option_title,option_3,option_4',
                'option_3' => 'string|regex:/^[\pL\s-\d]+$/|max:50|nullable|different:option_1,option_2,option_title,option_4',
                'option_4' => 'string|regex:/^[\pL\s-\d]+$/|max:50|nullable|different:option_1,option_2,option_3,option_title',
            ]);
        }else{
            $validator = Validator::make($data, [
                'option_title' => 'string|regex:/^[\pL\s-\d]+$/|max:50|nullable',
                'option_1' => 'string|regex:/^[\pL\s-\d]+$/|max:50|nullable',
                'option_2' => 'string|regex:/^[\pL\s-\d]+$/|max:50|nullable',
                'option_3' => 'string|regex:/^[\pL\s-\d]+$/|max:50|nullable',
                'option_4' => 'string|regex:/^[\pL\s-\d]+$/|max:50|nullable',
            ]);
        }


         return $validator;
    }

    public function product(Request $request, $id)
    {
        return view('pages.product');
    }

    /**
     * View users
     */
    public function control_users()
    {
        $this->authorize('showAdmin', User::class);
        $users = User::paginate(20);

        return view('pages.admin_controls', ['users' => $users]);
    }

    public function ban_users()
    {
        return view('pages.admin_controls');
    }

    public function delete_product($id)
    {
        $product = Product::find($id);

        $this->authorize('delete', $product);
        $product->delete();

        return $product;
    }

    public function edit_review(Request $request, $id){
        $review = Review::findOrFail($id);
        $this->authorize('reviewer', [Review::class, $review]);


        $updateResult = DB::table('review')
        ->where('id', $id)
        ->update(
            [
            'rating' => $request->input('rating'),
            'title' => $request->input('title'),
            'description' => $request->input('description')
            ]
        );

        if ($updateResult == 0) {
            return response('', 500)->header('Content-Type', 'text/plain');
        } else {
            return response('', 200)->header('Content-Type', 'text/plain');
        }
    }

    public function ban_user(Request $request, $buyer_id){
        $this->authorize('showAdmin', User::class);

        $updateResult = DB::table('buyer')
                        ->where('id',$buyer_id)
                        ->update(['status' => 'Banned']);
        
        if($updateResult == 0){
            return response('', 500)->header('Content-Type', 'text/plain');
        } else {
            return response('', 200)->header('Content-Type', 'text/plain');
        }
    }

    public function unban_user(Request $request, $buyer_id){

        $this->authorize('showAdmin', User::class);

        $updateResult = DB::table('buyer')
                        ->where('id',$buyer_id)
                        ->update(['status' => 'Active']);
        
        if($updateResult == 0){
            return response('', 500)->header('Content-Type', 'text/plain');
        } else {
            return response('', 200)->header('Content-Type', 'text/plain');
        }
    }

    public function get_users(Request $request){
        $this->authorize('showAdmin', User::class);

        $users = User::paginate(15);

        return view('partials.adminOptions', ['users' => $users]);
    }
}

?>