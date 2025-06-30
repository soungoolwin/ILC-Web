<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\FileUploadLink;

class AdminFileUploadLinkController extends Controller
{
    public function create()
    {
        return view('admin.file_upload_links.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'url' => 'required|url',
            'for_role' => 'required|in:student,mentor,team_leader',
        ]);

        FileUploadLink::create($validated);

        return redirect()->route('admin.forms.index')->with('success', 'Upload link created successfully.');
    }

    public function show(FileUploadLink $fileUploadLink)
    {
        return view('admin.file_upload_links.show', compact('fileUploadLink'));
    }

    public function edit(FileUploadLink $fileUploadLink)
    {
        return view('admin.file_upload_links.edit', compact('fileUploadLink'));
    }

    public function update(Request $request, FileUploadLink $fileUploadLink)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'url' => 'required|url',
            'for_role' => 'required|in:student,mentor,team_leader',
        ]);

        $fileUploadLink->update($validated);

        return redirect()->route('admin.forms.index')->with('success', 'Upload link updated successfully.');
    }

    public function destroy(FileUploadLink $fileUploadLink)
    {
        $fileUploadLink->delete();

        return redirect()->route('admin.forms.index')->with('success', 'Upload link deleted successfully.');
    }
}
