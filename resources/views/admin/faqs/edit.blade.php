@extends('layouts.admin')

@section('title', 'Edit FAQ')
@section('page_heading', 'Edit FAQ')

@section('content')
    <div class="max-w-3xl">
        <div class="mb-6">
            <h2 class="text-2xl font-bold text-slate-900">Edit FAQ</h2>
            <p class="mt-1 text-sm text-slate-600">Update the question, answer, category, or publication status.</p>
        </div>

        <form method="POST" action="{{ route('admin.faqs.update', $faq) }}">
            @csrf
            @method('PUT')
            @include('admin.faqs._form')
        </form>
    </div>
@endsection
