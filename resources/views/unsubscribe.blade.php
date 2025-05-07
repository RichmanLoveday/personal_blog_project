@extends('layouts.master')
@section('content')
    <!-- Unsubscribe Page Start -->
    <div class="unsubscribe-area bg-light py-5">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-lg-6">
                    <div class="card shadow-sm">
                        <div class="card-body text-center">
                            <h3 class="mb-4">Unsubscribe from Emails</h3>
                            <p class="mb-4">We're sorry to see you go! If you no longer wish to receive our emails, please
                                confirm your unsubscription below.</p>
                            <form action="{{ route('unsubscribe.confirm') }}" method="POST">
                                @csrf
                                <input type="hidden" name="email" value="{{ $email }}">
                                <input type="hidden" name="subscriber_token" value="{{ $token }}">
                                <button type="submit" class="btn btn-danger w-100">Unsubscribe</button>
                            </form>
                            <p class="mt-4"><a href="{{ route('home') }}" class="text-decoration-none">Go back to
                                    homepage</a></p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Unsubscribe Page End -->

    @if (session('success'))
        <script>
            $(document).ready(function() {
                toastr.success("{{ session('success') }}");
            });
        </script>
    @endif


    @if (session('error'))
        <script>
            $(document).ready(function() {
                toastr.error("{{ session('error') }}");
            });
        </script>
    @endif
@endsection
