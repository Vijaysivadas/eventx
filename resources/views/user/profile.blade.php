@extends('layouts.user')
@section('styles')
    <style>
        .profile-card {
            border-radius: 15px;
            overflow: hidden;
        }

        .profile-img {
            width: 120px;
            height: 120px;
            object-fit: cover;
            border: 4px solid white;
            box-shadow: 0px 4px 8px rgba(0, 0, 0, 0.1);
        }

        .profile-name {
            font-weight: bold;
            font-size: 1.5rem;
        }

        .profile-role {
            font-size: 1rem;
            color: gray;
        }

        .card-header {
            background: linear-gradient(135deg, #4e73df, #224abe);
            color: white;
            text-align: center;
        }
    </style>
@endsection
@section('content')
    <div class="row">
        <div class="col-lg-4">
            <div class="card shadow mb-4 profile-card text-center p-3">
                <div class="card-body">
                    <img class="profile-img rounded-circle mb-3" src="{{asset('assets/img/undraw_profile.svg') }}"
                         alt="Profile Picture">
                    <h4 class="profile-name">{{auth()->user()->name}}</h4>
                    <p class="profile-role">Service Worker</p>
                    <button class="btn btn-primary btn-sm">Edit Profile</button>
                </div>
            </div>
        </div>
        <div class="col-lg-8">
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold">About Me</h6>
                </div>
                <div class="card-body">
                    <p>Any description.</p>
                    <div class="row">
                        <div class="col-sm-6">
                            <p><strong>Email:</strong> {{auth()->user()->email}}</p>
                            <p><strong>Phone:</strong> +123 456 7890</p>
                        </div>
                        <div class="col-sm-6">
                            <p><strong>City:</strong> Thrissur</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection
