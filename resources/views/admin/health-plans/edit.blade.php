@extends('layouts.admin')
@section('title', 'Edit Health Plan')
@section('page_heading', 'Edit Health Plan')
@section('content')
    <div class="mb-6"><h2 class="text-2xl font-bold text-slate-900">{{ $plan->name }}</h2><p class="mt-1 text-sm text-slate-600">Update plan details, pricing, and benefits.</p></div>
    <form method="POST" action="{{ route('admin.health-plans.update', $plan) }}">@csrf @method('PUT') @include('admin.health-plans._form')</form>
@endsection
