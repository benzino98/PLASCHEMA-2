@extends('layouts.admin')
@section('title', 'Create Health Plan')
@section('page_heading', 'Create Health Plan')
@section('content')
    <div class="mb-6"><h2 class="text-2xl font-bold text-slate-900">New Health Plan</h2><p class="mt-1 text-sm text-slate-600">Add a health plan with pricing, description, and covered benefits.</p></div>
    <form method="POST" action="{{ route('admin.health-plans.store') }}">@csrf @include('admin.health-plans._form')</form>
@endsection
