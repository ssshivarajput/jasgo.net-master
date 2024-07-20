// redirectdonation.php
<?php
if (isset($_GET['data'])) {
    $data = $_GET['data'];
    // Redirect to the data
   // header('Location: ' . $data);
    echo "<script type='text/javascript'>window.location ='".$data."'</script>";
    exit();
} else {
    // Handle if data parameter is not provided
    echo "Data parameter not provided";
}
?>
