<?php


namespace Quiz\Controllers;


use Quiz\Models\UserModel;

class AccountsController extends BaseController
{
    public function loginAction()
    {
        echo 'login';
    }
    public function registerAction()
    {
        if ($_SERVER["REQUEST_METHOD"] == "GET") {
            return $this->render("../templates/registrationTemplate");
        }


        try {
            $this->validateUser();
        } catch(\Exception $err) {
            $error =  $err->getMessage();
            return $this->render('../templates/registrationTemplate',
                compact('error'));
        }

        $name = $this->post['name'];
        $email = $this->post['email'];
        $phone = $this->post['phone'];
        $hashedPassword = password_hash ( $this->post['firstPassword'] , PASSWORD_DEFAULT);


        $user = new UserModel;
        $user->name=$name;
        $user->name=$email;
        $user->name=$phone;
        $user->password=$hashedPassword;

        echo 'register';
    }

    /**
     * @throws \Exception
     */
    private function validateUser()
    {
        $name = $this->post['name'];
        $email = $this->post['email'];
        $countryCode = $this->post['countryCode'];
        $phone = $this->post['phone'];
        $firstPassword = $this->post['firstPassword'];
        $repeatedPassword = $this->post['repeatedPassword'];

        if (!$name || !$email || !$phone || !$firstPassword || !$repeatedPassword || !$countryCode) {
            throw new \Exception ("Please fill out all fields.");
        }

        if ($firstPassword !== $repeatedPassword) {
            throw new \Exception ("Passwords do not match.");
        }

        if(!preg_match("/^[0-9]+$/", $countryCode)) {
            throw new \Exception ("Country code is not valid");
        }

        if(!preg_match("/^[0-9]+$/", $phone)) {
            throw new \Exception ("Phone number is not valid.");
        }

        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            throw new \Exception ("E-mail is not valid");
        }
    }
}