<?php

namespace App\Http\Controllers;

use App\Models\TeamMember;
use Illuminate\Contracts\View\View;

class AboutController extends Controller
{
    public function __invoke(): View
    {
        $team = TeamMember::active()->ordered()->get();

        return view('pages.about', [
            'team' => $team,
        ]);
    }
}
