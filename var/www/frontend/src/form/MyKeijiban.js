import React, { Component } from 'react';
import MyContent from './MyContent';
import axios from 'axios';

export default class MyKeijiban extends Component {
  constructor(props) {
    super(props);
    
    this.state = {
      msg: 'wait...',
      users:[],
      name: '',
      comment: '',
      pass: '',
      file: '',
      flag: 0,
      post_type: true,
      edit_id: 0
    };
    
    this.handleChange = this.handleChange.bind(this);
    this.doAction = this.doAction.bind(this);
    this.deleteTask = this.deleteTask.bind(this);
    this.fileChange = this.fileChange.bind(this);
  }

  componentDidMount() {
    axios
      .get('http://localhost/post/form')
      .then(req => {
        this.setState((state)=>({
          msg: null,
          users: req.data.users
        }));
      });
  }

  //
  handleChange(e) {
    this.setState({
      [e.target.name]: e.target.value
    })
  }

  fileChange(e) {
    this.setState({
      file: e.target.files[0],
    })
  }

  //投稿部分
  doAction() {
    if((this.state.name === '') || (this.state.comment === '') || (this.state.pass === '')){
      alert('入力が不足しています。');
    }else{
      alert('入力成功');
      const data = new FormData();
      data.append('name', this.state.name);
      data.append('comment', this.state.comment);
      data.append('pass', this.state.pass);
      data.append('file', this.state.file);
      
      axios
        .post('http://localhost/keijiban/post', data,
        {
          headers: {
            'content-type': 'multipart/form-data',
          }
        })
        .then(req => {
          this.setState((state) => ({
            msg: null,
            users: req.data.users,
            flag: req.data.flag,
          }));
          //alert(this.state.flag);
          console.log(req);
        })
        .catch((error) => {
          console.info(error)
        })
      
      this.setState({
          name: '',
          comment: '',
          pass: '',
          file: '',
      })
    }
  }

  deleteClick(id){
    //パスワード確認
    let pass = prompt('パスワードを入力してください。');
    const pass_data = {
      id: id,
      pass: pass
    }
    axios
      .post(`http://localhost/save/delete/pass`, pass_data)
      .then(req => {
        this.setState((state) => ({
          flag: req.data.flag
        }))
        console.log(req);
        if(pass != null){
          if(this.state.flag == 1) {
            return this.deleteTask(id);
          } else {
            alert('パスワードが違います。');
          }
        } else {
          alert('入力をキャンセルしました。')
        }
      })
      .catch((error) => {
        console.info(error);
      })
  }

  deleteTask(id) {
    //削除部分
    if(this.state.flag == 1) {
      if(window.confirm('本当に削除してもよろしいですか？')) {
        axios
          .delete(`http://localhost/save/delete/${id}`)
          .then(req => {
            this.setState((state) => ({
              users: req.data.users
            }))
            console.log(req);
          })
          .catch((error) => {
            console.info(error);
          })
        alert('削除をしました。');
      } else {
        alert('削除を中止しました。');
      }
    }
  }

  editClick(id){
    let pass = prompt('パスワードを入力してください。');
    const pass_data = {
      id: id,
      pass: pass
    }
    axios
      .post(`http://localhost/save/edit_pass/pass`, pass_data)
      .then(req => {
        this.setState((state) => ({
          flag: req.data.flag,
          name: req.data.name,
          comment: req.data.comment,
          pass: req.data.pass,
          post_type: req.data.post_type,
          edit_id: req.data.edit_id
        }))
        console.log(req);
        console.log(this.state.flag);
        if(this.state.flag == 1) {
          //alert(this.state.edit_id);
          alert('編集をして下さい。');
        } else {
          //alert(this.state.edit_id);
          alert('パスワードが違います。');
        }
      })
      .catch((error) => {
        console.info(error);
      })
  }

  editTask(id) {
    let edit_id = id;
    console.log(edit_id);
    if((this.state.name === '') || (this.state.comment === '') || (this.state.pass === '')){
      alert('入力が不足しています。');
    }else{
      alert('入力成功');
      const data = new FormData();
      data.append('name', this.state.name);
      data.append('comment', this.state.comment);
      data.append('pass', this.state.pass);
      data.append('file', this.state.file);
      axios
        .post('http://localhost/save/edit/' + edit_id, data)
        .then(req => {
          this.setState((state) => ({
            msg: null,
            users: req.data.users
          }));
          console.log(req);
        })
        .catch((error) => {
          console.info(error)
        })
      
      this.setState({
          name: '',
          comment: '',
          pass: '',
          post_type: true
      })
    }
  }

  render() {
    return(
      <div>
        <h3>簡易掲示板</h3>
        <from enctype='multipart/form-data' >
          <div>
            <label id="name">name:</label><br />
            <input id="name" name="name" type="text" value={this.state.name} onChange={this.handleChange}/>
          </div>
          <div>
            <label id="comment">comment:</label><br />
            <textarea id="comment" name="comment" value={this.state.comment} onChange={this.handleChange}></textarea>
          </div>
          <div>
            <label id="pass">password:</label><br />
            <input id="pass" name="pass" type="text" value={this.state.pass} onChange={this.handleChange} />
          </div>
          <div class="">
            <label id="data">image・video</label><br />
            <input type="file" name="file"  accept="image/*,.png,.jpg,.jpeg,.gif, video/*, .mp4" onChange={this.fileChange} />
          </div>
          { this.state.post_type 
            ? <input type="submit" value="投稿" onClick={this.doAction} /> 
            : <input type="submit" value="編集" onClick={this.editTask.bind(this, this.state.edit_id)} /> 
          }
        </from>
        <hr />
        <p>{this.state.msg}</p>
        <div>
          {this.state.users.map((user) => 
            <div>
              <MyContent {...user} />
              <button onClick={this.deleteClick.bind(this, user.id)}>削除</button>&nbsp;|&nbsp;
              <button onClick={this.editClick.bind(this, user.id)}>編集</button>
              <hr />
            </div>
          )}
        </div>
      </div>
    );
  }
}

