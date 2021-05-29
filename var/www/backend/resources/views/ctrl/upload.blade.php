@extends('layouts.base')
@section('title', 'アップロードの基本')
@section('main')
<form method="POST" action="../save/edit/11" enctype="multipart/form-data">
  <div>
    <label id="name">name:</label><br />
    <input id="name" name="name" type="text" value=''/>
  </div>
  <div>
    <label id="comment">comment:</label><br />
    <textarea id="comment" name="comment" value=''></textarea>
  </div>
  <div>
    <label id="pass">password:</label><br />
    <input id="pass" name="pass" type="text" value='' />
  </div>
  <input id="file" name="file" type="file" />
  <input type="submit" value="送信" />
</form>
<img src="{{ $url }}">
<p>{{$url}}</p>
@endsection