<?php namespace App\Http\Controllers;

class IndexController 
    extends AbstractController 
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __initialize()
    {
        $this->middleware('guest');
    }

    /**
     * @return $this
     * 
     * @Get("/")
     */
    public function index()
    {
        return $this->loadLayoutConfig('home');
    }
}
