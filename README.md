Lime Technology unRAID OS System Management Utility, aka, webGui

### Installation

Login to the command line on your server, e.g., at the console or a telnet session.

First, empty the `/boot/plugins` directory or delete it entirely.  This is unneeded and will
be going away.

Next, make sure you have a `/boot/config/plugins` directory.  This directory is where all the
plugin `.plg` files go and where plugin configuration files will be stored.

Now 'wget' the two files:

`wget https://github.com/limetech/webGui/blob/master/webGui-latest.plg`
`wget https://github.com/limetech/webGui/blob/master/webGui-latest.txz`

Then type:

`installplg /boot/config/plugins/webGui-latest.plg`

alternately, you could reboot the server.

Now open the server webGui in your browser.

#### What is the plugin doing?

When installed for the first time, `installplg webGui-latest.plg` will do this:

* Download some needed slackware packages to `/boot/packages` (if not already there).
* Create the `/boot/config/plugins/webGui` directory where the file `webGui.cfg` will be maintained to
store user webGui preferences.
* Delete the current webGui in `/usr/local/emhttp/plugins/webGui`
* Extract the `webGui-latest.txz` package to `/usr/local/emhttp/plugins/webGui`

#### How is the .txz file created?

On the local server:
```
cd /usr/local/emhttp/plugins/webGui
makepkg ../webGui-latest.txz
```
