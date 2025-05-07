@extends('layouts.master')
@section('content')
    <!-- Unsubscribe Success Page Start -->
    <div class="unsubscribe-success-area bg-light py-5">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-lg-6">
                    <div class="card shadow-sm">
                        <div class="card-body text-center">
                            <h3 class="mb-4 text-success">Unsubscribed Successfully</h3>
                            <p class="mb-4">You have successfully unsubscribed from our email list. We're sorry to see you
                                go!</p>
                            <a href="{{ route('home') }}" class="btn btn-primary w-100 mt-3">Return to Homepage</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Unsubscribe Success Page End -->

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
