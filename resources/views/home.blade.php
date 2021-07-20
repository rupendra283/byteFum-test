@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">{{ __('Dashboard') }}
                    <a href="{{ route('blogs.create') }}" class="btn btn-primary float-right">Create Blogs</a>
                </div>

                <div class="card-body">
                    blogs lists
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
