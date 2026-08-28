<?php

namespace App\Http\Controllers\Student;

use App\Http\Controllers\Controller;
use App\Models\Form;
use App\Models\StudentForm;
use Illuminate\Support\Facades\Auth;

class StudentFormController extends Controller
{
    public function complete(Form $form)
    {
        $student = Auth::user()->students()->first();
        $record = StudentForm::firstOrNew([
            'student_id' => $student->id,
            'form_id' => $form->id,
        ]);
        $record->semester_id = $student->semester_id;
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
