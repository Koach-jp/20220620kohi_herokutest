<?php

namespace Tests\Feature\Models;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Models\Exercise;

class ExerciseTest extends TestCase
{
    use RefreshDatabase;

    public function testExerciseIndex() {
        $exercise = Exercise::factory()->create();
        $response = $this->get('/api/exercise');
        $response->assertStatus(200);
        $response->assertJsonFragment([
            'name' => $exercise->name,
            'email' => $exercise->email,
            'profile' => $exercise->profile,
        ]);
    }

    public function testExerciseStore() {
        $exercise = [
            'name' => 'testname',
            'email' => 'test@test.test',
            'profile' => 'My job is System Engineer'
        ];
        $response = $this->post('/api/exercise', $exercise);
        $response->assertStatus(201);
        $response->assertJsonFragment($exercise);
        $this->assertDatabaseHas('exercises',$exercise);
    }

    public function testExerciseShow() {
        $exercise = Exercise::factory()->create();
        $response = $this->get('/api/exercise/'.$exercise->id);
        $response->assertStatus(200);
        $response->assertJsonFragment([
            'name' => $exercise->name,
            'email' => $exercise->email,
            'profile' => $exercise->profile,
        ]);
    }

    public function testExerciseUpdate() {
        $exercise = Exercise::factory()->create();
        $update = [
            'name' => 'testname',
            'email' => 'test@test.test',
            'profile' => 'My job is System Engineer'
        ];
        $response = $this->put('/api/exercise/'.$exercise->id, $update);
        $response->assertStatus(200);
        $response->assertJsonFragment([
            'message' => 'Updated successfully'
        ]);
        $this->assertDatabaseHas('exercises', $update);
    }

    public function testExerciseDestroy() {
        $exercise = Exercise::factory()->create();
        $response = $this->delete('/api/exercise/'.$exercise->id);
        $response->assertStatus(200);
        $this->assertDeleted($exercise);
    }
}
