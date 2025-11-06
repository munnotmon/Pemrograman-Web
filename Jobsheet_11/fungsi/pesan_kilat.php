<?php
// FILE: fungsi/pesan_kilat.php

// PASTIKAN INI TIDAK ADA TANDA SERU (!)
function set_flashdata($key = "", $value = "")
{
    // HARUSNYA: if (!empty($key) ... (jika key TIDAK kosong)
    if (!empty($key) && !empty($value)) {
        if (!isset($_SESSION['_flashdata'][$key])) {
            $_SESSION['_flashdata'][$key] = $value;
        }
        return true;
    }
    return false;
}

// PASTIKAN INI JUGA TIDAK ADA TANDA SERU (!)
function get_flashdata($key = "")
{
    // HARUSNYA: if (!empty($key) ... (jika key TIDAK kosong)
    if (!empty($key) && isset($_SESSION['_flashdata'][$key])) {
        $data = $_SESSION['_flashdata'][$key];
        unset($_SESSION['_flashdata'][$key]); // Langsung dihapus setelah diambil
        return $data;
    }
    // Hapus bagian 'else' yang echo javascript, itu tidak perlu
}

// ... (fungsi pesan() Anda biarkan saja, sudah benar) ...
function pesan($key = "", $pesan = "")
{
    // ... (kode ini tidak perlu diubah) ...
}
?>