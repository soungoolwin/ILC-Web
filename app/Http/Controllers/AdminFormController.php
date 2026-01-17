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
        // ---- 1) Active forms grouped: [for_role][form_type] => Collection<Form> ----
        $forms = Form::where('is_active', true)
            ->orderBy('for_role')
            ->orderBy('form_type')
            ->orderBy('created_at')
            ->get()
            ->groupBy(['for_role', 'form_type']); // multi-level group

        $defaultFormTypes = ['pretest', 'posttest', 'questionnaire', 'consent'];
        $roles = ['student', 'mentor', 'team_leader'];

        // Ensure all role/type keys exist even if empty
        foreach ($roles as $role) {
            if (!isset($forms[$role])) $forms[$role] = collect();
            foreach ($defaultFormTypes as $type) {
                if (!isset($forms[$role][$type])) {
                    $forms[$role][$type] = collect(); // empty = no form created for that type
                }
            }
        }

        // ---- 2) Filters ----
        $studentId = $request->query('student_id');
        $mentorId = $request->query('mentor_id');
        $teamLeaderId = $request->query('team_leader_id');

        $students = Student::with(['user', 'studentForms'])
            ->when($studentId, fn($q) => $q->where('student_id', 'like', "%{$studentId}%"))
            ->get();

        $mentors = Mentor::with(['user', 'mentorForms'])
            ->when($mentorId, fn($q) => $q->where('mentor_id', 'like', "%{$mentorId}%"))
            ->get();

        $teamleaders = TeamLeader::with(['user', 'teamLeaderForms'])
            ->when($teamLeaderId, fn($q) => $q->where('team_leader_id', 'like', "%{$teamLeaderId}%"))
            ->get();

        // ---- 3) Build per-form statuses + per-type summaries ----
        // Structure:
        // - $studentStatusesByForm[studentId][type][formId] = 'completed'|'not_completed'
        // - $studentSummaries[studentId][type] = ['completed' => X, 'total' => T]
        $studentStatusesByForm = [];
        $studentSummaries = [];
        foreach ($students as $student) {
            foreach ($defaultFormTypes as $type) {
                $formList = $forms['student'][$type]; // Collection<Form>
                $total = $formList->count();
                $done = 0;

                foreach ($formList as $form) {
                    $record = $student->studentForms->firstWhere('form_id', $form->id);
                    $isCompleted = $record && (bool)($record->completion_status ?? true);
                    $studentStatusesByForm[$student->id][$type][$form->id] = $isCompleted ? 'completed' : 'not_completed';
                    if ($isCompleted) $done++;
                }

                $studentSummaries[$student->id][$type] = ['completed' => $done, 'total' => $total];
            }
        }

        $mentorStatusesByForm = [];
        $mentorSummaries = [];
        foreach ($mentors as $mentor) {
            foreach ($defaultFormTypes as $type) {
                $formList = $forms['mentor'][$type];
                $total = $formList->count();
                $done = 0;

                foreach ($formList as $form) {
                    $record = $mentor->mentorForms->firstWhere('form_id', $form->id);
                    $isCompleted = $record && (bool)($record->completion_status ?? true);
                    $mentorStatusesByForm[$mentor->id][$type][$form->id] = $isCompleted ? 'completed' : 'not_completed';
                    if ($isCompleted) $done++;
                }

                $mentorSummaries[$mentor->id][$type] = ['completed' => $done, 'total' => $total];
            }
        }

        $teamLeaderStatusesByForm = [];
        $teamLeaderSummaries = [];
        foreach ($teamleaders as $leader) {
            foreach ($defaultFormTypes as $type) {
                $formList = $forms['team_leader'][$type];
                $total = $formList->count();
                $done = 0;

                foreach ($formList as $form) {
                    $record = $leader->teamLeaderForms->firstWhere('form_id', $form->id);
                    $isCompleted = $record && (bool)($record->completion_status ?? true);
                    $teamLeaderStatusesByForm[$leader->id][$type][$form->id] = $isCompleted ? 'completed' : 'not_completed';
                    if ($isCompleted) $done++;
                }

                $teamLeaderSummaries[$leader->id][$type] = ['completed' => $done, 'total' => $total];
            }
        }

        // ---- 4) (Optional) columns helper for the view: labels per role/type ----
        // $formColumns['student']['pretest'] = [ ['id'=>1,'label'=>'Pre A'], ['id'=>7,'label'=>'Pre B'] ]
        $formColumns = [];
        foreach ($roles as $role) {
            foreach ($defaultFormTypes as $type) {
                $formColumns[$role][$type] = $forms[$role][$type]->map(fn($f) => [
                    'id' => $f->id,
                    'label' => $f->form_name ?? ('Form #'.$f->id),
                ])->values();
            }
        }

        

        // ---- 5) Calculate completion statistics for students, mentors, teamleaders ----
            $studentCompletionStats = [];

            foreach ($defaultFormTypes as $type) {
                // Get all forms of this type across all students
                $formList = $forms['student'][$type];
                $totalPossible = $formList->count() * $students->count();
                $completedCount = 0;

                foreach ($students as $student) {
                    foreach ($formList as $form) {
                        $status = $studentStatusesByForm[$student->id][$type][$form->id] ?? 'not_completed';
                        if ($status === 'completed') {
                            $completedCount++;
                        }
                    }
                }

                $studentCompletionStats[] = [
                    'label' => ucfirst($type),
                    'percentage' => $totalPossible > 0 ? round(($completedCount / $totalPossible) * 100, 1) : 0,
                    'completed' => $completedCount,
                    'total' => $totalPossible
                ];
            }

            $mentorCompletionStats = [];

            foreach ($defaultFormTypes as $type) {
                // Get all forms of this type across all mentors
                $formList = $forms['mentor'][$type];
                $totalPossible = $formList->count() * $mentors->count();
                $completedCount = 0;

                foreach ($mentors as $mentor) {
                    foreach ($formList as $form) {
                        $status = $mentorStatusesByForm[$mentor->id][$type][$form->id] ?? 'not_completed';
                        if ($status === 'completed') {
                            $completedCount++;
                        }
                    }
                }

                $mentorCompletionStats[] = [
                    'label' => ucfirst($type),
                    'percentage' => $totalPossible > 0 ? round(($completedCount / $totalPossible) * 100, 1) : 0,
                    'completed' => $completedCount,
                    'total' => $totalPossible
                ];
            }

            $teamLeaderCompletionStats = [];

            foreach ($defaultFormTypes as $type) {
                // Get all forms of this type across all team leaders
                $formList = $forms['team_leader'][$type];
                $totalPossible = $formList->count() * $teamleaders->count();
                $completedCount = 0;

                foreach ($teamleaders as $leader) {
                    foreach ($formList as $form) {
                        $status = $teamLeaderStatusesByForm[$leader->id][$type][$form->id] ?? 'not_completed';
                        if ($status === 'completed') {
                            $completedCount++;
                        }
                    }
                }

                $teamLeaderCompletionStats[] = [
                    'label' => ucfirst($type),
                    'percentage' => $totalPossible > 0 ? round(($completedCount / $totalPossible) * 100, 1) : 0,
                    'completed' => $completedCount,
                    'total' => $totalPossible
                ];
            }

            // For compatibility with your blade that expects $formTypes
            $formTypes = $defaultFormTypes;

            return view('admin.forms.tracking', compact(
                'forms',
                'formTypes',
                'students',
                'mentors',
                'teamleaders',
                'studentStatusesByForm',
                'mentorStatusesByForm',
                'teamLeaderStatusesByForm',
                'studentSummaries',
                'mentorSummaries',
                'teamLeaderSummaries',
                'formColumns',
                'studentCompletionStats',
                'mentorCompletionStats',
                'teamLeaderCompletionStats'
            ));
    }



}
