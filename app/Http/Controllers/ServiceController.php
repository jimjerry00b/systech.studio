<?php

namespace App\Http\Controllers;

use App\Models\Service;
use Illuminate\Contracts\View\View;

class ServiceController extends Controller
{
    public function index(): View
    {
        $services = Service::active()->ordered()->get();

        return view('pages.services.index', [
            'services' => $services,
        ]);
    }

    public function show(Service $service): View
    {
        abort_unless($service->is_active, 404);

        $relatedServices = Service::active()
            ->ordered()
            ->where('id', '!=', $service->id)
            ->take(3)
            ->get();

        return view('pages.services.show', [
            'service' => $service,
            'relatedServices' => $relatedServices,
        ]);
    }
}
