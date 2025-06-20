<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Form;
use App\Models\MentorForm;

class MentorFormController extends Controller
{
    public function complete(Form $form)
    {
        $mentor = Auth::user()->mentors()->first();
        $record = MentorForm::firstOrNew([
            'mentor_id' => $mentor->id,
            'form_id' => $form->id,
        ]);
        $record->completion_status = true;
        $record->submitted_datetime = now();
        $record->save();

        return back()->with('success', 'Form marked as completed.');
    }

    public function undo(Form $form)
    {
        $mentor = Auth::user()->mentors()->first();
        $record = MentorForm::where([
            'mentor_id' => $mentor->id,
            'form_id' => $form->id,
        ])->first();

        if ($record) {
            $record->delete();
            return back()->with('success', 'Form completion undone.');
        }

        return back()->with('error', 'Form not found.');
    }
}
