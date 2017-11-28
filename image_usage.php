  @if(empty($user->profile_image))
                    <i class="icon-head"></i>
                    @else
                        <div class="media-left"><span
                                    class="avatar avatar-sm avatar-online rounded-circle"><img
                                        src="pfiles/?u={{$user->profile_image}}&h=100&a=1"
                                        alt="avatar"></span></div>

                    @endif





<div class="media-left"><span class="avatar avatar-sm avatar-online rounded-circle">
	<img src=" {{makePrivateFileUrl($user->profile_image,150,150,1)}}" alt="avatar"></span></div>


<?php
function makePrivateFileUrl(string $path, int $width = 0, int $height = 0, int $aspect = 0)
{
    $parameterString = "?u=".$path ;
    if ($width > 0)
        $parameterString .= "&w=" . $width;
    if ($height > 0)
        $parameterString .= "&h=" . $height;
   // if (($width > 0 || $height > 0))
        $parameterString .= "&a=" .$aspect;

    return route("pfiles") . $parameterString;
}    

//////////////////////////////////////////controller

Route::get('/pfiles', "Common\File\FileController@getFile")->middleware('auth')->name('pfiles');


  public function getFile(Request $request)
    {
       // dd($request);

        if ($request->h || $request->w) {

            $filename = $request->input("u");
            $newFilename = $this->renameFile($filename, $request->w, $request->h, $request->a);
            $mime = \GuzzleHttp\Psr7\mimetype_from_filename($filename);




            if (!is_file($newFilename)) {

                if (empty($request->h)) {

                    Image::make($filename)->widen($request->w, function ($constraint) use ($request) {
                        if ($request->a)
                            $constraint->aspectRatio();
                    })->save($newFilename);

                } elseif (empty($request->w)) {

                    Image::make($filename)->heighten($request->h, function ($constraint) use ($request) {
                        if ($request->a)
                            $constraint->aspectRatio();
                    })->save($newFilename);

                } else {

                    Image::make($filename)->resize($request->w, $request->h, function ($constraint) use ($request) {
                      /*  if ($request->a)
                            $constraint->aspectRatio();*/
                    })->save($newFilename);


                }
            }
        } else {

            $newFilename = $request->input("u");

            //return $newFilename;
            $mime = \GuzzleHttp\Psr7\mimetype_from_filename($newFilename);


        }



        return response()->file($newFilename, [
            'Content-Type' => $mime,
            'Content-Disposition' => 'inline; filename="' . $newFilename . '"',
            'Cache-Control' => 'public, max-age=604800'// 1 weeek
        ]);
    }


?>                