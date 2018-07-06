var gulp = require('gulp');
var sass = require('gulp-sass');
var cleanCSS = require('gulp-clean-css');
var concat = require('gulp-concat');
var uglify = require('gulp-uglify');

var jsFiles = ['./node_modules/jquery/dist/jquery.js', './node_modules/dropzone/dist/dropzone.js', './js/**/*.js'];
var cssFiles = ['./node_modules/dropzone/dist/dropzone.css', './css/**/*.css',];

gulp.task('sass', function () {
    return gulp.src('./sass/**/*.scss')
        .pipe(sass({outputStyle: 'compressed'}).on('error', sass.logError))
        .pipe(cleanCSS())
        .pipe(gulp.dest('./css'));
});

gulp.task('styles', function () {
    return gulp.src(cssFiles)
        .pipe(concat('pantonify.min.css'))
        .pipe(cleanCSS())
        .pipe(gulp.dest('./dist/css'));
});

gulp.task('scripts', function () {
    return gulp.src(jsFiles)
        .pipe(concat('pantonify.min.js'))
        .pipe(uglify())
        .pipe(gulp.dest('./dist/js'));
});

gulp.task('default', function () {
    gulp.watch('./sass/**/*.scss', ['sass']);
    gulp.watch('./css/**/*.css', ['styles']);
    gulp.watch('./js/**/*.js', ['scripts']);
});