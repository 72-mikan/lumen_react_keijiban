import React, { Component } from 'react';
import axios from 'axios';

export default class extends Component {
  constructor(props) {
    super(props);
    this.state = {
      name: '',
      mail: '',
      pass: ''
    };

    this.handleChange = this.handleChange.bind(this);
    this.doAction = this.doAction.bind(this);
  }

  //データの保持
  handleChange(e) {
    this.setState({
      [e.target.name]: e.target.value
    })
  }

  doAction(e) {
    if((this.state.name === '') || (this.state.mail === '') || (this.state.pass === '')){
      alert('入力部分が不足しています');
    } else {
      alert('入力成功');
      const data = new FormData();
      data.append('name', this.state.name);
      data.append('mail', this.state.mail);
      data.append('pass', this.state.pass);
      axios
        .post('http://localhost/register', data, 
        { 
          headers: {
            'content-type': 'multipart/form-data',
          }
        })
      .then((response)=> {
        this.setState((state) => ({
          name: '',
          mail: '',
          pass: ''
        }));
        console.log(response);
      })
      .catch((error)=> {
        console.info(error);
      });
    }
  }

  render() {
    return(
      <div>
        <h3>登録ページ</h3>
        <form >
          <div>
            <label id="name">Name:</label><br />
            <input id="name" name="name" type="text" value={this.state.name} onChange={this.handleChange}/>
          </div>
          <div>
            <label id="mail">Mail:</label><br />
            <input id="mail" name="mail" type="mail" value={this.state.mail} onChange={this.handleChange}/>
          </div>
          <div>
            <label id="pass">Password:</label><br />
            <input id="pass" name="pass" type="password" value={this.state.pass} onChange={this.handleChange}/>
          </div>
          <input type="submit" value="登録" onClick={this.doAction} />
        </form>
      </div>
    );
  }
}