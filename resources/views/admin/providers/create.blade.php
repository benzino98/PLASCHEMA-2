@extends('layouts.admin')

@section('title', 'Add Provider')
@section('page_heading', 'Add Provider')

@section('content')
    <div class="max-w-3xl">
        <form action="{{ route('admin.providers.store') }}" method="POST" class="card space-y-6">
            @csrf
            @include('admin.providers._form')
            <div class="flex gap-3">
                <button type="submit" class="btn-primary">Create Provider</button>
                <a href="{{ route('admin.providers.index') }}" class="btn-outline">Cancel</a>
            </div>
        </form>
    </div>
@endsection
