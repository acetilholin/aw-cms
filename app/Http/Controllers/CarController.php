<?php

namespace App\Http\Controllers;

use App\Car;
use App\Helpers\CarHelper;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Input;
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
        $allCars = Car::all();
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
        $cfp = $callForPrice === 'checked' ? (int) true : (int) false;

        if ($request->file('file') !== null) {
            $imageName = Str::random(10).".jpeg";
            $imgPath = "pictures/cars/{$imageName}";
            $file = Input::file('file');
            Image::make($file)->resize(2048, 1536)->save("pictures/cars/{$imageName}");
        } else {
            $imgPath = "pictures/cars/noimage.png";
        }

        $validatedData['new'] = $new;
        $validatedData['image'] = $imgPath;
        $validatedData['call_for_price'] = $cfp;

        Car::create($validatedData)->save();
        $cars = Car::all();

        return view('main', [
            'cars' => $cars,
            'info' => trans('messages.carIsAdded')
        ]);
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
        $car = Car::find($id);
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
        $description = $request->input('description');
        $new = $request->input('new');
        $new = $new === 'checked';

        $image = Car::where('id',$id)->pluck('image')->toArray();

        if ($request->file('file') === null) {
            $imgPath = $image[0];
        } else {
            $imageName = Str::random(10).".jpeg";
            $imgPath = "pictures/cars/{$imageName}";
            $file = Input::file('file');
            Image::make($file)->resize(2048, 1536)->save("pictures/cars/{$imageName}");
        }

        $helper = new CarHelper();
        $helper->update($id, $title, $subtitle, $price, $description, $new, $imgPath, $callForPrice);

        $cars = Car::all();
        return view('main', [
            'cars' => $cars,
            'info' => trans('messages.carIsUpdated')
        ]);
    }

    public function showHide(Request $request)
    {
        $id = $request->id;

        $status = Car::where('id', $id)->pluck('hidden')->toArray();
        $hide = (boolean)$status[0] === false;

        $hidden = Car::where('id', $id)->update([
           'hidden' => (int)$hide
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
