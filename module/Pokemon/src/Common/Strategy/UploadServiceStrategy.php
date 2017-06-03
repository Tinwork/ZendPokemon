<?php

/**
 * Class UploadServiceStrategy
 *
 * @package             Pokemon\Common\Strategy
 * @author              Didier Youn <didier.youn@gmail.com>, Marc Intha-Amnouay <marc.inthaamnouay@gmail.com>, Antoine Renault <antoine.renault.mmi@gmail.com>
 * @copyright           Copyright (c) 2017 Tinwork
 * @license             http://opensource.org/licenses/osl-3.0.php  Open Software License (OSL 3.0)
 * @link                https://github.com/Tinwork/ZendPokemon
 */
namespace Pokemon\Common\Strategy;

use Zend\Db\Exception\ErrorException;
use Zend\Json\Json as Zend_Json;
use DateTime;

class UploadServiceStrategy
{
    /**
     * @var array FILE_ALLOWED_EXTENSION
     */
    const FILE_ALLOWED_EXTENSION = array("jpg", "png", "gif", "jpeg");
    /**
     * @var string ROOT_UPLOAD_DIRECTORY
     */
    const ROOT_UPLOAD_DIRECTORY = DS . "storage" . DS . "medias" . DS . "upload";

    /**
     * @param array $file
     * @return null|string
     */
    public function upload($file)
    {
        if (!isset($file)) {
            return null;
        }
        $uploadFile = $file;
        if (!$this->_validFileExtension($uploadFile)) {
            return false;
        }
        /** @var bool|string $uploadPath */
        $uploadPath = $this->_mv($uploadFile);
        if (!$uploadPath) {
            return false;
        }

        return $uploadPath;
    }
    /**
     * Check extension of the upload file
     *
     * @param array $file
     * @return bool
     */
    protected function _validFileExtension($file)
    {
        if (!isset($file)) {
            return false;
        }
        /** @var string $mimeType */
        $mimeType = $file['type'];
        preg_match('/([a-zA-Z]*)$/i', $mimeType, $matches);
        if (!isset($matches) || !isset($matches[1])) {
            return false;
        }
        /** @var string $extension */
        $extension = $matches[1];
        foreach (self::FILE_ALLOWED_EXTENSION as $allowedExtension) {
            if ($allowedExtension == $extension) {
                return true;
            }
        }

        return false;
    }
    /**
     * Move file to upload directory
     *
     * @param $file
     * @return bool
     */
    protected function _mv($file)
    {
        if (!isset($file)) {
            return false;
        }
        /** @var string $path */
        $path = $this->_getUploadPath();
        /** @var string $serverPath */
        $serverPath = ROOT_PATH . $path;
        if (!is_dir($serverPath) && !$this->_createUploadDirectory($serverPath)) {
            return false;
        }
        /** @var string $serverPath */
        $serverPath = $serverPath . DS . $file['name'];
        move_uploaded_file($file['tmp_name'], $serverPath);
        if (!file_exists($serverPath)) {
            return false;
        }

        return $path . DS . $file['name'];
    }
    /**
     * Get upload path
     *
     * @return bool|string
     */
    protected function _getUploadPath()
    {
        /** @var string $dateFolder */
        $dateFolder = $this->_getDateFolder();
        /** @var string $path */
        $path = self::ROOT_UPLOAD_DIRECTORY . DS . $dateFolder;
        if (!isset($path)) {
            return false;
        }
        return $path;
    }
    /**
     * Create upload directory
     *
     * @param string $path
     * @return bool
     */
    protected function _createUploadDirectory($path)
    {
        if (!isset($path) || !mkdir($path, 0777, true)) {
            return false;
        }
        return true;
    }

    /**
     * Get date folder format as Ymd
     * --> 25 janvier 2017
     * --> 20172501
     *
     * @return string
     */
    private function _getDateFolder()
    {
        /** @var DateTime $now */
        $now = new DateTime();
        return $now->format('Ydm');
    }
}