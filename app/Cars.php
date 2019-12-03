<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Cars extends Model
{
    function getAll()
    {
        $cars = DB::select("SELECT * FROM cars");
        return $cars;
    }

    function getAllFirstPage()
    {
        $cars = DB::select("SELECT * FROM cars order by new DESC");
        return $cars;
    }

    function insertCar($title, $subtitle, $price, $description, $new, $imgPath)
    {
        $values = array(
            'title' => $title,
            'subtitle' => $subtitle,
            'price' => $price,
            'description' => $description,
            'new' => $new,
            'image' => $imgPath
        );
        return $result = DB::table('cars')->insert($values);
    }

    function updateCar($id, $title, $subtitle, $price, $description, $new, $imgPath)
    {
        $update = DB::table('cars')
            ->where('id', $id)
            ->update([
                'title' => $title,
                'subtitle' => $subtitle,
                'price' => $price,
                'description' => $description,
                'new' => $new,
                'image' => $imgPath
            ]);
    }

    function getCarImage($id)
    {
        $image = DB::select("SELECT image FROM cars WHERE id='" . $id . "'");
        return $image[0];
    }

    function deleteCar($id)
    {
        $request = DB::table('cars')->where('id', $id)->delete();
        return $request;
    }

    function getCarDataById($id)
    {
        $cars = DB::select("SELECT * FROM cars WHERE id='" . $id . "'");
        return $cars[0];
    }
}
