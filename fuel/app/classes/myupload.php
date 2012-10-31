<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of myupload
 *
 * @author user
 */
class myupload {
    public static $small = 'small-';
    public static $medium = 'medium-';
    public static $large = 'large-';
    public static $thumb = 'thumb-';
    
    public static function upload_dir() {
        return Fuel\Core\Config::get('base_url') . 'assets/upload/';
    }
    
    public static function delete_images($file_name,$date) {
            $path = DOCROOT . 'assets/upload/' . $date .'/';
            \Fuel\Core\File::delete($path . self::$small . $file_name);
            \Fuel\Core\File::delete($path . self::$medium . $file_name);
            \Fuel\Core\File::delete($path . self::$large . $file_name);
            \Fuel\Core\File::delete($path . self::$thumb . $file_name);
            \Fuel\Core\File::delete($path . $file_name);
    }
    
    public static function upload_image() {
        if(Fuel\Core\Upload::is_valid()) {
           Fuel\Core\Upload::save();
           return true;
       }
    }
    
    public static function upload_resize() {
        if(self::upload_image()){
            $images = self::get_file_info(Fuel\Core\Upload::get_files());
            $images = self::resize_image($images);
            return $images;
        }
    }
    
    public static function resize_image($images) {
        $image_file = null;
        
        foreach ($images as $image) {
            $image_file = $image['server_path'] . $image['file_name'];
            \Fuel\Core\Image::load($image_file)->resize('20%', '20%', true)->save_pa(self::$small);
            \Fuel\Core\Image::load($image_file)->resize('50%', '50%', true)->save_pa(self::$medium);
            \Fuel\Core\Image::load($image_file)->resize('70%', '70%', true)->save_pa(self::$large);
            \Fuel\Core\Image::load($image_file)->crop_resize('150', '150')->save_pa(self::$thumb);
        }
        return $images;
    }
    
    private static function get_file_info($files) {
       $counter  = 0;
       $resize = null;
       
       foreach($files as $file) {
           $resize[$counter]['file_name'] = $file['saved_as'];
           $resize[$counter]['server_path'] = $file['saved_to'];
           $counter++;
       }
       return $resize;
    }
}
