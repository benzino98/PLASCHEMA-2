@extends('layouts.admin')

@section('title', 'Create FAQ')
@section('page_heading', 'Create FAQ')

@section('content')
    <div class="max-w-3xl">
        <div class="mb-6">
            <h2 class="text-2xl font-bold text-slate-900">Add New FAQ</h2>
            <p class="mt-1 text-sm text-slate-600">Create a new frequently asked question for the public website.</p>
        </div>

        <form method="POST" action="{{ route('admin.faqs.store') }}">
            @csrf
            @include('admin.faqs._form')
        </form>
    </div>
@endsection
