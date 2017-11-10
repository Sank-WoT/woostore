var gulp = require('gulp');
var stylus = require('gulp-stylus');
var concatCss = require('gulp-concat-css');
var autoprefixer = require('gulp-autoprefixer');
var rename = require('gulp-rename');
var plumber = require('gulp-plumber');
var notify = require('gulp-notify');
var gcmq = require('gulp-group-css-media-queries');
var mainBowerFiles = require('main-bower-files');
var uglify = require('gulp-uglify');
var concat = require('gulp-concat');
var cleanCSS = require('gulp-clean-css');
var spritesmith = require('gulp.spritesmith');
var rigger = require('gulp-rigger');
var imagemin = require('gulp-imagemin');
var pngquant = require('imagemin-pngquant');
var watch = require('gulp-watch');
var prettify = require('gulp-html-prettify');
var base64 = require('gulp-base64-inline');


var path = {
    src: {
        html: 'src/*.html',
        js: 'src/js/main.js',
        style: 'src/stylus/main.styl',
        img: 'src/images/imagemin/**/*.*',
        sprite: 'src/images/sprite/**/*.*',
        fonts: 'src/fonts/**/*.*'
    },
    dist: {
        html: 'dist/',
        js: 'js/',
        style: 'css/',
        img: 'images/',
        fonts: 'fonts/'
    },
    watch: {
        html: 'src/**/*.html',
        js: 'src/js/**/*.js',
        style: 'src/stylus/**/*.styl',
        img: 'src/images/imagemin/**/*.*',
        sprite: 'src/images/sprite/**/*.*',
        fonts: 'src/fonts/**/*.*'
    }
};

var onError = function errorsNotify(err) {
    notify.onError({
        title:    "Gulp",
        subtitle: "Failure!",
        message:  "Error: <%= error.message %>",
        sound:    "Beep"
    })(err);

    this.emit('end');
}

gulp.task('html', function () {
    gulp.src(path.src.html)
        .pipe(prettify({indent_char: ' ', indent_size: 4}))
        .pipe(rigger())
        .pipe(gulp.dest(path.dist.html))
        // .pipe(notify({ message: 'html task completed!'}));`
});

gulp.task('css', function () {
  return gulp.src(path.src.style)
    .pipe(plumber({errorHandler: onError}))
    .pipe(stylus({
      compress: true
    }))
    .pipe(base64('../images/base64'))
    .pipe(gcmq())
    .pipe(autoprefixer({
        browsers: ['last 3 versions'],
        cascade: false
    }))
    .pipe(cleanCSS())
    .pipe(concat('main.min.css'))
    .pipe(gulp.dest(path.dist.style))
    .pipe(notify({ message: 'css task completed!'}));
});

gulp.task('css:vendors', function() {
    return gulp.src(mainBowerFiles('**/*.css', {
        "overrides": {
            "normalize-css": {
                "main": [
                    "./normalize.css"
                ]
            },
            "magnific-popup": {
                "main": [
                    "./dist/magnific-popup.css"
                ]
            },
            "owlcarousel": {
                "main": [
                    "./owl-carousel/owl.carousel.css"
                ]
            }
        }
    }))
    .pipe(plumber({errorHandler: onError}))
    .pipe(concat('vendors.min.css'))
    .pipe(cleanCSS())
    .pipe(gulp.dest(path.dist.style))
    .pipe(notify({ message: 'css:vendors task completed!'}));
});

gulp.task('js', function() {
    gulp.src(path.src.js)
    // .pipe(uglify())
    .pipe(concat('main.min.js'))
    .pipe(gulp.dest(path.dist.js))
    .pipe(notify({ message: 'js task completed!'}));
});

gulp.task('js:vendors', function() {
    return gulp.src(mainBowerFiles('**/*.js', {
        "overrides": {
            "owlcarousel": {
                "main": [
                    "./owl-carousel/owl.carousel.min.js"
                ]
            },
            "magnific-popup": {
                "main": [
                    "./dist/jquery.magnific-popup.min.js"
                ]
            },
            "select2": {
                "main": [
                    "./dist/js/i18n/ru.js"
                ]
            }
        }

    }))
    .pipe(plumber({errorHandler: onError}))
    .pipe(concat('vendors.min.js'))
    // .pipe(uglify())
    .pipe(gulp.dest(path.dist.js))
    .pipe(notify({ message: 'js:vendors task completed!'}));
});

gulp.task('image', function () {
    gulp.src(path.src.img)
        .pipe(imagemin({
            progressive: true,
            svgoPlugins: [{removeViewBox: false}],
            use: [pngquant()],
            interlaced: true
        }))
        .pipe(gulp.dest(path.dist.img))
        // .pipe(notify({ message: 'image task completed!'}));
});

gulp.task('sprite', function() {
    var spriteData = gulp.src(path.src.sprite)
        .pipe(plumber({errorHandler: onError}))
        .pipe(spritesmith({
            imgName: 'sprite.png',
            cssName: 'sprite.styl',
            cssFormat: 'stylus',
            algorithm: 'binary-tree',
            cssTemplate: './src/stylus/helpers/stylus.template.mustache',
            padding:3,
            cssVarMap: function(sprite) {
                sprite.name = 's-' + sprite.name;
            }
        }))
    spriteData.img.pipe(gulp.dest(path.dist.img))
    spriteData.css.pipe(gulp.dest('./src/stylus/helpers'))
    .pipe(notify({ message: 'sprite task completed!'}));
});

gulp.task('fonts', function() {
    gulp.src(path.src.fonts)
        .pipe(gulp.dest(path.dist.fonts))
});

gulp.task('assets:slider', function() {
    gulp.src(['./src/libs/owlcarousel/owl-carousel/*.{png,gif}'])
        .pipe(gulp.dest('./css'))
});

gulp.task('watch', function(){
    // watch([path.watch.html], function(event, cb) {
    //     gulp.start('html');
    // });
    watch([path.watch.style], function(event, cb) {
        gulp.start('css');
    });
    watch([path.watch.js], function(event, cb) {
        gulp.start('js');
    });
    watch([path.watch.img], function(event, cb) {
        gulp.start('image');
    });
    watch([path.watch.sprite], function(event, cb) {
        gulp.start('sprite');
    });
    watch([path.watch.fonts], function(event, cb) {
        gulp.start('fonts');
    });
});

gulp.task('build', [
    //'html',
    'js',
    'js:vendors',
    'css',
    'css:vendors',
    'image',
    'sprite',
    'fonts',
    'assets:slider'
]);


gulp.task('default', ['build']);
gulp.task('dev', ['build', 'watch']);
gulp.task('watcher', ['css', 'css:vendors', 'js', 'js:vendors', 'watch']);
