@extends('layouts.admin')
@section('content')
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
    <!-- Page Heading -->
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">Volunteer Job Management</h1>
    </div>

    <!-- Tabs Navigation -->
    <ul class="nav nav-tabs mb-4" id="volunteerTabs" role="tablist">
        <li class="nav-item">
            <a class="nav-link active" id="jobs-tab" data-toggle="tab" href="#jobs" role="tab" aria-controls="jobs" aria-selected="true">
                <i class="fas fa-briefcase mr-1"></i>Job Posts
            </a>
        </li>
        <li class="nav-item">
            <a class="nav-link" id="requests-tab" data-toggle="tab" href="#requests" role="tab" aria-controls="requests" aria-selected="false">
                <i class="fas fa-user-clock mr-1"></i>Pending Requests
            </a>
        </li>
    </ul>

    <!-- Tab Content -->
    <div class="tab-content" id="volunteerTabsContent">
        <!-- Job Posts Tab -->
        <div class="tab-pane fade show active" id="jobs" role="tabpanel" aria-labelledby="jobs-tab">
            <!-- Add New Job Card -->
            <div class="row mb-4">
                <div class="col-12">
                    <div class="card shadow border-left-primary">
                        <div class="card-body">
                            <div class="row no-gutters align-items-center">
                                <div class="col mr-2">
                                    <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">
                                        Create New Volunteer Job
                                    </div>
                                    <div class="h5 mb-0 font-weight-bold text-gray-800">Post a new volunteer opportunity</div>
                                </div>
                                <div class="col-auto">
                                    <a href="#" class="btn btn-primary btn-icon-split" data-toggle="modal" data-target="#addJobModal">
                                        <span class="icon text-white-50">
                                            <i class="fas fa-plus"></i>
                                        </span>
                                        <span class="text">Add New Job</span>
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Job Posts List - Expandable Cards -->
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">Your Job Posts</h6>
                </div>
                <div class="card-body p-0">
                    @if(count($volunteerJobs) > 0)
                        <div class="accordion" id="jobsAccordion">
                            @foreach($volunteerJobs as $index => $job)
                                <div class="card mb-0 rounded-0 border-left-0 border-right-0">
                                    <!-- Job Header -->
                                    <div class="card-header bg-white py-3" id="headingJob{{ $job->id }}">
                                        <div class="d-flex justify-content-between align-items-center">
                                            <div>
                                                <button class="btn btn-link text-decoration-none text-left text-primary fw-bold collapsed"
                                                        data-toggle="collapse"
                                                        data-target="#collapseJob{{ $job->id }}"
                                                        aria-expanded="false"
                                                        aria-controls="collapseJob{{ $job->id }}">
                                                    <i class="fas fa-caret-right toggle-icon mr-2"></i>
                                                    <span class="font-weight-bold">{{ $job->title }}</span>
                                                </button>
                                                @if($job->status)
                                                    <span class="badge badge-success ml-2">Active</span>
                                                @else
                                                    <span class="badge badge-danger ml-2">Inactive</span>
                                                @endif
                                            </div>
                                            <div>
                                                <span class="text-muted small mr-3">
                                                    <i class="fas fa-users"></i>
                                                    {{ $applicantCount[$job->id]['total']  }} Applications
                                                </span>

                                                <a href="" class="btn btn-sm btn-outline-danger" data-toggle="modal" data-target="#deleteJobModal{{ $job->id }}">
                                                    <i class="fas fa-trash fa-sm"></i>
                                                </a>
                                            </div>
                                        </div>
                                    </div>

                                    <!-- Collapsible Content -->
                                    <div id="collapseJob{{ $job->id }}" class="collapse" aria-labelledby="headingJob{{ $job->id }}" data-parent="#jobsAccordion">
                                        <div class="card-body border-top">
                                            <div class="row">
                                                <!-- Left Column - Job Details -->
                                                <div class="col-md-8">
                                                    <div class="mb-4">
                                                        <h6 class="font-weight-bold">Description</h6>
                                                        <p>{{ $job->description }}</p>
                                                    </div>

                                                    <div class="row">
                                                        <div class="col-md-6">
                                                            <h6 class="font-weight-bold">
                                                                <i class="fas fa-info-circle text-gray-500 mr-1"></i> Details
                                                            </h6>
                                                            <div class="pl-4 border-left border-primary">

                                                                <p class="mb-1">
                                                                    <strong>Posted:</strong> {{ $job->created_at->format('M d, Y') }}
                                                                </p>
                                                            </div>
                                                        </div>
                                                        <div class="col-md-6">
                                                            <h6 class="font-weight-bold">
                                                                <i class="fas fa-users text-gray-500 mr-1"></i> Applications
                                                            </h6>
                                                            <div class="pl-4 border-left border-success">
                                                                <p class="mb-1">
                                                                    <strong>Total:</strong> {{ $job->applications_count ?? 0 }} applications
                                                                </p>
                                                                <p class="mb-1">
                                                                    <strong>Status:</strong>
                                                                    @if($job->status)
                                                                        <span class="text-success">Accepting applications</span>
                                                                    @else
                                                                        <span class="text-danger">Not accepting applications</span>
                                                                    @endif
                                                                </p>

                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>

                                                <!-- Right Column - Job Actions -->
                                            </div>
                                        </div>
                                        <div class="card-footer bg-light">
                                            <div class="d-flex justify-content-between align-items-center">
                                                <small class="text-muted">
                                                    Job ID: {{ $job->id }}
                                                </small>

                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <!-- Delete Job Modal -->
                                <div class="modal fade" id="deleteJobModal{{ $job->id }}" tabindex="-1" role="dialog" aria-labelledby="deleteJobModalLabel{{ $job->id }}" aria-hidden="true">
                                    <div class="modal-dialog" role="document">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h5 class="modal-title" id="deleteJobModalLabel{{ $job->id }}">Delete Job Post?</h5>
                                                <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                                                    <span aria-hidden="true">×</span>
                                                </button>
                                            </div>
                                            <div class="modal-body">Are you sure you want to delete this volunteer job post? This action cannot be undone.</div>
                                            <div class="modal-footer">
                                                <button class="btn btn-secondary" type="button" data-dismiss="modal">Cancel</button>
                                                <form action="{{ route('admin.jobs.delete') }}" method="POST">
                                                    @csrf
                                                    @method('POST')
                                                    <input type="hidden" name="id" value="{{ $job->id }}">
                                                    <button type="submit" class="btn btn-danger">Delete</button>
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    @else
                        <div class="text-center py-5">
                            <i class="fas fa-briefcase fa-3x text-gray-300 mb-3"></i>
                            <p class="text-gray-500 mb-0">No volunteer job posts available.</p>
                            <a href="#" class="btn btn-primary mt-3" data-toggle="modal" data-target="#addJobModal">
                                <i class="fas fa-plus mr-1"></i> Create First Job Post
                            </a>
                        </div>
                    @endif
                </div>
            </div>

            <!-- Pagination -->

        </div>

        <!-- Pending Requests Tab - Keeping original for now -->

        <div class="tab-pane fade" id="requests" role="tabpanel" aria-labelledby="requests-tab">
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">Pending Volunteer Applications</h6>
                </div>
                <div class="card-body p-0">
                    @if(count($pendingRequests) > 0)
                        <div class="accordion" id="requestsAccordion">
                            @foreach($pendingRequests as $request)
                                <div class="card rounded-0 border-0 border-bottom">
                                    <!-- Application Header -->
                                    <div class="card-header bg-white" id="heading{{ $request['application_id'] }}">
                                        <div class="d-flex justify-content-between align-items-center">
                                            <div>
                                                <h6 class="mb-0">
                                                    <button class="btn btn-link text-left text-primary collapsed" type="button"
                                                            data-toggle="collapse" data-target="#collapse{{ $request['application_id'] }}"
                                                            aria-expanded="false" aria-controls="collapse{{ $request['application_id'] }}">
                                                        <i class="fas fa-chevron-down mr-2 text-gray-500 toggle-icon"></i>
                                                        <span class="font-weight-bold">{{ $request['name'] }}</span> - {{ $request['job_title'] }}
                                                    </button>
                                                </h6>
                                            </div>
                                            <div>
                                                <span class="badge badge-primary mr-2">{{ $request['event_name'] }}</span>
                                                <span class="badge badge-warning">Applied {{ \Carbon\Carbon::parse($request['created_at'])->diffForHumans() }}</span>
                                            </div>
                                        </div>
                                    </div>

                                    <!-- Collapsible Content -->
                                    <div id="collapse{{ $request['application_id'] }}" class="collapse" aria-labelledby="heading{{ $request['application_id'] }}" data-parent="#requestsAccordion">
                                        <div class="card-body border-top">
                                            <div class="row">
                                                <!-- Applicant Details -->
                                                <div class="col-md-7">
                                                    <h6 class="font-weight-bold mb-3">Applicant Information</h6>
                                                    <div class="row mb-3">
                                                        <div class="col-md-6">
                                                            <p class="mb-1">
                                                                <i class="fas fa-user text-primary mr-2"></i>
                                                                <strong>Name:</strong> {{ $request['name'] }}
                                                            </p>
                                                            <p class="mb-1">
                                                                <i class="fas fa-envelope text-primary mr-2"></i>
                                                                <strong>Email:</strong> <a href="mailto:{{ $request['email'] }}">{{ $request['email'] }}</a>
                                                            </p>
                                                            <p class="mb-1">
                                                                <i class="fas fa-phone text-primary mr-2"></i>
                                                                <strong>Phone:</strong> {{ $request['phone'] ?? 'N/A' }}
                                                            </p>
                                                        </div>
                                                        <div class="col-md-6">
                                                            <p class="mb-1">
                                                                <i class="fas fa-briefcase text-primary mr-2"></i>
                                                                <strong>Job:</strong> {{ $request['job_title'] }}
                                                            </p>
                                                            <p class="mb-1">
                                                                <i class="fas fa-calendar-alt text-primary mr-2"></i>
                                                                <strong>Event:</strong> {{ $request['event_name'] }}
                                                            </p>
                                                            <p class="mb-1">
                                                                <i class="fas fa-map-marker-alt text-primary mr-2"></i>
                                                                <strong>Location:</strong> {{ $request['event_location'] ?? 'N/A' }}
                                                            </p>
                                                        </div>
                                                    </div>

                                                    @if(isset($request['experience']))
                                                        <div class="mb-3">
                                                            <h6 class="font-weight-bold">Experience & Skills</h6>
                                                            <p class="p-2 bg-light rounded">{{ $request['experience'] ?? 'No details provided' }}</p>
                                                        </div>
                                                    @endif

                                                    @if(isset($request['notes']))
                                                        <div>
                                                            <h6 class="font-weight-bold">Additional Notes</h6>
                                                            <p class="p-2 bg-light rounded">{{ $request['notes'] ?? 'No notes provided' }}</p>
                                                        </div>
                                                    @endif
                                                </div>

                                                <!-- Action Panel -->
                                                <div class="col-md-5 border-left">
                                                    <h6 class="font-weight-bold mb-3">Application Actions</h6>
                                                    <div class="card bg-light mb-3">
                                                        <div class="card-body">
                                                            <p class="mb-3">This application is currently <span class="badge badge-warning">Pending</span></p>

                                                            <div class="d-grid gap-2">
                                                                <form action="{{route('admin.jobs.approve')}}" method="post">
                                                                    @csrf
                                                                    <input type="hidden" name="id" value="{{$request['application_id']}}">

                                                                    <button class="btn btn-success btn-block mb-2" >
                                                                    <i class="fas fa-check mr-1"></i> Approve Application
                                                                </button>
                                                                </form>
                                                                <form action="{{route('admin.jobs.approve')}}" method="post">
                                                                    @csrf
