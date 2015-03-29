## Laravel Dev Application

### Installation

Clone git repository:

    git clone git@github.com:violetbrick/app-dev.git
  
Init git submodules:

    cd app-dev
    git submodule init
    git submodule update
  
Install dependencies:

    composer install

Apply database migrations:

    php artisan migrate

### Development

Route and Event anotation included? see official documentation for details http://laravelcollective.com/docs/5.0/annotations


All layout elements described in *config/layout.php*

Theme settings defined in *config/theme.php*

Layouts should be placed to *resources/design/{your_package}/{your_theme}/layout* directory

Templates should be placed to *resources/design/{your_package}/{your_theme}/template* directory

Assets must be placed to *public/{your_package}/{your_theme}* directory
