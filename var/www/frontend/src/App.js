import React, { Component } from 'react';
import { HashRouter as Router, Route, Switch } from "react-router-dom";

import MyHome from './home/MyHome';
import MyLogin from './login/MyLogin';
import MyRegister from './login/MyRegister';
import MyReregister from './login/MyReregister';
import MyKeijiban from './form/MyKeijiban';

export default class App extends Component {
  constructor(props){
    super(props);
  }

  render() {
    return(
      <Router>
        <Switch>
          <Route exact path="/" component={MyHome} />
          <Route path="/login" component={MyLogin} />
          <Route path="/register" component={MyRegister} />
          <Route path="/reregister" component={MyReregister} />
          <Route path="/keijiban" component={MyKeijiban} />
        </Switch>
      </Router>
    );
  }
}