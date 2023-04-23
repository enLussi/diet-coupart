<?php

namespace App\Service;

use Exception;
use Symfony\Component\DependencyInjection\ParameterBag\ParameterBagInterface;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use GdImage;

class PictureService
{
  private $params;

  public function __construct(ParameterBagInterface $params) {

    $this->params = $params;

  }

  public function add(UploadedFile $picture, ?string $folder = '', ?int $width = 250, ?int $height = 250) 
  {
    // On donne un nouveau nom à l'image
    $file = md5(uniqid(rand(), true)) . '.png'; 

    // On récupère les infos de l'image
    $picture_info = getimagesize($picture);

    if($picture_info === false){
      throw new Exception('Format d\'image incorrect.');
    }

    // On vérifie le format de l'image
    switch($picture_info['mime']) {
      case 'image/png':
        $picture_source = imagecreatefrompng($picture);
        break;
      case 'image/jpeg':
        $picture_source = imagecreatefromjpeg($picture);
        break;
      case 'image/webp':
        $picture_source = imagecreatefromwebp($picture);
        break;
      default:
        throw new Exception('Format d\'image incorrect.');
        break;
    }

    // On recadre l'image
    // On récupère les dimensions de l'image 
    
    $imageWidth = $picture_info[0];
    $imageHeight = $picture_info[1];

    // On vérifie l'orientation de l'image
    switch($imageWidth <=> $imageHeight){
      case -1:
        //portrait
        $squareSize= $imageWidth;
        $src_x = 0;
        $src_y = ($imageHeight - $squareSize) / 2;
        break;
      case 0:
        //carré
        $squareSize= $imageWidth;
        $src_x = 0;
        $src_y = 0;
        break;
      case 1:
        //paysage
        $squareSize= $imageHeight;
        $src_x = ($imageWidth - $squareSize) / 2;
        $src_y = 0;
        break;
    }

    // On crée une nouvelle image
    // $resized_image = imagecreatetruecolor($width, $height);
    // imagecopyresampled($resized_image, $picture_source, 0, 0, $src_x, $src_y, $width, $height, $squareSize, $squareSize);

    $path = $this->params->get('images_directory') . $folder;

    // On crée le dossier de destination s'il n'existe pas
    if(!file_exists(($path))) {
      mkdir($path, 0755, true);
    }


    // On stocke l'image recadré
    // imagepng($resized_image, $path . '/' . $fichier);

    $picture->move( $path, $file );

    return $file;


  }

  public function delete(string $file, ?string $folder = '', ?int $width = 250, ?int $height = 250)
  {
    if($file !== 'default.png'){
      $success = false;

      $path = $this->params->get('images_directory') . $folder;

      $image = $path . '/' . $file;
  
      if(file_exists($image)) {
        unlink($image);
        $success = true;
      }
  
      $original = $path . '/' . $file;
  
      if(file_exists($original)) {
        unlink($image);
        $success = true;
      }
  
      return $success;
    }

    return false;

  }
}

?>