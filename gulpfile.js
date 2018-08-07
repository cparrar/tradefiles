/**
 * Agregamos en un objeto los
 * procesos requeridos
 *
 * @type {{env: boolean, environment: string, gulp: Gulp, uglyfly: minify, concat: *, pump: pump}}
 */
var gulpfile = {

    /**
     * Importar las librerias
     */
    gulp: require('gulp'),
    uglyfly: require('gulp-uglyfly'),
    concat: require('gulp-concat'),
    pump: require('pump'),
    util: require('gulp-util'),
    obfuscator: require('gulp-javascript-obfuscator'),

    /**
     * Generamos las varaibles correspondientes
     * para los procesos
     */
    params : {
        loginJs : {
            name : 'js_login',
            tracking : [
                'public/assets/vendor_components/jquery/dist/jquery.min.js',
                'public/assets/vendor_components/popper/dist/popper.min.js',
                'public/vendor/vue/dist/vue.js',
                'public/vendor/axios/dist/axios.js',
                'src/Resources/assets/login/app.js',
                'public/assets/vendor_components/bootstrap/dist/js/bootstrap.min.js'
            ],
            task: {
                tracking: 'src/Resources/assets/login/app.js',
                output : 'login.app.min.js',
                destination : 'public/js'
            }
        },
        appJs : {
            name : 'js_app',
            tracking : 'src/Resources/assets/js/**/*.js',
            task : {
                output : 'app.min.js',
                destination: 'public/js'
            }
        }
    },

    /**
     * Valida si se ha generado
     * paso del environment
     *
     * @example gulp --env=dev
     * @returns {*}
     */
    minifyIfNeeded: function() {
        return this.util.env.env === 'dev' ? this.util.noop() : this.uglyfly();
    },

    /**
     * Valida si se ha generado
     * paso del environment y
     * ofusca la informacion
     * correspondiente
     *
     * @example gulp --env=dev
     * @returns {*}
     */
    obfuscateIfNeeded: function() {
        return this.util.env.env === 'dev' ? this.util.noop() : this.obfuscator();
    },

    /**
     * Se obtiene el environment
     *
     * @returns {string}
     */
    getEnvironment : function() {
        return this.util.env.env == 'dev' ? 'Development' : 'Production';
    }
};

/**
 * Muestra el environment
 */
gulpfile.util.log('Environment: ' + gulpfile.getEnvironment());

/**
 * Genera el proceso de concatenar los archivos
 * y generar el proceso con minify en un solo
 * archivo
 */
gulpfile.gulp.task(gulpfile.params.loginJs.name, function(cb) {
    gulpfile.pump([
        gulpfile.gulp.src(gulpfile.params.loginJs.tracking),
        gulpfile.concat(gulpfile.params.loginJs.task.output),
        gulpfile.minifyIfNeeded(),
        gulpfile.gulp.dest(gulpfile.params.loginJs.task.destination)
    ], cb);
});

/**
 * Genera el proceso de concatenar los archivos
 * y generar el proceso con minify en un solo
 * archivo
 */
gulpfile.gulp.task(gulpfile.params.appJs.name, function(cb) {
    gulpfile.pump([
        gulpfile.gulp.src(gulpfile.params.appJs.tracking),
        gulpfile.concat(gulpfile.params.appJs.task.output),
        gulpfile.minifyIfNeeded(),
        gulpfile.gulp.dest(gulpfile.params.appJs.task.destination)
    ], cb);
});

/**
 * Watch de archivos en linea
 */
gulpfile.gulp.task('watch', [gulpfile.params.loginJs.name, gulpfile.params.appJs.name], function() {
    gulpfile.gulp.watch(gulpfile.params.loginJs.task.tracking, [gulpfile.params.loginJs.name]);
    gulpfile.gulp.watch(gulpfile.params.appJs.tracking, [gulpfile.params.appJs.name]);
});

/**
 * Tarea por default
 */
gulpfile.gulp.task('default', [gulpfile.params.loginJs.name, gulpfile.params.appJs.name]);