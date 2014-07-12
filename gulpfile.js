/*
 See dev dependencies https://gist.github.com/isimmons/8927890
 Compiles less to compressed css with autoprefixing
 Compiles coffee to javascript
 Livereloads on changes to coffee, less, and blade templates
 Runs PHPUnit tests
 Watches less, coffee, blade, and phpunit
 Default tasks less, coffee, phpunit, watch
 */

var gulp = require('gulp');
var gutil = require('gulp-util');
var notify = require('gulp-notify');
var less = require('gulp-less');
var concat = require('gulp-concat');
var uglify = require('gulp-uglify');
var autoprefix = require('gulp-autoprefixer');
var coffee = require('gulp-coffee');
var phpunit = require('gulp-phpunit');//notify requires >= v 0.0.3
var fs = require('fs'); //only used for icon file with growlNotifier
var imagemin = require('gulp-imagemin');

//CSS directories
var lessDir = 'app/assets/less';
var targetCSSDir = 'public/css';

//javascript directories
var coffeeDir = 'app/assets/coffee';
var targetJSDir = 'public/js';

var componentsDir = 'public/components';

// Tasks
/* less compile */
gulp.task('less', function() {
    return gulp.src(lessDir + '/main.less')
        .pipe(less({compress: true}).on('error', gutil.log))
        .pipe(autoprefix('last 10 versions'))
        .pipe(gulp.dest(targetCSSDir))
        .pipe(notify('CSS compiled, prefixed, and minified.'));
});

/* coffee compile */
gulp.task('js', function() {
    return gulp.src(coffeeDir + '/**/*.js')
        .pipe(concat('main.js'))
        //.pipe(uglify())
        .pipe(gulp.dest(targetJSDir))
        .pipe(notify('JS compiled, prefixed, and minified.'));
});

gulp.task('images', function () {
    gulp.src('images-orig/*.{png,gif,jpg}')
        .pipe(imagemin())
        .pipe(gulp.dest('images/'));
});

/* PHPUnit */
gulp.task('phpunit', function() {
    //notify defaults to false. If you don't want to use a notifier or worry with errors in this task leave it off
    var options = {debug: false, notify: true}
    gulp.src('app/tests/*.php')
        .pipe(phpunit('', options)) //empty phpunit path defaults ./vendor/bin/phpunit for windows specify with double back slashes

        //both notify and notify.onError will take optional notifier: growlNotifier for windows notifications
        //if options.notify is true be sure to handle the error here or suffer the consequenses!
        .on('error', notify.onError({
            title: 'PHPUnit Failed',
            message: 'One or more tests failed, see the cli for details.'
        }))

        //will fire only if no error is caught
        .pipe(notify({
            title: 'PHPUnit Passed',
            message: 'All tests passed!'
        }));
});

gulp.task('js-libs', function() {
    var libs = [
        componentsDir + '/jquery/dist/jquery.js',
        componentsDir + '/bootstrap/dist/js/bootstrap.js'
    ]
    return gulp.src(libs)
        .pipe(concat('libs.js'))
        .pipe(uglify())
        .pipe(gulp.dest(targetJSDir))
})

/* Watcher */
gulp.task('watch', function() {
    gulp.watch(lessDir + '/**/*.less', ['less']);
    gulp.watch(coffeeDir + '/**/*.js', ['js']);
    gulp.watch('images-orig/**', ['images']);
    gulp.watch('app/**/*.php', ['phpunit']);
});

/* Default Task */
gulp.task('default', ['less', 'js-libs' , 'js', 'phpunit', 'watch']);