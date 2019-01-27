var gulp = require('gulp');
var $ = require('gulp-load-plugins')()//引入的是函数，调用以后返回的是对象
var del = require('del')
var cssmin = require('gulp-minify-css')
//注册合并压缩js的任务
gulp.task('js', function () {
    //你的任务执行 具体过程
    return gulp.src('public/static/assets/**/*.main.js')//找目标原文件 将原文件的数据读取到gulp的内存中
        .pipe($.uglify())//压缩js文件
        .pipe($.rev())
        .pipe($.rename({suffix: '_'}))
        .pipe(gulp.dest('public/static/assets/'))//输出
        .pipe($.rev.manifest('public/static/assets/rev-manifest.json',{
            base: 'public/static/assets',
            merge: true
        }))
        .pipe(gulp.dest('public/static/assets/'))//输出
});


//注册合并压缩css的任务
gulp.task('css',function () {
    return gulp.src('public/static/assets/**/*.main.css')
        .pipe(cssmin())//
        .pipe($.rev())
        .pipe($.rename({suffix: '_'}))
        .pipe(gulp.dest('public/static/assets/'))
        .pipe($.rev.manifest('public/static/assets/rev-manifest.json',{
            base: 'public/static/assets',
            merge: true
        }))
        .pipe(gulp.dest('public/static/assets/'))

});

// 清除老文件
gulp.task('clean', function (cb) {
    del([
        'public/static/assets/**/*.main_.js',
        'public/static/assets/**/*.main_.css',
        'public/static/assets/rev-manifest.json'
        // 我们不希望删掉这个文件，所以我们取反这个匹配模式
        //   '!dist/mobile/deploy.json'
    ], cb);
});

// Default task 设置默认任务
gulp.task('default',function(){
    gulp.run('clean');
    setTimeout(function (){
        gulp.run('js','css')
    },300)
});