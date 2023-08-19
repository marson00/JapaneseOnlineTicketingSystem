<?php

class encryption {
    private $secretKey;

    public function __construct($secretKey) {
        $this->secretKey = $secretKey;
    }

    public function encrypt($input) {
        // Encrypt the username using a secret key
        $paddedKey = str_pad($this->secretKey, 16, chr(16 - (strlen($this->secretKey) % 16)), STR_PAD_RIGHT);
        $encryptedInput = openssl_encrypt($input, "AES-128-ECB", $paddedKey);

        return urlencode($encryptedInput);
    }
}

?>
