import sayHello from './components/MyModule';
import _ from 'lodash';
import '../sass/main.scss';

const arr = _.concat([1, 2, 3], 4, [7]);
sayHello('Hello from Rollup and lodash: ' + arr);
