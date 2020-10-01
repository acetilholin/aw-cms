<?php


namespace App\Helpers;


use App\Car;

class CarHelper
{
    public function update($id, $title, $subtitle, $price, $description, $new, $imgPath, $callForPrice)
    {
        Car::where('id', $id)
            ->update([
                'title' => $title,
                'subtitle' => $subtitle,
                'price' => $price,
                'description' => $description,
                'new' => (int)$new,
                'image' => $imgPath,
                'call_for_price' => $callForPrice
            ]);
    }

    public function messages()
    {
        return [
            'title.required' => trans('cars.titleRequired'),
            'title.min' => trans('cars.titleMin'),
            'subtitle.required' => trans('cars.subtitleRequired'),
            'subtitle.max' => trans('cars.subtitleMax'),
            'price.required' => trans('cars.priceRequired'),
            'price.min' => trans('cars.priceMin'),
            'price.integer' => trans('cars.priceInteger'),
            'description.required' => trans('cars.descriptionRequired'),
            'description.max' => trans('cars.descriptionMax'),
        ];
    }
}
