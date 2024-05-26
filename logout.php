<?php
// Start the session
session_start();

// Clear all session data
session_unset();

// Destroy the session
session_destroy();

// Redirect user to home page with an alert after a delay
echo "<script>
    alert('You have been logged out.');
    setTimeout(function() {
        window.location.href = 'Home.php';
    }, 2000);
</script>";
?>
