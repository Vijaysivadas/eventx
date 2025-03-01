@extends('layouts.admin')
@section('content')
    <!-- Page Heading -->
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">Event Management</h1>
        <a href="#" class="d-none d-sm-inline-block btn btn-sm btn-primary shadow-sm" data-toggle="modal" data-target="#addEventModal">
            <i class="fas fa-plus fa-sm text-white-50 mr-1"></i> Add New Event
        </a>
    </div>

    <!-- Alerts -->
    @if ($errors->any())
        <div class="alert alert-danger">
            <ul class="mb-0">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    @if (session('error'))
        <div class="alert alert-danger">
            {{ session('error') }}
        </div>
    @endif

    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            {{ session('success') }}
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
    @endif

    <!-- Events Listing with Bootstrap Cards -->
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">Your Events</h6>
        </div>
        <div class="card-body p-0">
            @if(count($events) > 0)
                @foreach($events as $event)
                    <div class="card mb-0 rounded-0 border-left-0 border-right-0">
                        <!-- Event Header -->
                        <div class="card-header bg-white py-3" id="heading{{ $event->id }}">
                            <div class="d-flex justify-content-between align-items-center">
                                <div>
                                    <button class="btn btn-link text-decoration-none text-left text-primary fw-bold collapsed"
                                            data-toggle="collapse"
                                            data-target="#collapse{{ $event->id }}"
                                            aria-expanded="false"
                                            aria-controls="collapse{{ $event->id }}">
                                        <i class="fas fa-caret-right toggle-icon mr-2"></i>
                                        <span class="font-weight-bold">{{ $event->name }}</span>
                                    </button>
                                    <span class="badge badge-{{ $event->status == 'upcoming' ? 'primary' : ($event->status == 'ongoing' ? 'success' : 'secondary') }} ml-2">
                                        {{ ucfirst($event->status) }}
                                    </span>
                                </div>
                                <div>
                                    <span class="text-muted small mr-3">
                                        <i class="fas fa-calendar-alt"></i>
                                        {{ \Carbon\Carbon::parse($event->start)->format('M d, Y') }}
                                    </span>

                                    <button class="btn btn-sm btn-outline-danger" data-toggle="modal" data-target="#deleteEventModal{{ $event->id }}">
                                        <i class="fas fa-trash fa-sm"></i>
                                    </button>
                                </div>
                            </div>
                        </div>

                        <!-- Collapsible Content -->
                        <div id="collapse{{ $event->id }}" class="collapse" aria-labelledby="heading{{ $event->id }}">
                            <div class="card-body border-top">
                                <div class="row">
                                    <!-- Left Column - Event Details -->
                                    <div class="col-md-8">
                                        <div class="mb-4">
                                            <h6 class="font-weight-bold">Description</h6>
                                            <p>{{ $event->description }}</p>
                                        </div>

                                        <div class="row">
                                            <div class="col-md-6">
                                                <h6 class="font-weight-bold">
                                                    <i class="fas fa-clock text-gray-500 mr-1"></i> Schedule
                                                </h6>
                                                <div class="pl-4 border-left border-primary">
                                                    <p class="mb-1">
                                                        <strong>Start:</strong> {{ \Carbon\Carbon::parse($event->start)->format('M d, Y g:i A') }}
                                                    </p>
                                                    <p class="mb-1">
                                                        <strong>End:</strong> {{ \Carbon\Carbon::parse($event->end)->format('M d, Y g:i A') }}
                                                    </p>
                                                    <p class="mb-1">
                                                        <strong>Duration:</strong>
                                                        {{ \Carbon\Carbon::parse($event->start)->diffForHumans(\Carbon\Carbon::parse($event->end), true) }}
                                                    </p>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <h6 class="font-weight-bold">
                                                    <i class="fas fa-map-marker-alt text-gray-500 mr-1"></i> Location
                                                </h6>
                                                <div class="pl-4 border-left border-success">
                                                    <p>{{ $event->venue }}</p>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <!-- Right Column - Contact & Status -->
                                    <div class="col-md-4">
                                        <div class="card bg-light">
                                            <div class="card-body">
                                                <h6 class="font-weight-bold mb-3">Contact Information</h6>
                                                <p class="mb-2">
                                                    <i class="fas fa-envelope text-gray-500 mr-2"></i>
                                                    <a href="mailto:{{ $event->contact_email }}">{{ $event->contact_email }}</a>
                                                </p>
                                                @if($event->contact_phone)
                                                    <p class="mb-3">
                                                        <i class="fas fa-phone text-gray-500 mr-2"></i>
                                                        <a href="tel:{{ $event->contact_phone }}">{{ $event->contact_phone }}</a>
                                                    </p>
                                                @endif

                                                <h6 class="font-weight-bold mt-4 mb-2">Event Status</h6>
                                                <div class="progress" style="height: 20px;">
                                                    @if($event->status == 'upcoming')
                                                        <div class="progress-bar bg-primary" role="progressbar" style="width: 33%"
                                                             aria-valuenow="33" aria-valuemin="0" aria-valuemax="100">
                                                            <span class="small">Upcoming</span>
                                                        </div>
                                                    @elseif($event->status == 'ongoing')
                                                        <div class="progress-bar bg-success" role="progressbar" style="width: 66%"
                                                             aria-valuenow="66" aria-valuemin="0" aria-valuemax="100">
                                                            <span class="small">Ongoing</span>
                                                        </div>
                                                    @else
                                                        <div class="progress-bar bg-secondary" role="progressbar" style="width: 100%"
                                                             aria-valuenow="100" aria-valuemin="0" aria-valuemax="100">
                                                            <span class="small">Completed</span>
                                                        </div>
                                                    @endif
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="card-footer bg-light">
                                <div class="d-flex justify-content-between align-items-center">
                                    <small class="text-muted">
                                        Created {{ \Carbon\Carbon::parse($event->created_at)->format('M d, Y') }}
                                    </small>

                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Delete Event Modal -->
                    <div class="modal fade" id="deleteEventModal{{ $event->id }}" tabindex="-1" role="dialog" aria-labelledby="deleteEventModalLabel{{ $event->id }}" aria-hidden="true">
                        <div class="modal-dialog" role="document">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="deleteEventModalLabel{{ $event->id }}">Delete Event?</h5>
                                    <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                                        <span aria-hidden="true">×</span>
                                    </button>
                                </div>
                                <div class="modal-body">Are you sure you want to delete the event "{{ $event->name }}"? This action cannot be undone.</div>
                                <div class="modal-footer">
                                    <button class="btn btn-secondary" type="button" data-dismiss="modal">Cancel</button>
                                    <form action="{{ route('admin.events.delete') }}" method="POST">
                                        @csrf
                                        @method('POST')
                                        <input type="hidden" name="id" value="{{ $event->id }}">
                                        <button type="submit" class="btn btn-danger">Delete</button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach
            @else
                <div class="text-center py-5">
                    <i class="fas fa-calendar fa-3x text-gray-300 mb-3"></i>
                    <p class="text-gray-500 mb-0">No events available.</p>
                    <a href="#" class="btn btn-primary mt-3" data-toggle="modal" data-target="#addEventModal">
                        <i class="fas fa-plus mr-1"></i> Create First Event
                    </a>
                </div>
            @endif
        </div>
    </div>

    <!-- Add Event Modal -->
    <div class="modal fade" id="addEventModal" tabindex="-1" role="dialog" aria-labelledby="addEventModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="addEventModalLabel">Create New Event</h5>
                    <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">×</span>
                    </button>
                </div>
                <form action="{{ route('admin.events.create') }}" method="POST">
                    @csrf
                    <div class="modal-body">
                        <div class="form-group">
                            <label for="eventName">Event Name <span class="text-danger">*</span></label>
                            <input type="text" class="form-control" id="eventName" name="name" required placeholder="Enter event name">
                        </div>
                        <div class="form-group">
                            <label for="eventDescription">Description <span class="text-danger">*</span></label>
                            <textarea class="form-control" id="eventDescription" name="description" rows="4" required placeholder="Enter event description"></textarea>
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="eventStart">Start Date/Time <span class="text-danger">*</span></label>
                                    <input type="datetime-local" class="form-control" id="eventStart" name="start" required>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="eventEnd">End Date/Time <span class="text-danger">*</span></label>
                                    <input type="datetime-local" class="form-control" id="eventEnd" name="end" required>
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="eventVenue">Venue <span class="text-danger">*</span></label>
                            <input type="text" class="form-control" id="eventVenue" name="venue" required placeholder="Enter event venue">
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="eventEmail">Contact Email <span class="text-danger">*</span></label>
                                    <input type="email" class="form-control" id="eventEmail" name="contact_email" required placeholder="Enter contact email">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="eventPhone">Contact Phone</label>
                                    <input type="text" class="form-control" id="eventPhone" name="contact_phone" placeholder="Enter contact phone">
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button class="btn btn-secondary" type="button" data-dismiss="modal">Cancel</button>
                        <button type="submit" class="btn btn-primary">Create Event</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    @section('scripts')
        <script>
            $(document).ready(function() {
                // Change icon when collapsing/expanding
                $('.collapse').on('show.bs.collapse', function() {
                    $(this).siblings('.card-header').find('.toggle-icon').removeClass('fa-caret-right').addClass('fa-caret-down');
                });

                $('.collapse').on('hide.bs.collapse', function() {
                    $(this).siblings('.card-header').find('.toggle-icon').removeClass('fa-caret-down').addClass('fa-caret-right');
                });

                // Add active class to the card header
                $('.collapse').on('show.bs.collapse', function() {
                    $(this).siblings('.card-header').addClass('border-left border-primary');
                });

                $('.collapse').on('hide.bs.collapse', function() {
                    $(this).siblings('.card-header').removeClass('border-left border-primary');
                });
            });
        </script>
    @endsection
@endsection
