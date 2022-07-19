<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\ApiBaseController as Controller;

class RateController extends Controller
{
    public function rate(Request $request)
    {
        $price = $request->price;
        $currency = $request->currency;

        return $this->success(round(bcdiv($price, rate($currency), 3),2));
    }
}
