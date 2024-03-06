<?php

// Tentukan path absolut ke file artisan
$artisanPath = 'ftp://admin_siphon@siphon.pasamankab.go.id/public_html/apps/artisan';

// Jalankan perintah storage:link
$output = shell_exec("php \"$artisanPath\" -V:link");

// Tampilkan output dari perintah
echo "<pre>$output</pre>";
