const gulp = require('gulp');
const gutil = require('gulp-util');
const gulpif = require('gulp-if');
const autoprefixer = require('gulp-autoprefixer');
const cssmin = require('gulp-cssmin');
const less = require('gulp-less');
const concat = require('gulp-concat');
const plumber = require('gulp-plumber');
const buffer = require('vinyl-buffer');
const source = require('vinyl-source-stream');
const babelify = require('babelify');
const browserify = require('browserify');
const watchify = require('watchify');
const uglify = require('gulp-uglify');
const sourcemaps = require('gulp-sourcemaps');
const minify = require('gulp-minify');


//const production = process.env.NODE_ENV === 'production' || process.env.NODE_ENV === 'uat';
const production = 'production'
const dependencies = [];

gulp.task('stela', () => {
    return gulp.src([
        'public/js/stela/stela.js',
        'public/js/stela/stelaCustomer.js',
        'public/js/stela/stelaProduct.js'
    ]).pipe(concat('stela.js'))
        .pipe(uglify({ mangle: true }))
        .pipe(minify({ mangle: true }))
        .pipe(gulp.dest('public/js'));
});


gulp.task('default', ['stela']);
