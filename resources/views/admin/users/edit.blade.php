@extends('layouts.admin')
@section('title','Edit User')
@section('page_heading','Edit User')
@section('content')
<div class="mb-6"><h2 class="text-2xl font-bold text-slate-900">{{ $user->name }}</h2><p class="mt-1 text-sm text-slate-600">Update account details, role assignment, or reset the password.</p></div>
@include('admin.users._form', ['route' => route('admin.users.update', $user), 'method' => 'PUT'])
@endsection
