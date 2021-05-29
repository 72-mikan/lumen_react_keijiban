import React, { Component } from 'react';
import { HashRouter as Router, Link } from "react-router-dom";
import MyRegisterForm from './MyRegisterForm';
import MyRegisterConfirmation from './MyRegisterConfirmation';

export default class extends Component {
  constructor(props) {
    super(props);
    this.state = {
      flag: true
    };
  }

  render() {
    return(
      <div>
        {this.state.flag 
          ? <MyRegisterForm />
          : <MyRegisterConfirmation />
        }
        <div>
          <Router>
            <Link to="/" >戻る</Link>
          </Router>
        </div>
      </div>
    );
  }
}