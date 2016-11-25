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
	cssnano = require('gulp-cssnano'),
	del = require('del');

var options = {
	dist: 'dist',
	assets: 'assets',
	themes: 'themes',
	dist: 'dist',
	src: 'src'
}

gulp.task('concat_js', function() {
	return gulp.src( options.src + '/js/*.js')
		.pipe(maps.init())
		.pipe(concat('wp-photo-gallery.js'))
		.pipe(maps.write('./'))
		.pipe(gulp.dest( options.assets + '/js'));
});

gulp.task('js', ['concat_js'], function() {
	return gulp.src( options.assets + '/js/wp-photo-gallery.js')
		.pipe(uglify())
		.pipe(rename('wp-photo-gallery.min.js'))
		.pipe(gulp.dest( options.assets + '/js'));
});

gulp.task('concat_scss', function() {
	return gulp.src( options.src + '/scss/wp-photo-gallery.scss')
		.pipe(maps.init())
		.pipe(sass('wp-photo-gallery.css'))
		.pipe(maps.write('./'))
		.pipe(gulp.dest( options.assets + '/css'));
});

gulp.task('scss', ['concat_scss'], function() {
	return gulp.src( options.assets + '/css/wp-photo-gallery.css' )
		.pipe(cssnano())
		.pipe(rename('wp-photo-gallery.min.css'))
		.pipe(gulp.dest( options.assets + '/css' ));
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

gulp.task('themes', themes.map(function(name){ return name+'-theme'; }));

gulp.task('default', ['scss', 'js', 'svg', 'themes']);

gulp.task('watch', function() {
	gulp.watch( options.src + '/js/*.js', ['js']);
	gulp.watch( options.src + '/scss/*.scss', ['scss']);
	gulp.watch( options.src + '/images/*.svg', ['svg']);
	themes.map(function(name){
		gulp.watch( options.src + '/themes/'+name+'/scss/*.scss', [name + '-scss']);
	});
});

// Production

gulp.task('dist_clear', function() {
	del( options.dist + '/classes' );
	del( options.dist + '/smarty-plugins' );
	del( options.dist + '/templates' );
	del( options.dist + '/vendor' );
	del( options.dist + '/assets' );
});

gulp.task('dist_copy', ['dist_clear', 'default'], function() {
	return gulp.src( [
			'classes/**/*', 
			'smarty-plugins/**/*', 
			'vendor/**/*', 
			'composer.json', 
			'readme.txt', 
			'wp-photo-gallery.php', 
			'assets/**/*.{css,js,jpg,svg}', 
			'themes/**/*.{css,js,jpg,svg,png,php,html}', 
			'templates/**/*'
		], {base: './'}
	)
	.pipe(gulp.dest( options.dist ));
});

gulp.task('dist', ['dist_copy']);
