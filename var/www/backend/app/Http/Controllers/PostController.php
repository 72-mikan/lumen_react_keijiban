<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\Post;
use App\Models\File;

class PostController extends Controller
{
    public function form()
    {
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

    public function post(Request $req)
    {
      //初期値
      $image = false;
      $video = false;

      //アップロード部分
      function upload_judge($post_name, $comment, $pass, $file_pass, $file_type, $image, $video)
      {
        $post = new Post();
        $post->user_id = 1;
        $post->post_name = $post_name;
        $post->comment = $comment;
        $post->pass = $pass;
        $post->post_time = date("Y/m/d H:i:s", time());
        $post->image = $image;
        $post->video = $video;
        $post->save();
        //filesデータベースへ保存
        if($file_pass != null) {
          $file = new File();
          $file->post_id = $post->id;
          $file->file_pass = $file_pass;
          $file->file_type = $file_type;
          $file->save();
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
            upload_judge($req->name, $req->comment, $req->pass, $save_file, $extension, $image, $video);
          } elseif ($extension == 'mp4') {
            $video = true;
            //オリジナルファイル名を取得
            $name = uniqid();
            $save_file = "videos/".$name.".".$extension;

            //ファイルのアップロード
            $req->file('file')->storeAs('videos', $name.".".$extension, 'public_uploads');
            upload_judge($req->name, $req->comment, $req->pass, $save_file, $extension, $image, $video);
          }
        }
      } else {
        $save_file = null;
        $extension = null;
        upload_judge($req->name, $req->comment, $req->pass, $save_file, $extension, $image, $video);
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
