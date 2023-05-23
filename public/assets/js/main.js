//response table

$(document).ready(() => {
    
    const origin = location.origin;
    
    $('#btncari').click(() => {
        const nokartu = $('#postnokartu').val();
        var not_pass = false;
        
        //response get data peserta
        axios({
            method: "get",
            url: origin +"/getPeserta/" + nokartu
        })
        .then((response) => {
            $('#tr-peserta').addClass('d-none');
            var html = ""
            if(nokartu.type == "search" && nokartu.value == response.data.data.noKartu) {
                not_pass = true;
            } 
            if(nokartu == "" || nokartu.trim().length === 0)
            {
                alert("No Kartu Harap diisi");
                html += `<tr class="text-center" id="tr-record">
                            <td colspan="7">No Record</td>
                        </tr>`;
            }
            else{
                switch (response.data.code) {
                    case 200:
                        html += `<tr class="text-center text-dark">
                                    <td>${response.data.data.nama}</td>
                                    <td>${response.data.data.noKartu}</td>
                                    <td>${(response.data.data.kdProviderPst.kdProvider == null ? null : response.data.data.kdProviderPst.kdProvider )} / ${(response.data.data.kdProviderPst.nmProvider == null ? null : response.data.data.kdProviderPst.nmProvider )} </td>
                                    <td>${response.data.data.sex}</td>
                                    <td>${response.data.data.golDarah}</td>
                                    <td>${response.data.data.tglLahir}</td>
                                    <td>
                                        <div class="btn-group">
                                            <button class="btn btn-outline-primary my-2 my-sm-0" type="button" onclick="addantrian()">Add Antrian</button>
                                        </div>
                                    </td>
                                </tr>`;
                        break;
                    case 204:
                        html += `<tr class="text-center text-dark">
                                    <td colspan="7">Data Peserta Tidak Ditemukan</td>
                                </tr>`;
                        break
                    case 400:
                        html += `<tr class="text-center text-dark">
                                    <td colspan="7">No Response</td>
                                </tr>`
                    default:
                        break;
                }
            }
            $("#datapeserta").html(html);
            // console.log(response.data.data);
            // console.log(response);
        })
        .catch(error => {
            alert("No Response, Not Found Data");
        })
    });   

    $('#btnload').click(() => {
        
        const date = $('#postdate').val()
        const format = dateFormat(date, "dd-MM-yyyy")

        const startindex = $('#startindex').val()
        const endindex = $('#endindex').val()
        var not_pass = false
        // console.log("date : "+ format + "start : " + startindex + "endindex : " + endindex); 

        //response get pendaftaran by date
        axios({
            method: "get",
            url: origin +"/getAntrianProvider/" + format + "/" + startindex + "/" + endindex
        })
        .then((response) => {
            const data = response.data.data.list
            var html = ""
            let index = 1;

            if(startindex < 0 && endindex < 0 || startindex === 0  && endindex === 0)
            {
                alert("Index tidak boleh < 0 atau sama dengan 0")
            }
            $('#tr-daftar').addClass('d-none');

            if(date.type == "date" && date.value == response.data.data.tglDaftar) {
                not_pass = true;
            } 

            if(date == "" && startindex === 0 && endindex === 0)
            {
                html += `<tr class="text-center" id="tr-record">
                            <td colspan="9">No Record</td>
                        </tr>`;
            }
            else{
                // console.log(response.data.data);
                switch (response.data.code) {
                    case 200:
                        if(data === undefined)
                        {
                            return
                        }
                        else{
                            data.forEach(element => {
    
                                html += `<tr class="text-center text-dark">
                                        <td>${index++}</td>
                                        <td>${element.peserta.nama}</td>
                                        <td>${element.noUrut}</td>
                                        <td>${element.peserta.noKartu}</td>
                                        <td>${(element.peserta.kdProviderPst.kdProvider == null ? null : element.peserta.kdProviderPst.kdProvider )} / ${(element.peserta.kdProviderPst.nmProvider == null ? null : element.peserta.kdProviderPst.nmProvider )} </td>
                                        <td>${element.peserta.sex}</td>
                                        <td>${element.peserta.golDarah}</td>
                                        <td>${element.peserta.tglLahir}</td>
                                        <td>
                                            <div class="btn-group">
                                                <button class="btn btn-outline-danger my-2 my-sm-0" type="button" onclick="showModal(${element.peserta.noKartu})">Delete Antrian</button>
                                            </div>
                                        </td>
                                    </tr>`;
                                // console.log(element.noUrut);
                            });
                        }
                        break;
                    case 204:
                        html += `<tr class="text-center text-dark">
                                    <td colspan="9">Data Peserta Tidak Ditemukan</td>
                                </tr>`;
                        break
                    case 400:
                        html += `<tr class="text-center text-dark">
                                    <td colspan="9">No Response</td>
                                </tr>`
                    default:
                        break;
                }
            }
            $("#loadpeserta").html(html);
        })
        .catch((error) => {
            if (error || error.request.status === 404)
            {
                alert("No Response, Not Found Data");
            }
        })
        
    });

})

//action javascript add antrian
const addantrian = () => {

    const origin = location.origin;
    const nokartu = $('#postnokartu').val();

    axios({
        method: "get",
        url: origin +"/getPeserta/" + nokartu
    })
    .then((response) => {
        if(response.data.code == 200)
        {
            axios({
                    method : "post",
                    url : origin + '/postAntrian',
                    headers: {
                        'content-type': 'text/json'
                    },
                    data : {
                        kdproviderpst : (response.data.data.kdProviderPst.kdProvider == null ? null : response.data.data.kdProviderPst.kdProvider),
                        nokartu : nokartu
                    }
            })
            .then((response) => {
                console.log(response);
                switch (response.data.code) {
                    case 200:
                        alert("No Antrian : " + response.data.data.message)
                        break;
                    case 400:
                        alert("Gagal mengambil antrian silahkan coba lagi")
                        break;
                    case 412:
                        alert("Gagal mengambil antrian karena ada salah satu data yang kosong")
                        break;
                    default:    
                        break;
                }
            })
            .catch(error => {
                alert("No Response, Not Found Data");
            })
        }
        else{
            alert("Gagal Response");   
        }
    });    
}

const showModal = (id) => {
    const formatnokartu = "000" + id.toString();
    console.log(formatnokartu);
    $('#hapusModal').modal('show');


    // const date = $('#postdate').val()
    // const format = dateFormat(date, "dd-MM-yyyy")

    // const startindex = $('#startindex').val()
    // const endindex = $('#endindex').val()

    // axios({
    //     method: "get",
    //     url: origin +"/getAntrianProvider/" + format + "/" + startindex + "/" + endindex
    // })
    // .then((response) => {
    //     // if(response.data.code == 200)
    //     // {
    //     //     console.log(response);
    //     // }
    //     // else{
    //     //     alert("Gagal Response");   
    //     // }
    //     console.log(response);

    // })
}

const deleteantrian = () => {
    console.log("tes");
}





