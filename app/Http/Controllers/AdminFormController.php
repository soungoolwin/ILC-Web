<?php

namespace App\Http\Controllers;

use App\Models\Form;
use Illuminate\Http\Request;

class AdminFormController extends Controller
{
    // Display a list of all forms
    public function index(Request $request)
    {
        $query = Form::query();

        if ($request->filled('form_type')) {
            $query->where('form_type', $request->form_type);
        }

        if ($request->filled('for_role')) {
            $query->where('for_role', $request->for_role);
        }

        $forms = $query->orderBy('for_role')->get();

        return view('admin.forms.index', compact('forms'));
    }

    // Show the form for creating a new form
    public function create()
    {
        return view('admin.forms.create');
    }

    // Store a newly created form in the database
    public function store(Request $request)
    {
        $request->merge([
            'is_active' => $request->has('is_active'),
            'is_mandatory' => $request->has('is_mandatory'),
        ]);

        $validated = $request->validate([
            'form_name' => 'required|string|max:255',
            'form_description' => 'required|string',
            'form_type' => 'required|in:pretest,posttest,questionnaire,consent',
            'for_role' => 'required|in:student,mentor,team_leader',
            'is_active' => 'boolean',
            'is_mandatory' => 'boolean',
        ]);

        Form::create($validated);

        return redirect()->route('admin.forms.index')->with('success', 'Form created successfully.');
    }

    // Show the form for editing the specified form
    public function edit(Form $form)
    {
        return view('admin.forms.edit', compact('form'));
    }

    // Update the specified form in the database
    public function update(Request $request, Form $form)
    {
        $request->merge([
            'is_active' => $request->has('is_active'),
            'is_mandatory' => $request->has('is_mandatory'),
        ]);

        $validated = $request->validate([
            'form_name' => 'required|string|max:255',
            'form_description' => 'required|string',
            'form_type' => 'required|in:pretest,posttest,questionnaire,consent',
            'for_role' => 'required|in:student,mentor,team_leader',
            'is_active' => 'boolean',
            'is_mandatory' => 'boolean',
        ]);

        $form->update($validated);

        return redirect()->route('admin.forms.index')->with('success', 'Form updated successfully.');
    }

    // Remove the specified form from the database
    public function destroy(Form $form)
    {
        $form->delete();
        return redirect()->route('admin.forms.index')->with('success', 'Form deleted successfully!');
    }

    // Display the details of a specific form
    public function show(Form $form)
    {
        return view('admin.forms.show', compact('form'));
    }
}
