import React, { Component } from 'react';
import { HashRouter as Router, Link } from "react-router-dom";

export default class extends Component {
  render() {
    return(
      <div>
        <h3>再登録ページ</h3><br />
        <form action="" method="post">
          <div>
            <label id="mail">Mail:</label><br />
            <input id="mail" name="mail" type="mail" value="" />
          </div>
          <div>
            <label id="pass">Password:</label><br />
            <input id="pass" name="pass" type="password" />
          </div>
          <input type="submit" value="登録" />
        </form>
        <div>
          <Router>
            <Link to="/" >戻る</Link>
          </Router>
        </div>
      </div>
    );
  }
}