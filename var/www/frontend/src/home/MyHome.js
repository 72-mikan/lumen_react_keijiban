import React, { Component } from 'react';
import MyLogin from '../login/MyLogin'; 
import MyKeijiban from '../form/MyKeijiban';

export default class MyHome extends Component {
  constructor(props) {
    super(props);
    this.state = {
      type: true
    }
  }  

  render() {
    return(
      <div>
        { this.state.type 
          ? <MyLogin />
          : <MyKeijiban />}
      </div>
    );
  }

}