<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Controller;
use App\Models\Note;

class NoteController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        return $request->user()->notes;
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $data = $request->only([
            'title',
            'description'
        ]);

        $note = new Note($data);
        $note->user_id = $request->user()->id;
        $note->is_completed = false;

        if ($note->save()) {
            return response()->json(['status' => 'new note created successfully'], 200);
        } else {
            return response()->json(['status' => 'could not add a note'], 422);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(Note $note)
    {
        abort_if(Auth::user()->id !== $note->user_id, 404);
        return $note;
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Note $note)
    {
        abort_if(Auth::user()->id !== $note->user_id, 404);

        $data = $request->only([
            'title',
            'description'
        ]);

        $note->fill($data);

        if ($note->save()) {
            return response()->json(['status' => 'note updated successfully'], 200);
        } else {
            return response()->json(['status' => 'could not to update a note'], 422);
        }
    }

    /**
     * Set complete status for note
     */
    public function completed(Note $note) {
        abort_if(Auth::user()->id !== $note->user_id, 404);

        $note->is_completed = true;

        if ($note->save()) {
            return response()->json(['status' => 'note marked as completed'], 200);
        } else {
            return response()->json(['status' => 'could not to mark a note as completed'], 422);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Note $note)
    {
        abort_if(Auth::user()->id !== $note->user_id, 404);

        if ($note->delete()) {
            return response()->json(['status' => 'the note was deleted successfully'], 200);
        } else {
            return response()->json(['status' => 'could not to delete the note'], 422);
        }
    }
}
