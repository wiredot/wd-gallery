'use strict';

var gulp = require('gulp'),
	sass = require('gulp-sass'),
	maps = require('gulp-sourcemaps'),
	concat = require('gulp-concat'),
	svgmin = require('gulp-svgmin'),
	svgstore = require('gulp-svgstore'),
	rsp = require('remove-svg-properties').stream,
	plumber = require('gulp-plumber'),
	notify = require('gulp-notify'),
	browserSync = require('browser-sync'),
	reload = browserSync.reload,
	path = require('path');

var options = {
	dist: 'dist',
	templates: 'templates',
	assets: 'assets',
	src: 'src'
}

gulp.task('default', ['scss', 'js', 'svg']);

gulp.task('watch', function() {
	gulp.watch( options.src + '/js/*.js', ['js']);
	gulp.watch( options.src + '/scss/**/*.scss', ['scss']);
	gulp.watch( options.src + '/images/*.svg', ['svg']);
});

gulp.task('js', function() {
	return gulp.src( options.src + '/js/*.js')
		.pipe(plumber({errorHandler: notify.onError("Error: <%= error.message %>")}))
		.pipe(maps.init())
		.pipe(concat('wp-gallery.js'))
		// .pipe(uglify())
		.pipe(maps.write('./'))
		.pipe(gulp.dest( options.assets + '/js'))
		.pipe(notify({
			message: 'all done',
			title: 'JS'
		}));
});

gulp.task('scss', function() {
	return gulp.src( options.src + '/scss/*.scss')
		.pipe(plumber({errorHandler: notify.onError("Error: <%= error.message %>")}))
		.pipe(maps.init())
		.pipe(sass(''))
		// .pipe(cssnano())
		// .pipe(rename('wp-gallery-admin.min.css'))
		.pipe(maps.write('./'))
		.pipe(gulp.dest( options.assets + '/css'))
		.pipe(notify({
			message: 'all done',
			title: 'SCSS'
		}));
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

gulp.task('cleanimg', function () {
	del( options.assets + '/images/*.{png,jpg,jpeg}');
});

gulp.task('img', ['cleanimg'], function () {
	gulp.src( options.src + '/images/*.{png,jpg,jpeg}')
		.pipe(imagemin('iSsNqV3CinZPpNT_i5LV87-VeryQMdUT'))
		.pipe(gulp.dest( options.assets + '/images'));
});


// Production
gulp.task('dist_clear', function() {
	del( options.dist + '/*' );
});

gulp.task('dist_copy', ['dist_clear', 'default', ], function() {
	return gulp.src( [
		'composer.json', 
		'assets/**/*.{css,js,jpg,svg}', 
		'classes/*', 
		'config/*', 
		'languages/*', 
		'skins/**/*.{css,js,jpg,svg,png,php,html}', 
		'templates/**/*',
		'readme.txt', 
		'wp-gallery.php'
	], {base: './'} )
	.pipe(gulp.dest( options.dist ));
});

gulp.task('dist', ['dist_copy'], function(){
	composer({
        "working-dir": "./dist/",
        bin: "composer"
    });
});
