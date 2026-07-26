@extends('layouts.admin')
@section('title','Create User')
@section('page_heading','Create User')
@section('content')
<div class="mb-6"><h2 class="text-2xl font-bold text-slate-900">New User</h2><p class="mt-1 text-sm text-slate-600">Add an administrator or content editor.</p></div>
@include('admin.users._form', ['route' => route('admin.users.store'), 'method' => 'POST'])
@endsection
