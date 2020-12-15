@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
{{--                <div class="card-header"></div>--}}

                <div class="card-body">
                    <form method="POST" action="{{ route('home') }}">
                        @csrf

                        <div class="form-group row">
                            <label for="github_username" class="col-md-4 col-form-label text-md-right">{{ __('Username') }}</label>

                            <div class="col-md-6">
                                <input id="github_username" type="text" class="form-control @error('github_username') is-invalid @enderror" name="github_username" value="{{ old('github_username') }}" required autocomplete="github_username" autofocus>

                                @error('github_username')
                                <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="repository" class="col-md-4 col-form-label text-md-right">{{ __('Repository Name') }}</label>

                            <div class="col-md-6">
                                <input id="repository" type="text" class="form-control @error('repository') is-invalid @enderror" name="repository" required autocomplete="current-repository">

                                @error('repository')
                                <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row mb-0">
                            <div class="col-md-8 offset-md-4">
                                <button type="submit" class="btn btn-primary">
                                    {{ __('Get Commits') }}
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>

            @if(isset($commits) && is_array($commits) && count($commits) > 0)
            <div class="card mt-md-5">
                <div class="card-header">Repository Commits</div>
                <div class="card-body">

                </div>
            </div>
            @endif
        </div>
    </div>
</div>
@endsection
