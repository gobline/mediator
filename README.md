# Mediator Component - Mendo Framework

The Mendo Mediator component allows your application components to communicate with each other by dispatching events and listening to them. It implements the mediator behavioral design pattern.

### Creating the Dispatcher

```php
use Mendo\Mediator\EventDispatcher;

$dispatcher = new EventDispatcher();
```

### Adding Event Subscribers

```php
use Mendo\Mediator\EventSubscriberInterface;

class FooSubscriber implements EventSubscriberInterface
{
    public function onFooEvent()
    {
        // ... do something
    }

    public function getSubscribedEvents()
    {
        return ['fooEvent'];
    }
}

$subscriber = new FooSubscriber();
$dispatcher->addSubscriber($subscriber);
```

### Dispatching Events

```php
$dispatcher->dispatch('fooEvent');
```
