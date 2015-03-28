<?php namespace App\Http\Controllers;

use Illuminate\Contracts\Container\Container;
use Illuminate\Foundation\Bus\DispatchesCommands;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Contracts\Routing\UrlGenerator;

use Layout\Config;
use Layout\Processor\ProcessorAbstract;
use Layout\Processor\ProcessorHtml;
use Layout\Processor\ProcessorJson;

abstract class AbstractController 
    extends BaseController 
{
    use DispatchesCommands, ValidatesRequests;
    
    /** @var  Config */
    protected $layoutConfig;
    /** @var  ProcessorJson */
    protected $processorJson;
    /** @var  ProcessorHtml */
    protected $processorHtml;
    protected $urlGenerator;
    protected $handles = ['default'];

    /**
     * @param Config $config
     * @param ProcessorHtml $processorHtml
     * @param ProcessorJson $processorJson
     * @param Container $container
     * @param UrlGenerator $urlGenerator
     */
    final public function __construct(Config $config, ProcessorHtml $processorHtml, ProcessorJson $processorJson, Container $container, UrlGenerator $urlGenerator)
    {
        $this->layoutConfig  = $config;
        $this->processorHtml = $processorHtml;
        $this->processorJson = $processorJson;
        $this->urlGenerator  = $urlGenerator;
        
        if (method_exists($this, '__initialize')) {
            $container->call(array($this, '__initialize'));
        }
    }
    
    /**
     * @return Config
     */
    public function getLayoutConfig()
    {
        return $this->layoutConfig;
    }

    /**
     * @param $handle
     */
    protected function addLayoutHandle($handle)
    {
        $this->handles[] = $handle;
    }

    /**
     * @param array $handles
     * @return $this
     */
    protected function loadLayoutConfig($handles = [])
    {
        if (!is_array($handles)) {
            if ($handles) {
                $handles = [$handles];
            } else {
                $handles = [];
            }
        }
        
        return $this->getLayoutConfig()->load(array_unique(array_merge($this->handles, $handles)));
    }

    /**
     * @param string $method
     * @param array $parameters
     * @return mixed|\Symfony\Component\HttpFoundation\Response
     */
    public function callAction($method, $parameters)
    {
        $result = parent::callAction($method, $parameters);
        
        if ($result instanceof Config) {
            return $this->getResponse($result);
        }
        
        return $result;
    }

    /**
     * @return ProcessorAbstract
     */
    protected function getLayoutProcessor()
    {
        if (false !== strpos('application/json', $this->getRouter()->getCurrentRequest()->header('accept'))) {
            return $this->processorJson;
        }

        return $this->processorHtml;
    }

    /**
     * @param Config $config
     * @return mixed
     */
    protected function getResponse(Config $config)
    {
        $elements = [];

        if ($requestedElements = $this->getRouter()->getCurrentRequest()->header('elements')) {
            $elements += array_map(function ($v) { return trim($v); },
                explode(',', $requestedElements)
            );
        }
        
        if ($requestedElement = $this->getRouter()->getCurrentRequest()->header('element')) {
            $elements[] = trim($requestedElement);
        }
        if (count($elements)) {
            $result = [];
            foreach ($elements as $elementPath) {
                $config->setTarget($elementPath);
                $result[$elementPath] = $this->getLayoutProcessor()->run($config);
            }
            
            return $result;
        }
        
        return $this->getLayoutProcessor()->run($config);
    }

    /**
     * @param string $path
     * @param array $params
     * @param null $secure
     * @return string
     */
    public function getUrl($path, array $params = [], $secure = null)
    {
        return $this->urlGenerator->to($path, $params, !is_null($secure) ? $secure : $this->request->isSecure());
    }
}
