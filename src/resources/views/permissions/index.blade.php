@extends('vendor.rolevue.layouts.app')
@section('content')
    <section name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Permissions') }}
        </h2>
    </section>
    <div id="acl_wrapper" data-context="roles" class="table-wrapper">
        <section id="app">
            <permissions-all></permissions-all>
        </section>
    </div>
@endsection
