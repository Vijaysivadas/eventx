@extends('layouts.admin')
@section('content')

        <!-- Page Heading -->
        <div class="d-sm-flex align-items-center justify-content-between mb-4">
            <h1 class="h3 mb-0 text-gray-800">Dashboard</h1>

        </div>

        <!-- Content Row -->
        <div class="row">

            <!-- Total events -->
            <div class="col-xl-3 col-md-6 mb-4">
                <div class="card border-left-primary shadow h-100 py-2">
                    <div class="card-body">
                        <div class="row no-gutters align-items-center">
                            <div class="col mr-2">
                                <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">
                                    Total Events</div>
                                <div class="h5 mb-0 font-weight-bold text-gray-800">3</div>
                            </div>

                        </div>
                    </div>
                </div>
            </div>

            <!-- Completed Events -->
            <div class="col-xl-3 col-md-6 mb-4">
                <div class="card border-left-success shadow h-100 py-2">
                    <div class="card-body">
                        <div class="row no-gutters align-items-center">
                            <div class="col mr-2">
                                <div class="text-xs font-weight-bold text-success text-uppercase mb-1">
                                    Completed Events</div>
                                <div class="h5 mb-0 font-weight-bold text-gray-800">0</div>
                            </div>

                        </div>
                    </div>
                </div>
            </div>

            <!-- Ongoing Events -->
            <div class="col-xl-3 col-md-6 mb-4">
                <div class="card border-left-info shadow h-100 py-2">
                    <div class="card-body">
                        <div class="row no-gutters align-items-center">
                            <div class="col mr-2">
                                <div class="text-xs font-weight-bold text-info text-uppercase mb-1">
                                    Ongoing Events
                                </div>
                                <div class="row no-gutters align-items-center">
                                    <div class="col-auto">
                                        <div class="h5 mb-0 mr-3 font-weight-bold text-gray-800">3</div>
                                    </div>

                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Pending Requests Card Example -->
            <div class="col-xl-3 col-md-6 mb-4">
                <div class="card border-left-warning shadow h-100 py-2">
                    <div class="card-body">
                        <div class="row no-gutters align-items-center">
                            <div class="col mr-2">
                                <div class="text-xs font-weight-bold text-warning text-uppercase mb-1">
                                    Pending Requests</div>
                                <div class="h5 mb-0 font-weight-bold text-gray-800">1</div>
                            </div>
                            <div class="col-auto">
                                <i class="fas fa-comments fa-2x text-gray-300"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>



        <!-- Content Row -->
        <div class="row">

            <!-- Content Column -->
            <div class="col-lg-6 mb-4">

                <!-- Volunteer Querys -->

                <div class="container mt-1">
                    <div class="card shadow mb-4">
                        <div class="card-header py-3">
                            <h6 class="m-0 font-weight-bold text-primary">Volunteer Query</h6>
                        </div>
                        <div class="card-body scrollable-card-body">
                            <!-- Messages will be dynamically inserted here -->
                            <div class="message">
                                <p><strong>John Doe:</strong> Just checked in for the event!</p>
                                <span class="timestamp">2 mins ago</span>
                                <button class="close-btn" onclick="removeMessage(this)">x</button>
                            </div>
                            <div class="message">
                                <p><strong>Jane Smith:</strong> Looking forward to the keynote session.</p>
                                <span class="timestamp">5 mins ago</span>
                                <button class="close-btn" onclick="removeMessage(this)">x</button>
                            </div>
                            <div class="message">
                                <p><strong>Jane Smith:</strong> Looking forward to the keynote session.</p>
                                <span class="timestamp">5 mins ago</span>
                                <button class="close-btn" onclick="removeMessage(this)">x</button>
                            </div>

                        </div>
                        <div class="card-footer text-center">
                            <button class="btn btn-sm btn-primary" onclick="refreshChat()">Refresh</button>
                        </div>
                    </div>
                </div>

                <!-- JavaScript to Add Messages Dynamically -->
                <script>
                    function refreshChat() {
                        location.reload();

                        // Auto-scroll to the latest message
                        setTimeout(() => {
                            messageBox.scrollTop = messageBox.scrollHeight;
                        }, 100);
                    }
                    function removeMessage(button) {
                        button.parentElement.remove(); // Removes the message card
                    }
                </script>

                <!--
                <div class="card shadow mb-4">
                    <div class="card-header py-3">
                        <h6 class="m-0 font-weight-bold text-primary">Vounteer Query</h6>
                    </div>
                    <div class="card-body">

                    </div>
                </div> -->



            </div>

            <div class="col-lg-6 mb-4">

                <!-- Illustrations -->
                <div class="card shadow mb-4">
                    <div class="card-header py-3">
                        <h6 class="m-0 font-weight-bold text-primary">Upcoming Event Dates</h6>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                                <thead>
                                <tr>
                                    <th>Name</th>
                                    <th>Venue</th>
                                    <th>Date</th>
                                </tr>
                                </thead>
                                <tbody>
                                <tr>
                                    <td>Edge+</td>
                                    <td>L1</td>

                                    <td>2011/04/25</td>

                                </tr>
                                <tr>
                                    <td>Renissance</td>
                                    <td>Main Auditorium</td>

                                    <td>2011/07/25</td>

                                </tr>

                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>


            </div>
        </div>

@endsection
