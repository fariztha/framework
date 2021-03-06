import resolve from '@rollup/plugin-node-resolve';
import commonjs from '@rollup/plugin-commonjs';
import replace from '@rollup/plugin-replace';
import copy from 'rollup-plugin-copy';
import scss from 'rollup-plugin-scss';
import json from '@rollup/plugin-json';
import nodePolyfills from 'rollup-plugin-node-polyfills';
import vuePlugin from 'rollup-plugin-vue';


//amd – Asynchronous Module Definition, used with module loaders like RequireJS
//cjs – CommonJS, suitable for Node and other bundlers
//esm – Keep the bundle as an ES module file, suitable for other bundlers and inclusion as a <script type=module> tag in modern browsers
//iife – A self-executing function, suitable for inclusion as a <script> tag. (If you want to create a bundle for your application, you probably want to use this.)
//umd – Universal Module Definition, works as amd, cjs and iife all in one
//system – Native format of the SystemJS loader

export default {
    input: './resources/javascript/main.js',
    onwarn,
    output: {
        file: './public/assets/js/bundle.min.js',
        format: 'esm',         
        name: 'bundle.min',
        globals: {            
            'jquery': '$',
        }     
    },
    plugins: [
        resolve({
            extensions: ['.vue', '.js', '.jsx', '.json'],
            preferBuiltins: true ,
            mainFields: ['browser'],
            browser: true
        }),
        vuePlugin({
            compileTemplate: true,
        }), 
        replace({
            'process.env.NODE_ENV': JSON.stringify('development')
        }),                        
        commonjs(),
        nodePolyfills(),
        json(),        
        scss({
            output: true,            
            output: './public/assets/css/bundle.min.css',
        }),
        copy({
	      targets: [	        
	        { src: './resources/assets/*', dest: './public/assets' }
	      ]
        })        
    ]
}

function onwarn(warning) {
    if (warning.code !== 'CIRCULAR_DEPENDENCY') {
        console.error(`(!) ${warning.message}`);
    }
}