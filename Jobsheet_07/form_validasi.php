<!DOCTYPE html>
<html>
<head>
    <title>Form Input dengan Validasi dan AJAX</title>
    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
</head>
<body>
    <h1>Form Input dengan Validasi dan AJAX</h1>

    <form id="myForm">
        <label for="nama">Nama:</label>
        <input type="text" id="nama" name="nama">
        <span id="nama-error" style="color: red;"></span><br><br>

        <label for="email">Email:</label>
        <input type="text" id="email" name="email">
        <span id="email-error" style="color: red;"></span><br><br>

        <label for="password">Password:</label>
        <input type="password" id="password" name="password">
        <span id="password-error" style="color: red;"></span><br><br>

        <input type="submit" value="Submit">
    </form>

    <div id="hasil" style="margin-top: 20px; font-weight: bold;"></div>

    <script>
        $(document).ready(function() {
            $("#myForm").submit(function(event) {
                event.preventDefault(); // Mencegah pengiriman form biasa

                var nama = $("#nama").val();
                var email = $("#email").val();
                var password = $("#password").val();
                var valid = true;

                // Reset pesan error
                $("#nama-error").text("");
                $("#email-error").text("");
                $("#password-error").text("");
                $("#hasil").text("");

                // Validasi sederhana
                if (nama === "") {
                    $("#nama-error").text("Nama harus diisi.");
                    valid = false;
                }

                if (email === "") {
                    $("#email-error").text("Email harus diisi.");
                    valid = false;
                }

                if (password === "") {
                    $("#password-error").text("Password harus diisi.");
                    valid = false;
                } else if (password.length < 8) {
                    $("#password-error").text("Password minimal 8 karakter.");
                    valid = false;
                }

                if (!valid) return; // Jika tidak valid, hentikan proses

                // Kirim data dengan AJAX
                $.ajax({
                    url: "proses_validasi.php",
                    type: "POST",
                    data: { nama: nama, email: email, password: password },
                    success: function(response) {
                        $("#hasil").html(response); // Tampilkan hasil dari PHP
                    },
                    error: function() {
                        $("#hasil").text("Terjadi kesalahan saat mengirim data.");
                    }
                });
            });
        });
    </script>
</body>
</html>
