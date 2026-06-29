<?php

namespace App\Http\Controllers;

use Illuminate\View\View;

class PageController extends Controller
{
    public function home(): View
    {
        return view('pages.home');
    }

    public function about(): View
    {
        return view('pages.placeholder', [
            'title' => 'About PLASCHEMA',
            'description' => 'Mission, vision, leadership, and history of the Plateau State Contributory Healthcare Management Agency.',
        ]);
    }

    public function healthPlans(): View
    {
        return view('pages.placeholder', [
            'title' => 'Health Insurance Plans',
            'description' => 'Explore formal, informal, family, student, and vulnerable persons coverage options.',
        ]);
    }

    public function providers(): View
    {
        return view('pages.placeholder', [
            'title' => 'Find Healthcare Provider',
            'description' => 'Search accredited hospitals and clinics across Plateau State.',
        ]);
    }

    public function news(): View
    {
        return view('pages.placeholder', [
            'title' => 'News & Updates',
            'description' => 'Latest articles, health campaigns, and press releases from PLASCHEMA.',
        ]);
    }

    public function resources(): View
    {
        return view('pages.placeholder', [
            'title' => 'Resources & Downloads',
            'description' => 'Forms, policies, guidelines, reports, and circulars.',
        ]);
    }

    public function contact(): View
    {
        return view('pages.placeholder', [
            'title' => 'Contact Us',
            'description' => 'Reach the PLASCHEMA team — office address, hotlines, and contact form.',
        ]);
    }
}
