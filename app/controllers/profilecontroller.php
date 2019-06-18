<?php
namespace MVC\Controllers;

use MVC\LIB\Helper;
use MVC\Models\UsersModel;
use MVC\LIB\InputFilter;

class ProfileController extends AbstractController
{
    use InputFilter;
    use Helper;
    public $User_id;
    public $User_name;
    public $User_email;
    public $User_password;
    public $User_img;
    public $Errors = [];

    public function defaultAction()
    {
        if (isset($_SESSION['userid'])) {
            // Set The ID 
            $this->User_id = $_SESSION['userid'];

            //Get The Data of the user
            $user = UsersModel::getByPK($_SESSION['userid']);
            //$user = $user[0];
            foreach ($user as $key => $value) {
                if ($key == 'User_name') {
                    $this->User_name = $value;
                }
                if ($key == 'User_email') {
                    $this->User_email = $value;
                }
                if ($key == 'User_img') {
                    $this->User_img = $value;
                }
            }
            $this->_view();
        } else {
            $this->redirect('/login/');
        }
    }

    public function editAction()
    {
        if (isset($_POST['submit'])) {


            //Get The Data of the user
            $user = UsersModel::getByPK($_SESSION['userid']);
            //$user = $user[0];
            foreach ($user as $key => $value) {
                if ($key == 'User_name') {
                    $User_name = $value;
                }
                if ($key == 'User_email') {
                    $User_email = $value;
                }
                if ($key == 'User_img') {
                    $User_img = $value;
                }
            }

            if (!empty($_POST['name'])) {

                $this->User_name = $_POST['name'];

                $this->User_name = $this->FilterString($this->User_name);
                if (strlen($this->User_name) < 3) {
                    $this->Errors[] = 'Name must be more than 3 char';
                }
                if ($User_name != $this->User_name) {
                    if (UsersModel::getBy(['User_name' => $this->User_name])) {
                        $this->Errors[] = 'This name Used befour';
                    }
                }
            }
            if (!empty($_POST['email'])) {

                $this->User_email = $_POST['email'];

                $this->User_email = $this->FilterEmail($this->User_email);
                if (strlen($this->User_email) < 8) {
                    $this->Errors[] = 'Email must be more than 9 char';
                }
                if ($User_email != $this->User_email) {
                    if (UsersModel::getBy(['User_email' => $this->User_email])) {
                        $this->Errors[] = 'This Email Used befour';
                    }
                }
            }
            if (!empty($_POST['password'])) {

                $this->User_password = $_POST['password'];

                $this->User_password1 = $this->FilterString($this->User_password);
                if (strlen($this->User_password) < 6) {
                    $this->Errors[] = 'Password must be more than 6 char';
                }
            }
            if (!empty($_FILES['img']['name'])) {
                $this->User_img = $_FILES['img'];

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
                //Get The Data of the user
                $user = UsersModel::getByPK($_SESSION['userid']);
                //$user = $user[0];
                foreach ($user as $key => $value) {
                    if ($key == 'User_img') {
                        $this->User_img = $value;
                    }
                }
            }
            if (empty($this->Errors)) {
                $this->User_password = password_hash($this->User_password1, PASSWORD_DEFAULT);

                if (!empty($_FILES['img']['name'])) {

                    // upload Img
                    do {
                        $img = $this->randomString() . '_' . $_FILES['img']["name"];
                    } while (UsersModel::getBy(['User_img' => $img]));

                    $uploadPath = APP_PATH . DS . '..' . DS . 'public' . DS . 'upload'  . DS;
                    move_uploaded_file($_FILES['img']["tmp_name"], $uploadPath . $img);
                    $this->User_img = $img;
                }

                $user = new UsersModel(
                    $_SESSION['userid'],
                    $this->User_name,
                    $this->User_email,
                    $this->User_password,
                    $this->User_img
                );
                if ($user->update()) {
                    $this->redirect('/profile/');
                }
            } else {
                $this->redirect('/profile/');
            }
        }
        $this->redirect('/profile/');
    }
}
