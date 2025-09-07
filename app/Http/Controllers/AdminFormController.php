<?php

namespace App\Http\Controllers;

use App\Models\Form;
use Illuminate\Http\Request;
use App\Models\Student;
use App\Models\Mentor;
use App\Models\TeamLeader;
use App\Models\FileUploadLink;

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
        
        $uploadLinks = FileUploadLink::query()
            ->when($request->filled('for_role'), function ($q) use ($request) {
                $q->where('for_role', $request->for_role);
            })
            ->orderBy('for_role')
            ->get();

        return view('admin.forms.index', compact('forms', 'uploadLinks'));
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

   public function tracking(Request $request)
{
    // Get all active forms and group by role
    $forms = Form::where('is_active', true)->get()->groupBy('for_role');

    // Ensure keys exist to avoid "undefined array key" errors
    $roles = ['student', 'mentor', 'team_leader'];
    foreach ($roles as $role) {
        if (!isset($forms[$role])) {
            $forms[$role] = collect(); // empty collection
        }
    }

    // Default form types
    $defaultFormTypes = ['pretest', 'posttest', 'questionnaire', 'consent'];

    // Normalize form list with all possible types (add "Not Created" placeholders)
    foreach ($roles as $role) {
        foreach ($defaultFormTypes as $type) {
            if (!$forms[$role]->firstWhere('form_type', $type)) {
                $forms[$role][] = (object)[
                    'form_type' => $type,
                    'id' => null,
                    'form_name' => ucfirst($type) . ' (Not Created)',
                ];
            }
        }
    }

    // ============= FILTERS =============
    $studentId = $request->query('student_id');
    $studentName = $request->query('student_name');
    $studentStatus = $request->query('student_status');

    $mentorId = $request->query('mentor_id');
    $mentorName = $request->query('mentor_name');
    $mentorStatus = $request->query('mentor_status');

    $teamLeaderId = $request->query('team_leader_id');
    $teamLeaderName = $request->query('team_leader_name');
    $teamLeaderStatus = $request->query('team_leader_status');

    // ============= QUERY DATA =============
    $students = Student::with(['user', 'studentForms'])
        ->when($studentId, fn($q) => $q->where('student_id', 'like', "%$studentId%"))
        ->when($studentName, fn($q) => $q->whereHas('user', fn($u) => $u->where('name', 'like', "%$studentName%")))
        ->get();

    $mentors = Mentor::with(['user', 'mentorForms'])
        ->when($mentorId, fn($q) => $q->where('mentor_id', 'like', "%$mentorId%"))
        ->when($mentorName, fn($q) => $q->whereHas('user', fn($u) => $u->where('name', 'like', "%$mentorName%")))
        ->get();

    $teamleaders = TeamLeader::with(['user', 'teamLeaderForms'])
        ->when($teamLeaderId, fn($q) => $q->where('team_leader_id', 'like', "%$teamLeaderId%"))
        ->when($teamLeaderName, fn($q) => $q->whereHas('user', fn($u) => $u->where('name', 'like', "%$teamLeaderName%")))
        ->get();

    // ============= BUILD STATUS ARRAYS =============
    $studentStatuses = [];
    foreach ($students as $student) {
        foreach ($forms['student'] as $form) {
            $record = $form->id ? $student->studentForms->firstWhere('form_id', $form->id) : null;
            $studentStatuses[$student->id][$form->form_type] = $form->id
                ? ($record ? ($record->completion_status ? 'completed' : 'not_completed') : 'not_completed')
                : 'not_assigned';
        }
    }

    $mentorStatuses = [];
    foreach ($mentors as $mentor) {
        foreach ($forms['mentor'] as $form) {
            $record = $form->id ? $mentor->mentorForms->firstWhere('form_id', $form->id) : null;
            $mentorStatuses[$mentor->id][$form->form_type] = $form->id
                ? ($record ? ($record->completion_status ? 'completed' : 'not_completed') : 'not_completed')
                : 'not_assigned';
        }
    }

    $teamLeaderStatuses = [];
    foreach ($teamleaders as $leader) {
        foreach ($forms['team_leader'] as $form) {
            $record = $form->id ? $leader->teamLeaderForms->firstWhere('form_id', $form->id) : null;
            $teamLeaderStatuses[$leader->id][$form->form_type] = $form->id
                ? ($record ? ($record->completion_status ? 'completed' : 'not_completed') : 'not_completed')
                : 'not_assigned';
        }
    }

    // ============= FILTER BY STATUS =============
    if ($studentStatus) {
        $students = $students->filter(fn($s) => in_array($studentStatus, $studentStatuses[$s->id] ?? []));
    }
    if ($mentorStatus) {
        $mentors = $mentors->filter(fn($m) => in_array($mentorStatus, $mentorStatuses[$m->id] ?? []));
    }
    if ($teamLeaderStatus) {
        $teamleaders = $teamleaders->filter(fn($t) => in_array($teamLeaderStatus, $teamLeaderStatuses[$t->id] ?? []));
    }

    // ============= RETURN VIEW =============
    $formTypes = $defaultFormTypes;

    return view('admin.forms.tracking', compact(
        'forms',
        'formTypes',
        'students',
        'mentors',
        'teamleaders',
        'studentStatuses',
        'mentorStatuses',
        'teamLeaderStatuses'
    ));
}
}
