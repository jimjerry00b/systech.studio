<?php

namespace App\Http\Controllers;

use App\Models\Project;
use App\Models\Service;
use Illuminate\Contracts\View\View;

class HomeController extends Controller
{
    public function __invoke(): View
    {
        $services = Service::active()->ordered()->take(6)->get();

        $featuredProjects = Project::published()
            ->featured()
            ->ordered()
            ->take(3)
            ->get();

        return view('pages.home', [
            'services' => $services,
            'featuredProjects' => $featuredProjects,
        ]);
    }
    
    public function landingPage(){
        return view('landingpage');
    }
}
