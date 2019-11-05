<?php

namespace App\Http\Controllers;

use App\Cars;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Input;

class CarsController extends Controller
{
    function index(Request $request)
    {
        if (Auth::guest()) {
            return redirect('/login');
        }
        $cars = new Cars();
        $allCars = $cars->getAll();

        return view('main', [
            'cars' => $allCars
        ]);
    }

    function addCar(Request $request)
    {
        $cars = new Cars();
        $title = $request->input('title');
        $subtitle = $request->input('subtitle');
        $price = $request->input('price');
        $description = $request->input('description');
        $new = $request->input('new');
        $new = $new === 'checked' ? 'true' : 'false';

        if ($request->file('file') !== null) {
            $name = $request->file('file')->getClientOriginalName();
            $file = Input::file('file');
            $file->move('pictures/cars', $name);
            $imgPath = "pictures/cars/{$name}";
        } else {
            $imgPath = "pictures/cars/noimage.png";
        }

       $cars->insertCar($title, $subtitle, $price, $description, $new, $imgPath);

        $allCars = $cars->getAll();
        return view('main', [
            'cars' => $allCars
        ]);
    }

    function updateCar(Request $request)
    {
        $cars = new Cars();
        $id = $request->input('id');
        $title = $request->input('title');
        $subtitle = $request->input('subtitle');
        $price = $request->input('price');
        $description = $request->input('description');
        $new = $request->input('new');
        $new = $new === 'checked' ? 'true' : 'false';

        $data = $cars->getCarDataById($id);

        if($request->file('file') === null) {
            $imgPath = $data->image;
        } else {
            $name = $request->file('file')->getClientOriginalName();
            $file = Input::file('file');
            $file->move('pictures/cars', $name);
            $imgPath = "pictures/cars/{$name}";
        }

        $cars->updateCar($id, $title, $subtitle, $price, $description, $new, $imgPath);
        $allCars = $cars->getAll();
        return view('main', [
            'cars' => $allCars
        ]);
    }

    function delete($id)
    {
        $cars = new Cars();
        $delete = $cars->deleteCar($id);
        $allCars = $cars->getAll();
        return view('main', [
            'cars' => $allCars
        ]);
    }

    function loadCar(Request $request)
    {
        $id = $request->id;
        $cars = new Cars();
        $data = $cars->getCarDataById($id);
        return json_encode($data);
    }
}
