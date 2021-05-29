<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\User;
use App\Models\Post;
use App\Models\File;
use PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

class RegisterController extends Controller
{
  //データの登録
  public function register(Request $req)
  {
    $create_id = uniqid();

    $user = new User();
    $user->user_id = $create_id;
    $user->name = $req->name;
    $user->pass = $req->pass;
    $user->mail = $req->mail;
    $user->permit = false;
        
    $user->save();
    
    mb_language("japanese");
    mb_internal_encoding("UTF-8");

    //本登録用urlの取得
    $url = "http://".$_SERVER["HTTP_HOST"]."/register/mail/".$create_id;
    
    $subject = "ユーザー登録";
    $body = "以下URLから24時間以内に登録を行ってください。\n";
    $body.= $url."\n";
    $body.= "24時間を過ぎた場合、仮登録は自動で登録が解除されます。\n";
    
    $mail = new PHPMailer\PHPMailer();

    $send_mail = (string) $req->mail;
    $name = (string) $req->name;
    
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

  return response()->json();
  }

  public function true_register($login_id)
  {
    $user = User::where('user_id', $login_id)->first();

    if(!empty($user)) {
      $user->permit = true;
      $user->update();
      return redirect('http://localhost:3000/#/');
    } else {
      return 'IDが無効です。';
    }
    
  }

}