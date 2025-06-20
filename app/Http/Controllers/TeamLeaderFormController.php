<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Form;
use App\Models\TeamLeaderForm;

class TeamLeaderFormController extends Controller
{
    public function markCompleted(Form $form)
    {
        $user = Auth::user();

        // Get the first team leader associated with this user
        $teamLeader = $user->teamLeaders()->first();

        // Optional: check if team leader exists
        if (!$teamLeader) {
            return redirect()->back()->with('error', 'Team leader not found.');
        }

        // Record completion
        $record = TeamLeaderForm::firstOrNew([
            'team_leader_id' => $teamLeader->id,
            'form_id' => $form->id,
        ]);

        $record->completion_status = true;
        $record->submitted_datetime = now();
        $record->save();

        return redirect()->back()->with('success', 'Form marked as completed.');
    }

    public function undo(Form $form)
    {
        $teamLeader = Auth::user()->teamLeaders()->first();

        $deleted = TeamLeaderForm::where('team_leader_id', $teamLeader->id)
            ->where('form_id', $form->id)
            ->delete();

        return redirect()->back()->with('success', 'Completion has been undone.');
    }


}
