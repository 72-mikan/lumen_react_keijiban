import React, { Component } from 'react';
import axios from 'axios';

export default class extends Component {
  constructor(props) {
    super(props);
    this.state = {
      msg: 'wait...'
    };
    //apiの取得
    axios
      .get('http://localhost/api')
      .then(req => {
        let person = req.data;
        let name = person.name;
        let sex = person.sex;
        let age = person.age;
        this.setState((state)=>({
          msg: 'api通信に成功',
          name: name,
          sex: sex,
          age: age,
        }));
      });
  }

  render() {
    return(
      <div>
        <p>{this.state.msg}</p>
        <p>名前：{this.state.name}</p>
        <p>性別：{this.state.sex}</p>
        <p>年齢：{this.state.age}</p>
      </div>
    );
  }
}