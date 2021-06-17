<?php

namespace App\Http\Controllers;

use App\Models\Drink;
use App\Models\DrinkLog;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class DrinkController extends Controller
{
    public function main(Request $request)
    {
        $drinks = Drink::all();

        $drink_log = DrinkLog::with('drink')
                             ->whereTime('created_at', '>=', Carbon::now()->subMinutes(3))
                             ->get()
                             ->map(function ($entry) {
                                 return [
                                     'id'       => $entry->id,
                                     'name'     => $entry->drink->name,
                                     'servings' => $entry->servings,
                                     'caffeine' => $entry->drink->caffeine_per_serving,
                                     'time'     => $entry->created_at
                                 ];
                             });

        return view('main', compact('drinks', 'drink_log'));
    }

    public function save(Request $request)
    {
        $data = $request->all();
        $validator = Validator::make($data, [
            'id'       => 'required|integer',
            'servings' => 'required|integer'
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        $drink_log = DrinkLog::create([
            'drink_id' => $data['id'],
            'servings' => $data['servings']
        ]);

            return response()->json(['id' => $drink_log->id]);
    }

    public function delete(Request $request)
    {
        $data = $request->all();
        $validator = Validator::make($data, [
            'id' => 'required|integer'
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        } else {
            DrinkLog::find($data['id'])->delete();
            return response()->json([], 200);
        }
    }
}
