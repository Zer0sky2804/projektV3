<?php
    session_unset();
    session_destroy();    
    echo "<script> alert('Úspěšně odhlášen.') </script>";
    echo "<script> window.location.href = 'index.html'; </script>";
    echo "<script>window.opener.location.reload();</script>";
    exit();
?>