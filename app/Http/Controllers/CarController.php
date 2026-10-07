<?php

namespace App\Http\Controllers;

use App\Car;
use App\CarImage;
use App\Helpers\CarHelper;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Intervention\Image\Facades\Image;


class CarController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return Car[]|\Illuminate\View\View
     */
    public function index()
    {
        $allCars = Car::orderBy('new', 'DESC')
            ->orderBy('created_at', 'DESC')
            ->get();
        return view('main', [
            'cars' => $allCars
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {

    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\View\View
     */
    public function store(Request $request)
    {
        $helper = new CarHelper();
        $validatedData = $request->validate([
            'title' => 'required|min:3',
            'subtitle' => 'required|max:45',
            'price' => 'required|min:4|integer',
            'description' => 'required|max:170'
        ], $helper->messages());

        $price = $request->input('price');
        $callForPrice = $request->input('cfp');
        $new = $request->input('new');
        $new = $new === 'checked' ? (int) true : (int) false;
        $link = is_null($request->input('link')) ? env('DEFAULT_LINK') : $request->input('link');
        $cfp = $callForPrice === 'checked' ? (int) true : (int) false;

        $files = $request->file('file');
        if ($files !== null && !is_array($files)) {
            $files = [$files];
        }

        $imgPath = empty($files) ? "pictures/cars/noimage.png" : $this->storeUploadedImage($files[0]);

        $validatedData['new'] = $new;
        $validatedData['link'] = $link;
        $validatedData['image'] = $imgPath;
        $validatedData['call_for_price'] = $cfp;

        $car = Car::create($validatedData);

        if (!empty($files)) {
            foreach ($files as $index => $file) {
                CarImage::create([
                    'car_id' => $car->id,
                    'path' => $index === 0 ? $imgPath : $this->storeUploadedImage($file),
                    'is_cover' => $index === 0
                ]);
            }
        }

        $cars = Car::all();

        return view('main', [
            'cars' => $cars,
            'info' => trans('messages.carIsAdded')
        ]);
    }

    /**
     * Resize and store an uploaded image file, returning its relative path.
     *
     * @param  \Illuminate\Http\UploadedFile  $file
     * @return string
     */
    private function storeUploadedImage($file)
    {
        $imageName = Str::random(10).".jpeg";
        $path = "pictures/cars/{$imageName}";
        Image::make($file)->resize(2048, 1536)->save($path);
        return $path;
    }

    /**
     * Display specific car image.
     *
     * @param  \App\Car  $car
     * @return \Illuminate\Http\JsonResponse
     */
    public function loadImage(Request $request)
    {
        $id = $request->id;
        $image = Car::where('id', $id)->pluck('image')->toArray();
        return response()->json([
            'image' => $image[0]
        ], 200);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Car  $car
     * @return \Illuminate\Http\JsonResponse
     */
    public function show(Request $request)
    {

    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Car  $car
     * @return \Illuminate\Http\JsonResponse
     */
    public function edit(Request $request)
    {
        $id = $request->id;
        $car = Car::with('images')->find($id);
        return response()->json([
            'car' => $car
        ], 200);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Car  $car
     * @return \Illuminate\View\View
     */
    public function update(Request $request, Car $car)
    {
        $id = $request->input('id');
        $title = $request->input('title');
        $subtitle = $request->input('subtitle');
        $price = $request->input('price') === null ? 0 : $request->input('price');
        $callForPrice = $request->input('cfp') === 'checked';
        $link = is_null($request->input('link')) ? env('DEFAULT_LINK') : $request->input('link');
        $description = $request->input('description');
        $new = $request->input('new');
        $new = $new === 'checked';

        $image = Car::where('id', $id)->pluck('image')->toArray();
        $imgPath = $image[0];

        $files = $request->file('file');
        if ($files !== null && !is_array($files)) {
            $files = [$files];
        }

        if (!empty($files)) {
            $hasCover = CarImage::where('car_id', $id)->where('is_cover', true)->exists();
            foreach ($files as $file) {
                $path = $this->storeUploadedImage($file);
                $isCover = !$hasCover;
                if ($isCover) {
                    $imgPath = $path;
                    $hasCover = true;
                }
                CarImage::create([
                    'car_id' => $id,
                    'path' => $path,
                    'is_cover' => $isCover
                ]);
            }
        }

        $helper = new CarHelper();
        $helper->update($id, $title, $subtitle, $link, $price, $description, $new, $imgPath, $callForPrice);

        $cars = Car::all();
        return view('main', [
            'cars' => $cars,
            'info' => trans('messages.carIsUpdated')
        ]);
    }

    /**
     * Remove a single uploaded photo from a car's gallery.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function deleteImage(Request $request)
    {
        $image = CarImage::find($request->input('id'));

        if ($image === null) {
            return response()->json(['message' => 'Not found'], 404);
        }

        $carId = $image->car_id;
        $wasCover = (bool) $image->is_cover;
        $path = $image->path;

        $image->delete();

        // Removing the file must never fail the request - the database row is already gone.
        $file = public_path($path);
        if ($path !== 'pictures/cars/noimage.png' && is_file($file)) {
            @unlink($file);
        }

        if ($wasCover) {
            $next = CarImage::where('car_id', $carId)->orderBy('id')->first();
            if ($next !== null) {
                $next->update(['is_cover' => true]);
                Car::where('id', $carId)->update(['image' => $next->path]);
            } else {
                Car::where('id', $carId)->update(['image' => 'pictures/cars/noimage.png']);
            }
        }

        return response()->json([
            'images' => CarImage::where('car_id', $carId)->orderByDesc('is_cover')->orderBy('id')->get()
        ], 200);
    }

    /**
     * Mark a photo as the car's cover/main image.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function setCoverImage(Request $request)
    {
        $image = CarImage::find($request->input('id'));

        if ($image === null) {
            return response()->json(['message' => 'Not found'], 404);
        }

        CarImage::where('car_id', $image->car_id)->update(['is_cover' => false]);
        $image->update(['is_cover' => true]);
        Car::where('id', $image->car_id)->update(['image' => $image->path]);

        return response()->json([
            'images' => CarImage::where('car_id', $image->car_id)->orderByDesc('is_cover')->orderBy('id')->get()
        ], 200);
    }

    public function showHide(Request $request)
    {
        $id = $request->id;

        $status = Car::where('id', $id)->pluck('hidden')->toArray();
        $hide = (boolean) $status[0] === false;

        $hidden = Car::where('id', $id)->update([
            'hidden' => (int) $hide
        ]);

        $info = $hide === false ? trans('messages.carIsDisplayed') : trans('messages.carIsHidden');
        $cars = Car::all();
        return view('main', [
            'cars' => $cars,
            'info' => $info
        ]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Car  $car
     * @return \Illuminate\View\View
     */
    public function destroy(Request $request)
    {
        $id = $request->id;
        Car::find($id)->delete();
        $cars = Car::all();

        return view('main', [
            'cars' => $cars,
            'info' => trans('messages.carIsDeleted')
        ]);
    }
}
