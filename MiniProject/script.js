$(document).ready(function () {
    // Fungsi memuat daftar file
    function loadFiles() {
        $.ajax({
            url: "get_files.php",
            type: "GET",
            dataType: "json",
            success: function (files) {
                let html = "";
                if (files.length > 0) {
                    files.forEach(f => {
                        html += `
                            <tr>
                                <td><a href="uploads/${f.name}" target="_blank">${f.name}</a></td>
                                <td>${f.description}</td>
                                <td>${f.date || '-'}</td>
                            </tr>
                        `;
                    });
                } else {
                    html = `<tr><td colspan="3">Belum ada file yang diunggah.</td></tr>`;
                }
                $("#file-list tbody").html(html);
            },
            error: function () {
                $("#file-list tbody").html("<tr><td colspan='3'>Gagal memuat data.</td></tr>");
            }
        });
    }

    loadFiles();

    // Handle upload file
    $("#upload-form").on("submit", function (e) {
        e.preventDefault();

        let formData = new FormData(this);
        $("#status").text("Mengunggah...").css("color", "orange");

        $.ajax({
            url: "upload.php",
            type: "POST",
            data: formData,
            contentType: false,
            processData: false,
            success: function (response) {
                try {
                    let res = JSON.parse(response);
                    $("#status").text(res.msg).css("color", res.status === "success" ? "green" : "red");
                    if (res.status === "success") {
                        $("#file").val("");
                        $("#description").val("");
                        loadFiles(); // Update daftar tanpa reload
                    }
                } catch (e) {
                    $("#status").text("Respon server tidak valid.").css("color", "red");
                }
            },
            error: function () {
                $("#status").text("Terjadi kesalahan saat mengunggah file.").css("color", "red");
            }
        });
    });
});
