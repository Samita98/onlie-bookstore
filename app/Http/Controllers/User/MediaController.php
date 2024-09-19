<?php

namespace App\Http\Controllers\User;

use Validator;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use App\Http\Controllers\Controller;
use App\Model\Media as MediaModel;

class MediaController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $medias = MediaModel::where('user_id', \Auth::guard('web')->user()->id);
        if (isset($_GET['trashed'])) {
            $medias = $medias->orderBy('deleted_at', 'desc')->onlyTrashed();
        }else{
            $medias = $medias->orderBy('id', 'desc');
        }
        if(isset($_GET['keyword']) && !empty($_GET['keyword'])){
            $medias = $medias->where('title', 'like', '%'.$_GET['keyword'].'%');
        }
        return view('user.media.list', ['medias'=>$medias->paginate(10), 'title'=>'Media List']);
    }
    public function restore(Request $request, $id)
    {
        $media = MediaModel::where('user_id', \Auth::guard('web')->user()->id)->withTrashed()->find($id);
        if($media){
            $media->restore();
            \Session::flash('success_message', 'Media restored successfully.');
            return redirect(route('user.media.index').'?trashed');
        }else{
            return abort(404);
        }
    }
    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $media = MediaModel::where('user_id', \Auth::guard('web')->user()->id)->withTrashed()->find($id);
        if ($media->trashed()) {
            $media->forceDelete();
            \Session::flash('success_message', 'Media permanently deleted.');
            return redirect(route('user.media.index').'?trashed');
        }else{
            $media->delete();
            \Session::flash('success_message', 'Media moved to trash.');
            return redirect(route('user.media.index'));
        }
    }
    public function action(Request $request)
    {
        if($request->hasFile('files'))
        {
            $files = $request->file('files');
            foreach ($files as $file) {
                $validator = Validator::make(array('file'=>$file), array('file' => 'image|required|max:5120'));
                if($validator->passes()){
                    $media = new MediaModel;
                    $destinationPath        =   'uploads/'.date("Y").'/'.date("m").'/';
                    //$destinationPath        =   'uploads/2015/07/';
                    $filename               =   $file->getClientOriginalName();
                    $nfilename              =   Str::replaceLast('.'.$file->getClientOriginalExtension(), ' ', $filename);
                    $media->original_file   =   Str::slug($nfilename, '-').'.'.$file->getClientOriginalExtension();
                    $media->alt             =   $nfilename; 
                    $media->type            =   $file->getClientMimeType();
                    $media->folder_path     =   $destinationPath;
                    $media->user_id        =   \Auth::guard('web')->user()->id;
                    $media->save();

                    $file_temp = public_path().'/'.$destinationPath.$media->original_file;
                    if (file_exists($file_temp)) {
                        $media->original_file = Str::slug($nfilename, '-').'-'.$media->id.'.'.$file->getClientOriginalExtension();
                        $media->save();
                        $file->move($destinationPath,$media->original_file);
                    }else{
                        $file->move($destinationPath,$media->original_file);
                    }
                    $media->regenerate_thumbnails();
                    return json_encode(array('success_msg'=>'Upload Successfull.', 'media_id'=>$media->id, 'media_url'=>'/'.$destinationPath.$media->original_file));
                }else{
                    $errors = $validator->errors();
                    return json_encode(array('error_msg'=>implode('<br>', $errors->all())));
                }
            }
        }else{
            return json_encode(array('error_msg'=>'No file selected.'));
        }
    }
    public function ajax(Request $request)
    {
        if (!empty($_SERVER['HTTP_X_REQUESTED_WITH']) && (strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest')) {
            if (isset($request->action)) {
                switch ($request->action) {
                    case 'load_more':
                        $images = MediaModel::where('user_id', \Auth::guard('web')->user()->id)->Where('alt', 'like', '%' . $request->keyword . '%')->orderBy('id', 'desc')->skip($request->count)->take(12)->get();
                        $return_val = '';
                        foreach ($images as $key => $image) {
                           $return_val.= '<li class="jFiler-item" data-media="'.$image->id.'" data-src="'.url($image->folder_path.$image->original_file).'">
                                <div class="jFiler-item-container waves-effect waves-dark">
                                    <div class="jFiler-item-inner">
                                        <div class="jFiler-item-thumb">
                                            <div class="jFiler-item-status"></div>
                                            <div class="jFiler-item-info">
                                                <span class="jFiler-item-title"><b title="'.$image->alt.'">'.$image->alt.'</b></span>
                                            </div>
                                            <div class="jFiler-item-thumb-image">
                                            <img src="'.url($image->folder_path.$image->original_file).'" alt="'.$image->alt.'">
                                            </div>
                                        </div>
                                        <div class="jFiler-item-assets jFiler-row">
                                            <ul class="list-inline pull-left">
                                                <span class="jFiler-item-others"><i class="icon-jfi-file-image jfi-file-ext-"></i> image</span>
                                            </ul>
                                            <ul class="list-inline pull-right">
                                                <li><span class="media-send-to-edit waves-effect waves-dark btn btn-primary" onclick="return send_media_to_edit(this);">Edit</span></li>
                                                <li><span class="icon-jfi-trash media-send-to-trash"></span></li>
                                            </ul>
                                        </div>
                                    </div>
                                </div>
                            </li>';
                        }
                        echo  $return_val;
                        break;
                        case 'trash_media':
                            $media = MediaModel::where('user_id', \Auth::guard('web')->user()->id)->find($request->media_id);
                            if($media){
                                $media->delete();
                                echo json_encode(array('success_msg'=>'Media successfully moved to trash.'));
                            }else{
                                echo json_encode(array('error_msg'=>'Error while deleting media.'));
                            }

                        break;
                        case 'edit_media_with_filename':
                            $media = MediaModel::where('user_id', \Auth::guard('web')->user()->id)->find($request->mediaid);
                            $media->alt = $request->main_media_title;
                            $media->save();
                            if (isset($request->main_media_file_name) && !empty($request->main_media_file_name)) {

                                    $newfilename = Str::slug($request->main_media_file_name);
                                    $unique_name = microtime();

                                    $info =  pathinfo(public_path($media->folder_path . $media->original_file));
                                    $ext = $info['extension'];

                                    if( !file_exists( public_path($media->folder_path . $newfilename.'.'.$ext ) ) ){
                                        rename(public_path($media->folder_path . $media->original_file), public_path($media->folder_path . $newfilename.'.'.$ext ));
                                        $media->original_file = $newfilename.'.'.$ext;
                                    }elseif( !file_exists( public_path($media->folder_path . $newfilename.'-'.$media->id.'.'.$ext ) ) ){
                                        rename(public_path($media->folder_path . $media->original_file), public_path($media->folder_path . $newfilename.'-'.$media->id.'.'.$ext ));
                                        $media->original_file = $newfilename.'-'.$media->id.'.'.$ext;
                                    }else{
                                        rename(public_path($media->folder_path . $media->original_file), public_path($media->folder_path . $newfilename.'-'.$media->id.'-'.$unique_name.'.'.$ext ));
                                        $media->original_file = $newfilename.'-'.$media->id.'-'.$unique_name.'.'.$ext;
                                    }
                                    $media->save();

                                    $media->regenerate_thumbnails();

                            }

                            return $media;

                        break;
                    
                    default:
                        # code...
                        break;
                }
            }
        }
    }
}
