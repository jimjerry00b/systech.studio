<?php

namespace App\Http\Controllers;

use App\Models\Project;
use Illuminate\Contracts\View\View;
use Illuminate\Http\Request;

class ProjectController extends Controller
{
    public function index(Request $request): View
    {
        $category = $request->string('category')->toString() ?: null;

        $projects = Project::published()
            ->ordered()
            ->when($category, fn ($q) => $q->where('category', $category))
            ->paginate(9)
            ->withQueryString();

        $categories = Project::published()
            ->select('category')
            ->distinct()
            ->orderBy('category')
            ->pluck('category');

        return view('pages.projects.index', [
            'projects' => $projects,
            'categories' => $categories,
            'currentCategory' => $category,
        ]);
    }

    public function show(Project $project): View
    {
        abort_unless($project->is_published, 404);

        $relatedProjects = Project::published()
            ->where('category', $project->category)
            ->where('id', '!=', $project->id)
            ->ordered()
            ->take(3)
            ->get();

        return view('pages.projects.show', [
            'project' => $project,
            'relatedProjects' => $relatedProjects,
        ]);
    }
}
