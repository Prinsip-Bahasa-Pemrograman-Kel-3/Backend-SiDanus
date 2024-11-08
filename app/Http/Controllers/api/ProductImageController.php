<?php

namespace App\Http\Controllers\api;

use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Product_Image;
use App\Helpers\APIFormatter;
use Illuminate\Support\Facades\Storage;

class ProductImageController extends Controller
{
    public function index()
    {
        try {
            $product_images = Product_Image::all();
            if ($product_images->isEmpty()) {
                return APIFormatter::createAPI(200, 'success', 'Product Images not found', null);
            }
            return APIFormatter::createAPI(200, 'success', 'Product Images found', $product_images);
        } catch (\Throwable $th) {
            return APIFormatter::createAPI(400, 'error', 'Failed to get product images', $th->getMessage());
        }
    }

    public function show($id)
    {
        try {
            $product_image = Product_Image::find($id);
            if (!$product_image) {
                return APIFormatter::createAPI(200, 'success', 'Product Image not found', null);
            }
            return APIFormatter::createAPI(200, 'success', 'Product Image found', $product_image);
        } catch (\Throwable $th) {
            return APIFormatter::createAPI(400, 'error', 'Failed to get product image', $th->getMessage());
        }
    }

    public function store(Request $request)
    {
        $request->validate([
            'product_id' => 'required|exists:products,id',
            'images' => 'required|array',
            'images.*' => 'image|mimes:jpeg,png,jpg,svg|max:2048'
        ]);

        DB::beginTransaction();
        try {
            $images = $request->file('images');
            $storedImages = [];

            if (is_array($images)) {
                foreach ($images as $image) {
                    $fileName = time() . '_' . $image->getClientOriginalName();
                    $destinationPath = public_path('storage/product_images');
                    $image->move($destinationPath, $fileName);
                    $path = 'storage/product_images/' . $fileName;
                    if (!file_exists($destinationPath . '/' . $fileName)) {
                        throw new \Exception("Failed to store image.");
                    }
                    $product_image = Product_Image::create([
                        'product_id' => $request->product_id,
                        'image' => $path
                    ]);

                    $storedImages[] = $product_image;
                }
            } else {
                return APIFormatter::createAPI(400, 'fail', 'Invalid image data', null);
            }

            DB::commit();
            return APIFormatter::createAPI(201, 'success', 'Product Images created', $storedImages);
        } catch (\Throwable $e) {
            DB::rollBack();
            return APIFormatter::createAPI(400, 'fail', 'Failed to create product images', $e->getMessage());
        }
    }
    public function update(Request $request, $id)
    {
        $request->validate([
            'product_id' => 'required|exists:products,id',
            'image.*' => 'image|mimes:jpeg,png,jpg,svg|max:2048'
        ]);
        $product_images = Product_Image::where('product_id', $id)->get();
        if (!$product_images) {
            return APIFormatter::createAPI(200, 'success', 'Product Image not found', null);
        }
        DB::beginTransaction();
        try {
            foreach ($product_images as $product_image) {
                Storage::delete($product_image->image);
                $product_image->delete();
            }
            $newImages = $request->file('images');
            $saved_images = [];

            foreach ($newImages as $image) {
                $fileName = time() . '_' . $image->getClientOriginalName();
                $destinationPath = public_path('storage/product_images');
                $image->move($destinationPath, $fileName);
                $path = 'storage/product_images/' . $fileName;
                if (!file_exists($destinationPath . '/' . $fileName)) {
                    throw new \Exception("Failed to store image.");
                }
                $product_image = Product_Image::create([
                    'product_id' => $request->product_id,
                    'image' => $path
                ]);
                $saved_images[] = $product_image;
            }
            DB::commit();
            return APIFormatter::createAPI(200, 'success', 'Product Image updated', $product_image);
        } catch (\Throwable $e) {
            DB::rollBack();
            return APIFormatter::createAPI(400, 'fail', 'Failed to update product image', $e->getMessage());
        }
    }

    public function destroy($id)
    {
        $product_images = Product_Image::where('product_id', $id)->get();
        if (!$product_images) {
            return APIFormatter::createAPI(200, 'success', 'Product Image not found', null);
        }
        DB::beginTransaction();
        try {
            foreach ($product_images as $product_image) {
                Storage::delete($product_image->image);
                $product_image->delete();
            }
            DB::commit();
            return APIFormatter::createAPI(200, 'success', 'Product Image deleted', null);
        } catch (\Throwable $e) {
            DB::rollBack();
            return APIFormatter::createAPI(400, 'fail', 'Failed to delete product image', $e->getMessage());
        }
    }
}
