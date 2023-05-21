<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
    <title>Bridging PCARE Lidwina</title>
</head>
<body class="mb-5">
    <?php echo $this->yieldSection('content'); ?>    
</body>
<script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/popper.js@1.12.9/dist/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>
<script src="https://cdn.datatables.net/1.10.24/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.10.24/js/dataTables.bootstrap4.min.js"></script>
<script>
    $(document).ready(() => {
        $('#btncari').click(() => {
            const origin = location.origin;
            const nokartu = $('#postnokartu').val();
            
            axios({
                method: "get",
                url: origin +"/getPeserta/" + nokartu
            })
            .then((response) => {
                var html = ""
                html += `<tr class="text-center">
                                        <td>${response.data.data.nama}</td>
                                        <td>${response.data.data.noKartu}</td>
                                        <td>${response.data.data.kdProviderPst.kdProvider}</td>
                                        <td>${response.data.data.sex}</td>
                                        <td>${response.data.data.golDarah}</td>
                                        <td>${response.data.data.tglLahir}</td>
                                </tr>`;
                $("#datapeserta").html(html);
                console.log(response.data.data);
            })
            
        })
    })
        
</script>
</html>