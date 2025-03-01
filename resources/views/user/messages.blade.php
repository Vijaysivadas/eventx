@extends('layouts.user')
@section('content')
    <!-- Page Heading -->
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">Announcements</h1>
    </div>

    <!-- Announcements List -->
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">Latest Announcements</h6>
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
                                        @if($announcement->created_at->diffInDays(now()) < 3)
                                            <span class="badge badge-danger mr-2">New</span>
                                        @endif
                                        <small class="text-muted">
                                            {{ \Carbon\Carbon::parse($announcement->created_at)->format('M d, Y') }}
                                        </small>
                                    </div>
                                </div>
                            </div>

                            <!-- Announcement Content -->
                            <div id="collapse{{ $announcement->id }}" class="collapse" aria-labelledby="heading{{ $announcement->id }}" data-parent="#announcementsAccordion">
                                <div class="card-body border-top">
                                    <div class="row">
                                        <div class="col-md-12">
                                            <div class="announcement-content">
                                                {{ $announcement->content }}
                                            </div>
                                            <div class="mt-3 text-right">
                                                <small class="text-muted">
                                                    Posted {{ \Carbon\Carbon::parse($announcement->created_at)->diffForHumans() }}
                                                </small>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            @else
                <div class="text-center py-5">
                    <i class="fas fa-bullhorn fa-3x text-gray-300 mb-3"></i>
                    <p class="text-gray-500 mb-0">No announcements available at this time.</p>
                </div>
            @endif
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
