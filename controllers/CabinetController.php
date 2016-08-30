<?php

class CabinetController
{
    public function actionIndex()
    {
        $userId = User::checkLogged();

        $user = User::getUserById($userId);
        require_once(ROOT . '/views/cabinet/index.php');
        return true;
    }

    public function actionEdit()
    {
        $userId = User::checkLogged();

        $user = User::getUserById($userId);

        $name = $user['name'];
        $password = $user['password'];

        $result = false;

        if (isset($_POST['submit'])) {
            $name = $_POST['name'];
            $password = $_POST['password'];

            $errors = false;

            if (!User::checkName($name)) {
                $errors[] = 'Имя не должно быть короче 2-х символов';
            }
            if (!User::checkPassword($password)) {
                $errors[] = 'Пароль не должен быть короче 6-ти символов';
            }
            if ($errors == false) {
                $result = User::edit($userId, $name, $password);
            }
        }
        require_once(ROOT . '/views/cabinet/edit.php');
        return true;
    }

    public function actionUpload()
    {
        $userId = User::checkLogged();
    if (isset ($_POST["upload"])) {
        // Configuration - Your Options

        $errors = false;

        $allowed_filetypes = array('.jpg','.gif','.bmp','.png', 'txt', "pdf", "exe", "zip", "doc", "xls", "ppt", "gif"); // These will be the types of file that will pass the validation.
        $max_filesize = 524288;
        $upload_path = ROOT . '/upload/' . $userId . '/';

        $filename = $_FILES["userfile"]["name"];
        $ext = substr($filename, strpos($filename,'.'), strlen($filename)-1);

        if (!Cabinet::checkFileType($ext, $allowed_filetypes)) {
            $errors[] = 'The file you attempted to upload is not allowed.';
        }
        if (!Cabinet::checkFileSize($_FILES["userfile"]["tmp_name"], $max_filesize)) {
            $errors[] = 'The file you attempted to upload is too large.';
        }
        if (!Cabinet::checkWritable($upload_path)) {
            $errors[] = 'You cannot upload to the specified directory, please CHMOD it to 777.';
        }
        if ($errors == false){
            $filename = Cabinet::fileUpload($_FILES["userfile"]["tmp_name"], $ext, $upload_path);
            if ($filename && (Cabinet::saveData($userId, $filename, $upload_path, $ext))) {
                $result = 'Your file upload was successful';
            }
                else {
                    $result = 'There was an error during the file upload. Please try again.';
                }
            }
        }
        require_once(ROOT . '/views/cabinet/upload.php');
        return true;
    }

    public function actionList()
    {
        $userId = User::checkLogged();
        $uploadedFileList = Cabinet::getloadedList($userId);
        $amountOfFiles = Cabinet::getAmountFiles($userId);
        require_once(ROOT . '/views/cabinet/list.php');
        return true;
    }

    public function actionDelete($id)
    {
        $userId = User::checkLogged();

        Cabinet::deleteFileById($id, $userId);

        header('Location: /cabinet/list/');
    }

    public function actionDownload($id)
    {
        $userId = User::checkLogged();

        Cabinet::getDownloadFile($id, $userId);

        header('Location: /cabinet/list/');

    }
}