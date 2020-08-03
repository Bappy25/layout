<?php

namespace App\Http\Controllers;

use Storage;
use App\Models\User;
use App\Models\Admin;
use App\Models\Content;
use App\Notifications\UserNotification;
use App\Notifications\AdminNotification;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Intervention\Image\ImageManagerStatic as Image;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    protected function get_page_contents($page='welcome'){
        $content = new Content;
        $get_content = $content->where('headline', $page)->first();
        $contents = json_decode($get_content->web_contents);
        return $contents;
    }

    protected function uploadImage($image, $path, $resizeX, $resizeY)
    {        
        $ext = explode('.', $image->getClientOriginalName()); 
        $filename = md5(uniqid())."." . $ext[count($ext) -1];
        $image_resize = Image::make($image->getRealPath()); 
        $image_resize->resize($resizeX, $resizeY);             
        /*$image_resize->resize($resizeX, $resizeY, function ($constraint) {
            $constraint->aspectRatio();                 
        });*/
        $image_resize->stream(); 
        Storage::disk('local')->put('public/'.$path.$filename, $image_resize, 'public');
        return 'storage/'.$path.$filename;
    }

    protected function uploadUrlImage($url, $path, $resizeX, $resizeY)
    {        
        $image = file_get_contents($url);
        $filename = substr($url, strrpos($url, '/') + 1);
        Storage::disk('local')->put('public/'.$path.$filename, $image, 'public');
        $filepath = 'storage/'.$path.$filename;
        $image_resize = Image::make($filepath);
        $image_resize->resize($resizeX, $resizeY);
        $image_resize->save();  
        return $filepath;
    }

    protected function userNotification($receivers, $text='You have got a new notification!', $link='javascript:void(0)'){
        for($i = 0; $i < count($receivers); $i++){
            $user = User::findOrFail($receivers[$i]);
            $user->notify(new UserNotification(['text' => $text, 'link' => $link]));
        }
    }

    /**
     * Upload contents images.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function addContentImage(\Illuminate\Http\Request $request)
    {
        $api = new \App\Helpers\ApiHelper;
        
        try {
            $path = $this->uploadImage($request->file('upload_image'), 'all_images/content_images/', 400, 400);

            \Log::info('Req=Controller@addContentImage image added');

            return $api->success('Image added successfully!', ['path' => $path]);

        }catch(\Exception $e){
            \Log::error('Error caught msg='.$e->getMessage());
            return $api->fail($e->getMessage());
        }
    }
}
