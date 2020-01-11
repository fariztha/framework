import React from 'react';
import $ from "jquery";

export default class MyComponent extends React.Component {
  componentDidMount() {
    $("button").click(function() {
      $("h1").toggleClass("red");
    });
  }
  render() {
    return (
    		<div>    		
    		<h1>Hello From ReactJS</h1>
    		<button>Click Me</button>
    		</div>
    );
  }
}