@extends('layouts.admin')
@section('title','Create News Article')
@section('page_heading','Create News Article')
@section('content')
<div class="mb-6"><h2 class="text-2xl font-bold text-slate-900">New Article</h2><p class="mt-1 text-sm text-slate-600">Create a campaign update, activity report, or press release.</p></div>
<form method="POST" action="{{ route('admin.news.store') }}" enctype="multipart/form-data">@csrf @include('admin.news._form')</form>
@endsection
