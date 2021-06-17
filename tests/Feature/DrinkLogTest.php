<?php

namespace Tests\Feature;

use App\Models\Drink;
use App\Models\DrinkLog;
use Carbon\Carbon;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class DrinkLogTest extends TestCase
{
    public function testLogCreation()
    {
        $response = $this->postJson('/save', [
            'id'       => 1,
            'servings' => 1
        ]);

        $response->assertStatus(201)
                 ->assertJsonStructure([
                     'id'
                 ]);

        $log = DrinkLog::find($response->original['id']);

        $this->assertNotNull($log);
        $this->assertEquals(1, $log->servings);
    }

    public function testLogDeletion()
    {
        $log = DrinkLog::create([
            'drink_id' => 1,
            'servings' => 1
        ]);

        $this->assertNotNull($log);

        $response = $this->postJson('/delete', [
            'id' => $log->id
        ]);
        $response->assertStatus(204);

        $checkLog = DrinkLog::find($log->id);

        $this->assertNull($checkLog);
    }

    public function testGettingLogs()
    {
        DrinkLog::create(['drink_id' => 1, 'servings' => 1]);
        DrinkLog::create(['drink_id' => 2, 'servings' => 1]);
        DrinkLog::create(['drink_id' => 3, 'servings' => 1]);
        DrinkLog::create(['drink_id' => 4, 'servings' => 1]);

        $logs = DrinkLog::all();

        $this->assertNotEmpty($logs);
        $this->assertCount(4, $logs);
    }

    public function testSaveValidation()
    {
        $this->postJson('/save', [
            'id'       => 'test',
            'servings' => 1
        ])->assertStatus(422);

        $this->postJson('/save', [
            'id'       => 1,
            'servings' => 'test'
        ])->assertStatus(422);

        $this->postJson('/save', [
            'id'       => 6,
            'servings' => 1
        ])->assertStatus(422);
    }

    public function testDeleteValidation()
    {
        $this->postJson('/delete', [
            'id' => 'test'
        ])->assertStatus(422);
    }

}
