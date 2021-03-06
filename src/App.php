<?php

use Authentication\EventDispatcherTrait;
use Exception\ExceptionHandler;
use Exception\HttpException;
use Http\Request;
use Routing\Route;
use View\TemplateEngineInterface;

class App
{
    use EventDispatcherTrait;

    const GET    = 'GET';

    const POST   = 'POST';

    const PUT    = 'PUT';

    const DELETE = 'DELETE';

    /**
     * @var array
     */
    private $routes = array() ;

    /**
     * @var TemplateEngineInterface
     */
    private $templateEngine;

    /**
     * @var boolean
     */
    private $debug;

    /**
     * @var statusCode
     */
    private $statusCode;

    public function __construct(TemplateEngineInterface $templateEngine, $debug = false)
    {
        $this->templateEngine = $templateEngine;
        $this->debug          = $debug;

        $exceptionHandler = new ExceptionHandler($templateEngine, $this->debug);
        set_exception_handler(array($exceptionHandler, 'handle'));
    }

    /**
     * @param string $template
     * @param array  $parameters
     * @param int    $statusCode
     *
     * @return string
     */
    public function render($template, array $parameters = array(), $statusCode = 200)
    {
        $this->statusCode = $statusCode;

        return $this->templateEngine->render($template, $parameters);
    }

    /**
     * @param string   $pattern
     * @param callable $callable
     *
     * @return App
     */
    public function get($pattern, $callable)
    {
        $this->registerRoute(Request::GET, $pattern, $callable);

        return $this;
    }

    public function put($pattern, $callable)
    {
        $this->registerRoute(Request::PUT, $pattern, $callable);

        return $this;
    }

    public function post($pattern, $callable)
    {
        $this->registerRoute(Request::POST, $pattern, $callable);

        return $this;
    }

    public function delete($pattern, $callable)
    {
        $this->registerRoute(Request::DELETE, $pattern, $callable);

        return $this;
    }

    public function run(Request $request = null)
    {
        if(null === $request)
        {
            $request = Request::createFromGlobals();
        }

        $method = $request->getMethod();
        $uri    = $request->getUri();

        foreach ($this->routes as $route) {
            if ($route->match($method, $uri))
            {
                return $this->process($route, $request);
            }
        }
        throw new HttpException(404, 'Page Not Found');
    }

    /**
     * @param Route $route
     */
    private function process(Route $route, Request $request)
    {

        $this->dispatch('process.before', [ $request ]);

        $arguments = $route->getArguments();
        array_unshift($arguments, $request);

        try {

            // Calling our own function to retrieve the response
            $rep = call_user_func_array($route->getCallable(), $arguments);
            // If it is not a "response object" we create one (If it's the html version for example
            if(!$rep instanceof \Http\Response)
            {
                $rep = new \Http\Response($rep, $this->statusCode);
            }

            // We send the reponse
            $rep->send();

        } catch (HttpException $e) {
            throw $e;
        } catch (\Exception $e) {
            throw new HttpException(500, "Internal server error", $e);
        }
    }

    /**
     * @param string   $method
     * @param string   $pattern
     * @param callable $callable
     */
    private function registerRoute($method, $pattern, $callable)
    {
        $this->routes[] = new Route($method, $pattern, $callable);
    }

    /**
     * Redirect the user
     * @param $to               The page to redirect to
     * @param int $statusCode   Status code, 302 by default, "Document moved temporarily"
     */
    public function redirect($to, $statusCode = 302)
    {
        http_response_code($statusCode);
        header(sprintf('Location: %s', $to));

        die;
    }
}
