<?php

namespace feiron\fe_login\http\controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Storage;

class FeProfileController extends Controller
{
    public function UploadProfImg(Request $request){
        $validator = Validator::make($request->all(), [
            'FeLogin_ProfImgUpload' => ('required|file')
        ]);
        if ($validator->fails()) {
            return ['status' => 'error', 'errors' => $validator->getMessageBag()->toArray()];
        } else {
            $user= auth()->user();
            $file= $request->file('FeLogin_ProfImgUpload');
            $filename = 'Profile-photo.' . $file->getClientOriginalExtension();
            Storage::deleteDirectory(('public/usrProfile/' . $user->getKey() . '/ProfileImage'));
            $path = $file->storeAs(('public/usrProfile/' . $user->getKey() . '/ProfileImage'), $filename);
            $user->profile_image=$path;
            $user->save();
        }
        return ['status' => 'success', 'message' => ['Profile Image uploaded.'], 'datapath' => Storage::url($path)];
    }
    public function removeProfImg(Request $request){
        $user= auth()->user();
        Storage::deleteDirectory(('public/usrProfile/' . $user->getKey() . '/ProfileImage'));
        $user->profile_image = null;
        $user->save();
        return ['status' => 'success', 'message' => ['Profile Image Removed.']];
    }
}
