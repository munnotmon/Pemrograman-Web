<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>CRUD Dengan Ajax</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
</head>
<body>
<nav class="navbar navbar-dark bg-primary mb-4">
    <div class="container-fluid">
        <span class="navbar-brand mb-0 h1">CRUD Dengan Ajax</span>
    </div>
</nav>

<div class="container">
    <h2 class="text-center mb-4">Data Anggota</h2>

    <form id="formData">
        <input type="hidden" id="id" name="id">

        <div class="row mb-3">
            <div class="col-md-6">
                <label>Nama</label>
                <input type="text" id="nama" name="nama" class="form-control">
                <small id="nama_error" class="text-danger"></small>
            </div>
            <div class="col-md-6">
                <label>Jenis Kelamin</label><br>
                <input type="radio" name="jenis_kelamin" value="L"> Laki-laki
                <input type="radio" name="jenis_kelamin" value="P"> Perempuan
                <br><small id="jk_error" class="text-danger"></small>
            </div>
        </div>

        <div class="mb-3">
            <label>Alamat</label>
            <textarea id="alamat" name="alamat" class="form-control"></textarea>
            <small id="alamat_error" class="text-danger"></small>
        </div>

        <div class="mb-3">
            <label>No Telepon</label>
            <input type="text" id="no_telp" name="no_telp" class="form-control">
            <small id="telp_error" class="text-danger"></small>
        </div>

        <button type="submit" class="btn btn-primary"><i class="fa fa-save"></i> Simpan</button>
    </form>

    <hr>
    <div id="dataTable"></div>
</div>

<footer class="text-center mt-4">
    <p>© 2025 Copyright: <a href="#">Desain Dan Pemrograman Web</a></p>
</footer>

<script>
function loadData() {
    $("#dataTable").load("data.php");
}

$(document).ready(function() {
    loadData();

    $("#formData").on("submit", function(e) {
        e.preventDefault();
        let nama = $("#nama").val().trim();
        let alamat = $("#alamat").val().trim();
        let no_telp = $("#no_telp").val().trim();
        let jk = $("input[name='jenis_kelamin']:checked").val();

        $("#nama_error, #alamat_error, #telp_error, #jk_error").text("");

        if (nama === "") { $("#nama_error").text("Nama Harus Diisi!"); return; }
        if (!jk) { $("#jk_error").text("Jenis Kelamin Harus Dipilih"); return; }
        if (alamat === "") { $("#alamat_error").text("Alamat Harus Diisi!"); return; }
        if (no_telp === "") { $("#telp_error").text("No Telepon Harus Diisi!"); return; }

        $.ajax({
            url: "form_action.php",
            method: "POST",
            data: $(this).serialize(),
            dataType: "json",
            success: function(res) {
                if (res.success) {
                    alert(res.success);
                    $("#formData")[0].reset();
                    $("#id").val('');
                    loadData();
                } else {
                    alert(res.error);
                }
            }
        });
    });

    // Edit data
    $(document).on("click", ".edit_data", function() {
        let id = $(this).attr("id");
        $.ajax({
            url: "get_data.php",
            method: "POST",
            data: { id },
            dataType: "json",
            success: function(data) {
                $("#id").val(data.id);
                $("#nama").val(data.nama);
                $("#alamat").val(data.alamat);
                $("#no_telp").val(data.no_telp);
                $("input[name='jenis_kelamin'][value='" + data.jenis_kelamin + "']").prop("checked", true);
                window.scrollTo(0, 0);
            }
        });
    });
});

// Hapus data
$(document).on("click", ".hapus_data", function() {
    let id = $(this).attr("id");

    if (confirm("Yakin mau hapus data ini?")) {
        $.ajax({
            url: "delete_action.php",
            method: "POST",
            data: { id },
            dataType: "json",
            success: function(res) {
                if (res.success) {
                    alert(res.success);
                    loadData();
                } else {
                    alert(res.error);
                }
            }
        });
    }
});

</script>
</body>
</html>
