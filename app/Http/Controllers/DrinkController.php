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
//        $drink_log = DrinkLog::with('drink')->get();

        $drink_log = DrinkLog::with('drink')->get()->map(function ($entry) {
            return [
                'id' => $entry->id,
                'name' => $entry->drink->name,
                'caffeine' => $entry->drink->caffeine_per_serving * $entry->servings,
                'time' => $entry->created_at
            ];
        });

        return view('main', compact('drinks', 'drink_log'));
    }

    public function save(Request $request)
    {
        $data = $request->all();
        dump($data);
        DrinkLog::create([
            'drink_id' => $data['id'],
            'servings' => $data['servings']
        ]);
    }

    public function delete(Request $request)
    {
        $data = $request->all();
        dump($data);
    }
}
