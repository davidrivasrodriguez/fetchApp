<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;


class Product extends Model
{
    protected $table = 'product';

    protected $fillable = ['name', 'price'];

    function store() {
        try {
            $result = $this->save();
        } catch(\Exception $e) {
            $result = false;
        }
        return $result;
    }

    function modify($request) {
        $result = false;
        try {
            $result = $this->update($request->all());
        } catch(\Exception $e) {
        }
        return $result;
    }

    static function change($request) {
        $product = new Product($request->all());
        return $product->store();
    }
}