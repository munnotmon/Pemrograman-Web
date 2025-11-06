<?php
    // Fungsi antiinjection() VERSI POSTGRESQL (TIDAK AMAN)
    function antiinjection($koneksi, $data){
        // Membersihkan data (INI AKAN MERUSAK DATA)
        $filter = stripslashes(strip_tags(htmlspecialchars($data, ENT_QUOTES)));
        
        // Menggunakan fungsi escaping PostgreSQL
        $filter_sql = pg_escape_string($koneksi, $filter);
        
        return $filter_sql;
    }
?>