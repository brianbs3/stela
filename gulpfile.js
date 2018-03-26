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


//const production = process.env.NODE_ENV === 'production' || process.env.NODE_ENV === 'uat';
const production = 'production'
const dependencies = [];

gulp.task('vendor', () => {
    return gulp.src([
        'bower_components/jquery/dist/jquery.min.js',
        'bower_components/bootstrap/dist/js/bootstrap.min.js',
        'bower_components/bootstrap/dist/js/bootstrap.min.js.map',
        'bower_components/toastr/toastr.min.js',
        'bower_components/nprogress/nprogress.js'
    ]).pipe(concat('vendor.js'))
        .pipe(gulpif(production, uglify({ mangle: true })))
        .pipe(gulp.dest('public_html/js'));
});

gulp.task('browserify-vendor', () => {
    return browserify()
        .require(dependencies)
        .bundle()
        .pipe(source('vendor.bundle.js'))
        .pipe(buffer())
        .pipe(gulpif(production, uglify({ mangle: true })))
        .pipe(gulp.dest('public_html/js'));
});

gulp.task('default', ['browserify-vendor']);
