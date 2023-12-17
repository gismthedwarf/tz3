<?php

namespace App\Http\Controllers;

use App\Http\Resources\CurrencyResource;
use App\Models\Currency;

class CurrencyController extends Controller
{
    public function index()
    {
        return CurrencyResource::collection(Currency::all());
    }
}
