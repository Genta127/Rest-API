<?php
//UTS
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

        return response()->json('Data Berhasil Disimpan')->setStatusCode(200);
    }

    function showAll(){
        $product = Product::All();

        return response()->json(['Data Produk Keselruhan', $product])->setStatusCode(200);
    }

    function showById($id){
        $product = Product::where('id', $id)->first();

        if($product){
            return response()->json(['Data Produk Dengan ID: '.$id, $product])->setStatusCode(200);
        }
        
        return response()->json('Data Dengan ID: '.$id.'Tidak ditemukan')->setStatusCode(404);

    }
    
    function showByName($name){
        $product = Product::where('name', 'LIKE', '%' .$name.'%')->get();

        if($product->count() > 0){
            return response()->json(['Data Produk Dengan Nama yang Mirip: ' .$name, $product])->setStatusCode(200);
        }

        return response()->json('Data Produk Dengan Nama Yang Mirip: ' .$name. ' Tidak Ditemukan')->setStatusCode(404);

    }

    public function update(Request $request, $id){
        $validator = Validator::make($request->All(),[
            'name' => 'required|max:100',
            'type' => 'required|in:makanan,minuman,makeup',
            'price' => 'required|numeric',
            'expired_at' => 'required|date'
        ]);

        if($validator->fails()) {
            return response()->json($validator->messages())-> setStatusCode(422);
        }

        $validated = $validator->validated();

        Product::where('id', $id)->update([
            'name' => $validated['name'],
            'type' => $validated['type'],
            'price'=> $validated['price'],
            'expired_at' => $validated['expired_at']

        ]);

        return response()->json('Data produk berhasil diubah')->setStatusCode(200);
    }

    public function delete($id){
        $product = Product::where('id', $id)->get();

        if($product){
            Product::where('id', $id)->delete();

            return response()->json('Data Produk dengan ID: ' .$id. ' Data Berhasil Dihapus')->setStatusCode(200);
        }
        return response()->json('Data dengan ID: ' .$id. ' Tidak Detemukan');
    }
    
}
