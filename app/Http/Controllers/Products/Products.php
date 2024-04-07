<?php

namespace App\Http\Controllers\Products;

use App\Http\Controllers\Controller;
use App\Http\Libs\Connections\PayPal;
use DateTime;

class Products extends Controller
{
    public function index(): array
    {
        $conn = new PayPal();
        $datetime = new DateTime();
        $timestamp = $datetime->getTimestamp();
        $body = [
            "name" => "T-Shirt",
            "type" => "PHYSICAL",
            "id" => "$timestamp",
            "description" => "Cotton XL",
            "category" => "CLOTHING",
            "image_url" => "https://example.com/gallary/images/$timestamp.jpg",
            "home_url" => "https://example.com/catalog/$timestamp.jpg"
        ];
        return $conn->post('v1/catalogs/products', $body);
    }
}
