@extends('layouts.admin')
@section('title','Edit Download')
@section('page_heading','Edit Download')
@section('content')
<div class="mb-6"><h2 class="text-2xl font-bold text-slate-900">{{ $download->title }}</h2><p class="mt-1 text-sm text-slate-600">Update metadata, publication, or replace the document file.</p></div>
<form method="POST" action="{{ route('admin.downloads.update',$download) }}" enctype="multipart/form-data">@csrf @method('PUT') @include('admin.downloads._form')</form>
@endsection
