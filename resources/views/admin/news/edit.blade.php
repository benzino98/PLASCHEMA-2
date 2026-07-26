@extends('layouts.admin')
@section('title','Edit News Article')
@section('page_heading','Edit News Article')
@section('content')
<div class="mb-6"><h2 class="text-2xl font-bold text-slate-900">{{ $article->title }}</h2><p class="mt-1 text-sm text-slate-600">Update article content, image, and publication settings.</p></div>
<form method="POST" action="{{ route('admin.news.update',$article) }}" enctype="multipart/form-data">@csrf @method('PUT') @include('admin.news._form')</form>
@endsection
