@extends('layouts.app')

@section('content')
    <div class="container" style="margin-top: 10%;">
        <div class="row justify-content-center">
            <div class="col-md-6 col-lg-8">
                <div class="card shadow-lg border-0 rounded-4">
                    <div class="card-body p-5">
                        <h3 class="text-center mb-4 fw-bold">{{ __('Verify Your Email Address') }}</h3>

                        @if (session('resent'))
                            <div class="alert alert-success" role="alert">
                                {{ __('A fresh verification link has been sent to your email address.') }}
                            </div>
                        @endif

                        <p>{{ __('Before proceeding, please check your email for a verification link.') }}</p>
                        <p>{{ __('If you did not receive the email') }},
                            <form class="d-inline" method="POST" action="{{ route('verification.resend') }}">
                                @csrf
                                <button type="submit" class="btn btn-link p-0 m-0 align-baseline">
                                    {{ __('click here to request another') }}
                                </button>.
                            </form>
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
