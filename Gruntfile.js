module.exports = function(grunt) {

    // Project configuration.
    grunt.initConfig({
        pkg: grunt.file.readJSON('package.json'),
        appFolder: '<%= pkg.name %>-source',
        distFolder: '<%= pkg.name %>',

        copy: {
            build: {
                cwd: '<%= appFolder %>',
                src: [ '**', '!**/images/**/*', '!**/sass/**/*'],
                dest: '<%= distFolder %>',
                expand: true
            }
        },

        clean: {
            build: {
                nonull: false,
                src: ['<%= distFolder %>']
            },

            stylesheets: {
                nonull: false,
                src: ['<%= distFolder %>/*.css']
            },

            scripts: {
                nonull: false,
                src: ['<%= distFolder %>/js']
            },

            images: {
                nonull: false,
                src: ['<%= distFolder %>/images']
            },

            postbuild: {
                nonull: false,
                src: ['<%= distFolder %>/js/assets/', '<%= distFolder %>/js/vendor/', '<%= distFolder %>/sass']
            }
        },

        concat: {
            options: {
                // define a string to put between each file in the concatenated output
                separator: ';'
            },

            dist: {
                // the files to concatenate
                src: ['<%= distFolder %>/js/vendor/**/*.js', '<%= distFolder %>/js/assets/**/*.js', '<%= distFolder %>/js/main.js'],
                // the location of the resulting JS file
                dest: '<%= distFolder %>/js/<%= pkg.name %>.<%= pkg.version %>.js'
            }
        },

        jshint: {
            files: ['<%= distFolder %>/js/*.js'],
            options: {
                maxerr: 10,
                unused: true,
                eqnull: true,
                eqeqeq: true,
                jquery: true
            }
        },

        uglify: {
            my_target: {
                options: {
                    mangle: false
                },

                files: {
                    '<%= distFolder %>/js/<%= pkg.name %>.<%= pkg.version %>.js': ['<%= distFolder %>/js/<%= pkg.name %>.<%= pkg.version %>.js']
                }
            }
        },

        imagemin: {
            dist: {
                options: {
                    optimizationLevel: 7
                },
                files: [{
                    expand: true,
                    cwd: '<%= appFolder %>/images',
                    src: '**/*.{png,jpg,jpeg}',
                    dest: '<%= distFolder %>/images'
                }]
            }
        },

        sass: {
            dev: {
                options: {
                    style: 'expanded'
                },
                files: [{
                    expand: true,
                    cwd: '<%= appFolder %>/sass',
                    src: ['**/*.scss'],
                    dest: '<%= distFolder %>',
                    ext: '.css'
                }]
            },
            dist: {
                options: {
                    style: 'compressed'
                },
                files: [{
                    expand: true,
                    cwd: '<%= appFolder %>/sass',
                    src: ['**/*.scss'],
                    dest: '<%= distFolder %>',
                    ext: '.css'
                }]
            }
        },

        scsslint: {
            allFiles: [
                '<%= appFolder %>/sass/partials/**/*.scss',
            ],
            options: {
                bundleExec: false,
                colorizeOutput: true,
                config: '.scss-lint.yml',
                reporterOutput: null
            }
        },

        autoprefixer: {
            options: {
                browsers: ['last 8 versions']
            },
            build: {
                expand: true,
                flatten: true,
                src: '<%= distFolder %>/*.css', // -> src/css/file1.css, src/css/file2.css
                dest: '<%= distFolder %>' // -> dest/css/file1.css, dest/css/file2.css
            }
        },

        csslint: {
            strict: {
                options: {
                    "unique-headings": false,
                    "font-sizes": false,
                    "box-sizing": false,
                    "floats": false,
                    "duplicate-background-images": false,
                    "font-faces": false,
                    "star-property-hack": false,
                    "qualified-headings": false,
                    "ids": false,
                    "text-indent": false,
                    "box-model": false,
                    "adjoining-classes": false,
                    "compatible-vendor-prefixes": false,
                    "important": false,
                    "unqualified-attributes": false,
                    "fallback-colors": false
                },
                src: ['<%= distFolder %>/*.css']
            }
        },

        watch: {
            images: {
                files: ['<%= appFolder %>/images/**/*.{png,jpg,jpeg}'],
                tasks: [ 'imagemin' ],
            },
            sass: {
                // We watch and compile sass files as normal but don't live reload here
                files: ['<%= appFolder %>/sass/**/*.scss'],
                tasks: [ 'sass:dev', 'scsslint', 'csslint' ],
            },
            scripts: {
                // We watch and compile sass files as normal but don't live reload here
                files: ['<%= appFolder %>/js/**/*.js'],
                tasks: [ 'concat', 'jshint' ],
            },
            copy: {
                files: [ '<%= appFolder %>/**', '!<%= appFolder %>/**/*.scss', '!<%= appFolder %>/**/*.{png,jpg,jpeg}' ],
                tasks: [ 'copy' ]
            },
            livereload: {
                // These files are sent to the live reload server after sass compiles to them
                options: { livereload: true },
                files: ['<%= distFolder %>/**/*'],
            },
        }

    });

    // Load the plugin that provides the "uglify" task.
    grunt.loadNpmTasks('grunt-contrib-sass');
    grunt.loadNpmTasks('grunt-contrib-concat');
    grunt.loadNpmTasks('grunt-contrib-uglify');
    grunt.loadNpmTasks('grunt-contrib-imagemin');
    grunt.loadNpmTasks('grunt-contrib-watch');
    grunt.loadNpmTasks('grunt-contrib-clean');
    grunt.loadNpmTasks('grunt-contrib-csslint');
    grunt.loadNpmTasks('grunt-contrib-jshint');
    grunt.loadNpmTasks('grunt-contrib-copy');
    grunt.loadNpmTasks('grunt-rev');
    grunt.loadNpmTasks('grunt-usemin');
    grunt.loadNpmTasks('grunt-autoprefixer');
    grunt.loadNpmTasks('grunt-scss-lint');
    grunt.loadNpmTasks('grunt-browser-sync');

    // Default task(s).
    grunt.registerTask('default', [
        'clean:build',
        'copy',
        'imagemin',
        'concat',
        'sass:dev',
        'autoprefixer',
        'scsslint',
        'csslint',
        'jshint',
        'clean:postbuild',
        'watch'
    ]);
    grunt.registerTask('build', [
        'clean:build',
        'copy',
        'imagemin',
        'concat',
        'uglify',
        'sass:dist',
        'autoprefixer',
        'scsslint',
        'csslint',
        'jshint',
        'clean:postbuild'
    ]);
};