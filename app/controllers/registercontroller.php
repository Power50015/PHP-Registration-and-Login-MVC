<?php
namespace MVC\Controllers;

use MVC\MODELS\UsersModel;
use MVC\LIB\InputFilter;
use MVC\LIB\Helper;

class RegisterController extends AbstractController
{
    use InputFilter;
    use Helper;

    protected $User_id;
    protected $User_name;
    protected $User_email;
    protected $User_password1;
    protected $User_password2;
    protected $User_img;
    protected $Errors = [];

    public function defaultAction()
    {
        if (isset($_SESSION['userid'])) {
            $this->redirect('/profile/');
        }
        if (isset($_POST['submit'])) {
            do {
                $this->User_id = $this->randomString();
            } while (UsersModel::getByPK($this->User_id));

            $this->User_name = $_POST['name'];

            $this->User_email = $_POST['email'];

            $this->User_password1 = $_POST['password1'];

            $this->User_password2 = $_POST['password2'];

            $this->User_img = $_FILES['img'];

            $this->Validate();

            if (empty($Errors)) {

                //Hash Password
                $this->User_password1 = password_hash($this->User_password1, PASSWORD_DEFAULT);

                // upload Img
                do {
                    $img = $this->randomString() . '_' . $this->User_img["name"];
                } while (UsersModel::getBy(['User_img' => $img]));

                $uploadPath = APP_PATH . DS . '..' . DS . 'public' . DS . 'upload'  . DS;
                move_uploaded_file($this->User_img["tmp_name"], $uploadPath . $img);

                $this->User_img = $img;

                $user = new UsersModel(
                    $this->User_id,
                    $this->User_name,
                    $this->User_email,
                    $this->User_password1,
                    $this->User_img
                );
                if ($user->create()) {
                    $msg = "<h1>Thank you </h1>";
                    $headers = 'From: ' . 'powerismynickname2016@gmail.com' . '\r\n';
                    mail($this->User_email, 'Register', $msg, $headers);
                    //Set The Session
                    session_regenerate_id(true);
                    $_SESSION['userid'] = $this->User_id;

                    $this->redirect('/profile/');
                }
            }
        }
        $this->_view();
    }


    public function Validate()
    {
        // Validate Name
        $this->User_name = $this->FilterString($this->User_name);
        if (strlen($this->User_name) < 3) {
            $this->Errors[] = 'Name must be more than 3 char';
        }
        if (UsersModel::getBy(['User_name' => $this->User_name])) {
            $this->Errors[] = 'This name Used befour';
        }
        // Validate Email
        $this->User_email = $this->FilterEmail($this->User_email);
        if (strlen($this->User_email) < 8) {
            $this->Errors[] = 'Email must be more than 9 char';
        }
        if (UsersModel::getBy(['User_email' => $this->User_email])) {
            $this->Errors[] = 'This Email Used befour';
        }
        // Validate Password
        $this->User_password1 = $this->FilterString($this->User_password1);
        $this->User_password2 = $this->FilterString($this->User_password2);
        if (strlen($this->User_password1) < 6) {
            $this->Errors[] = 'Password must be more than 6 char';
        }
        if ($this->User_password1 !== $this->User_password2) {
            $this->Errors[] = 'Password much match';
        }
        // Validate img
        if (!empty($this->User_img["name"])) {

            // List Of Allowed File Typed To Upload
            $imgAllowedExtension = array(
                "jpeg",
                "jpg",
                "png"
            );
            // Get img Extension
            $tmp                    = explode('.', $this->User_img["name"]);
            $file_extension         = end($tmp);
            $img_Extension        = strtolower($file_extension);

            if (!empty($this->User_img["name"]) && !in_array($img_Extension, $imgAllowedExtension)) {
                $this->Errors[] = 'This Extension Is Not Allowed';
            }
            if ($this->User_img["name"] > 4194304) {
                $this->Errors[] = 'Img Cant Be Larger Than 4MB';
            }
        } else {
            $this->Errors[] = 'Img Is Required';
        }
    }
}
