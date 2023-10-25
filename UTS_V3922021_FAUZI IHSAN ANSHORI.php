<!DOCTYPE html>
<html>
<head>
    <title>Form Enkripsi dan Deskripsi</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css">
</head>
<body>
    <div class="container">
        <center><br><h1>VIGENERE CIPHER DAN AFFINE CIPHER</h1><br></center>

        <form method="post" action="">
            <div class="form-group">
                <input type="text" class="form-control" name="text" id="text" placeholder="Text Asli" required>
            </div>

            <div class="form-group">
                <input type="text" class="form-control" name="keyVigenere" id="keyVigenere" placeholder="Kata Kunci Text" required>
            </div>

            <div class="form-group">
                <input type="number" class="form-control" name="keyAffineA" id="keyAffineA" placeholder="Kata Kunci Numerik (1)" required>
            </div>

            <div class="form-group">
                <input type="number" class="form-control" name="keyAffineB" id="keyAffineB" placeholder="Kata Kunci Numerik (2)" required>
            </div>

            <input type="submit" class="btn btn-primary" value="ENKRIPSI DAN DESKRIPSI"><br><br><br><br>
        </form>
    </div>
    
<?php
function vigenereEncrypt($text, $key) {
    $text = strtoupper($text);
    $key = strtoupper($key);
    $encryptedText = "";
    $keyIndex = 0;
    $keyLength = strlen($key);

    for ($i = 0; $i < strlen($text); $i++) {
        $char = $text[$i];
        if (ctype_alpha($char)) {
            $charCode = ord($char) - 65;
            $keyChar = $key[$keyIndex % $keyLength];
            $keyCode = ord($keyChar) - 65;
            $encryptedCharCode = ($charCode + $keyCode) % 26;
            $encryptedChar = chr($encryptedCharCode + 65);
            $encryptedText .= $encryptedChar;
            $keyIndex++;
        } else {
            $encryptedText .= $char;
        }
    }

    return $encryptedText;
}

function affineEncrypt($text, $key) {
    $text = strtoupper($text);
    $encryptedText = "";

    for ($i = 0; $i < strlen($text); $i++) {
        $char = $text[$i];
        if (ctype_alpha($char)) {
            $charCode = ord($char) - 65;
            $encryptedCharCode = ($key[0] * $charCode + $key[1]) % 26;
            $encryptedChar = chr($encryptedCharCode + 65);
            $encryptedText .= $encryptedChar;
        } else {
            $encryptedText .= $char;
        }
    }

    return $encryptedText;
}

function vigenereDecrypt($text, $key) {
    $text = strtoupper($text);
    $key = strtoupper($key);
    $decryptedText = "";
    $keyIndex = 0;
    $keyLength = strlen($key);

    for ($i = 0; $i < strlen($text); $i++) {
        $char = $text[$i];
        if (ctype_alpha($char)) {
            $charCode = ord($char) - 65;
            $keyChar = $key[$keyIndex % $keyLength];
            $keyCode = ord($keyChar) - 65;
            $decryptedCharCode = ($charCode - $keyCode + 26) % 26;
            $decryptedChar = chr($decryptedCharCode + 65);
            $decryptedText .= $decryptedChar;
            $keyIndex++;
        } else {
            $decryptedText .= $char;
        }
    }

    return $decryptedText;
}

function affineDecrypt($text, $key) {
    $text = strtoupper($text);
    $decryptedText = "";
    $modInverse = array(
        1 => 1,
        3 => 9,
        5 => 21,
        7 => 15,
        9 => 3,
        11 => 19,
        15 => 7,
        17 => 23,
        19 => 11,
        21 => 5,
        23 => 17,
        25 => 25
    );
    $keyInverse = $modInverse[$key[0]] ?? null;

    for ($i = 0; $i < strlen($text); $i++) {
        $char = $text[$i];
        if (ctype_alpha($char)) {
            $charCode = ord($char) - 65;
            $decryptedCharCode = ($keyInverse * ($charCode - $key[1] + 26)) % 26;
            $decryptedChar = chr($decryptedCharCode + 65);
            $decryptedText .= $decryptedChar;
        } else {
            $decryptedText .= $char;
        }
    }

    return $decryptedText;
}

    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $text = $_POST["text"];
        $keyVigenere = strtoupper($_POST["keyVigenere"]);
        $keyAffineA = (int)$_POST["keyAffineA"];
        $keyAffineB = (int)$_POST["keyAffineB"];

        $encryptedTextVigenere = vigenereEncrypt($text, $keyVigenere);
        $encryptedTextAffine = affineEncrypt($encryptedTextVigenere, [$keyAffineA, $keyAffineB]);

        $decryptedTextAffine = affineDecrypt($encryptedTextAffine, [$keyAffineA, $keyAffineB]);
        $decryptedTextVigenere = vigenereDecrypt($decryptedTextAffine, $keyVigenere);

        echo "<h2>Jawaban :</h2>";
        echo "<p><strong>Text :</strong> $text</p>";
        echo "<p><strong>Kata Kunci Text :</strong> $keyVigenere</p>";
        echo "<p><strong>Kata Kunci Numerik :</strong> ($keyAffineA, $keyAffineB)</p>";
        echo "<p><strong>Enkripsi :</strong> $encryptedTextAffine</p>";
        echo "<p><strong>Deskripsi :</strong> $decryptedTextVigenere</p>";
    }
    ?>

<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js"></script>

</body>
</html>