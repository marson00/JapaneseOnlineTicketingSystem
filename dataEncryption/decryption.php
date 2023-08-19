<?php

class decryption {
    private $secretKey;

    public function __construct($secretKey) {
        $this->secretKey = $secretKey;
    }

    public function decrypt($input) {

        // Decrypt the encrypted username using the secret key
        $paddedKey = str_pad($this->secretKey, 16, chr(16 - (strlen($this->secretKey) % 16)), STR_PAD_RIGHT);
        $decryptedInput = openssl_decrypt($input, "AES-128-ECB", $paddedKey);

        return $decryptedInput;
    }
}

?>
