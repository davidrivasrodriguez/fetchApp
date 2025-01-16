<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class ProductController extends Controller {

    function fetch() {
        return view('fetch');
    }

    public function index1() {
        return response()->json([
            'products' => Product::orderBy('name')->get()
        ]);
    }

    public function index() {
        return response()->json([
            'products' => Product::orderBy('name')->paginate(10)
        ]);
    }

    /*public function create() {
        //
    }*/

    public function store(Request $request) {
        $products = [];
        $validator = Validator::make($request->all(), [
            'name'  => 'required|unique:product|max:100|min:2',
            'price' => 'required|numeric|gte:0|lte:100000',
        ]);
        if ($validator->passes()) {
            $message = '';
            $object = new Product($request->all());
            try {
                $result = $object->save();
                $products = Product::orderBy('name')->paginate(10);
            } catch(\Exception $e) {
                $result = false;
                $message = $e->getMessage();
            }
        } else {
            $result = false;
            $message = $validator->getMessageBag();
        }
        return response()->json(['result' => $result, 'message' => $message, 'products' => $products]);
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
        $products = [];
        $result = false;
        if($product != null) {
            $validator = Validator::make($request->all(), [
                'name'  => 'required|max:100|min:2|unique:product,name,' . $product->id,
                'price' => 'required|numeric|gte:0|lte:100000',
            ]);
            if($validator->passes()) {
                try {
                    $result = $product->update($request->all());
                    $products = Product::orderBy('name')->paginate(10);
                } catch(\Exception $e) {
                    $message = $e->getMessage();
                }
            } else {
                $message = $validator->getMessageBag();
            }
        } else {
            $message = 'Product not found';
        }
        return response()->json(['result' => $result, 'message' => $message, 'products' => $products]);
    }

    public function destroy($id) {
        $message = '';
        $products = [];
        $product = Product::find($id);
        $result = false;
        $currentPage = request()->get('page', 1);
        
        if($product != null) {
            try {
                $result = $product->delete();
                
                // Get paginated products
                $products = Product::orderBy('name')->paginate(10);
                
                // If current page has no items and it's not the first page, 
                // get the previous page
                if ($products->count() === 0 && $currentPage > 1) {
                    $products = Product::orderBy('name')
                        ->paginate(10, ['*'], 'page', $currentPage - 1)
                        ->setPath(url('product'));
                } else {
                    $products->setPath(url('product'));
                }
    
            } catch(\Exception $e) {
                $message = $e->getMessage();
            }
        } else {
            $message = 'Product not found';
        }
        
        return response()->json([
            'message' => $message,
            'products' => $products,
            'result' => $result
        ]);
    }
}