@extends('layouts.admin')
@section('content')
    <!-- Page Heading -->
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">Announcements</h1>
        <a href="#" class="d-none d-sm-inline-block btn btn-sm btn-primary shadow-sm" data-toggle="modal" data-target="#addAnnouncementModal">
            <i class="fas fa-plus fa-sm text-white-50 mr-1"></i> New Announcement
        </a>
    </div>

    <!-- Alerts -->
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

    <!-- Announcements List -->
    <div class="card shadow mb-4">
        <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
            <h6 class="m-0 font-weight-bold text-primary">Your Announcements</h6>
            <div class="dropdown no-arrow">
                <a class="dropdown-toggle" href="#" role="button" id="dropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    <i class="fas fa-ellipsis-v fa-sm fa-fw text-gray-400"></i>
                </a>
                <div class="dropdown-menu dropdown-menu-right shadow animated--fade-in" aria-labelledby="dropdownMenuLink">
                    <div class="dropdown-header">Options:</div>
                    <a class="dropdown-item" href="#" data-toggle="modal" data-target="#addAnnouncementModal">
                        <i class="fas fa-plus fa-sm fa-fw mr-2 text-gray-400"></i>Add New
                    </a>
                    <a class="dropdown-item" href="#">
                        <i class="fas fa-archive fa-sm fa-fw mr-2 text-gray-400"></i>View Archived
                    </a>
                </div>
            </div>
        </div>
        <div class="card-body p-0">
            @if(count($announcements ?? []) > 0)
                <div class="accordion" id="announcementsAccordion">
                    @foreach($announcements as $announcement)
                        <div class="card rounded-0 border-0 border-bottom">
                            <!-- Announcement Header -->
                            <div class="card-header bg-white" id="heading{{ $announcement->id }}">
                                <div class="d-flex justify-content-between align-items-center">
                                    <div>
                                        <h6 class="mb-0">
                                            <button class="btn btn-link text-left text-primary collapsed" type="button"
                                                    data-toggle="collapse" data-target="#collapse{{ $announcement->id }}"
                                                    aria-expanded="false" aria-controls="collapse{{ $announcement->id }}">
                                                <i class="fas fa-chevron-down mr-2 text-gray-500 toggle-icon"></i>
                                                {{ $announcement->title }}
                                            </button>
                                        </h6>
                                    </div>
                                    <div class="d-flex align-items-center">
                                        <span>Published</span>
                                        <span>Published</span>
                                        <small class="text-muted mr-3">
                                            {{ \Carbon\Carbon::parse($announcement->created_at)->diffForHumans() }}
                                        </small>
                                        <div class="dropdown no-arrow">
                                            <a class="dropdown-toggle" href="#" role="button" id="dropdownMenuLink{{ $announcement->id }}"
                                               data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                <i class="fas fa-ellipsis-v fa-sm fa-fw text-gray-400"></i>
                                            </a>
                                            <div class="dropdown-menu dropdown-menu-right shadow animated--fade-in"
                                                 aria-labelledby="dropdownMenuLink{{ $announcement->id }}">
                                                <div class="dropdown-header">Actions:</div>

                                                <div class="dropdown-divider"></div>
                                                <a class="dropdown-item text-danger" href="#" data-toggle="modal" data-target="#deleteAnnouncementModal{{ $announcement->id }}">
                                                    <i class="fas fa-trash fa-sm fa-fw mr-2 text-gray-400"></i>Delete
                                                </a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Announcement Content -->
                            <div id="collapse{{ $announcement->id }}" class="collapse" aria-labelledby="heading{{ $announcement->id }}" data-parent="#announcementsAccordion">
                                <div class="card-body border-top">
                                    <div class="row">
                                        <div class="col-md-9">
                                            <h5 class="font-weight-bold mb-3">{{ $announcement->title }}</h5>
                                            <div class="announcement-content">
                                                {{ $announcement->message }}
                                            </div>
                                        </div>
                                        <div class="col-md-3 border-left">
                                            <h6 class="font-weight-bold mb-3">Details</h6>
                                            <ul class="list-unstyled">
                                                <li class="mb-2">
                                                    <i class="fas fa-calendar-alt mr-2 text-primary"></i>
                                                    <strong>Created:</strong>
                                                    {{ \Carbon\Carbon::parse($announcement->created_at)->format('M d, Y') }}
                                                </li>
                                                @if($announcement->updated_at != $announcement->created_at)
                                                    <li class="mb-2">
                                                        <i class="fas fa-edit mr-2 text-primary"></i>
                                                        <strong>Updated:</strong>
                                                        {{ \Carbon\Carbon::parse($announcement->updated_at)->format('M d, Y') }}
                                                    </li>
                                                @endif
                                                <li class="mb-2">
                                                    <i class="fas fa-eye mr-2 text-primary"></i>
                                                    <strong>Status:</strong>
                                                   <span>Published</span>
                                                </li>
                                                @if($announcement->is_published)
                                                    <li class="mb-2">
                                                        <i class="fas fa-paper-plane mr-2 text-primary"></i>
                                                        <strong>Published:</strong>
                                                        {{ \Carbon\Carbon::parse($announcement->published_at)->format('M d, Y') }}
                                                    </li>
                                                @endif
                                            </ul>

                                            <div class="mt-4">

                                                <a href="#" class="btn btn-sm btn-danger btn-block" data-toggle="modal" data-target="#deleteAnnouncementModal{{ $announcement->id }}">
                                                    <i class="fas fa-trash fa-sm mr-1"></i> Delete
                                                </a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Edit Announcement Modal -->


                        <!-- Delete Announcement Modal -->
                        <div class="modal fade" id="deleteAnnouncementModal{{ $announcement->id }}" tabindex="-1" role="dialog" aria-labelledby="deleteAnnouncementModalLabel{{ $announcement->id }}" aria-hidden="true">
                            <div class="modal-dialog" role="document">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title" id="deleteAnnouncementModalLabel{{ $announcement->id }}">Delete Announcement?</h5>
                                        <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                                            <span aria-hidden="true">×</span>
                                        </button>
                                    </div>
                                    <div class="modal-body">Are you sure you want to delete this announcement? This action cannot be undone.</div>
                                    <div class="modal-footer">
                                        <button class="btn btn-secondary" type="button" data-dismiss="modal">Cancel</button>
                                        <form action="{{ route('admin.announcements.delete') }}" method="POST">
                                            @csrf
                                            <input type="hidden" name="id" value="{{ $announcement->id }}">
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
                    <i class="fas fa-bullhorn fa-3x text-gray-300 mb-3"></i>
                    <p class="text-gray-500 mb-0">No announcements available.</p>
                    <button class="btn btn-primary mt-3" data-toggle="modal" data-target="#addAnnouncementModal">
                        <i class="fas fa-plus mr-1"></i> Create First Announcement
                    </button>
                </div>
            @endif
        </div>
    </div>

    <!-- Add Announcement Modal -->
    <div class="modal fade" id="addAnnouncementModal" tabindex="-1" role="dialog" aria-labelledby="addAnnouncementModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="addAnnouncementModalLabel">Create New Announcement</h5>
                    <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">×</span>
                    </button>
                </div>
                <form action="{{ route('admin.announcements.create') }}" method="POST">
                    @csrf
                    <div class="modal-body">
                        <div class="form-group">
                            <label for="title">Title <span class="text-danger">*</span></label>
                            <input type="text" class="form-control" id="title" name="title" required placeholder="Enter announcement title">
                        </div>
                        <div class="form-group">
                            <label for="message">Message <span class="text-danger">*</span></label>
                            <textarea class="form-control" id="message" name="message" rows="6" required placeholder="Enter announcement message..."></textarea>
                        </div>
                        <div class="form-group">
                            <label for="event">Select Event</label>
                            <select class="form-control" id="event" name="event_id">
                                <option value="" selected disabled>-- Choose an event --</option>
                                @foreach($events as $event)
                                    <option value="{{ $event->id }}">{{ $event->name }}</option>
                                @endforeach
                            </select>
                        </div>

                    </div>
                    <div class="modal-footer">
                        <button class="btn btn-secondary" type="button" data-dismiss="modal">Cancel</button>
                        <button type="submit" class="btn btn-primary">Create Announcement</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- JavaScript for toggle icon rotation -->
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            $('.collapse').on('show.bs.collapse', function() {
                $(this).siblings('.card-header').find('.toggle-icon').removeClass('fa-chevron-down').addClass('fa-chevron-up');
            });

            $('.collapse').on('hide.bs.collapse', function() {
                $(this).siblings('.card-header').find('.toggle-icon').removeClass('fa-chevron-up').addClass('fa-chevron-down');
            });
        });
    </script>
@endsection
