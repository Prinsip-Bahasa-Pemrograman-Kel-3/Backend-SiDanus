<?php

namespace App\Http\Controllers\api\Products;

use Illuminate\Support\Facades\DB;
use Illuminate\Routing\Controller;
use Illuminate\Http\Request;
use App\Models\ProductImage;
use App\Models\Product;
use App\Helpers\APIFormatter;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;



class ProductImageController extends Controller
{
    protected function makeFullImageUrl($imagePath)
    {
        return url('storage/' .$imagePath);
    }

    public function index()
    {
        try {
            $product_images = ProductImage::all();
            if ($product_images->isEmpty()) {
                return APIFormatter::createAPI(200, 'success', 'Product Images not found', null);
            }

            // Konversi setiap path image ke URL lengkap
            $product_images = $product_images->map(function ($product_image) {
                $product_image->image = $this->makeFullImageUrl($product_image->image);
                return $product_image;
            });

            return APIFormatter::createAPI(200, 'success', 'Product Images found', $product_images);
        } catch (\Throwable $th) {
            return APIFormatter::createAPI(400, 'error', 'Failed to get product images', Log::error($th->getMessage()));
        }
    }

    public function show($id)
    {
        try {
            $product_image = ProductImage::find($id);
            if (!$product_image) {
                return APIFormatter::createAPI(200, 'success', 'Product Image not found', null);
            }

            // Konversi path image ke URL lengkap
            $product_image->image = $this->makeFullImageUrl($product_image->image);

            return APIFormatter::createAPI(200, 'success', 'Product Image found', $product_image);
        } catch (\Throwable $th) {
            return APIFormatter::createAPI(400, 'error', 'Failed to get product image', Log::error($th->getMessage()));
        }
    }

    public function store(Request $request)
    {
        DB::beginTransaction();
        try {
            $request->validate([
                'product_id' => 'required|exists:products,id',
                'images' => 'required|array',
                'images.*' => 'image|mimes:jpeg,png,jpg,svg|max:50000'
            ]);

            $product =  Product::find($request->product_id);
            if (!$product) {
                return APIFormatter::createAPI(200, 'success', 'Product not found', null);
            }

            $product_name = preg_replace('/[^a-zA-Z0-9_-]/', '', str_replace(' ', '_', strtolower($product->name)));

            $images = $request->file('images');
            $storedImages = [];
            $destinationPath = 'product_images/' . $product_name;

            if (is_array($images)) {
                foreach ($images as $image) {
                    $fileName = uniqid() . '.' . $image->getClientOriginalExtension();
                    $path = $image->storeAs($destinationPath, $fileName, 'public');

                    if (!$path) {
                        throw new \Exception("Failed to store image.");
                    }

                    $product_image = ProductImage::create([
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
            return APIFormatter::createAPI(400, 'fail', 'Failed to create product images', Log::error($e->getMessage()));
        }
    }

    public function update(Request $request, $id)
    {
        DB::beginTransaction();
        try {
            $request->validate([
                'product_id' => 'required|exists:products,id',
                'images.*' => 'image|mimes:jpeg,png,jpg,svg|max:1024'
            ]);

            $product_images = ProductImage::where('product_id', $id)->get();
            if ($product_images->isEmpty()) {
                return APIFormatter::createAPI(200, 'success', 'Product Image not found', null);
            }

            // Delete existing images
            foreach ($product_images as $product_image) {
                Storage::delete('public/' . $product_image->image);
                $product_image->delete();
            }

            $product =  Product::find($request->product_id);
            if (!$product) {
                return APIFormatter::createAPI(200, 'success', 'Product not found', null);
            }

            $product_name = preg_replace('/[^a-zA-Z0-9_-]/', '', str_replace(' ', '_', strtolower($product->name)));

            // Store new images
            $newImages = $request->file('images');
            $saved_images = [];
            $destinationPath = 'product_images/' . $product_name;

            foreach ($newImages as $image) {
                $fileName = uniqid() . '.' . $image->getClientOriginalExtension();
                $path = $image->storeAs($destinationPath, $fileName, 'public');

                if (!$path) {
                    throw new \Exception("Failed to store image.");
                }

                $product_image = ProductImage::create([
                    'product_id' => $request->product_id,
                    'image' => $path
                ]);
                $saved_images[] = $product_image;
            }

            DB::commit();
            return APIFormatter::createAPI(200, 'success', 'Product Image updated', $saved_images);
        } catch (\Throwable $e) {
            DB::rollBack();
            return APIFormatter::createAPI(400, 'fail', 'Failed to update product image', Log::error($e->getMessage()));
        }
    }

    public function destroy($id)
    {
        DB::beginTransaction();
        try {
            $product_images = ProductImage::where('product_id', $id)->get();
            if ($product_images->isEmpty()) {
                return APIFormatter::createAPI(200, 'success', 'Product Image not found', null);
            }

            foreach ($product_images as $product_image) {
                Storage::delete('public/' . $product_image->image);
                $product_image->delete();
            }

            DB::commit();
            return APIFormatter::createAPI(200, 'success', 'Product Image deleted', null);
        } catch (\Throwable $e) {
            DB::rollBack();
            return APIFormatter::createAPI(400, 'fail', 'Failed to delete product image', Log::error($e->getMessage()));
        }
    }
}
