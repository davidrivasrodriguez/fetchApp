<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class ProductController extends Controller {

    function fetch() {
        return view('fetch');
    }

    public function index() {
        return response()->json([
            'products' => Product::orderBy('name')->get()
        ]);
    }

    /*public function create() {
        //
    }*/

    public function store(Request $request) {
        $validator = Validator::make($request->all(), [
            'name'  => 'required|unique:product|max:100|min:2',
            'price' => 'required|numeric|gte:0|lte:100000',
        ]);
        if ($validator->passes()) {
            $message = '';
            $object = new Product($request->all());
            try {
                $result = $object->save();
            } catch(\Exception $e) {
                $result = false;
                $message = $e->getMessage();
            }
        } else {
            $result = false;
            $message = $validator->getMessageBag();
        }
        return response()->json(['result' => $result, 'message' => $message]);
    }

    public function show($id) {
        $product = Product::find($id);
        $message = '';
        if($product === null) {
            $message = 'Product not found.';
        }
        return response()->json([
            'message' => $message,
            'product' => $product
        ]);
    }

    /*public function edit(Product $product) {
        //
    }*/

    public function update(Request $request, $id) {
        $message = '';
        $product = Product::find($id);
        $result = false;
        if($product != null) {
            $validator = Validator::make($request->all(), [
                'name'  => 'required|max:100|min:2|unique:product,name,' . $product->id,
                'price' => 'required|numeric|gte:0|lte:100000',
            ]);
            if($validator->passes()) {
                try {
                    $result = $product->update($request->all());
                } catch(\Exception $e) {
                    $message = $e->getMessage();
                }
            } else {
                $message = $validator->getMessageBag();
            }
        } else {
            $message = 'Product not found';
        }
        return response()->json(['result' => $result, 'message' => $message]);
    }

    public function destroy($id) {
        $message = '';
        $product = Product::find($id);
        $result = false;
        if($product != null) {
            try {
                $result = $product->delete();
            } catch(\Exception $e) {
                $message = $e->getMessage();
            }
        } else {
            $message = 'Product not found';
        }
        return response()->json(['result' => $result, 'message' => $message]);
    }
}