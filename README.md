### Minimal Site Profile For [Processwire 3x](https://processwire.com/) with include functions like:
#### [New “Unique” status for pages](https://processwire.com/blog/posts/pw-3.0.127/)  
#### [New $page->if() method](https://processwire.com/blog/posts/pw-3.0.126/)
#### [API setting()](https://processwire.com/blog/posts/processwire-3.0.119-and-new-site-updates/#new-functions-api-setting-function)
#### [MarkupRegions](https://processwire.com/blog/posts/processwire-3.0.49-introduces-a-new-template-file-strategy/)
#### [FunctionsAPI](https://processwire.com/blog/posts/processwire-3.0.39-core-updates/)  

### How To Install
1. Download the [zip file](https://github.com/rafaoski/site-minimal/archive/master.zip) at Github or clone directly the repo: ```git clone https://github.com/rafaoski/site-minimal.git```
2. Extract the folder **site-minimal-master** into a fresh ProcessWire installation root folder.
3. During the installation of ProcessWire, choose the profile **Minimal - Site Profile for ProcessWire 3x**.

### Basic Info
1. Most of the profile settings and translates are in the ``` _init.php ``` file.
2. Functions can be found in the ``` _func.php ``` file.
3. The entire view is rendered in the ``` _main.php ``` file that uses [markup regions](https://processwire.com/docs/front-end/output/markup-regions/).
4. You can easily add [hooks](https://processwire.com/docs/modules/hooks/) using the ``` ready.php ``` file.
5. Options page added with the new [“Unique”](https://processwire.com/blog/posts/pw-3.0.127/) status, which you can use in this simple way like:  
 ``` pages('options')->site_name ```  
  ``` pages->get('options')->site_name ```

#### Additionally, you can use the icon font that are included:
[Feather Icons](https://feathericons.com/)

#### All images ( svg ) on the pages come from:
[Icofont](https://icofont.com/)  
[Simpleicons ( Processwire Logo ) ](https://simpleicons.org/?q=processwire)

#### If you want to use [Laravel Mix](https://github.com/JeffreyWay/laravel-mix) you must first ensure that [Node.js](https://nodejs.org/en/download/) and [NPM](https://www.npmjs.com/get-npm) are installed on your machine.
Basic example to Debian and Ubuntu based Linux distributions:  
#### Node.js
curl -sL https://deb.nodesource.com/setup_8.x | sudo -E bash -
sudo apt-get install -y nodejs

See more installation options [LINK](https://nodejs.org/en/download/package-manager/)  
#### npm is installed with Node.js just check in linux terminal like below:
<code>node -v</code>  
<code>npm -v</code>

#### Set BrowserSync inside folder <code>/templates/webpack.mix.js</code> and change your dev url  
<code>proxy: 'http://minimal.test/',</code> to your installation processwire folder like:  
<code>proxy: 'http://localhost/your-processwire-installation-folder/',</code>

Next install npm packages in your templates folder with command <code><b>npm install</b></code>  
Now, boot up the dev server <code><b>npm run watch</b></code>, and you're all set go!  
On completion, use the command <code><b>npm run production</b></code> to build styles and scripts in the dist folder  

#### Simple Usage ( Basic Command )
<ul>
    <li><b>Run</b> <code>npm install</code></li>
    <li><b>Watch</b> <code>npm run watch</code></li>  
    <li><b>Build</b> <code>npm run production</code></li>
</ul>

#### All files to Webpack build steps is inside file ( ``` webpack.mix.js ``` )

#### Folder With all SCSS files is inside ``` templates/asets/src/scss ```

#### All build styles and scripts is inside the ( ```templates/assets``` ) folder ( ```/css/mix.css``` or ```/js/app.js``` )
