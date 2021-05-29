<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\Post;
use App\Models\File;

class SaveController extends Controller
{
  public function delete_pass(Request $req)
  {
    $flag = 0;
    $data = Post::find(($req->id));
    if($data->pass == $req->pass) {
      $flag = 1;
    } else {
      $flag = 2;
    }
    return response()
      ->json([
      'flag' => $flag
      ]);
  }

  public function delete($id)
  {
    $delete = Post::findOrFail($id);
    $delete->delete();
    if(!empty($delete->file->file_pass)){
      unlink($delete->file->file_pass);
      $delete->file->delete();
    }
    //jsonデータ部分
    $posts = Post::all();
      foreach($posts as $post) {
        if($post->file != null){
          $user = [
            'id' => $post->id,
            'post_name' => $post->post_name,
            'comment' => $post->comment,
            'post_time' => $post->post_time,
            'file_type' => $post->file->file_type,
            'file_pass' => $post->file->file_pass,
            'image' => $post->image,
            'video' => $post->video,
          ];
        } else {
          $user = [
            'id' => $post->id,
            'post_name' => $post->post_name,
            'comment' => $post->comment,
            'post_time' => $post->post_time,
            'file_type' => null,
            'file_pass' => null,
            'image' => $post->image,
            'video' => $post->video,
          ];
        }
        $data[] = $user;
      }

      return response()
        ->json([
          'users' => $data
        ]);
  }

  public function edit_pass(Request $req)
  {
    $edit = Post::find($req->id);
    if($edit->pass == $req->pass) {
      $flag = 1;
      $name = $edit->post_name;
      $comment = $edit->comment;
      $pass = $edit->pass;
      $post_type = false;
      $edit_id = $req->id;
    } else {
      $flag = 2;
      $name = null;
      $comment = null;
      $pass = null;
      $post_type = true;
      $edit_id = 0;
    }

    return response()->json([
      'flag' => $flag,
      'name' => $name,
      'comment' => $comment,
      'pass' => $pass,
      'post_type' => $post_type,
      'edit_id' => $edit_id,
    ]);
  }

  public function edit(Request $req, $id)
  {
    //初期値
    $image = false;
    $video = false;

    //アップロード部分
    function upload_judge($post_name, $comment, $pass, $file_pass, $file_type, $image, $video, $id)
    {
      //postsデータベースのアップデート
      $edit = Post::find($id);
      $edit->post_name = $post_name;
      $edit->comment = $comment;
      $edit->pass = $pass;
      $edit->post_time = date("Y/m/d H:i:s", time());
      $edit->image = $image;
      $edit->video = $video;
      $edit->update();
      //filesデータベースのアップデート
      if($file_pass != null) {
        //ファイル保存がある場合
        if($edit->file != null){
          unlink($edit->file->file_pass);
          $edit->file->post_id = $edit->id;
          $edit->file->file_pass = $file_pass;
          $edit->file_type = $file_type;
          $edit->file->update();
        } else {
          //ファイル保存がない場合
          $file = new File();
          $file->post_id = $edit->id;
          $file->file_pass = $file_pass;
          $file->file_type = $file_type;
          $file->save();
        }
      } else {
        if($edit->file != null){
          unlink($edit->file->file_pass);
          $edit->file->delete();
        }  
      }
    }

    $flag = null;
    
    if ($req->hasFile('file')) {
      //ファイルの取得
      $file = $req->file;

      //アップロードの確認
      if (!$file->isValid()) {
        $flag = 'アップロードに失敗しました。';
      }

      //動画・画像ファイルの場合分け
      //ファイルのタイプの取得
      $finfo = finfo_open(FILEINFO_MIME_TYPE);
      $mime_type = finfo_file($finfo, $file);
      finfo_close($finfo);
      
      $filetype_array = array(
        'gif' => 'image/gif',
        'jpg' => 'image/jpeg',
        'jpeg' => 'image/jpeg',
        'png' => 'image/png',
        'mp4' => 'video/mp4',
      );
        
      if ($extension = array_search($mime_type, $filetype_array, true)) {
        if ($extension == 'gif' || $extension == 'jpg' || $extension == 'jpeg' || $extension == 'png') {
          $image = true;
          //オリジナルファイル名を取得
          $name = uniqid();
          $save_file = "images/".$name.".".$extension;

          //ファイルのアップロード
          $req->file('file')->storeAs('images', $name.".".$extension, 'public_uploads');
          upload_judge($req->name, $req->comment, $req->pass, $save_file, $extension, $image, $video, $id);
        } elseif ($extension == 'mp4') {
          $video = true;
          //オリジナルファイル名を取得
          $name = uniqid();
          $save_file = "videos/".$name.".".$extension;

          //ファイルのアップロード
          $req->file('file')->storeAs('videos', $name.".".$extension, 'public_uploads');
          upload_judge($req->name, $req->comment, $req->pass, $save_file, $extension, $image, $video, $id);
        }
      }
    } else {
      $save_file = null;
      $extension = null;
      upload_judge($req->name, $req->comment, $req->pass, $save_file, $extension, $image, $video, $id);
    }

    //json部分
    $posts = Post::all();
    foreach($posts as $post) {
      if($post->file != null){
        $user = [
          'id' => $post->id,
          'post_name' => $post->post_name,
          'comment' => $post->comment,
          'post_time' => $post->post_time,
          'file_type' => $post->file->file_type,
          'file_pass' => $post->file->file_pass,
          'image' => $post->image,
          'video' => $post->video,
        ];
      } else {
        $user = [
          'id' => $post->id,
          'post_name' => $post->post_name,
          'comment' => $post->comment,
          'post_time' => $post->post_time,
          'file_type' => null,
          'file_pass' => null,
          'image' => $post->image,
          'video' => $post->video,
        ];
      }
      $data[] = $user;
    }

    
    return response()
      ->json([
        'users' => $data
      ]);
  }

}