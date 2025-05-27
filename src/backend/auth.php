<?php
session_start();
    
if (!isset($_SESSION['status']) || $_SESSION['status'] != "login") {
    header("Location: ../main/login-fe.php?pesan=belum_login");
    exit;
}


header("Cache-Control: no-cache, no-store, must-revalidate"); 
header("Pragma: no-cache"); 
header("Expires: 0"); 
?>

<script>
  window.addEventListener("pageshow", function (event) {
    if (event.persisted || (window.performance && window.performance.navigation.type === 2)) {
      window.location.reload();
    }
  });
</script>
