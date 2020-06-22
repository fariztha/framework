import React from 'react';
import ReactDOM from 'react-dom';
import sayHello from './components/MyModule';
import MyComponent from './components/reactcomponent';
import { Dropdown , Button, Card, Row, Col } from 'react-materialize';
import M from 'materialize-css'
import 'materialize-css/sass/materialize.scss';
import '../sass/main.scss';

const App = ({name}) =>
  <Dropdown trigger={
    <Button>Drop me!</Button>
  }>
    <p>Hello</p>
    <p>Hello</p>
    <p>Hello</p>
    <p>Bye</p>
  </Dropdown>;

ReactDOM.render(
  <App />, document.getElementById('root')
);