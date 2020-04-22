# Dispatcher Middleware

The middleware takes an extractor and a dispatcher object. The extractor extracts whatever information is needed from the server request object and returns the handler. The actual dispatcher will then execute the handler.

This is a very clean separation of concerns and should provide you a maximum of flexibility to change your dispatching processes as you need it. For details check the documentation.

The only requirement is that your request object somehow contains the information that is needed to figure out what handler should take the request.  This can can be done by passing the result of the routing as a request attribute for example.

## Requirements

The library has no other dependencies than the PSR HTTP and container interfaces. The only requirement to use this library is that you are using a PSR compatible middleware queue.

## Documentation

Please see the [docs][1] folder in this repository for the documentation.

## License

Copyright 2020 Florian Krämer

Licensed under the [MIT license](license.txt).

[1]: /docs/index.md
