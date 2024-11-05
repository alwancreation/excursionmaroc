<?php
namespace App\Helper;

class ImageResize
{

    /**
     * Resize
     * @param string $file
     * @param integer $width
     * @param integer $height
     * @param string $destination
     * @param boolean $crop
     * @param int $quality
     *
     * @return string file destination
     */


    public function resize( $file,  $width , $height ,$destination=null, $crop,  $quality=90){

        //Check if GD extension is loaded
        if (!extension_loaded('gd') && !extension_loaded('gd2')) {
            trigger_error("GD is not loaded", E_USER_WARNING);
            return false;
        }

        //Get Image size info
        list($width_orig, $height_orig, $image_type) = getimagesize($file);

        switch ($image_type) {
            case 1: $im = imagecreatefromgif($file);
                break;
            case 2: $im = imagecreatefromjpeg($file);
                break;
            case 3: $im = imagecreatefrompng($file);
                break;
            default: trigger_error('Unsupported filetype!', E_USER_WARNING);
                break;
        }

        /*  * * calculate the aspect ratio ** */

        $rat1 = $width_orig / $height_orig;
        $rat2 = $width / $height;
        $ho = $height_orig;
        $wo = $width_orig;
 
        if ($crop) {
            if ($rat2 > $rat1) {
                $w_to_copy = $width;
                $h_to_copy = $height_orig * $width / $width_orig;
            } else {
                $h_to_copy = $height;
                $w_to_copy = $width_orig * $height / $height_orig;
            }
        } else {
            if ($rat2 < $rat1) {
                $w_to_copy = $width;
                $h_to_copy = $height_orig * $width / $width_orig;
            } else {
                $h_to_copy = $height;
                $w_to_copy = $width_orig * $height / $height_orig;
            }
        }



        $xo = floor(($width - $w_to_copy) / 2);
        $yo = floor(($height - $h_to_copy) / 2);

        /*         * * calulate the thumbnail width based on the height ** */

        $newImg = imagecreatetruecolor($width, $height);

        /* Check if this image is PNG or GIF, then set if Transparent */
        if (($image_type == 1) OR ($image_type == 3)) {
            imagealphablending($newImg, false);
            imagesavealpha($newImg, true);
            $transparent = imagecolorallocatealpha($newImg, 255, 255, 255, 127);
            imagefilledrectangle($newImg, 0, 0, $width, $height, $transparent);
        }

        $whiteBackground = imagecolorallocate($newImg, 255, 255, 255);
        imagefill($newImg, 0, 0, $whiteBackground); // fill the background with white

        imagecopyresampled($newImg, $im, $xo, $yo, 0, 0, $w_to_copy, $h_to_copy, $width_orig, $height_orig);
        //Generate the file, and rename it to $destination
        switch ($image_type) {
            case 1: imagegif($newImg, $destination, 9);
                break;
            case 2: imagejpeg($newImg, $destination, $quality);
                break;
            case 3: imagepng($newImg, $destination, 9);
                break;
            default: trigger_error('Failed resize image!', E_USER_WARNING);
                break;
        }

        return $destination;
    }


}