import React, { Component } from 'react';
import PropTypes from 'prop-types';

export default class MyContent extends Component {
  constructor(props){
    super(props);
    this.state = {
    };
  }

  render() {
    return(
      <React.Fragment>
        <div>
          <table>
            <th>投稿者名</th>
            <td>{this.props.post_name}</td>
          </table>
          <table>
            <th>コメント：</th>
            <td>{this.props.comment}</td>
          </table>
          <table>
            <th>投稿日</th>
            <td>{this.props.post_time}</td>
          </table>
          {this.props.image ? <img src={`http://localhost/`+this.props.file_pass} width="500" height="500"></img> : null} 
          {this.props.video ? <video src={`http://localhost/`+this.props.file_pass}  alt="アップロードファイル" controls></video> : null}
        </div>
      </React.Fragment>
    );
  }
}