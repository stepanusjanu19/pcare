

//response table
$(() => {
    
    const origin = location.origin;

    $('#btncari').click(() => {
        const pilih = $("input[name='pilihjenis']:checked").val();
        const text = $("#posttext").val();
        var html = ""
        var not_pass = false;

        if(pilih === "nik")
        {
            axios({
                method: "get",
                url: origin +"/getPesertaByJenisKartu/" + pilih + '/' + text
            })
            .then((response) => {
                var html = ""
                $('#tr-peserta').addClass('d-none');
                if(text == "" || text.trim().length === 0)
                {
                    alert("No Kartu Harap diisi");
                    html += `<tr class="text-center" id="tr-record">
                    <td colspan="7">No Record</td>
                    </tr>`;
                }
                else if(text.type == "search" && text.value == response.data.data.noKartu) {
                    not_pass = true;
                } 
                else if(text.length < 13 || text.length > 16)
                {
                    alert("Text tidak boleh lebih dari 16 karakter atau kurang dari 13 karakter");
                    html += `<tr class="text-center" id="tr-record">
                                <td colspan="7">No Record</td>
                            </tr>`;
                }
    
                else
                {
                    if(response.data.code === 404)
                    {
                        // alert("No Response, Data Not Found");
                        alert(response.data.message);
                        html += `<tr class="text-center" id="tr-record">
                                    <td colspan="7">No Record</td>
                                </tr>`;
                        console.log(response);
                    }
                    else if(response.data.code === 412)
                    {
                        alert(response.data.message);
                        html += `<tr class="text-center" id="tr-record">
                                    <td colspan="7">No Record</td>
                                </tr>`;
                        console.log(response);
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
                                            <td colspan="7">No Record</td>
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
                }
                
                $("#datapeserta").html(html);
                // console.log(response.data.data);
                // console.log(response);
            })
            .catch((error) => {
                var html = ""
                if (error || error.request.status === 404)
                {
                    alert("No Response, Not Found Data");
                }
                html += `<tr class="text-center" id="tr-record">
                                    <td colspan="7">No Record</td>
                                </tr>`;
                alert("No Response, Not Found Data");
    
                $("#datapeserta").html(html);
    
                // console.log(error);
            })
        }
        else if (pilih === "noka" ){
            axios({
                method: "get",
                url: origin +"/getPeserta/" + text
            })
            .then((response) => {
                var html = ""
                $('#tr-peserta').addClass('d-none');
                if(text == "" || text.trim().length === 0)
                {
                    alert("No Kartu Harap diisi");
                    html += `<tr class="text-center" id="tr-record">
                    <td colspan="7">No Record</td>
                    </tr>`;
                }
                else if(text.type == "search" && text.value == response.data.data.noKartu) {
                    not_pass = true;
                } 
                else if(text.length < 13 || text.length > 16)
                {
                    alert("Text tidak boleh lebih dari 16 karakter atau kurang dari 13 karakter");
                    html += `<tr class="text-center" id="tr-record">
                                <td colspan="7">No Record</td>
                            </tr>`;
                }
                else
                {
                    if(response.data.code === 404)
                    {
                        // alert("No Response, Data Not Found");
                        alert(response.data.message);
                        html += `<tr class="text-center" id="tr-record">
                                    <td colspan="7">No Record</td>
                                </tr>`;
                        console.log(response);
                    }
                    else if(response.data.code === 412)
                    {
                        alert(response.data.message);
                        html += `<tr class="text-center" id="tr-record">
                                    <td colspan="7">No Record</td>
                                </tr>`;
                        console.log(response);
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
                                            <td colspan="7">No Record</td>
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
                }
                
                $("#datapeserta").html(html);
                // console.log(response.data.data);
                // console.log(response);
            })
            .catch((error) => {
                var html = ""
                if (error || error.request.status === 404)
                {
                    alert("No Response, Not Found Data");
                }
                html += `<tr class="text-center" id="tr-record">
                                    <td colspan="7">No Record</td>
                                </tr>`;
                alert("No Response, Not Found Data");
    
                $("#datapeserta").html(html);
    
                // console.log(error);
            })
        }else{
            alert("Silahkan pilih jenis kartu terlebih dahulu");
            html += `<tr class="text-center" id="tr-record">
                        <td colspan="7">No Record</td>
                    </tr>`;
        }
        //response get data peserta
        $("#datapeserta").html(html);

        
    });   

    $('#btnload').click(() => {
        
        const date = $('#postdate').val();
        const format = dateFormat(date, "dd-MM-yyyy")
        const startindex = $('#startindex').val()
        const endindex = $('#endindex').val()
        var not_pass = false


        axios({
            method: "get",
            url: origin +"/getAntrianProvider/" + format + "/" + startindex + "/" + endindex
        })
        .then((response) => {
            if(response.data.data)
            {
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
                                    localStorage.setItem('nourut', element.noUrut);
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
                                                    <button class="btn btn-outline-danger my-2 my-sm-0" type="button" onclick="deleteantrian('${element.peserta.noKartu}', '${localStorage.getItem('nourut')}', '${element.tglDaftar}', '${element.poli.kdPoli}')">Delete Antrian</button>
                                                </div>
                                            </td>
                                        </tr>`;
                                    // console.log(element.noUrut);
                                });
                            }
                            break;
                        case 204:
                            html += `<tr class="text-center text-dark">
                                        <td colspan="9">No Record</td>
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
                $('#countantrian').html(`&nbsp;`+response.data.data.count);
            }
            else if(response.data.code === 404)
            {

                // alert("No Response, Data Not Found");
                alert(response.data.message);
                html += `<tr class="text-center" id="tr-record">
                            <td colspan="9">No Record</td>
                        </tr>`;
                const data = JSON.stringify({
                    message : response.data.message,
                    code : response.data.code
                });
                console.log(data);
            }
            else{
                // console.log(response);
                alert("No Response, " + response.data.message );
                const data = JSON.stringify({
                    message : response.data.message,
                    code : response.data.code
                });
                console.log(data);
            }
        })
        .catch((error) => {
            if (error.response || error.request.status === 404 || date === NaN)
            {
                alert('Oops! ' + error.message);
                // console.error(error);
                console.log('Oops!', error.message);
                console.error('Oops!', error.message);
                return false
            }
        })
        // console.log("date : "+ format + "start : " + startindex + "endindex : " + endindex); 
        //response get pendaftaran by date
    });

})



    
const addantrian = () => {

    const origin = location.origin;

    $(() => {      
        
        $('#modaladdantrian').modal('show');

        const pilih = $("input[name='pilihjenis']:checked").val();
        const text = $("#posttext").val();
        
        //response get data peserta

        if(pilih === "nik")
        {
            axios({
                method: "get",
                url: origin +"/getPesertaByJenisKartu/" + pilih + '/' + text
            })
            .then((res) => {
                console.log(res);
                if(res.data.data)
                {
                    const kdprovider = res.data.data.kdProviderPst.kdProvider;
                    const nokartu = res.data.data.noKartu;
                    const checkkunjsakit = document.getElementById('kunjsakit');
                    const checkrujukbalik = document.getElementById('rujukbalik');
    
                    //setvalue
                    $('#kdprovider').attr("value", kdprovider);
                    $('#nokartu').attr("value", nokartu);
                    // $('#kunjsakit').attr("value", "false")
                    // $('#rujukbalik').attr("value", 0)
    
                    checkkunjsakit.addEventListener('change', () => {
                        if(checkkunjsakit.checked)
                        {
                            checkkunjsakit.value = "true"
                        }
                    })
    
                    checkrujukbalik.addEventListener('change', () => {
                        if(checkrujukbalik.checked)
                        {
                            checkrujukbalik.value = 1
                        }
                    })
    
    
                    if ($('#form-add-antrian').length > 0){
                        $('#form-add-antrian').validate({
                            rules : {
                                tgldaftar : {
                                    required : true,
                                },
                                kdpoli : {
                                    required : true,
                                },
                                keluhan : {
                                    required : true,
                                },
                                siastole : {
                                    required : true,
                                },
                                diastole : {
                                    required : true,
                                },
                                beratbadan : {
                                    required : true,
                                },
                                tinggibadan : {
                                    required : true,
                                },
                                resprate : {
                                    required : true,
                                },
                                lingkarperut : {
                                    required : true,
                                },
                                heartrate : {
                                    required : true,
                                },
                                kdtkp : {
                                    required : true
                                }
                            },
                            messages : {
                                tgldaftar : {
                                    required : "Silahkan isi kolom tanggal daftar",
                                },
                                kdpoli : {
                                    required : "Silahkan pilih kode poli",
                                },
                                keluhan : {
                                    required : "Silahkan isi kolom keluhan",
                                },
                                siastole : {
                                    required : "Silahkan isi kolom siastole",
                                },
                                diastole : {
                                    required : "Silahkan isi kolom diastole",
                                },
                                beratbadan : {
                                    required : "Silahkan isi kolom berat badan",
                                },
                                tinggibadan : {
                                    required : "Silahkan isi kolom tinggi badan",
                                },
                                resprate : {
                                    required : "Silahkan isi kolom resp rate",
                                },
                                lingkarperut : {
                                    required : "Silahkan isi kolom lingkar perut",
                                },
                                heartrate : {
                                    required : "Silahkan isi kolom heart rate",
                                },
                                kdtkp : {
                                    required : "Silahkan pilih kode ref tkp"
                                }
    
                            },
                            submitHandler: () => {
                                $('#btnKirimData').html('Sending...');  
                                const formData = $('#form-add-antrian').serialize();
                                console.log(formData);
                                $.ajax({
                                    method: "POST",
                                    data: formData,
                                    dataType: "json",
                                    url: origin + '/webPostAntrian',
                                    success: function(res) {
                                        console.log(res);
                                        switch (res.code) {
                                            case 201:
                                                // alert("No Antrian : " + response.data.data.message)
                                                Swal.fire(
                                                    'No Antrian',
                                                        res.data.message,
                                                    'success'
                                                )
                                                break;
                                            case 400:
                                                // alert("Gagal mengambil antrian silahkan coba lagi")
                                                Swal.fire(
                                                    'Gagal mengambil antrian silahkan coba lagi',
                                                    'error'
                                                )
                                                break;
                                            case 412:
                                                // alert("Gagal mengambil antrian karena ada salah sat  u data yang kosong")
                                                Swal.fire(
                                                    'Gagal mengambil antrian',
                                                    'karena ada salah satu data yang kosong',
                                                    'warning'
                                                )
                                                break;
                                            default:    
                                                break;
                                        }
    
                                        $('#modaladdantrian').modal('hide');
                                        $('#form-add-antrian')[0].reset();
                                        $('#btnKirimData').html('Send');  
    
                                    },
                                    error:(error) => {
                                        alert("No Response, Not Found Data");
                                        console.error(error);
                                    }
                                });
    
                                
    
    
                            }
                        })
                    }
    
    
                }
                else{
                    const data = JSON.stringify({
                        message : "Response Null",
                        code : 404
                    });
                    console.log(data);
                }
                // console.log(response);
            })     
        }
        else if (pilih === "noka")
        {
            axios({
                method: "get",
                url: origin +"/getPeserta/" + text
            })
            .then((res) => {
                console.log(res);
                if(res.data.data)
                {
                    const kdprovider = res.data.data.kdProviderPst.kdProvider;
                    const nokartu = res.data.data.noKartu;
                    const checkkunjsakit = document.getElementById('kunjsakit');
                    const checkrujukbalik = document.getElementById('rujukbalik');
    
                    //setvalue
                    $('#kdprovider').attr("value", kdprovider);
                    $('#nokartu').attr("value", nokartu);
                    // $('#kunjsakit').attr("value", "false")
                    // $('#rujukbalik').attr("value", 0)
    
                    checkkunjsakit.addEventListener('change', () => {
                        if(checkkunjsakit.checked)
                        {
                            checkkunjsakit.value = "true"
                        }
                    })
    
                    checkrujukbalik.addEventListener('change', () => {
                        if(checkrujukbalik.checked)
                        {
                            checkrujukbalik.value = 1
                        }
                    })
    
    
                    if ($('#form-add-antrian').length > 0){
                        $('#form-add-antrian').validate({
                            rules : {
                                tgldaftar : {
                                    required : true,
                                },
                                kdpoli : {
                                    required : true,
                                },
                                keluhan : {
                                    required : true,
                                },
                                siastole : {
                                    required : true,
                                },
                                diastole : {
                                    required : true,
                                },
                                beratbadan : {
                                    required : true,
                                },
                                tinggibadan : {
                                    required : true,
                                },
                                resprate : {
                                    required : true,
                                },
                                lingkarperut : {
                                    required : true,
                                },
                                heartrate : {
                                    required : true,
                                },
                                kdtkp : {
                                    required : true
                                }
                            },
                            messages : {
                                tgldaftar : {
                                    required : "Silahkan isi kolom tanggal daftar",
                                },
                                kdpoli : {
                                    required : "Silahkan pilih kode poli",
                                },
                                keluhan : {
                                    required : "Silahkan isi kolom keluhan",
                                },
                                siastole : {
                                    required : "Silahkan isi kolom siastole",
                                },
                                diastole : {
                                    required : "Silahkan isi kolom diastole",
                                },
                                beratbadan : {
                                    required : "Silahkan isi kolom berat badan",
                                },
                                tinggibadan : {
                                    required : "Silahkan isi kolom tinggi badan",
                                },
                                resprate : {
                                    required : "Silahkan isi kolom resp rate",
                                },
                                lingkarperut : {
                                    required : "Silahkan isi kolom lingkar perut",
                                },
                                heartrate : {
                                    required : "Silahkan isi kolom heart rate",
                                },
                                kdtkp : {
                                    required : "Silahkan pilih kode ref tkp"
                                }
    
                            },
                            submitHandler: () => {
                                $('#btnKirimData').html('Sending...');  
                                const formData = $('#form-add-antrian').serialize();
                                console.log(formData);
                                $.ajax({
                                    method: "POST",
                                    data: formData,
                                    dataType: "json",
                                    url: origin + '/webPostAntrian',
                                    success: function(res) {
                                        console.log(res);
                                        switch (res.code) {
                                            case 201:
                                                // alert("No Antrian : " + response.data.data.message)
                                                Swal.fire(
                                                    'No Antrian',
                                                        res.data.message,
                                                    'success'
                                                )
                                                break;
                                            case 400:
                                                // alert("Gagal mengambil antrian silahkan coba lagi")
                                                Swal.fire(
                                                    'Gagal mengambil antrian silahkan coba lagi',
                                                    'error'
                                                )
                                                break;
                                            case 412:
                                                // alert("Gagal mengambil antrian karena ada salah sat  u data yang kosong")
                                                Swal.fire(
                                                    'Gagal mengambil antrian',
                                                    'karena ada salah satu data yang kosong',
                                                    'warning'
                                                )
                                                break;
                                            default:    
                                                break;
                                        }
    
                                        $('#modaladdantrian').modal('hide');
                                        $('#form-add-antrian')[0].reset();
                                        $('#btnKirimData').html('Send');  
    
                                    },
                                    error:(error) => {
                                        alert("No Response, Not Found Data");
                                        console.error(error);
                                    }
                                });
    
                                
    
    
                            }
                        })
                    }
    
    
                }
                else{
                    const data = JSON.stringify({
                        message : "Response Null",
                        code : 404
                    });
                    console.log(data);
                }
                // console.log(response);
            })     
        }
    });

    axios({
        method: "get",
        url: origin +"/assets/json/reftkp.json"
    })
    .then((resp) => {
        const data = resp.data.tkp
        responsereftkp(data)
        const selectedValue = data.selectedValue;
        setselectreftkp(selectedValue);
        console.log(resp);
    })
    .catch((error) => { console.error(error); }) 


    //response select
    axios({
        method: "get",
        url: origin +"/getPoli/" + 0 + '/' + 16
    })
    .then((response) => {
        if(response.data.data)
        {
            const data = response.data.data.list
            switch (response.data.code) {
                case 200:
                    if(data === undefined)
                    {
                        return
                    }
                    else{
                        responsepoli(data);
                        const selectedValue = data.selectedValue;
                        setselectpoli(selectedValue);
                        console.log(response);
                    }
                    break;
                case 400:
                    console.log(response);
                    break;
                default:
                break;
            }
        }
        else{
            
            const selectElement = document.querySelector('.kdpoli');
            const option = document.createElement('option');
            option.value = null;
            option.textContent = "Not Found";
            selectElement.appendChild(option);

            const data = JSON.stringify({
                message : "Response Null",
                code : 404
            });
            console.log(data);
        }
        
    })
    .catch((error) => { console.error(error); })  


    // Mengisi Select dengan data
    const responsepoli = (data) => {
        const selectElement = document.querySelector('.kdpoli');

        if(data.length > 0)
        {
            selectElement.innerHTML = '';
            data.forEach(item => {
                const option = document.createElement('option');
                option.value = item.kdPoli;
                option.textContent = item.nmPoli;
                selectElement.appendChild(option);
            });
        }
        else{
            selectElement.innerHTML = '';
            const option = document.createElement('option');
            option.value = null;
            option.textContent = "Not Found";
            selectElement.appendChild(option);
        }
    }

    // Mengatur nilai terpilih pada Select
    const setselectpoli = (value) => {
        const selectElement = document.querySelector('.kdpoli');
        selectElement.value = value;
    }


    const responsereftkp = (data) => {
        const selectElement = document.querySelector('.kdtkp');

        if(data.length > 0)
        {
            selectElement.innerHTML = '';
            data.forEach(item => {
                const option = document.createElement('option');
                option.value = item.kdTkp;
                option.textContent = item.nmTkp;
                selectElement.appendChild(option);
            });
        }
        else{
            selectElement.innerHTML = '';
            const option = document.createElement('option');
            option.value = null;
            option.textContent = "Not Found";
            selectElement.appendChild(option);
        }
    }

    // Mengatur nilai terpilih pada Select
    const setselectreftkp = (value) => {
        const selectElement = document.querySelector('.kdtkp');
        selectElement.value = value;
    }

    

}  




//action javascript add antrian
// const addantrian = () => {

//     const origin = location.origin;
//     const nokartu = $('#postnokartu').val();

//     axios({
//         method: "get",
//         url: origin +"/getPeserta/" + nokartu
//     })
//     .then((response) => {
//         if(response.data.code == 200)
//         {
//             axios({
//                     method : "post",
//                     url : origin + '/postAntrian',
//                     headers: {
//                         'content-type': 'text/json'
//                     },
//                     data : {
//                         kdproviderpst : (response.data.data.kdProviderPst.kdProvider == null ? null : response.data.data.kdProviderPst.kdProvider),
//                         nokartu : nokartu
//                     }
//             })
//             .then((response) => {
//                 console.log(response);
//                 switch (response.data.code) {
//                     case 200:
//                         // alert("No Antrian : " + response.data.data.message)
//                         Swal.fire(
//                             'No Antrian',
//                              response.data.data.message,
//                             'success'
//                         )
//                         break;
//                     case 400:
//                         // alert("Gagal mengambil antrian silahkan coba lagi")
//                         Swal.fire(
//                             'Gagal mengambil antrian silahkan coba lagi',
//                             'error'
//                         )
//                         break;
//                     case 412:
//                         // alert("Gagal mengambil antrian karena ada salah satu data yang kosong")
//                         Swal.fire(
//                             'Gagal mengambil antrian',
//                             'karena ada salah satu data yang kosong',
//                             'warning'
//                         )
//                         break;
//                     default:    
//                         break;
//                 }
//             })
//             .catch(error => {
//                 alert("No Response, Not Found Data");
//             })
//         }
//         else{
//             alert("Gagal Response");   
//         }
//     });    
// }

//deleteantrian
const deleteantrian = (nokartu, nourut, date, kdpoli) => {
        const origin = location.origin;
        Swal.fire({
            title: 'Yakin ingin menghapus antrian ini ?',
            text: "Anda tidak bisa mengembalikan data antrian ini !",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Yes'
        }).then((result) => {
            if (result.isConfirmed) {
                axios({
                    method : "delete",
                    url : origin + "/deleteAntrian/" + nokartu + '/' + date + '/' + nourut + '/' + kdpoli
                })
                .then((response) => {
                    console.log(response);

                    const date = $('#postdate').val();
                    const format = dateFormat(date, "dd-MM-yyyy")
                    const startindex = $('#startindex').val()
                    const endindex = $('#endindex').val()

                    axios({
                        method: "get",
                        url: origin +"/getAntrianProvider/" + format + "/" + startindex + "/" + endindex
                    })
                    .then((response) => {
                       if(response.data.data.count > 0)
                       {
                            const data = response.data.data.list
                            var html = ""
                            let index = 1;
                            var html = ""
                            
                            switch (response.data.code) {
                                case 200:
                                    if(data === undefined)
                                    {
                                        return
                                    }
                                    else{
                                        data.forEach(element => {
                                            localStorage.setItem('nourut', element.noUrut);
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
                                                            <button class="btn btn-outline-danger my-2 my-sm-0" type="button" onclick="deleteantrian('${element.peserta.noKartu}', '${localStorage.getItem('nourut')}', '${element.tglDaftar}', '${element.poli.kdPoli}')">Delete Antrian</button>
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

                            $('#loadpeserta').html(html);
                            $('#countantrian').html(`&nbsp;`+response.data.data.count);

                       }
                       else if(response.data.code === 404)
                        {
                            html += `<tr class="text-center" id="tr-record">
                                        <td colspan="9">No Record</td>
                                    </tr>`;
                            const data = JSON.stringify({
                                message : response.data.message,
                                code : response.data.code
                            });
                            console.log(data);
                        }
                       else{
                            var html = "";
                            html += `<tr class="text-center text-dark">
                                <td colspan="9">No Record</td>
                            </tr>`;
                            const data = JSON.stringify({
                                message : response.data.message,
                                code : response.data.code
                            });
                            $('#loadpeserta').html(html);
                            console.log(data);
                       }
                    })
                    .catch((error) => {
                        if (error.response || date === NaN)
                        {
                            alert('Oops! ' + error.message);
                            // console.error(error);
                            console.log('Oops!', error.message);
                            return false
                        }
                        else{
                            var html = "";
                            html += `<tr class="text-center text-dark">
                                <td colspan="9">No Record</td>
                            </tr>`;
                            const data = JSON.stringify({
                                message : response.data.message,
                                code : response.data.code
                            });
                            $('#loadpeserta').html(html);
                            console.log(data);
                        }
                    })

                    // location.reload(true)
                    Swal.fire(
                        'Terhapus!',
                        'Data ini telah terhapus',
                        'success'
                    )

                })
               
            }
        })
    
}









