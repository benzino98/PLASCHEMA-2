@extends('layouts.admin')

@section('title', 'Edit Provider')
@section('page_heading', 'Edit Provider')

@section('content')
    <div class="max-w-3xl">
        <form action="{{ route('admin.providers.update', $provider) }}" method="POST" class="card space-y-6">
            @csrf @method('PUT')
            @include('admin.providers._form', ['provider' => $provider])
            <div class="flex gap-3">
                <button type="submit" class="btn-primary">Save Changes</button>
                <a href="{{ route('admin.providers.index') }}" class="btn-outline">Cancel</a>
            </div>
        </form>
    </div>
@endsection
