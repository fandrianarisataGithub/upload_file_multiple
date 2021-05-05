<?php

    namespace App\Services;

use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\HttpFoundation\File\Exception\FileException;

class UploadFile
    {
        // url de destination
        private $targetDir_image;
        private $targetDir_fichier;
        private $targetDir_video;


        // meth construct
        public function __construct(string $targetDir_image, string $targetDir_fichier, string $targetDir_video)
        {
            $this->targetDir_image = $targetDir_image;
            $this->targetDir_fichier = $targetDir_fichier;
            $this->targetDir_video = $targetDir_video;
        }

        public function getTargetDirImage(){
            return $this->targetDir_image;
        }

        public function getTargetDirFichier(){
            return $this->targetDir_fichier;
        }
        
        public function getTargetDirVideo(){
            return $this->targetDir_video;
        }

        // upload the file 

        public function upload(UploadedFile $uploadedFile)
        {
            // get the original filename url
            
            $origin = $uploadedFile->getClientOriginalName();

            //dd($origin);
            // safe filename 

            $origin = transliterator_transliterate("Any-Latin; Latin-ASCII; [^A-Za-z0-9_] remove; Lower()", $origin);

            // get extension

            $extension = $uploadedFile->getClientOriginalExtension();

            // les tableaux d'estension 

            $ext_image = ["png", "PNG", "jpg", "JPG", "JPEG", "jpeg"];
            $ext_fichier = ["DOCX", "docx", "HTML", "html", "ODT", "odt", "PDF", "pdf", "TXT", "txt", "XLS", "XLSX", "xls", "xlsx"];
            $ext_video = ["MP4", "mp4", "MOV", "mov", "AVI", "avi", "MKV", "mkv"];

            $newFilename = $origin.'-'.uniqid().'.'.$extension;

            // specify targetDirectory
            //dd($newFilename);
            if(in_array($extension, $ext_image)){
               // move 
               try {
                    $uploadedFile->move($this->getTargetDirImage(), $newFilename);
                } catch (FileException $e) {
                    // ... handle exception if something happens during file upload
                }
            }
            if(in_array($extension, $ext_fichier)){
                try {
                    $uploadedFile->move($this->getTargetDirFichier(), $newFilename);
                } catch (FileException $e) {
                    // ... handle exception if something happens during file upload
                }
            }
            if(in_array($extension, $ext_video)){
                try {
                    $uploadedFile->move($this->getTargetDirVideo(), $newFilename);
                } catch (FileException $e) {
                    // ... handle exception if something happens during file upload
                }
            }

            return $newFilename;

        } 

        
    }