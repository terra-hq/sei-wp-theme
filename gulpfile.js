var gulp = require("gulp");
var sftp = require("gulp-sftp-up4");
var Client = require('ssh2-sftp-client');
var minimist = require('minimist');

// Import SFTP configurations
var { devSFTPConfig, stageSFTPConfig, prodSFTPConfig, filesToExclude } = require('./config/sftpConfig.js');

var args = minimist(process.argv.slice(2), {
  string: ['env', 'path', 'hash']
});

// Get SFTP config based on environment ( based on task argument  --env=dev/stage/production )
function getSFTPConfig(env) {
  switch(env) {
    case 'dev':
      return devSFTPConfig;
    case 'stage':
      return stageSFTPConfig;
    case 'production':
      return prodSFTPConfig;
    default:
      throw new Error("Unknown environment: " + env);
  }
}

// define environment
//! this is a must or args.env is undefined
if(args.dev){
  args.env = 'dev';
} else if (args.stage) {
  args.env = 'stage';
} else if (args.production) {
  args.env = 'production';
}

function dphp(done) {
  var env = args.env;
  console.log('Environment:', env);
  var sftpConfig = getSFTPConfig(env);

  return gulp
    .src(["**/*.php", ...filesToExclude], { base: "./" })
    .pipe(sftp(sftpConfig))
    .on('end', done)
    .on('error', done);
}

exports.dphp = dphp;

// Task to deploy all files in the dist folder
function ddist(done) {
  var env = args.env;
  console.log('Environment:', env);
  var sftpConfig = getSFTPConfig(env);
  return gulp
    .src(["dist/**/*", ...filesToExclude], { base: "./", encoding: false }) 
    .pipe(sftp({
      ...sftpConfig,
    }))
    .on('end', done);
}
exports.ddist = ddist;

// Task to deploy all files in the dist folder + functions/project/hash.php
function ddisthash(done) {
  var env = args.env;
  console.log('Environment:', env);
  var sftpConfig = getSFTPConfig(env);
  return gulp
    .src(["dist/**/*", "functions/project/hash.php"], { base: "./", encoding: false }) 
    .pipe(sftp({
      ...sftpConfig,
    }))
    .on('end', done);
}
exports.ddisthash = ddisthash;

// Task to deploy all flexible modules
function dfm(done) {
  const env = args.env;
  const sftpConfig = getSFTPConfig(env);

  return gulp
    .src(["flexible/**/*", ...filesToExclude], { base: "./", encoding: false }) 
    .pipe(sftp(sftpConfig))
    .on('error', function(err) {
      console.error('Error:', err);
      done(err);
    })
    .on('end', done);
}
exports.dfm = dfm;

// Task to deploy a single file or folder
function ds(done) {
  var env = args.env;
  console.log('Environment:', env);
  var sftpConfig = getSFTPConfig(env);
  var filePath = args.path;

  if (!filePath) {
    console.error("Error: No path specified. Use --path to specify the file or folder to upload.");
    done(new Error("No path specified"));
    return;
  }

  console.log('Deploying file or folder:', filePath);

  var isDirectory = false;

  try {
    isDirectory = require('fs').statSync(filePath).isDirectory();
  } catch (e) {
    isDirectory = false;
  }

  if (isDirectory) {
    return gulp
      .src([`${filePath}/**/*`, ...filesToExclude.map(pattern => `!${pattern}`)], { base: "./", allowEmpty: true, encoding: false })
      .pipe(sftp(sftpConfig))
      .on('end', done)
      .on('error', done);
  } else {
    return gulp
      .src([filePath, ...filesToExclude.map(pattern => `!${pattern}`)], { base: "./", allowEmpty: true, encoding: false })
      .pipe(sftp(sftpConfig))
      .on('end', done)
      .on('error', done);
  }
}

exports.ds = ds;


// Task to deploy PHP files
function dall(done) {
  var env = args.env;
  console.log('Environment:', env);
  var sftpConfig = getSFTPConfig(env);
  return gulp
    .src(["**/*.*", ...filesToExclude], { base: "./", encoding: false }) 
    .pipe(sftp(sftpConfig))
    .on('end', done);
}
exports.dall = dall;

// Task to delete a file or folder
async function remove(done) {
  var env = args.env;
  console.log('Environment:', env);
  var sftpConfig = getSFTPConfig(env);
  var filePath = args.path;

  if (!filePath) {
    console.error("Error: No path specified. Use --path to specify the file or folder to delete.");
    done(new Error("No path specified"));
    return;
  }

  console.log('Deleting remote file/folder at:', filePath);

  let sftp = new Client();

  try {
    await sftp.connect({
      host: sftpConfig.host,
      port: sftpConfig.port,
      username: sftpConfig.user,
      password: sftpConfig.password
    });

    let stats = await sftp.stat(sftpConfig.remotePath + '/' + filePath);

    if (stats.isDirectory) {
      await sftp.rmdir(sftpConfig.remotePath + '/' + filePath, true);
      console.log('Deleted remote directory:', filePath);
    } else {
      await sftp.delete(sftpConfig.remotePath + '/' + filePath);
      console.log('Deleted remote file:', filePath);
    }

    await sftp.end();
    done();
  } catch (err) {
    console.error('Error deleting remote file/folder:', err);
    done(err);
  }
}

exports.remove = remove;