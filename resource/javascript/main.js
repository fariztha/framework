import React from 'react';
import ReactDOM from 'react-dom';
import sayHello from './components/MyModule';
import MyComponent from './components/reactcomponent';
import $ from 'jquery';
import 'bootstrap';
import '../sass/main.scss';

const MyComponentElement = document.getElementById('root');
console.log(MyComponentElement);

if (MyComponentElement) {
  ReactDOM.render(<MyComponent/>, MyComponentElement);  
  sayHello('Hello from Rollup');
}