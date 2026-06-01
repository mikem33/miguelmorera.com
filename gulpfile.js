const { Transform } = require('stream');
const noop = () => new Transform({ objectMode: true, transform(f, _, cb) { cb(null, f); } });

const
    // source and build folders
    theme           = 'content/themes/prometheus/',
    fs              = require('fs'),
    spawnSync       = require('child_process').spawnSync,
    gulp            = require('gulp'),
    nib             = require('nib'),
    newer           = require('gulp-newer'),
    babel           = require('gulp-babel'),
    stylus          = require('gulp-stylus'),
    notify          = require('gulp-notify'),
    concat          = require('gulp-concat'),
    uglify          = require('gulp-uglify'),
    rename          = require('gulp-rename'),
    svgSprites      = require('gulp-svg-sprite'),
    sourcemaps      = require('gulp-sourcemaps'),
    realFavicon     = require('gulp-real-favicon'),
    checktextdomain = require('gulp-checktextdomain');

// Files settings
const files = {
    source      : 'source/**/*.php',
    dist        : 'dist/'
};

var build = theme;
var isProduction = false;
const hasNotifySend = spawnSync('which', ['notify-send'], { stdio: 'ignore' }).status === 0;

const acfFields = 'source/includes/acf-json/*.json';
const screenshot = 'source/screenshot.png';
const languageFiles = 'source/languages/*.*';
const wpLanguageFiles = 'content/languages/*.*';
const fonts = 'source/assets/fonts/*.*';
const readme = 'README.md';
const favicons = 'source/assets/images/favicons/*.*';
const htaccess = '.htaccess';

// copy PHP files.
gulp.task('php', function() {
    return gulp.src(files.source)
        .pipe(newer(build))
        .pipe(gulp.dest(build));
});

gulp.task('php-release', function() {
    return gulp.src(files.source)
        .pipe(gulp.dest(build));
});

// copy Assets not included in the other tasks.
gulp.task('copy-assets', gulp.parallel(
    function copyFontsAssets() {
        return gulp.src(fonts, { encoding: false, allowEmpty: true })
            .pipe(newer(build + 'assets/fonts'))
            .pipe(gulp.dest(build + 'assets/fonts'));
    },
    function copyLanguageFiles() {
        return gulp.src(languageFiles, { allowEmpty: true })
            .pipe(gulp.dest(build + 'languages'));
    },
    function copyScreenshot() {
        return gulp.src(screenshot, { allowEmpty: true })
            .pipe(newer(build))
            .pipe(gulp.dest(build));
    },
    function copyFavicons() {
        return gulp.src(favicons, { encoding: false, allowEmpty: true })
            .pipe(newer(build + 'assets/images/favicons'))
            .pipe(gulp.dest(build + 'assets/images/favicons'));
    }
));

gulp.task('copy-config-files', gulp.parallel(
    function copyReadme() {
        return gulp.src(readme, { allowEmpty: true })
            .pipe(newer(files.dist))
            .pipe(gulp.dest(files.dist));
    },
    function copyHtaccess() {
        return gulp.src(htaccess, { allowEmpty: true })
            .pipe(gulp.dest(files.dist));
    },
    function copyWpLanguages(done) {
        if (fs.existsSync('content/languages')) {
            return gulp.src(wpLanguageFiles, { allowEmpty: true })
                .pipe(gulp.dest(files.dist + 'content/languages'));
        }
        done();
    }
));

gulp.task('acf-json', function() {
    return gulp.src(acfFields, { allowEmpty: true })
        .pipe(newer(build + 'includes/acf-json'))
        .pipe(gulp.dest(build + 'includes/acf-json'));
});

gulp.task('styles', function(){
    var s = gulp.src('source/assets/css/styl/style.styl');
    if (!isProduction) s = s.pipe(sourcemaps.init());
    s = s.pipe(stylus({
            compress: true, 
            use: nib(),
            'include css': true,
            paths: ['source/assets/css/styl']
        }))
        .on('error', swallowError);
    if (!isProduction) s = s.pipe(sourcemaps.write('.'));
    return s.pipe(hasNotifySend ? notify('Compiled!') : noop())
        .pipe(gulp.dest(build));
});

// Generate Javascript
gulp.task('js-compiled', function(){
    return gulp.src([
            'source/assets/javascript/compile/*.js'
        ], { allowEmpty: true })
        .pipe(concat('javascript.min.js'))
        .pipe(gulp.dest(build + 'assets/javascript'))
        .pipe(babel({
            presets: ['@babel/preset-env']
        }))
        .pipe(uglify())
        .on('error', swallowError)
        .pipe(gulp.dest(build + 'assets/javascript'));
});

