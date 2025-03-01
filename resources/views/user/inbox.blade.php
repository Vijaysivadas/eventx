@extends('layouts.user')
@section('content')
    <div class="container-fluid">
        <!-- Page Heading -->
        <div class="d-sm-flex align-items-center justify-content-between mb-4">
            <h1 class="h3 mb-0 text-gray-800">Volunteer Opportunities</h1>
        </div>

        <!-- Alerts for form submission -->
        @if(session('success'))
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                {{ session('success') }}
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
        @endif

        @if(session('error'))
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                {{ session('error') }}
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
        @endif

        @if ($errors->any())
            <div class="alert alert-danger">
                <ul class="mb-0">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <!-- Filter Card -->


        <!-- Volunteer Jobs List - Expandable Cards -->
        <div class="card shadow mb-4">
            <div class="card-header py-3">
                <h6 class="m-0 font-weight-bold text-primary">Available Opportunities</h6>
            </div>
            <div class="card-body p-0">
                @if(count($jobs) > 0)
                    <div class="accordion" id="jobsAccordion">
                        @foreach($jobs as $job)
                            <div class="card rounded-0 border-0 border-bottom">
                                <!-- Job Header -->
                                <div class="card-header bg-white" id="heading{{ $job->id }}">
                                    <div class="d-flex justify-content-between align-items-center">
                                        <div>
                                            <h6 class="mb-0">
                                                <button class="btn btn-link text-left text-primary" type="button"
                                                        data-toggle="collapse" data-target="#collapse{{ $job->id }}"
                                                        aria-expanded="false" aria-controls="collapse{{ $job->id }}">
                                                    <i class="fas fa-chevron-down mr-2 text-gray-500"></i>
                                                    {{ $job->title }}
                                                </button>
                                            </h6>
                                        </div>
                                        <div class="d-flex align-items-center">
                                            <span class="badge badge-secondary mr-2">{{ $job->name }}</span>
                                            <span class="badge badge-info">{{ $job->location ?? 'Various Locations' }}</span>
                                        </div>
                                    </div>
                                </div>

                                <!-- Job Content -->
                                <div id="collapse{{ $job->id }}" class="collapse" aria-labelledby="heading{{ $job->id }}" data-parent="#jobsAccordion">
                                    <div class="card-body">
                                        <div class="row">
                                            <div class="col-md-8">
                                                <h5 class="font-weight-bold mb-3">Job Description</h5>
                                                <p>{{ $job->description }}</p>

                                                @if($job->responsibilities)
                                                    <h6 class="font-weight-bold mt-4 mb-2">Responsibilities:</h6>
                                                    <p>{{ $job->responsibilities }}</p>
                                                @endif

                                                @if($job->requirements)
                                                    <h6 class="font-weight-bold mt-4 mb-2">Requirements:</h6>
                                                    <p>{{ $job->requirements }}</p>
                                                @endif
                                            </div>
                                            <div class="col-md-4 border-left">
                                                <h5 class="font-weight-bold mb-3">Details</h5>
                                                <ul class="list-unstyled">
                                                    <li class="mb-2">
                                                        <i class="fas fa-calendar-alt mr-2 text-primary"></i>
                                                        <strong>Event Date:</strong>
                                                        {{ \Carbon\Carbon::parse($job->event->start)->format('M d, Y') }}
                                                    </li>
                                                    <li class="mb-2">
                                                        <i class="fas fa-map-marker-alt mr-2 text-primary"></i>
                                                        <strong>Location:</strong>
                                                        {{ $job->event->venue }}
                                                    </li>
                                                    <li class="mb-2">
                                                        <i class="fas fa-clock mr-2 text-primary"></i>
                                                        <strong>Duration:</strong>
                                                        {{ \Carbon\Carbon::parse($job->event->start)->diffForHumans(\Carbon\Carbon::parse($job->event->end), true) }}
                                                    </li>
                                                    <li class="mb-2">
                                                        <i class="fas fa-users mr-2 text-primary"></i>
                                                        <strong>Positions:</strong>
                                                        {{ $job->positions ?? 'Multiple' }}
                                                    </li>
                                                </ul>

                                                <hr>

                                                @if(in_array($job->id, $appliedJobs ?? []))
                                                    <div class="alert alert-success mb-0">
                                                        <i class="fas fa-check-circle mr-2"></i> You have already applied
                                                    </div>
                                                @else
                                                    <form action="{{ route('user.inbox.apply') }}" method="POST">
                                                        @csrf
                                                        <input type="hidden" name="job_id" value="{{ $job->id }}">
                                                        <input type="hidden" name="event_id" value="{{ $job->event->id }}">
                                                        <input type="hidden" name="type" value="volunteer">



                                                        <button type="submit" class="btn btn-primary btn-block">
                                                            <i class="fas fa-paper-plane mr-1"></i> Apply Now
                                                        </button>
                                                    </form>
                                                @endif
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                @else
                    <div class="text-center py-5">
                        <i class="fas fa-clipboard-list fa-3x text-gray-300 mb-3"></i>
                        <p class="text-gray-500 mb-0">No volunteer opportunities available at this time.</p>
                    </div>
                @endif
            </div>
        </div>
    </div>
@endsection
