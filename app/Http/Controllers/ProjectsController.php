<?php declare(strict_types=1);

namespace App\Http\Controllers;

use App\Models\Project;
use Illuminate\Database\RecordsNotFoundException;

class ProjectsController extends Controller
{
    public function list()
    {
        return view('list', [
            'title' => 'Projects'
        ]);
    }

    public function show(string $id)
    {
        if (!Project::whereId($id)->exists()) {
            throw new RecordsNotFoundException('Project not found');
        }

        return view('project', [
            'title' => 'Project',
            'projectId' => $id
        ]);
    }
}
