<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\StudentForm;
use App\Models\Form;

class StudentFormController extends Controller
{
    public function complete(Form $form)
    {
        $student = Auth::user()->students()->first();
        $record = StudentForm::firstOrNew([
            'student_id' => $student->id,
            'form_id' => $form->id,
        ]);
        $record->completion_status = true;
        $record->submitted_datetime = now();
        $record->save();

        return back()->with('success', 'Form marked as completed.');
    }

    public function undo(Form $form)
    {
        $student = Auth::user()->students()->first();

        $deleted = StudentForm::where('student_id', $student->id)
            ->where('form_id', $form->id)
            ->delete();

        return redirect()->back()->with('success', 'Completion has been undone.');
    }
}
