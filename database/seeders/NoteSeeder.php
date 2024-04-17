<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Factories\Sequence;
use App\Models\Note;
use App\Models\User;

class NoteSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Note::factory(200)
            ->state(new Sequence(
                fn(Sequence $sequence) => ['user_id' => User::all()->random()]
            ))
            ->sequence(
                ['is_completed' => true],
                ['is_completed' => false],
            )
            ->create();
    }
}
