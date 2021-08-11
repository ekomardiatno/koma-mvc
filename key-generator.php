<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Key Generator for KOMA-MVC</title>
    <style>
    p {
        margin-top: 0;
        margin-bottom: 6px;
    }
    </style>
</head>

<body>
    <form action="key-generator.php" method="post">
        <div style="margin-bottom:15px">
            <label for="host">Host</label>
            <input type="text" name="host" placeholder="domain.com" id="host">
        </div>
        <div style="margin-bottom:15px">
            <label for="app">App Name</label>
            <input type="text" name="app" placeholder="App Name" id="app">
        </div>
        <div style="margin-bottom:15px">
            <label for="name">Author</label>
            <input type="text" name="name" placeholder="Author Name" id="name">
        </div>
        <div style="margin-bottom:15px">
            <label for="pass">Password</label>
            <input type="password" name="pass" placeholder="••••••••" id="pass">
        </div>
        <div style="margin-bottom:15px">
            <label for="exp">Expired</label>
            <input type="number" name="exp" placeholder="Months" id="exp">
        </div>
        <div style="margin-bottom:15px">
            <button type="submit">Generate</button>
        </div>
    </form>
    <?php
    if(isset($_POST['host'])) {
        $cipher = 'aes-256-cbc';
        $ivlen = openssl_cipher_iv_length($cipher);
        $iv = openssl_random_pseudo_bytes($ivlen);
        $date = date('Y-m-d');
        $expired = date('Y-m-d', strtotime('+'. $_POST['exp'] .' month', strtotime($date)));
        $exp = str_replace('-', '', $expired);
        $plaintext = $_POST['host'] . '//' . $_POST['app'] . '//' . $_POST['name'] . '//' . $exp;
        $hex = bin2hex($plaintext);
        $password = substr(hash('sha256', $_POST['pass'], true), 0, 32);
        $encrypt = base64_encode(openssl_encrypt($hex, $cipher, $password, 0, $iv));
        echo '<div style="margin-bottom: 8px">' .
            '<span>Hostname</span>'.
            '<p>' . $_POST['host'] . '</p>' .
        '</div>' .
        '<div style="margin-bottom: 8px">' .
            '<span>App Name</span>'.
            '<p>' . $_POST['app'] . '</p>' .
        '</div>' .
        '<div style="margin-bottom: 8px">' .
            '<span>Password</span>'.
            '<p>' ;
            for($i=0;$i<strlen($_POST['pass']);$i++) {
                echo '•';
            }
            echo '</p>' .
        '</div>' .
        '<div style="margin-bottom: 8px">' .
            '<span>Expired</span>'.
            '<p>' . $expired . '</p>' .
        '</div>';
        echo '<textarea cols="50" rows="4">' . bin2hex($iv) . $encrypt . '</textarea>';
    }
    ?>
</body>

</html>