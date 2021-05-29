import React, { Component } from 'react';
import { HashRouter as Router, Link } from "react-router-dom";

export default class MyLogin extends Component {
  constructor(props) {
    super(props);

    this.state = {
      mail: '',
      pass: '',
      type: true,
    }

    this.handleChange = this.handleChange.bind(this);
  }

  handleChange(e) {
    this.setState({
      [e.target.name]: e.target.vale,
    })
  }

  render() {
    return(
      <div>
        <h3>簡易掲示板ログインページ</h3>
        <from action="" method="post">
          <div>
            <label id="login_id">Mail:</label><br />
            <input id="login_id" name="mail" type="text" value={this.state.mail} onChange={this.handleChange}/>
          </div>
          <div>
            <label id="pass">Password:</label><br />
            <input id="pass" name="pass" type="password" value={this.state.pass} onChange={this.handleChange} />
          </div>
          <input type="submit" value="ログイン" />
        </from>
        <div>
          <Router>
            <div>
              <Link to="/register">登録はこちらから</Link>
            </div>
            <div>
              <Link to="/reregister">パスワードを忘れた方はこちら</Link>
            </div>
            <div>
              <Link to="/keijiban">テスト掲示板</Link>
            </div>
          </Router>
        </div>
      </div>
    );
  }
}