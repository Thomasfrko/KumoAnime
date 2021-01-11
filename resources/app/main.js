const electron = require('electron')
// const path = require('path')
const spawn = require('child_process').spawn
const exec = require('child_process').exec

const BrowserWindow = electron.BrowserWindow
const app = electron.app

// Modify this varaible to your own XAMPP path folder
const xampp = 'D:\\Logiciels\\XAMPP'

app.on('ready', () => {
  spawn('cmd.exe', [
    '/c',
    'php',
    './resources/app/artisan',
    'config:cache'
  ])
  spawn('cmd.exe', [
    '/c',
    xampp + '\\mysql_start.bat'
  ])
  spawn('cmd.exe', [
    '/c',
    'php',
    './resources/app/artisan',
    'db:create',
    'anime'
  ])
  setTimeout(function () {
    spawn('cmd.exe', [
      '/c',
      'php',
      './resources/app/artisan',
      'migrate'
    ])
  }, 2000)

  setTimeout(function () {
    createWindow()
  }, 5000)

  spawn('cmd.exe', [
    '/c',
    'php',
    './resources/app/artisan',
    'queue:work'
  ])
})

const phpServer = require('node-php-server')
const port = 8000; const host = '127.0.0.1'
const serverUrl = `http://${host}:${port}`

let mainWindow

function createWindow () {
  // Create a PHP Server
  phpServer.createServer({
    port: port,
    hostname: host,
    base: `${__dirname}/public`,
    keepalive: false,
    open: false,
    bin: xampp + '\\php\\php.exe',
    router: __dirname + '/server.php'
  })

  // Create the browser window.
  const {
    width,
    height
  } = electron.screen.getPrimaryDisplay().workAreaSize
  mainWindow = new BrowserWindow({
    width: width,
    height: height,
    show: false,
    autoHideMenuBar: true,
    webPreferences: {
      devTools: true
    }
  })

  mainWindow.loadURL(serverUrl)

  mainWindow.webContents.once('dom-ready', function () {
    mainWindow.show()
    mainWindow.maximize()
    // mainWindow.webContents.openDevTools()
  })

  // Emitted when the window is closed.
  mainWindow.on('closed', function () {
    phpServer.close()
    mainWindow = null
    spawn('cmd.exe', [
      '/c',
      xampp + '\\mysql_stop.bat'
    ])
  })
}

// This method will be called when Electron has finished
// initialization and is ready to create browser windows.
// Some APIs can only be used after this event occurs.
// app.on('ready', createWindow) <== this is extra so commented, enabling this can show 2 windows

// Quit when all windows are closed.
app.on('window-all-closed', function () {
  // On OS X it is common for applications and their menu bar
  // to stay active until the user quits explicitly with Cmd + Q
  if (process.platform !== 'darwin') {
    // PHP SERVER QUIT
    phpServer.close()
    app.quit()
  }
})

app.on('activate', function () {
  // On OS X it's common to re-create a window in the app when the
  // dock icon is clicked and there are no other windows open.
  if (mainWindow === null) {
    createWindow()
  }
})
