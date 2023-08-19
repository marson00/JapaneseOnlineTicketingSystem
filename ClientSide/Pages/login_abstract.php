<?php

abstract class login_abstract {

    protected $loginInput;
    protected $password;
    protected $statusId;
    protected $isError;

    public function doLogin() {
        $this->loginInput = $_POST['username'];
        $this->password = $_POST['password'];
        $this->statusId = 1;
        $this->isError = false;

        $this->connect();

        if ($this->isError == true) {
            return $this->showError();
        } else {
            return $this->handleSuccess();
        }
    }

    protected function connect() {
        $conn = connection::getInstance()->getCon();

        session_start();
        $_SESSION['isLogin'] = false;

        $query = "SELECT `userId`, `roleId`, `username`, `password`, `email` 
                  FROM user 
                  WHERE (username = :username OR email = :email)
                  AND password = PASSWORD(:password)
                  AND statusId = :statusId";

        $stmt = $conn->prepare($query);
        $stmt->bindValue(':username', $this->loginInput);
        $stmt->bindValue(':email', $this->loginInput);
        $stmt->bindValue(':password', $this->password);
        $stmt->bindParam(':statusId', $this->statusId);
        $stmt->execute();
        $rowCount = $stmt->rowCount();

        if ($rowCount > 0) {
             $this->handleSuccess($stmt);
        } else{
             $this->isError = true;
        }
    }

    protected abstract function handleSuccess($stmt);

    protected abstract function showError();
}
