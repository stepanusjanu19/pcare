@section('content')

    <div class="container mt-5">
        <div class="text-center mt-4">
            <h3 class="text-dark text-uppercase">Daftar Antrian PCARE</h3>
        </div>
        <div class="row mb-5 mt-4 justify-content-center">
            <nav class="navbar navbar-light bg-transparent">
                <form class="form-inline">
                    <input class="form-control mr-sm-2" type="search" placeholder="Silahkan isi no kartu BPJS" aria-label="Search" id="postnokartu">
                    <button class="btn btn-outline-primary my-2 my-sm-0" type="button" id="btncari">Search</button>
                </form>
            </nav>
        </div>
        <div class="row justify-content-center">
            <table class="table table-bordered">
                <thead class="text-center bg-dark text-light">
                    <tr>
                    <th scope="col">Full Name</th>
                    <th scope="col">Card Number</th>
                    <th scope="col">Provider Code</th>
                    <th scope="col">Sex</th>
                    <th scope="col">Blood Type</th>
                    <th scope="col">Birth Date</th>
                    <th scope="col">Action</th>
                    </tr>
                </thead>
                <tbody id="datapeserta">
                    <tr class="text-center" id="tr-peserta">
                        <td colspan="7">No Record</td>
                    </tr>
                </tbody>
            </table>
        </div>
        <div class="row mb-5 mt-4 justify-content-center">
            <nav class="navbar navbar-light bg-transparent">
                <form class="form-inline justify-content-center">
                    <input class="form-control mr-sm-2" type="date" id="postdate">
                    <input class="form-control mr-sm-2 sizeindex" type="number" id="startindex" min=0 value=0>
                    <input class="form-control mr-sm-2 sizeindex" type="number" id="endindex" min=0 value=0>
                    <button class="btn btn-outline-secondary my-2 my-sm-0" type="button" id="btnload"><i class="fa fa-refresh"></i></button>
                </form>
            </nav>
        </div>
        <div class="row justify-content-center">
            <table class="table table-bordered">
                <thead class="text-center bg-dark text-light">
                    <tr>
                    <th scope="col">No</th>
                    <th scope="col">Full Name</th>
                    <th scope="col">No Antrian</th>
                    <th scope="col">Card Number</th>
                    <th scope="col">Provider Code</th>
                    <th scope="col">Sex</th>
                    <th scope="col">Blood Type</th>
                    <th scope="col">Birth Date</th>
                    <th scope="col">Action</th>
                    </tr>
                </thead>
                <tbody id="loadpeserta">
                    <tr class="text-center" id="tr-daftar">
                        <td colspan="9">No Record</td>
                    </tr>
                </tbody>
            </table>
        </div>
        <div class="modal fade" id="hapusModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true" data-backdrop="false">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Delete Customer</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    Yakin ingin menghapus data antrian ini ?
                </div>
                <div class="modal-footer">
                    <input type="hidden" name="custid" class="SPBUID">
                    <button type="button" class="btn btn-danger" data-dismiss="modal">No</button>
                    <button type="submit" class="btn btn-primary" onclick="deleteantrian()" >Yes</button>
                </div>
                </div>
            </div>
        </div>
    </div>
@endsection

