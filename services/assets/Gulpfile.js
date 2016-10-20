
const path = require('path');
const gulp = require('gulp');
const sass = require('gulp-sass');

const sourceFolder = path.join(__dirname, 'src');
const stylesSource = path.join(sourceFolder, '*.scss');
const buildTarget = process.env.BUILD_TARGET || path.join(__dirname, 'build');

console.log("***********************");
console.log("ASSETS BUILD TO:", buildTarget);
console.log("***********************");

gulp.task('styles', function(){
	return gulp.src(stylesSource)
        .pipe(sass({includePaths: ['./node_modules']}).on('error', sass.logError))
		.pipe(gulp.dest(buildTarget));
});

// build
gulp.task('default', ['styles']);

// watch
gulp.task('default:watch', function(){
	gulp.watch(stylesSource, ['styles']);
});
