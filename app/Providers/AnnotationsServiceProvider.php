<?php namespace App\Providers;

use Collective\Annotations\AnnotationsServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\File;

class AnnotationsServiceProvider extends ServiceProvider {

    /**
     * The classes to scan for event annotations.
     *
     * @var array
     */
    protected $scanEvents = [];

    /**
     * The classes to scan for route annotations.
     *
     * @var array
     */
    protected $scanRoutes = [];

    /**
     * Determines if we will auto-scan in the local environment.
     *
     * @var bool
     */
    protected $scanWhenLocal = true;

    /**
     * Initialize routes
     */
    public function boot()
    {
        $nameSpace = 'App\Http\Controllers';
        $basePath  = $this->app->make('path') . '/Http/Controllers';
        foreach (File::allFiles($basePath) as $controller) {
            $controller = substr($controller, strlen($basePath)+1);
            $controller = str_replace('/', '\\', $controller);
            $controller = str_replace('.php', '', $controller);
            $this->scanRoutes[] = "{$nameSpace}\\{$controller}";
        }
        
        return parent::boot();
    }
}
