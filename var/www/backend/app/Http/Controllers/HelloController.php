<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Post;
use App\Models\File;
use PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;
use Illuminate\Support\Facades\Mail;

class HelloController extends Controller
{
  public function mail()
    {
      $mail_honbun = "tset";
      
      Mail::raw($mail_honbun, function($msg) {
        $msg->to(['shinzi7280.18@gmail.com']);
        $msg->from(['shinzi7280@gmail.com']);
        $msg->subject("メール件名");
      }); 
      

    }

    public function sendMail()
    {
      $subject = 'test';
      $body = 'test';
      $mail = new PHPMailer\PHPMailer();
      
      $mail->isSMTP(); 
      $mail->SMTPAuth   = true;
      $mail->Host       = 'smtp.gmail.com';       // メインのSMTPサーバーを指定する
      $mail->Port       = 587;       // 接続するTCPポート
      $mail->Username   = 'shinzi7280@gmail.com';   // SMTPユーザー名
      $mail->Password   = 'suzydnjkebboyptp';   // SMTPパスワード
      $mail->SMTPSecure = 'tls'; // TLS暗号化
      // メール内容設定
      $mail->CharSet  = "UTF-8";
      $mail->Encoding = "base64";
      //FROM用メールアドレスと宛先名
      $mail->setFrom('shinzi7280@gmail.com', 'test');
      // TO用メールアドレスと宛先名
      $mail->addAddress('shinzi7280.18@gmail.com', 'tset');
      $mail->Subject = $subject;
      // HTMLフォーマットの有効
      $mail->Body = $body;

      if ($mail->send() === false) {
        echo "Mail sending failed!! Mailer Error: {$mail->ErrorInfo}";
      }
    }

    public function test_mail()
    {
      //本登録用urlの取得
      $url = "http://".$_SERVER["HTTP_HOST"]."/test";

      mb_language("japanese");
      mb_internal_encoding("UTF-8");
      
      $subject = "ユーザー登録";
      $body = "以下URLから24時間以内に登録を行ってください。\n";
      $body.= $url."\n";
      $body.= "24時間を過ぎた場合、仮登録は自動で登録が解除されます。\n";
      
      $mail = new PHPMailer\PHPMailer();

      $send_mail = 'shinzi7280.18@gmail.com';
      $name = 'test';
      
      $mail->isSMTP(); 
      $mail->SMTPAuth   = true;
      $mail->Host       = 'smtp.gmail.com';       // メインのSMTPサーバーを指定する
      $mail->Port       = 587;       // 接続するTCPポート
      $mail->Username   = 'shinzi7280@gmail.com';   // SMTPユーザー名
      $mail->Password   = 'suzydnjkebboyptp';   // SMTPパスワード
      $mail->SMTPSecure = 'tls'; // TLS暗号化
      // メール内容設定
      $mail->CharSet  = "UTF-8";
      $mail->Encoding = "base64";
      //FROM用メールアドレスと宛先名
      $mail->setFrom('shinzi7280@gmail.com', 'test');
      // TO用メールアドレスと宛先名
      $mail->addAddress($send_mail, $name);
      $mail->Subject = $subject;
      // HTMLフォーマットの有効
      $mail->Body = $body;

      if ($mail->send() === false) {
        echo "Mail sending failed!! Mailer Error: {$mail->ErrorInfo}";
      }
    }

    public function index()
    {
      return view('dist.index');
    }

    public function api()
    {
        return response()
          ->json([
            'name' => 'Shinji, NATSUHARA',
            'sex' => 'male',
            'age' => '100',
          ]);
    }

    public function test()
    {
      return 'test1';
    }

    public function img()
    {
      echo url(`image/53516.jpg`);
    }

    public function upload()
    {
      
      return view('ctrl.upload', 
      [
        'result' => '',
        'url' => url('/image/53516.jpg')
      ]);
    }
    /*
    public function upload()
    {
      return 'test';
    }
    */

    public function uploadfile(Request $req)
    {
      if(!$req->hasFile('upfile')) {
        return 'ファイルを指定してください。';
      }
      $file = $req->upfile;
      if(!$file->isValid()) {
        return 'アップロードに失敗しました。';
      }
      $name = $file->getClientOriginalName();
      //$file->storeAs('public/image', $name);
      $req->file('upfile')->storeAs('image', $name, 'public_uploads');
      return view('ctrl.upload', [
        'result' => $name.'をアップロードしました。',
        'url' => url('/image/53516.jpg')
      ]);
    }

    public function json_test() 
    {
      $posts = Post::all();
      foreach($posts as $post) {
        //if($post->file != null){
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
       // } 
       /*
        else {
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
        }*/
        $data[] = $user;
      }

      
      return response()
        ->json([
          'users' => $data
        ]);
    }

    
}