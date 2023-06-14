@section('content')

    <div class="container mt-5">
        <div class="text-center mt-4">
            <h3 class="text-dark text-uppercase">Daftar Antrian PCARE</h3>
        </div>
        <div class="row mb-5 mt-4 justify-content-center">
            <nav class="navbar navbar-light bg-transparent">
                <form class="form-group">
                    <div class="row mb-2 justify-content-center">
                        <div class="form-check-inline">
                            <label class="form-check-label">
                            </label>
                            <input type="radio" class="form-check-input" name="pilihjenis" value="nik">NIK
                        </div>
                        <div class="form-check-inline">
                            <label class="form-check-label">
                            </label>
                            <input type="radio" class="form-check-input" name="pilihjenis" value="noka">No Kartu 
                        </div>
                    </div>
                    <div class="row mb-2">
                        <div class="form-inline">
                            <input class="form-control mr-sm-2 search_text" type="search" placeholder="Silahkan isi kolom dengan nokartu / nik" aria-label="Search" id="posttext">
                            <button class="btn btn-outline-primary my-2 my-sm-0" type="button" id="btncari"><i class="fa fa-search"></i></button>
                        </div>
                    </div>
                    
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
        <div class="row justify-content-left mb-2">
            <h5 class="text-center"><span class="badge badge-secondary">Total Antrian : </span></h5>
            <h4 class="tempelcount" id="countantrian">&nbsp;0</h4>
        </div>



        <!-- modal form -->
        <div class="modal fade" id="modaladdantrian" data-backdrop="static" data-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="staticBackdropLabel">Add Antrian</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                    <form method="POST" action="javascript:void(0)" id="form-add-antrian">
                        <div class="modal-body">
                            <div class="row mb-3">
                                <div class="col-md-6">
                                    <label>Kode Provider</label>
                                    <input type="text" name="kdproviderpst" id="kdprovider" class="form-control" readonly>
                                </div>
                                <div class="col-md-6">
                                    <label>Tanggal Daftar</label>
                                    <input type="date" name="tgldaftar" id="tgldaftar" placeholder="Pilih Tanggal" class="form-control">
                                </div>
                            </div>
                            <div class="row mb-3">
                                <div class="col-md-12">
                                    <label>No Kartu</label>
                                    <input type="text" name="nokartu" id="nokartu" class="form-control" readonly>
                                </div>
                            </div>
                            <div class="row mb-3">
                                <div class="col-md-6">
                                    <label>Kode Poli</label>
                                    <select name="kdpoli" id="kdpoli" class="form-control kdpoli">
                                    </select>
                                </div>
                                <div class="col-md-6">
                                    <label>Keluhan</label>
                                    <input type="text" name="keluhan" id="keluhan" placeholder="Masukkan keluhan" class="form-control">
                                </div>
                            </div>
                            <div class="row mb-3">
                                <div class="col-md-4">
                                    <div class="form-check">
                                        <input type="checkbox" class="form-check-input" id="kunjsakit" name="kunjsakit">
                                        <label>Kunjungan Sakit</label>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <label>Siastole</label>
                                    <input type="number" class="form-control" min=0 id="siastole" name="siastole" value=0>
                                </div>
                                <div class="col-md-4">
                                    <label>Diastole</label>
                                    <input type="number" class="form-control" min=0 id="diastole" name="diastole" value=0>
                                </div>
                            </div>     
                            <div class="row mb-3">
                                <div class="col-md-4">
                                    <label>Berat Badan</label>
                                    <input type="number" class="form-control" min=0 id="beratbadan" name="beratbadan" value=0>
                                </div>
                                <div class="col-md-4">
                                     <label>Tinggi Badan</label>
                                    <input type="number" class="form-control" min=0 id="tinggibadan" name="tinggibadan" value=0>
                                </div>
                                <div class="col-md-4">
                                     <label>Resp Rate</label>
                                    <input type="number" class="form-control" min=0 id="resprate" name="resprate" value=0>
                                </div>
                            </div>
                            <div class="row mb-3">
                                <div class="col-md-3">
                                    <label>Lingkar Perut</label>
                                    <input type="number" class="form-control" min=0 id="lingkarperut" name="lingkarperut" value=0>
                                </div>
                                <div class="col-md-3">
                                    <label>Heart Rate</label>
                                    <input type="number" class="form-control" min=0 id="heartrate" name="heartrate" value=0>
                                </div>
                                <div class="col-md-3">
                                    <div class="form-check">
                                        <input type="checkbox" class="form-check-input" id="rujukbalik" name="rujukbalik">
                                        <label>Rujuk Balik</label>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <label>Kode TKP</label>
                                    <select name="kdtkp" id="kdtkp" class="form-control kdtkp">
                                    </select>
                                </div>
                            </div>                    
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                            <button type="submit" class="btn btn-primary" id="btnKirimData">Send</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <!-- close modal form -->
    </div>
@endsection

