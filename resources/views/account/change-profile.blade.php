@extends('adminlte::page')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card mt-4">
                <div class="card-header">Form Profile</div>

                <div class="card-body">
                    @if(session('success'))
                        <div class="alert alert-success" role="alert">
                            {{ session('success') }}
                        </div>
                    @endif

                    <form method="POST" action="{{ route('change-profile') }}">
                        @csrf

                        <div class="form-group row">
                            <label for="username" class="col-md-4 col-form-label text-md-right">{{ __('Username') }}</label>

                            <div class="col-md-6">
                                <input id="username" type="text" class="form-control" name="username" value="{{ Auth::user()->username }}" readonly>
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="profile_name" class="col-md-4 col-form-label text-md-right">{{ __('Name') }}</label>

                            <div class="col-md-6">
                                <input id="profile_name" type="text" class="form-control" name="profile_name" required value={{ Auth::user()->name }}>
                            </div>
                        </div>

                        <div class="form-group row mb-0">
                            <div class="col-md-6 offset-md-4">
                                 @if($errors->has('error'))
                                    <div class="alert alert-danger" role="alert">
                                        {{ $errors->first('error') }}
                                    </div>
                                @endif
                                
                                <button type="submit" class="btn btn-primary">
                                    {{ __('Change Profile') }}
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
