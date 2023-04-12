# Migration drupal
Étape pour migrer les sites drupal<br>

# Désactiver le cache du site
Les outils drupal on un cache, pour pouvoir exporter une bdd minimal il est conseiller de supprimer le cache et le désactiver dans le backoffice Developpement/Performence <br>

# Exporter le core de drupal
En fonction de la version de drupal exporter le coeur du drupal<br>
<ul>
    <li>.git</li>
    <li>composer</li>
</ul>

# Examples
## Simple chat
start.php
```php
use Workerman\Worker;
use PHPSocketIO\SocketIO;
require_once __DIR__ . '/vendor/autoload.php';
// Listen port 2021 for socket.io client
$io = new SocketIO(2021);
$io->on('connection', function ($socket) use ($io) {
    $socket->on('chat message', function ($msg) use ($io) {
        $io->emit('chat message', $msg);
    });
});
Worker::runAll();
```

## Another chat demo

https://github.com/walkor/phpsocket.io/blob/master/examples/chat/start_io.php
```php
use Workerman\Worker;
use PHPSocketIO\SocketIO;
require_once __DIR__ . '/vendor/autoload.php';
// Listen port 2020 for socket.io client
$io = new SocketIO(2020);
$io->on('connection', function ($socket) {
    $socket->addedUser = false;
    // When the client emits 'new message', this listens and executes
    $socket->on('new message', function ($data) use ($socket) {
        // We tell the client to execute 'new message'
        $socket->broadcast->emit('new message', array(
            'username' => $socket->username,
            'message' => $data
        ));
    });
    // When the client emits 'add user', this listens and executes
    $socket->on('add user', function ($username) use ($socket) {
        global $usernames, $numUsers;
        // We store the username in the socket session for this client
        $socket->username = $username;
        // Add the client's username to the global list
        $usernames[$username] = $username;
        ++$numUsers;
        $socket->addedUser = true;
        $socket->emit('login', array( 
            'numUsers' => $numUsers
        ));
        // echo globally (all clients) that a person has connected
        $socket->broadcast->emit('user joined', array(
            'username' => $socket->username,
            'numUsers' => $numUsers
        ));
    });
    // When the client emits 'typing', we broadcast it to others
    $socket->on('typing', function () use ($socket) {
        $socket->broadcast->emit('typing', array(
            'username' => $socket->username
        ));
    });
    // When the client emits 'stop typing', we broadcast it to others
    $socket->on('stop typing', function () use ($socket) {
        $socket->broadcast->emit('stop typing', array(
            'username' => $socket->username
        ));
    });
    // When the user disconnects, perform this
    $socket->on('disconnect', function () use ($socket) {
        global $usernames, $numUsers;
        // Remove the username from global usernames list
        if ($socket->addedUser) {
            unset($usernames[$socket->username]);
            --$numUsers;
            // echo globally that this client has left
            $socket->broadcast->emit('user left', array(
               'username' => $socket->username,
               'numUsers' => $numUsers
            ));
        }
   });
});
Worker::runAll();
```