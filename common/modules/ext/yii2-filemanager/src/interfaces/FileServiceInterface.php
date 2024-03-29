<?php

namespace jakharbek\filemanager\interfaces;

use jakharbek\filemanager\dto\FileSaveDTO;
use jakharbek\filemanager\dto\FileUploadDTO;
use jakharbek\filemanager\dto\FileUploadedDTO;
use jakharbek\filemanager\dto\GeneratedPathFileDTO;
use jakharbek\filemanager\dto\GeneratePathFileDTO;
use jakharbek\filemanager\models\Files;

/**
 * Interface iFileManagerServices
 * @package jakharbek\filemanager\interfaces
 */
interface FileServiceInterface
{
    /**
     * @param FileUploadDTO $fileUploadDTO
     * @return FileUploadedDTO|null
     */
    public function upload(FileUploadDTO $fileUploadDTO): ?FileUploadedDTO;

    /**
     * @param FileUploadedDTO $fileUploadedDTO
     * @return bool
     */
    public function save(FileUploadedDTO $fileUploadedDTO, FileSaveDTO $fileSaveDTO): ?array;

    /**
     * @param GeneratePathFileDTO $generatePathFileDTO
     * @return mixed
     */
    public function generatePath(GeneratePathFileDTO $generatePathFileDTO): GeneratedPathFileDTO;

    /**
     * @param Files $file
     * @return bool
     */
    public function createThumbsImage(Files $file): ?bool;

}