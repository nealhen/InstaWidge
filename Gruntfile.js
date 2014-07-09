module.exports = function(grunt) {

  // Project configuration.
  var fileList = [ "production/jquery.jcarousel.min.js", "production/InstaWidge.js" ];//will be generated
  grunt.initConfig({
    pkg: grunt.file.readJSON('package.json'),
    uglify: {
      options: {
        banner: '/*! <%= pkg.name %> <%= grunt.template.today("yyyy-mm-dd") %> */\n'
      },
      build: {
        src: fileList,
          //'src/<%= pkg.name %>.js',
          //'src/more.js',
        
        dest: 'js/<%= pkg.name %>.min.js'
      }
    }
  });

  // Load the plugin that provides the "uglify" task.
  grunt.loadNpmTasks('grunt-contrib-uglify');

  // Default task(s).
  grunt.registerTask('default', ['uglify']);

};