<?php declare(strict_types=1);

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\ProjectResource;
use App\Models\Project;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;

class ApiProjectsController extends Controller
{
    public function list(): AnonymousResourceCollection
    {
        $projects = Project::all();
        return ProjectResource::collection($projects);
    }

    public function project(string $id): JsonResponse
    {
        /** @var Project $project */
        $project = Project::whereId($id)->firstOrFail();
        $project->hits++;
        $project->save();

        return response()->json(new ProjectResource($project));
    }
}
