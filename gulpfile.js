'use strict';

var gulp = require('gulp'),
	concat = require('gulp-concat'),
	maps = require('gulp-sourcemaps'),
	sass = require('gulp-sass'),
	svgstore = require('gulp-svgstore'),
	svgmin = require('gulp-svgmin'),
	path = require('path'),
	imagemin = require('gulp-tinypng'),
	glob = require('glob'),
	uglify = require('gulp-uglify'),
	rename = require('gulp-rename'),
	plumber = require('gulp-plumber'),
	notify = require('gulp-notify'),
	composer = require('gulp-composer'),
	cssnano = require('gulp-cssnano'),
	del = require('del');

var options = {
	dist: 'dist',
	assets: 'assets',
	skins: 'skins',
	dist: 'dist',
	src: 'src'
}

gulp.task('js', function() {
	return gulp.src( options.src + '/js/*.js')
		.pipe(plumber({errorHandler: notify.onError("Error: <%= error.message %>")}))
		.pipe(maps.init())
		.pipe(concat('wp-photo-gallery.js'))
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
		// .pipe(rename('wp-photo-gallery-admin.min.css'))
		.pipe(maps.write('./'))
		.pipe(gulp.dest( options.assets + '/css'))
		.pipe(notify({
			message: 'all done',
			title: 'SCSS'
		}));
});

var skins = glob.sync(options.src + '/skins/*').map(function(themeDir) {
    return path.basename(themeDir);
});

skins.forEach(function(name) {
    gulp.task(name+'-scss', function() {
        return gulp.src(options.src + '/skins/'+name+'/scss/*.scss')
        	.pipe(plumber({errorHandler: notify.onError("Error: <%= error.message %>")}))
            .pipe(maps.init())
			.pipe(sass())
			.pipe(maps.write('./'))
            .pipe(gulp.dest(options.skins + '/'+name+'/assets/css'))
            .pipe(notify({
				message: 'all done',
				title: 'JS'
			}))
    });

    gulp.task(name+'-skins', [name+'-scss']);
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

gulp.task('skins', skins.map(function(name){ return name+'-skins'; }));

gulp.task('default', ['scss', 'js', 'svg', 'skins']);

gulp.task('watch', function() {
	gulp.watch( options.src + '/js/*.js', ['js']);
	gulp.watch( options.src + '/scss/**/*.scss', ['scss']);
	gulp.watch( options.src + '/images/*.svg', ['svg']);
	skins.map(function(name){
		gulp.watch( options.src + '/skins/'+name+'/scss/*.scss', [name + '-scss']);
	});
});

// Production

gulp.task('dist_clear', function() {
	del( options.dist + '/assets' );
	del( options.dist + '/classes' );
	del( options.dist + '/config' );
	del( options.dist + '/languages' );
	del( options.dist + '/skins' );
	del( options.dist + '/templates' );
	del( options.dist + '/vendor' );
});

gulp.task('composer', function() {
	composer({
        "working-dir": "./dist/",
        bin: "composer"
    });
});

gulp.task('dist_copy', ['dist_clear', 'default', ], function() {
	return gulp.src( [
			'assets/**/*.{css,js,jpg,svg}', 
			'classes/*', 
			'config/*', 
			'languages/*', 
			'skins/**/*.{css,js,jpg,svg,png,php,html}', 
			'templates/**/*',
			'composer.json', 
			'readme.txt', 
			'wp-photo-gallery.php'
		], {base: './'}
	)
	.pipe(gulp.dest( options.dist ));
});

gulp.task('dist', ['dist_copy', 'composer']);
