<?php

namespace Core;

class UserManagement extends BaseController
{
    protected $template = "registration.html.twig";

    public function login()
    {
        $username = isset($_POST['username']) ? $_POST['username'] : "";
        $password = isset($_POST['password']) ? $_POST['password'] : "";

        $this->session->setVariable('userName', $username);
        $this->session->setVariable('password', $password);

        $user = $this->session->getUser();
        $success = $user->login($username, $password);

        if (!$success) {
            $this->tplArguments['loginError'] = 0; // value does not matter
        } else {
            $this->redirect("?cl=MyAccount");
        }
    }

    /**
     * @codeCoverageIgnore  Method is written in non testable way
     */
    public function logout()
    {
        $user = $this->session->getUser();
        if ($user) {
            $user->logOut();
        }
        $this->redirect("/");
    }


    /**
     * @codeCoverageIgnore  Method is written in non testable way
     */
    public function register()
    {
        $username = isset($_POST['username']) ? $_POST['username'] : "";
        $password = isset($_POST['password']) ? $_POST['password'] : "";
        $password2 = isset($_POST['password2']) ? $_POST['password2'] : "";

        if ($username === "" || $password === "" || $password2 === "") {
            $this->tplArguments['registrationError'] = User::ERROR_EMPTY_FIELD;
            return;
        }

        $fakeUser = new User();

        $error = $fakeUser->create($username, $password, $password2);

        $this->tplArguments['registrationError'] = $error;
    }
}
