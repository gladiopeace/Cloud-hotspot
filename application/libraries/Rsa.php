<?php
/**
 * 使用openssl实现非对称加密
 * 
 * @Yangbin 2017-4-10
 * Email:654665653@qq.com
 */
class Rsa
{
    /**
     * 私钥
     * 
     */
    private $_privKey;

    /**
     * 公钥
     * 
     */
    private $_pubKey;

 
    /**
     * 指定密钥文件地址
     * 
     */

    private $_config = array(
        'public_key'=>'-----BEGIN PUBLIC KEY-----
MIGfMA0GCSqGSIb3DQEBAQUAA4GNADCBiQKBgQDa5vG1xtEnckVU1UUAQhvEMM8+
eKk+fBI6tAshaU3JjEjTS+Kke+d3j+ymevJbPCJFSzMFby53sIqLfqwsrTsJCPlN
xibDFbggtnK9cpCpbLR7XTnEn6YJeSnMB3PsnSmy8xMGzS7neknNYAmWRcfcyFPJ
XwlsFGv0b0fKKW161wIDAQAB
-----END PUBLIC KEY-----',
        'private_key'=>'-----BEGIN RSA PRIVATE KEY-----
MIICXQIBAAKBgQDa5vG1xtEnckVU1UUAQhvEMM8+eKk+fBI6tAshaU3JjEjTS+Kk
e+d3j+ymevJbPCJFSzMFby53sIqLfqwsrTsJCPlNxibDFbggtnK9cpCpbLR7XTnE
n6YJeSnMB3PsnSmy8xMGzS7neknNYAmWRcfcyFPJXwlsFGv0b0fKKW161wIDAQAB
AoGBALomGDf/aU9FImZAslvE2/3bj/FNBIdJVOssviZceTTCog9lAcfkQfLvpkvw
U3Z4TaBlkW62nGpV64syXlHjwkWan0z7AXl7qWXN1g6rxvzLLSDtPASr09lhEB+F
bF6qVwge1jSdVJK2XxcHo3ZuUFeoNPE52Ky6kcRhEwsUBWgpAkEA97JzOUo8yZY9
gR96JQF+3yqvg/AriGlWHrOw7SU2xZ3whYlhWjZK0r5aygU9vnRkanW+gNMX66S0
qXYoUdB9nQJBAOI9ZcS4hxnCuy31OidK27ypzHZvjfKaAwqsteyIpvljOXD6Ca5n
znK9I19Y+K+3ulhX3VC4I2OYgYZUi8sNagMCQGdqJ9VJe2umwHMCk1qT70Z5aeIq
CeLgJ8aVu06ndOC4+kymePDTLhYix4EFAyxbJ/mSw0DB4YDOuWbvIBJYe7kCQQCp
3f2magKOVgbip+ilDfDUxA0PtAy5Zef4wNrLoYL1Zwn/CM3yFGEPB3IiqhP3I5UX
tcknTUrNAfnmmV5o9EZvAkAYOVLQ3rXrv3vXvSCSLwIBOlZMf6tTK5Km3CIudozl
4E3Y5AgIbU2Uz7zfNZiCE4T/o4rBmVx2UhGmn71VUF1e
-----END RSA PRIVATE KEY-----'
    );



   
    /**
     * 设置私钥
     * 
     */
    public function setupPrivKey()
    {
        if (is_resource($this->_privKey)) {
            return true;
        }
     
        $this->_privKey = openssl_pkey_get_private($this->_config['private_key']);
        return true;
    }

    /**
     * 设置公钥
     * 
     */
    public function setupPubKey()
    {
        if (is_resource($this->_pubKey)) {
            return true;
        }
        //$file = $this->_keyPath . DIRECTORY_SEPARATOR . 'pub.key';
        //$pubKey = file_get_contents($file);
        $id = openssl_pkey_get_public($this->_config['public_key']);
     
        $this->_pubKey = openssl_pkey_get_public($this->_config['public_key']);
        return true;
    }

    /**
     * 用私钥加密
     * 
     */
    public function privEncrypt($data)
    {
        if (!is_string($data)) {
            return null;
        }
        $encrypted = "";
        $this->setupPrivKey();
  
        $result = openssl_private_encrypt($data, $encrypted, $this->_privKey);
        if ($result) {
            return base64_encode($encrypted);
        }
        return null;
    }

    /**
     * 私钥解密
     * 
     */
    public function privDecrypt($encrypted)
    {
        if (!is_string($encrypted)) {
            return null;
        }
        $this->setupPrivKey();
        $encrypted = base64_decode($encrypted);
        $result = openssl_private_decrypt($encrypted, $decrypted, $this->_privKey);
        if ($result) {
            return $decrypted;
        }
        return null;
    }

    /**
     * 公钥加密
     * 
     */
    public function pubEncrypt($data)
    {
        if (!is_string($data)) {
            return null;
        }
        $encrypted = "";
        $this->setupPubKey();
        $result = openssl_public_encrypt($data, $encrypted, $this->_pubKey);
        if ($result) {
            return base64_encode($encrypted);
        }
        return null;
    }

    /**
     * 公钥解密
     * 
     */
    public function pubDecrypt($crypted)
    {
        if (!is_string($crypted)) {
            return null;
        }
        $this->setupPubKey();
        $crypted = base64_decode($crypted);
        $result = openssl_public_decrypt($crypted, $decrypted, $this->_pubKey);
        if ($result) {
            return $decrypted;
        }
        return null;
    }

    /**
     * __destruct
     * 
     */
 /*   public function __destruct() {
        @fclose($this->_privKey);
        @fclose($this->_pubKey);
    }*/
}

?> 