<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Models\Product;

class ProductController extends Controller
{
    public function store(Request $request){
        $validator = Validator::make($request->all(),[
            'name' => 'required|max:100',
            'type' => 'required|in:makanan,minuman,makeup',
            'price' => 'required|numeric',
            'expired_at' => 'required|date'
        ]);

        if($validator->fails()) {
            return response()->json($validator->messages())-> setStatusCode(422);
        }

        $validated = $validator->validated();
        Product::create([
            'name' => $validated['name'],
            'type' => $validated['type'],
            'price'=> $validated['price'],
            'expired_at' => $validated['expired_at']

        ]);

        return response()->json('data berhasil disimpan')->setStatusCode(201);
    }
        
}
