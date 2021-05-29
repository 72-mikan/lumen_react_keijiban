import React, { Component } from 'react';


export default class extends Component {
  constructor(props) {
    super(props);
    this.state = {
    };
  }

  render() {
    return(
      <div>
        <h3>本登録用メールを送信しました。</h3>
        <h3>メール内容に沿って登録を行ってください。</h3>
      </div>
    );
  }
}