gulp.task('js-templates', function(){
    return gulp.src('source/assets/javascript/source/*.js', { allowEmpty: true })
        .pipe(uglify())
        .pipe(rename({ suffix: '.min' }))
        .on('error', swallowError)
        .pipe(gulp.dest(build + 'assets/javascript'));
});

gulp.task('copy-images', function() {
    return gulp.src([
            'source/assets/images/**/*',
            '!source/assets/images/_*/',
            '!source/assets/images/_*/**/*'
        ], { allowEmpty: true })
        .pipe(newer(build + 'assets/images'))
        .pipe(gulp.dest(build + 'assets/images'));
});

gulp.task('copy-fonts', function() {
    return gulp.src(['source/assets/fonts/*'], { encoding: false, allowEmpty: true })
        .pipe(newer(build + 'assets/fonts'))
        .pipe(gulp.dest(build + 'assets/fonts'));
});

gulp.task('copy-muplugins', function() {
    return gulp.src('content/mu-plugins/*', { allowEmpty: true })
        .pipe(newer('dist/content/mu-plugins/'))
        .pipe(gulp.dest('dist/content/mu-plugins/'));
});

config = {
    svg: {
        xmlDeclaration: false,
        doctypeDeclaration: false
    },
    mode: {
        symbol: {
            dest: '.',
            sprite: 'sprites.svg'
        }
    }
};

gulp.task('svgsprites', function(done) {
    return gulp.src('source/assets/images/_svg-sprites/*.svg', { allowEmpty: true })
    .pipe(svgSprites(config))
    .pipe(gulp.dest(build + 'assets/images'));
});

function watchFiles(done) {
    // usePolling is required when running in WSL watching /mnt/c/ files edited from Windows
    const watchOpts = { usePolling: true, interval: 500 };
    console.log('Watching source files for changes...');
    gulp.watch('source/assets/css/styl/**/*.styl', watchOpts, gulp.series('styles'));
    gulp.watch('source/assets/javascript/source/*.js', watchOpts, gulp.series('js-templates'));
    gulp.watch('source/assets/javascript/compile/*.js', watchOpts, gulp.series('js-compiled'));
    gulp.watch('source/assets/images/*.*', watchOpts, gulp.series('copy-images'));
    gulp.watch('source/assets/fonts/*.*', watchOpts, gulp.series('copy-fonts'));
    gulp.watch('source/**/*.php', watchOpts, gulp.series('php'));
    gulp.watch(acfFields, watchOpts, gulp.series('acf-json'));
    done();
}

gulp.task('watch', watchFiles);


// Check textdomains in the theme.
gulp.task('checktextdomain', function() {
    var textdomain = 'prometheus';
    return gulp.src([
        'source/*.php',
        'source/**/*.php',
        'source/**/**/*.php'
    ])
    .pipe(checktextdomain({
        text_domain: textdomain, // Specify allowed domain
        keywords: [ // List keyword specifications
            '__:1,2d',
            '_e:1,2d',
            '_x:1,2c,3d',
            'esc_html__:1,2d',
            'esc_html_e:1,2d',
            'esc_html_x:1,2c,3d',
            'esc_attr__:1,2d',
            'esc_attr_e:1,2d',
            'esc_attr_x:1,2c,3d',
            '_ex:1,2c,3d',
            '_n:1,2,4d',
            '_nx:1,2,4c,5d',
            '_n_noop:1,2,3d',
            '_nx_noop:1,2,3c,4d'
        ],
        force: true,
        correct_domain: true
    }));
});

gulp.task('env-prod', function(done) {
    build = files.dist + build;
    isProduction = true;
    done();
});

gulp.task('init', gulp.parallel(
    'styles',
    'js-templates',
    'js-compiled',
    'copy-images',
    'copy-assets',
    'copy-config-files',
    'php',
    'acf-json'
));

gulp.task('release', gulp.series('env-prod', 
    gulp.parallel(
        'styles',
        'js-templates',
        'js-compiled',
        'copy-images',
        'copy-assets',
        'copy-config-files',
        'svgsprites',
        'php-release',
        'acf-json',
        'copy-muplugins'
    ), 
    function release(done) { done();}
));

// Show errors on console.
function swallowError (error) {
    console.log(error.toString())
    this.emit('end')
}