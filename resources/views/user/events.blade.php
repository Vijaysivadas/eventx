@extends('layouts.user')
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
        <h1 class="h3 mb-2 text-gray-800">Event list</h1>

        <!-- DataTales Example -->
        <div class="card shadow mb-4">
            <div class="card-header py-3">
                <h6 class="m-0 font-weight-bold text-primary">Events</h6>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                        <thead>
                        <tr>
                            <th>Name</th>
                            <th>Venue</th>
                            <th>Date</th>
                            <th>Status</th>
                            <th>Action</th>
                        </tr>
                        </thead>
                        <tbody>
                        @forelse($events as $event)
                            <tr>
                                <td>{{ $event->name }}</td>
                                <td>{{ $event->venue }}</td>
                                <td>{{ \Carbon\Carbon::parse($event->start)->format('M d, Y') }}</td>
                                <td>
                                    @php
                                        $now = \Carbon\Carbon::now();
                                        $start = \Carbon\Carbon::parse($event->start);
                                        $end = \Carbon\Carbon::parse($event->end);

                                        if ($now < $start) {
                                            $status = 'Upcoming';
                                            $statusClass = 'primary';
                                        } elseif ($now >= $start && $now <= $end) {
                                            $status = 'Ongoing';
                                            $statusClass = 'success';
                                        } else {
                                            $status = 'Closed';
                                            $statusClass = 'secondary';
                                        }


                                    @endphp
                                    <span class="badge badge-{{ $statusClass }}">{{ $status }}</span>
                                </td>
                                <td>

                                    @if($now <= $end)
                                        @if(in_array($event->id, $appliedEventIds))
                                            <span class="badge badge-success">Applied</span>
                                        @else
                                            <form action="{{ route('user.events.apply') }}" method="post">
                                                @csrf
                                                <input type="hidden" name="event_id" value="{{ $event->id }}">
                                                <input type="hidden" name="type" value="participant">
{{--                                                <div class="form-group mb-3">--}}
{{--                                                    <label for="applicationType">Select application type</label>--}}
{{--                                                    <select class="form-control" id="applicationType" name="type" required>--}}
{{--                                                        <option value="participant">Participant</option>--}}
{{--                                                    </select>--}}
{{--                                                </div>--}}

                                                <button type="submit" class="btn btn-primary">Apply</button>

                                            </form>
                                        @endif

                                            @else
                                        <span class="text-muted">Event Closed</span>
                                    @endif
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="text-center">No events available at this time.</td>
                            </tr>
                        @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

@endsection
