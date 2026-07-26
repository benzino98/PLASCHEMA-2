@extends('layouts.admin')
@section('title','Add Download')
@section('page_heading','Add Download')
@section('content')
<div class="mb-6"><h2 class="text-2xl font-bold text-slate-900">New Document</h2><p class="mt-1 text-sm text-slate-600">Upload a public form, policy, guideline, report, or circular.</p></div>
<form method="POST" action="{{ route('admin.downloads.store') }}" enctype="multipart/form-data">@csrf @include('admin.downloads._form')</form>
@endsection
