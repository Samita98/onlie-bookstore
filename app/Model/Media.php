<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Intervention\Image\ImageManagerStatic as Image;

class Media extends Model
{
	use SoftDeletes;
	protected $fillable = ['attachment_path', 'alt', 'type', 'original_file', ' folder_path', 'admin_id', 'user_id'];

	protected $dates = ['deleted_at'];
    private $image_sizes = array(
            array('thumb', 200, 200),
            array('thumb_175', 175, 175, false),
            array('thumb_100x120', 100, 120),
            array('thumb_500x280', 500, 280),
            array('thumb_300x350', 300, 350),
            array('thumb_600x600', 600, 600, false),
            array('thumb_1200x1200', 1200, 1200, false),
            array('thumb_350x375', 350, 375)
        );
    //

    public static function get_all_attachment(){
    	$images = self::orderBy('id', 'desc')->take(40)->get()->reverse()->values();
    	$return_arr = array();
    	foreach ($images as $key => $image) {
    		$return_arr[] = array(
    				'name'	=>	$image->alt,
    				'size'	=>	$image->id,
    				'type'	=>	$image->type,
                    'file'  =>  url($image->folder_path.$image->original_file),
                    'url'  =>  url($image->folder_path.$image->original_file)
    		);
    	}
    	return json_encode($return_arr);
    }
    public static function get_user_attachment(){
    	$images = self::where('user_id', \Auth::guard('web')->user()->id)->orderBy('id', 'desc')->take(40)->get()->reverse()->values();
    	$return_arr = array();
    	foreach ($images as $key => $image) {
    		$return_arr[] = array(
    				'name'	=>	$image->alt,
    				'size'	=>	$image->id,
    				'type'	=>	$image->type,
                    'file'  =>  url($image->folder_path.$image->original_file),
                    'url'  =>  url($image->folder_path.$image->original_file)
    		);
    	}
    	return json_encode($return_arr);
    }
    public function regenerate_thumbnails()
    {
        $upload_folder = $this->folder_path;

        $images = @unserialize($this->attachment_path);
        $regenerate_image = $this->original_file;

        if (file_exists(public_path().'/'.$upload_folder.$regenerate_image)) {
            if(is_array($images)){
                foreach ($images as $image_key => $image) {
                    $file = public_path().'/'.$this->folder_path.$image;
                    if (file_exists($file)) {
                        unlink($file);
                    }
                }
            }
            $attachment_path = $regenerate_image;
            $attachment_paths = array();

            foreach ($this->image_sizes as $key => $value) {
                $img = Image::make(public_path($upload_folder.$attachment_path));
                if(!isset($value[3])){
                    $value[3] = 1;
                }elseif($value[3]==true){
                    $value[3] = 1;
                }

                $explode = explode('.', $attachment_path); // split all parts
                $end = '';
                $begin = '';
                if(count($explode) > 0){
                    $end = array_pop($explode); // removes the last element, and returns it

                    if(count($explode) > 0){
                        $begin = implode('.', $explode); // glue the remaining pieces back together
                    }
                }
                $att_name = $begin.'-'.$value[1].'x'.$value[2].'.'.$end;

                if($value[3]){
                    $imgg = $img->fit($value[1], $value[2]);
                }else{
                    $imgg = $img->resize($value[1], $value[2], function ($constraint) {
                                $constraint->aspectRatio();
                            });
                }
                $imgg->save(public_path($upload_folder .$att_name));
                $attachment_paths[$value[0]] =  $att_name;

            }
            $this->attachment_path = serialize($attachment_paths);
            $this->save();

        }else{
            return 'Source File does not Exist';
        }
    }
    public function get_attachment($size='full')
    {
        $paths  = @unserialize($this->attachment_path);
        if (isset($paths[$size])) {
            $path   = $paths[$size];
        }else{
            $path   = $this->original_file;
        }
        if (file_exists(public_path($this->folder_path . $path)) && $size!='full') {
            return '<img src="'.url($this->folder_path . $path).'" alt="'.$this->alt.'">';
        }else{
            return '<img src="'.url($this->folder_path . $this->original_file).'" alt="'.$this->alt.'">';
        }
    }
    public function get_attachment_url($size='full')
    {
        $paths  = @unserialize($this->attachment_path);
        if (isset($paths[$size])) {
            $path   = $paths[$size];
        }else{
            $path   = $this->original_file;
        }
        if (file_exists(public_path($this->folder_path. $path))  && $size!='full') {
            return url($this->folder_path. $path);
        }else{
            return url($this->folder_path. $this->original_file);
        }
    }
}
