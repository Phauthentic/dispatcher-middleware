# Dispatcher

## Dispatcher Middleware

## Handler Extractors

They will extract a handler from the request object.

To implement your own extractor you'll have to implement the [HandlerExtractorInterface](../src/Infrastructure/Http/Dispatcher/HandlerExtractorInterface.php).

This library comes with a simple [RequestAttributeExtractor](../src/Infrastructure/Http/Dispatcher/RequestAttributeExtractor.php) that will check the request for an attribute, if it is not present NULL will be returned.

## Dispatchers
