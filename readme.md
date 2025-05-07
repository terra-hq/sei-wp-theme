

# Terra Starter

 - [Performance](documentation/performance.md)
 - [CheckList](documentation/checklist.md)
 - [Post Launch](documentation/post-launch.md)
 - [History](documentation/history.md)

This project provides a WordPress starter theme integrated with [Vite](https://vitejs.dev) 

It streamlines the development process by automatically generating CSS, refreshing the browser on every file save/edit, and offering a hassle-free production build tool.


## Features
 - Fast auto browser refresh/sync on file changes or saves
 - Retain your local domain during development
 - Use Gulp for deployment
 - Simple production build with `npm run build`



## Installation (Node.js/npm required):

Ensure Node.js and npm are installed on your machine.
<br>
It's recommended to use Node version 21.0.0 or above. While it may work with lower versions, be aware that versions between 18 and 20 might cause some errors.

#### Development
`npm run virtual`

#### Production / Build
`npm run build`

<br><br>

## What changes from previous versions

#### Moving Away from Vite

Previously, we used Webpack, which, although powerful, often made custom configurations cumbersome.

One of the first things we need to change is the VITE_WP_PATH environment variable in the .env.virtual file to match the name of our WP install and theme.

Update `VITE_WP_PATH` as follows:

``` bash
VITE_WP_PATH = http://localhost/{your-wordpress-install}/wp-content/themes/{your-theme-name}/public
 
```

#### Hot reloading

From now on, by using Vite, we can have hot reloading on the page for SCSS, JS, and PHP files. This will help us save time during development

#### Start using PHP clases

Organized Code: Classes encapsulate related functionality, making the code more organized. Functions, properties, and methods related to a specific feature are bundled together within a class.


```php 
new Custom_Post_Type((object) array(
    'post_type' => 'test',
    'singular_name' => 'Test',
    'plural_name' => 'Tests',
    'args' => (object) array(
        'menu_icon' => 'dashicons-welcome-learn-more',
        'rewrite' => array('slug' => 'tests')
    )
));
```




#### Images & Fonts

Images should be divided as follows: those used in HTML should be placed in the `img` folder at the root of the project, while those used within SCSS should go in the `public` folder. This is because Vite cannot process them the same way. Additionally, font files should also be placed in public, and both types of files should be referenced in SCSS using the `#{$base-path}` variable.


``` scss
@font-face {
    font-family: 'Danfo';
    src: url('#{$base-path}/fonts/Danfo-Regular.woff2') format('woff2'),
         url('#{$base-path}/fonts/Danfo-Regular.woff') format('woff');
}

.c--card-a{
    background-image: url(#{$base-path}/assets/bg1.jpg);
}
```


#### Alias

Using aliases in Vite is worthwhile because they improve code clarity, simplify refactoring tasks, help avoid naming conflicts, and make accessing specific functions or components more straightforward and efficient.

``` scss
@import '@scssFoundation/reset/reset.scss';
@import '@scssComponents/header/header-a.scss';
```

``` js
// regular import
import Core from '@js/Core';
import VueJsInstance from '@jsModules/VueJsInstance.js';

// for dynamic imports
import("@js/Main.js")

```
_When building dynamic import you should not include /* webpackChunkName: "YourModule" */_	

#### .Env Variables

We have introduced .env variables for virtual and build environments. These variables are not uploaded to the production site.

#### Commits

Until now, we did not have a commit system. From now on, the default folder should be mostly un edit by the team. When making changes, use examples like "🛠️ fix generate_imag_tag function" and "🛠️ cleanHouse update."

#### The Suggestion box 

When a client has a maintenance budget, here you can add code improvements. Here's a list for you to use. Some examples could be:

- "Card 44 is not being used" ❌
- "Card 44 does not have variations -- this could affect performance" ❌
- "There is an Axios request that is not working" ❌
- "This component could unify three others" ❌
- "Refactored the login module to improve security" ✅

Adding notes like "this could affect performance" or "this could unify 3 components" will provide better context for Maria and me.

Finally, do not remove items once they've been added to the list. Instead, mark them as done so we can track progress and show the client the improvements we've made over time.



## Be accountable & responsable & Time sensitive

I've realized that sometimes developers know they're doing things that may not be optimal, but within the project timeline, it can be very complicated to re-evaluate or clean up patterns. If you think you're doing something questionable, just add a simple note like "Help 🤷" with the emoji. This will be easy to search for in *GitHub*.

This small detail signals that the developer recognizes something might be wrong but doesn't know how to fix it at that moment. It indicates that the developer's perspective is accurate, even if they cannot solve the issue right away.

If you don't add the emoji, I might assume you are unaware of the issue. If that's the case, we'll work on it together. However, if you do add the emoji, it shows that you understand the reasoning but need help polishing the execution.
```js 

finally{
      // Help 🤷 - need assistance with this promise
      var tl = gsap.timeline({
        defaults: {duration: 0.8, ease: "power1.inOut"},
        onUpdate: async () => {
            //* Check if the animation is at least 50% complete and the function hasn't been executed yet
            if (tl.progress() >= 0.5 && !this.halfwayExecuted) {
                this.halfwayExecuted = true;
                const result = await import("@js/Main.js");
                new result.default({ });
            }
        },
      });
      tl.to(".c--preloader-a", {duration: 1, y:'-100%', ease: "power1.inOut"});

    }

```



## Deployment

Simply go to `config/sftpConfg.js` and change whatever is needed. Click [here](documentation/deploy.md) for more details.

Some tasks have been refactored. Use the following commands to perform different deployment operations:

- `gulp ddist --dev|stage|production` - Upload all files.
- `gulp ddisthash --dev|stage|production` - Upload dist and hash directories.
- `gulp dfm --dev|stage|production` - Deploy all flexible modules.
- `gulp dall --dev|stage|production` - Deploy all files.
- `gulp ds --dev|stage|production  --path footer.php || --path folder ` - Deploy single file or directory.
- `gulp remove --dev|stage|production --path footer.php` - Remove a specified file or folder.