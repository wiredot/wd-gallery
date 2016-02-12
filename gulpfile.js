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
	glob = require('glob'),
	del = require('del');

var options = {
	dist: 'dist',
	assets: 'assets',
	themes: 'themes',
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

var themes = glob.sync(options.src + '/themes/*').map(function(themeDir) {
    return path.basename(themeDir);
});

themes.forEach(function(name) {
    gulp.task(name+'-scss', function() {
        return gulp.src(options.src + '/themes/'+name+'/scss/*.scss')
            .pipe(maps.init())
			.pipe(sass())
			.pipe(maps.write('./'))
            .pipe(gulp.dest(options.themes + '/'+name+'/assets/css'))
    });

    gulp.task(name+'-theme', [name+'-scss']);
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

gulp.task('default', ['scss', 'js', 'svg', 'themes']);
gulp.task('themes', themes.map(function(name){ return name+'-theme'; }));

gulp.task('watch', function() {
	gulp.watch( options.src + '/js/*.js', ['js']);
	gulp.watch( options.src + '/scss/*.scss', ['scss']);
	gulp.watch( options.src + '/images/*.svg', ['svg']);
	themes.map(function(name){
		gulp.watch( options.src + '/themes/'+name+'/scss/*.scss', [name + '-scss']);
	});
});