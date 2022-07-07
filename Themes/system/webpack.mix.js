const path = require('path')
const mix  = require('laravel-mix')

const proxy   = 'callkruger.sys'
const folders = {
    src:   'src',
    dist:  'assets/modules',
    views: {
        theme:   'views',
        modules: '../../Modules/**/Resources/views'
    }
}

/*
 |--------------------------------------------------------------------------
 | Mix Asset Management
 |--------------------------------------------------------------------------
 |
 | Mix provides a clean, fluent API for defining some Webpack build steps
 | for your Laravel applications. By default, we are compiling the CSS
 | file for the application as well as bundling up all the JS files.
 |
 */

mix.alias({
    '@': path.join(__dirname, `${ folders.src }/js`),
    '~': path.join(__dirname, `${ folders.src }/scss`)
})

mix.sass(`${ folders.src }/scss/modules.scss`, `${ folders.dist }/css`)
   .options({ processCssUrls: false })

mix.js(`${ folders.src }/js/modules.js`, `${ folders.dist }/js`)

if (process.argv.some(arg => arg === 'sync')) {
    mix.browserSync({
        proxy: `${ proxy }`,
        files: [
            `${ folders.dist }/css/*.css`,
            `${ folders.dist }/js/*.js`,
            `${ folders.views.theme }/**`,
            `${ folders.views.modules }/**`
        ]
    })
}
mix.disableNotifications()




/*mix.js('resources/js/app.js', 'public/js')
   .postCss('resources/css/app.css', 'public/css', [
       //
   ])*/
