var gulp = require('gulp'),
    sass = require('gulp-sass'),
    autoprefixer = require('gulp-autoprefixer'),
    rename = require('gulp-rename'),
    cleanCSS = require('gulp-clean-css'),
    sourcemaps = require('gulp-sourcemaps');

gulp.task('styles', function () {
    return gulp.src('web/assets/sass/styles.scss')
        .pipe(sass({
            errLogToConsole: true,
            includePaths: ['node_modules/bootstrap-sass/assets/stylesheets']
        }).on('error', sass.logError))
        .pipe(autoprefixer('last 2 version'))
        .pipe(rename('main.css'))
        .pipe(cleanCSS())
        .pipe(sourcemaps.write())
        .pipe(gulp.dest('web/assets/css/')) ;
});

gulp.task('default',function() {
    gulp.watch('web/assets/sass/*.scss', ['styles']);
});
