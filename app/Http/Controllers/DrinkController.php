<?php

namespace App\Http\Controllers;

use App\Models\Drink;
use App\Models\DrinkLog;
use Illuminate\Http\Request;

class DrinkController extends Controller
{
    public function main(Request $request)
    {
        $drinks = Drink::all();
        $drink_log = DrinkLog::all();

        return view('main', compact('drinks', 'drink_log'));
    }

    public function save(Request $request, Drink $drink)
    {

    }

    public function delete(Request $request, Drink $drink)
    {

    }
}
