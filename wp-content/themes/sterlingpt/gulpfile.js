
/*
  Usage:
  1. npm install //To install all dev dependencies of package
  2. npm run dev //To start development and server for live preview
  3. npm run prod //To generate minifed files for live server
*/

const { src, dest, watch, series, parallel } = require('gulp');
const del = require('del'); //For Cleaning build/dest for fresh export
const options = require("./config"); //paths and other options from config.js

const sass = require('gulp-sass')(require('sass')); //For Compiling SASS files
const concat = require('gulp-concat'); //For Concatinating js,css files
const uglify = require('gulp-terser');//To Minify JS files
const cleanCSS = require('gulp-clean-css');//To Minify CSS files
const sourcemaps = require('gulp-sourcemaps'); // To show sourcemap
const purgecss = require('gulp-purgecss');

// ===== Dev tasks =====
function devStyles() {
  return src(`${options.paths.src.scss}/**/*.scss`)
    .pipe(sourcemaps.init())
    .pipe(sass().on('error', sass.logError))
    .pipe(concat({ path: 'style.css' }))
    .pipe(cleanCSS())
    .pipe(sourcemaps.write('.'))
    .pipe(dest(options.paths.dest.css));
}

function devScripts() {
  return src([
    `${options.paths.src.js}/libs/**/*.js`,
    `${options.paths.src.js}/**/*.js`,
  ])
  .pipe(concat({ path: 'scripts.js' }))
  // .pipe(uglify())
  .pipe(dest(options.paths.dest.js));
}

function watchFiles() {
  watch(`${options.paths.src.scss}/**/*.scss`, series(devStyles));
  watch(`${options.paths.src.scss}/**/*.scss`, series(prodStyles));
  watch(`${options.paths.src.js}/**/*.js`, series(devScripts));
  watch(`${options.paths.src.js}/**/*.js`, series(prodScripts));
  console.log("Watching for Changes..\n");
}

function devClean() {
  console.log("Cleaning dest folder for fresh start.\n");
  return del([options.paths.dest.css, options.paths.dest.js]);
}

// ==== BUILD tasks =====
function prodStyles() {
  return src(`${options.paths.src.scss}/**/*.scss`)
    .pipe(sass().on('error', sass.logError))
    .pipe(dest(options.paths.dest.css))
    .pipe(concat({ path: 'style.min.css' }))
    .pipe(cleanCSS())
    .pipe(dest(options.paths.dest.css));
}

function prodScripts() {
  return src([
    `${options.paths.src.js}/libs/**/*.js`,
    `${options.paths.src.js}/**/*.js`
  ])
    .pipe(concat({ path: 'scripts.min.js' }))
    .pipe(uglify())
    .pipe(dest(options.paths.dest.js));
}

function prodClean() {
  console.log("Cleaning build folder for fresh start.\n");
  return del([options.paths.dest.css, options.paths.dest.js]);
}

function buildFinish(done) {
  console.log(`Production build is complete. Files are located at ${options.paths.dest.base}\n`);
  done();
}

exports.default = series(
  devClean, // Clean dest Folder
  parallel(devStyles, devScripts), //Run All tasks in parallel
  watchFiles // Watch for Live Changes
);

exports.watchFiles = watchFiles; // Make sure it's exported as a task

exports.prod = series(
  prodClean, // Clean Build Folder
  parallel(prodStyles, prodScripts), //Run All tasks in parallel
  buildFinish
);