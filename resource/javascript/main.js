import React from 'react';
import ReactDOM from 'react-dom';
import AppRoute from './router';
import sayHello from './components/MyModule';
import MyComponent from './components/reactcomponent';
import { Navbar, Icon ,NavItem  } from 'react-materialize';
import M from 'materialize-css'
import 'materialize-css/sass/materialize.scss';
import '../sass/main.scss';



ReactDOM.render(
  <AppRoute />, document.getElementById('root')
);