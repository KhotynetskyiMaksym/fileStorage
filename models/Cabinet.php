<?php

class Cabinet
{
    public static function checkFileType($ext, $allowed_filetypes)
    {
        return in_array($ext,$allowed_filetypes);
    }

    public static function checkFileSize($tmp_name, $max_filesize)
    {
        if(filesize($tmp_name) > $max_filesize) {
            return false;
        }
        return true;
    }

    public static function checkWritable($upload_path)
    {
        if (!is_dir($upload_path)) {
            mkdir($upload_path);
        }
        return is_writable($upload_path);
    }
    public static function fileUpload($tmp_name, $ext, $upload_path)
    {
        $filename = time().$ext; // this will give the file current time so avoid files having the same name

        if(move_uploaded_file($tmp_name, $upload_path . $filename)) {
            return $filename;
        }
        else {
            return false;
        }
    }

    public static function saveData($userId, $filename, $upload_path, $ext)
    {
        $db = Db::getConnection();
        $size = filesize($upload_path . $filename);
        $type = substr($ext, 1);

        $sql = 'INSERT INTO upload (user_id, name, type, size, path) '
            . 'VALUES (:user_id, :name, :type, :size, :path)';
        $result = $db->prepare($sql);
        $result->bindParam(':user_id', $userId, PDO::PARAM_INT);
        $result->bindParam(':name', $filename, PDO::PARAM_STR);
        $result->bindParam(':path', $upload_path, PDO::PARAM_STR);
        $result->bindParam(':type', $type, PDO::PARAM_STR);
        $result->bindParam(':size', $size, PDO::PARAM_INT);
        return $result->execute();
    }

    public static function getloadedList($userId)
    {
        $db = Db::getConnection();

        $result = $db->query('SELECT id, name, type, size, date, path FROM upload '
                            . 'WHERE user_id = ' . $userId
                            . ' ORDER BY name');
        $ordersList = array();
        $i = 0;
        while ($row = $result->fetch()) {
            $loadedList[$i]['id'] = $row['id'];
            $loadedList[$i]['name'] = $row['name'];
            $loadedList[$i]['type'] = $row['type'];
            $loadedList[$i]['size'] = $row['size'];
            $loadedList[$i]['date'] = $row['date'];
            $loadedList[$i]['path'] = $row['path'];
            $i++;
        }
        if (!empty($loadedList)) {
            return $loadedList;
        }
    }

    public static function  getAmountFiles($userId) {
        $loadedList = self::getloadedList($userId);
        return count($loadedList);
    }


    public static function deleteFileById($id, $userId)
    {

        $loadedList = self::getloadedList($userId);
        foreach ($loadedList as $file) {
            if ($file['id'] == $id) {
                if (file_exists($file['path'] . $file['name']))
                    unlink($file['path'] . $file['name']);
            }
        }
        if (!file_exists($file['path'] . $file['name'])) {
        $db = Db::getConnection();

        $sql = 'DELETE FROM `upload` WHERE id = :id';

        $result = $db->prepare($sql);
        $result->bindParam(':id', $id, PDO::PARAM_INT);
        return $result->execute();
        }
    }
    public static function getDownloadFile($id, $userId)
    {
        $loadedList = self::getloadedList($userId);
        foreach ($loadedList as $file) {
            if ($file['id'] == $id) {
                if (file_exists($file['path'] . $file['name'])) {
                    switch ($file['type']) {
                        case "txt":
                            $ctype = "text/plain";
                            break;
                        case "pdf":
                            $ctype = "application/pdf";
                            break;
                        case "exe":
                            $ctype = "application/octet-stream";
                            break;
                        case "zip":
                            $ctype = "application/zip";
                            break;
                        case "doc":
                            $ctype = "application/msword";
                            break;
                        case "xls":
                            $ctype = "application/vnd.ms-excel";
                            break;
                        case "ppt":
                            $ctype = "application/vnd.ms-powerpoint";
                            break;
                        case "gif":
                            $ctype = "image/gif";
                            break;
                        case "png":
                            $ctype = "image/png";
                            break;
                        case "jpeg":
                            $ctype = "image/jpg";
                            break;
                        case "jpg":
                            $ctype = "image/jpg";
                            break;
                        default:
                            $ctype = "application/force-download";
                    }
                }
                header('Content-Type: ' . $ctype);
                header('Content-Disposition: attachment; filename="' . $file['name']);
                readfile($file['path'] . $file['name']);
            }

        }
    }



}