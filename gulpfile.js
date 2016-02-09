/**
 * Nails Asset Gulpfile
 * Build tool for JS and CSS
 *
 * @todo Only process changed files
 */

// --------------------------------------------------------------------------

//  Configs
var watchCss           = 'assets/less/*.less';
var watchJs            = ['assets/js/*.js', '!assets/js/*.min.js', '!assets/js/*.min.js.map'];
var autoPrefixBrowsers = ['last 2 versions', 'ie 8', 'ie 9'];
var autoPrefixCascade  = false;
var minifiedSuffix     = '.min';
var sourcemapDest      = './';
var sourcemapOptions   = {includeContent: false};
var jsDest             = './assets/js/';
var cssDest            = './assets/css/';

//  Notification vars
var cssSuccessTitle  = 'Successfully compiled CSS';
var cssSuccessBody   = '.less files were successfully compiled into CSS';
var cssSuccessSound  = false;
var cssSuccessIcon   = false;
var cssSuccessOnLast = true;

var jsSuccessTitle  = 'Successfully compiled JS';
var jsSuccessBody   = '.js files were successfully minified and sourcemaps created';
var jsSuccessSound  = false;
var jsSuccessIcon   = false;
var jsSuccessOnLast = true;

// --------------------------------------------------------------------------

//  Common
var gulp      = require('gulp');
var watch     = require('gulp-watch');
var watchLess = require('gulp-less-watcher');
var plumber   = require('gulp-plumber');
var notify    = require('gulp-notify');
var path      = require('path');
var gutil     = require('gulp-util');

//  CSS
var less         = require('gulp-less');
var autoprefixer = require('gulp-autoprefixer');
var minifyCss    = require('gulp-minify-css');

//  JS
var sourcemaps = require('gulp-sourcemaps');
var uglify     = require('gulp-uglify');
var rename     = require('gulp-rename');
var jshint     = require('gulp-jshint');
var stylish    = require('jshint-stylish');

// --------------------------------------------------------------------------

var onError = function(err) {
    notify
        .onError({
            title: 'Check your Terminal',
            message: '<%= error.message %>',
            sound: 'Funk',
            icon: false,
            onLast: true
        })(err);
}

// --------------------------------------------------------------------------

/**
 * Watch for changes in LESS files and process on change
 */
gulp.task('watch:css', function() {
    gulp.watch('assets/less/**/*.less', ['css']);
});

// --------------------------------------------------------------------------

/**
 * Watch for changes in JS files and process on change
 */
gulp.task('watch:js', function() {
    gulp.watch(watchJs, ['js']);
});

// --------------------------------------------------------------------------

/**
 * Build CSS
 */
gulp.task('css', function() {

    //  CSS
    return gulp.src(watchCss)
        .pipe(plumber({
            errorHandler: onError
        }))
        .pipe(less())
        .pipe(autoprefixer({
            browsers: autoPrefixBrowsers,
            cascade: autoPrefixCascade
        }))
        .pipe(minifyCss())
        .pipe(gulp.dest(cssDest))
        .pipe(notify({
            title: cssSuccessTitle,
            message: cssSuccessBody,
            sound: cssSuccessSound,
            icon: cssSuccessIcon,
            onLast: cssSuccessOnLast
        }));
});

// --------------------------------------------------------------------------

/**
 * Build both CSS and JS
 */
gulp.task('js', function() {

    //  JS
    return gulp.src(watchJs)
        .pipe(plumber({
            errorHandler: onError
        }))
        .pipe(sourcemaps.init())
        .pipe(jshint('.jshintrc'))
        .pipe(jshint.reporter('jshint-stylish'))
        .pipe(uglify())
        .pipe(rename({
            suffix: minifiedSuffix
        }))
        .pipe(sourcemaps.write(sourcemapDest, sourcemapOptions))
        .pipe(gulp.dest(jsDest))
        .pipe(notify({
            title: jsSuccessTitle,
            message: jsSuccessBody,
            sound: jsSuccessSound,
            icon: jsSuccessIcon,
            onLast: jsSuccessOnLast
        }));
});


// --------------------------------------------------------------------------

gulp.task('build', ['css', 'js']);
gulp.task('watch', ['watch:css', 'watch:js']);
gulp.task('default', ['watch:css', 'watch:js']);
