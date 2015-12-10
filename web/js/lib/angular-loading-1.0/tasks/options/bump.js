'use strict';

// Bump package version, create tag, commit, push
// https://github.com/vojtajina/grunt-bump
module.exports = {
  options: {
    files: ['bower.json', 'package.json'],
    updateConfigs: [],
    commit: true,
    commitMessage: 'Release v%VERSION%',
    commitFiles: ['bower.json', 'package.json'], // '-a' for all files
    createTag: true,
    tagName: 'v%VERSION%',
    tagMessage: 'Version %VERSION%',
    push: true,
    pushTo: 'origin',
    gitDescribeOptions: '--tags --always --abbrev=1 --dirty=-d' // options to use with '$ git describe'
  }
};