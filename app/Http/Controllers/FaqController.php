<?php

namespace App\Http\Controllers;

use App\Models\FaqCategory;
use Illuminate\View\View;

class FaqController extends Controller
{
    public function index(): View
    {
        $categories = FaqCategory::query()
            ->with(['publishedFaqs'])
            ->orderBy('sort_order')
            ->get();

        return view('pages.faqs', compact('categories'));
    }
}
