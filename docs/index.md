# Documentation

## Dispatcher Middleware

The middleware inspects the requests using the extractor and if the result of the extraction was something else than `null`, it will pass the result on to the dispatcher. The dispatcher will try to dispatch it and implements the actual dispatching logic.

```php
new DispatcherMiddleware(
    new RequestAttributeExtractor(),
    new Dispatcher($psrContainer)
);
```

### Passing the handler through

If you want to pass a route object or anything else from a middleware running before the dispatcher, you'll need to put the data into a request attribute.

The RequestAttributeExtractor will check by default for a `handler` attribute in the request object.

So for example in your routing middleware, if the router resolves to a route object, then pass it along:

```
$request = $request->withAttribute('handler', $route);
```

## Handler Extractors

They will extract a handler from the request object.

To implement your own extractor you'll have to implement the [HandlerExtractorInterface](../src/Infrastructure/Http/Dispatcher/HandlerExtractorInterface.php).

This library comes with a simple [RequestAttributeExtractor](../src/Infrastructure/Http/Dispatcher/RequestAttributeExtractor.php) that will check the request for an attribute, if it is not present `null` will be returned.

## Dispatchers

Dispatchers take the handler and try to execute it depending what it is. The library comes with a dispatcher that will resolve `callable` and `string` handlers. The string must be of the format `<prefix>.<controller-or-handler>@<action>`.

* `<prefix>` is optional but useful for plugins or extensions that reside in another namespace.
 * `<controller-or-handler>` is the actual class.
 * `<action>` is the method to call on the class. It is optional.

You can change the separators via setter methods on the dispatcher object.
 If you want to implement your own dispatcher you'll have to implement the [DispatcherInterface](../src/Infrastructure/Http/Dispatcher/DispatcherInterface.php).

The dispatcher that comes with the library uses a PSR container to resolve the actual controller or request handler class.

```php
new Dispatcher($psrContainer)
```
