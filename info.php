<?php
if (!function_exists('mysqli_init') && !extension_loaded('mysqli')) {
    echo 'We don\'t have mysqli!!!';
} else {
    echo 'Phew we have it!<br>';
}


echo password_hash('hashedexampleword', PASSWORD_BCRYPT);

$hash = '$2y$10$uOPXbbUA.je5hIYC3Gpk7.mayD.eo3d9OEF/iWzRwYPZinf9WjvIW';

if (password_verify('admin', $hash)) {
    echo 'Password is valid!';
} else {
    echo 'Invalid password.';
}

?>
