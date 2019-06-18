<?php
namespace MVC\Controllers;

use MVC\MODELS\UsersModel;
use MVC\LIB\InputFilter;
use MVC\LIB\Helper;

class LoginController extends AbstractController
{
    use InputFilter;
    use Helper;
    private $User_email;
    private $User_password;
    protected $Errors = [];

    public function defaultAction()
    {
        if (!isset($_SESSION['userid'])) {

            if (isset($_POST['submit'])) {

                // Get The data and filter it
                $this->User_email = $_POST['email'];
                $this->User_email = $this->FilterEmail($this->User_email);
                $this->User_password = $_POST['password'];
                $this->User_password = $this->FilterString($this->User_password);

                // Cheak Email
                $user = UsersModel::getBy(['User_email' => $this->User_email]);
                if ($user) {
                    $user = $user[0];
                    $id;
                    $hash;
                    foreach ($user as $key => $value) {
                        if ($key == 'User_id') {
                            $id = $value;
                        }
                        if ($key == 'User_password') {
                            $hash = $value;
                        }
                    }

                    //Cheak Password
                    if (password_verify($this->User_password, $hash)) {
                        session_regenerate_id(true);
                        $_SESSION['userid'] = $id;
                        if ($_POST['check']) {
                            setcookie('userid', $_SESSION['userid'], time() + (86400 * 30 * 30), "/");
                        }
                        $this->redirect('/profile/');
                    } else {
                        $this->Errors[] = 'This email or password isn\'t correct  ';
                    }
                } else {
                    $this->Errors[] = 'This email or password isn\'t correct  ';
                }
            }

            $this->_view();
        } else {
            $this->redirect('/profile/');
        }
        $this->_view();
    }
}
