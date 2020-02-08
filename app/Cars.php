<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Cars extends Model
{
    function getAllFirstPage()
    {
        $cars = DB::select("SELECT * FROM cars WHERE hidden = 'false' order by new DESC");
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
            'image' => $imgPath,
            'hidden' => 'false'
        );
        return $result = DB::table('cars')->insert($values);
    }

    function showOrHide($id)
    {
        $sql = DB::select("SELECT hidden FROM cars WHERE id='" . $id . "'");
        $hidden = $sql[0]->hidden == 'false' ? 'true' : 'false';

        $update = DB::table('cars')
            ->where('id', $id)
            ->update([
                'hidden' => $hidden
            ]);
        return $hidden;
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
                'image' => $imgPath,
                'hidden' => 'false'
            ]);
    }

    function getCarImage($id)
    {
        $image = DB::select("SELECT image FROM cars WHERE id='" . $id . "'");
        return $image[0];
    }
}
