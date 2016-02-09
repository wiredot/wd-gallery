'use strict';

var gulp = require('gulp'),
	concat = require('gulp-concat'),
	maps = require('gulp-sourcemaps'),
	sass = require('gulp-svgstore'),
	sass = require('gulp-sass'),
	svgstore = require('gulp-svgstore'),
	svgmin = require('gulp-svgmin'),
	path = require('path'),
	imagemin = require('gulp-tinypng'),
	del = require('del');

var options = {
	dist: 'dist',
	assets: 'assets',
	src: 'src'
}

gulp.task('js', function() {
	return gulp.src( options.src + '/js/*.js')
		.pipe(maps.init())
		.pipe(concat('wd-gallery.js'))
		.pipe(maps.write('./'))
		.pipe(gulp.dest( options.assets + '/js'));
});

gulp.task('scss', function() {
	return gulp.src( options.src + '/scss/wd-gallery.scss')
		.pipe(maps.init())
		.pipe(sass('wd-gallery.css'))
		.pipe(maps.write('./'))
		.pipe(gulp.dest( options.assets + '/css'));
});

gulp.task('svg', function() {
	return gulp.src( options.src + '/images/*.svg')
		.pipe(svgmin(function (file) {
			var prefix = path.basename(file.relative, path.extname(file.relative));
			return {
				plugins: [{
					cleanupIDs: {
						prefix: prefix + '-',
						minify: true
					}
				}]
			}
		}))
		.pipe(gulp.dest( options.assets + '/images'));
});

gulp.task('default', ['scss', 'js', 'svg']);

gulp.task('watch', function() {
	gulp.watch( options.src + '/js/*.js', ['js']);
	gulp.watch( options.src + '/scss/*.scss', ['scss']);
	gulp.watch( options.src + '/images/*.svg', ['svg']);
});