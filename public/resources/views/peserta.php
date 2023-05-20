@section('content')

    <div class="container">
        <div class="row mb-5 justify-content-center">
            <nav class="navbar navbar-light bg-light">
                <form class="form-inline">
                    <input class="form-control mr-sm-2" type="search" placeholder="Search" aria-label="Search" id="postnokartu">
                    <button class="btn btn-outline-primary my-2 my-sm-0" type="button" id="btncari">Search</button>
                </form>
            </nav>
        </div>
        <div class="row justify-content-center">
            <!-- <table class="table table-responsive table-bordered">
                <thead>
                    <tr>
                        <th>No Kartu</th>
                        <th>Kd Provider</th>
                        <th>Sex</th>
                        <th>Gol Darah</th>
                        <th>Message</th>
                        <th>Tanggal Lahir</th>
                    </tr>
                </thead>
                <tbody id="datapeserta">
                </tbody>
            </table> -->

            <table class="table">
                <thead>
                    <tr>
                    <th scope="col">Card Number</th>
                    <th scope="col">Provider Code</th>
                    <th scope="col">Sex</th>
                    <th scope="col">Blood Type</th>
                    <th scope="col">Response</th>
                    <th scope="col">Birth Date</th>
                    </tr>
                </thead>
                <tbody id="datapeserta">
                </tbody>
            </table>
        </div>
    </div>
@endsection