<input type="hidden" name="id" value="{{$request['application_id']}}">
                                                                <button type="submit" class="btn btn-danger btn-block" >
                                                                    <i class="fas fa-times mr-1"></i> Decline Application
                                                                </button>
                                                                </form>
                                                            </div>
                                                        </div>
                                                    </div>

                                                    <div class="text-right">

                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <!-- Approve Modal -->
                                <div class="modal fade" id="approveModal{{ $request['application_id'] }}" tabindex="-1" role="dialog" aria-labelledby="approveModalLabel{{ $request['application_id'] }}" aria-hidden="true">
                                    <div class="modal-dialog" role="document">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h5 class="modal-title" id="approveModalLabel{{ $request['application_id'] }}">Approve Application?</h5>
                                                <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                                                    <span aria-hidden="true">×</span>
                                                </button>
                                            </div>
                                            <div class="modal-body">
                                                <p>Are you sure you want to approve this application from <strong>{{ $request['name'] }}</strong>?</p>
                                                <div class="alert alert-info">
                                                    <i class="fas fa-info-circle mr-1"></i> They will be notified and added to the volunteer list for this event.
                                                </div>
                                            </div>
                                            <div class="modal-footer">
                                                <button class="btn btn-secondary" type="button" data-dismiss="modal">Cancel</button>
                                                <form action="{{ route('admin.jobs.approve', $request['application_id']) }}" method="POST">
                                                    @csrf
                                                    <button type="submit" class="btn btn-success">Confirm Approval</button>
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <!-- Decline Modal -->
                                <div class="modal fade" id="declineModal{{ $request['application_id'] }}" tabindex="-1" role="dialog" aria-labelledby="declineModalLabel{{ $request['application_id'] }}" aria-hidden="true">
                                    <div class="modal-dialog" role="document">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h5 class="modal-title" id="declineModalLabel{{ $request['application_id'] }}">Decline Application?</h5>
                                                <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                                                    <span aria-hidden="true">×</span>
                                                </button>
                                            </div>
                                            <div class="modal-body">
                                                <p>Are you sure you want to decline this volunteer application from <strong>{{ $request['name'] }}</strong>?</p>
                                                <form id="declineForm{{ $request['application_id'] }}">
                                                    <div class="form-group">
                                                        <label for="declineReason{{ $request['application_id'] }}">Reason (Optional):</label>
                                                        <textarea class="form-control" id="declineReason{{ $request['application_id'] }}" name="decline_reason" rows="3" placeholder="Provide a reason for declining this application..."></textarea>
                                                        <small class="text-muted">This reason will be included in the notification email sent to the applicant.</small>
                                                    </div>
                                                </form>
                                            </div>
                                            <div class="modal-footer">
                                                <button class="btn btn-secondary" type="button" data-dismiss="modal">Cancel</button>
                                                <form action="{{ route('admin.jobs.decline', $request['application_id']) }}" method="POST">
                                                    @csrf
                                                    @method('PUT')
                                                    <input type="hidden" name="decline_reason" id="declineReasonCopy{{ $request['application_id'] }}">
                                                    <button type="submit" class="btn btn-danger" onclick="copyDeclineReason({{ $request['application_id'] }})">Decline Application</button>
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    @else
                        <div class="text-center py-5">
                            <i class="fas fa-user-clock fa-3x text-gray-300 mb-3"></i>
                            <p class="text-gray-500 mb-0">No pending volunteer requests at this time.</p>
                        </div>
                    @endif
                </div>
            </div>
        </div>

        <!-- JavaScript for copying decline reason -->
        <script>
            function copyDeclineReason(requestId) {
                const reason = document.getElementById('declineReason' + requestId).value;
                document.getElementById('declineReasonCopy' + requestId).value = reason;
            }

            // For toggle icon rotation
            document.addEventListener('DOMContentLoaded', function() {
                $('.collapse').on('show.bs.collapse', function() {
                    $(this).siblings('.card-header').find('.toggle-icon').removeClass('fa-chevron-down').addClass('fa-chevron-up');
                });

                $('.collapse').on('hide.bs.collapse', function() {
                    $(this).siblings('.card-header').find('.toggle-icon').removeClass('fa-chevron-up').addClass('fa-chevron-down');
                });
            });
        </script>

            </div>
        </div>
    </div>

    <!-- Add Job Modal -->
    <div class="modal fade" id="addJobModal" tabindex="-1" role="dialog" aria-labelledby="addJobModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="addJobModalLabel">Create New Volunteer Job</h5>
                    <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">×</span>
                    </button>
                </div>
                <form action="{{ route('admin.jobs.create') }}" method="POST">
                    @csrf
                    <div class="modal-body">
                        <div class="form-group">
                            <label for="jobTitle">Job Title <span class="text-danger">*</span></label>
                            <input type="text" class="form-control" id="jobTitle" name="title" required placeholder="Enter job title">
                        </div>
                        <div class="form-group">
                            <label for="jobDescription">Description <span class="text-danger">*</span></label>
                            <textarea class="form-control" id="jobDescription" name="description" rows="4" required placeholder="Enter job description"></textarea>
                        </div>
                        <div class="form-group">
                            <label for="eventSelect">Select Event</label>
                            @if(count($events)==0)
                                <div>No events created yet</div>
                            @endif
                            @if(count($events)>0)
                                <select class="form-control" id="eventSelect" name="event_id">
                                    <option value="" selected disabled>Choose an event</option>
                                    @foreach($events as $event)
                                        <option value="{{ $event->id }}">{{ $event->name }}</option>
                                    @endforeach
                                </select>
                            @endif
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button class="btn btn-secondary" type="button" data-dismiss="modal">Cancel</button>
                        <button type="submit" class="btn btn-primary">Create Job</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    @section('scripts')
        <script>
            // For copying decline reason
            function copyDeclineReason(requestId) {
                const reason = document.getElementById('declineReason' + requestId).value;
                document.getElementById('declineReasonCopy' + requestId).value = reason;
            }

            // For expandable cards
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
