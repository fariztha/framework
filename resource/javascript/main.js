import React from 'react';
import ReactDOM from 'react-dom';
import sayHello from './components/MyModule';
import MyComponent from './components/reactcomponent';
import _ from 'lodash';

import '../sass/main.scss';

const MyComponentElement = document.getElementById('root');

if (MyComponentElement) {
  ReactDOM.render(<MyComponent/>, MyComponentElement); 
}


const arr = _.concat([1, 2, 3], 4, [7]);
sayHello('Hello from Rollup and lodash: ' + arr);
