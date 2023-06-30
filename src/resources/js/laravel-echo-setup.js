import Echo from 'laravel-echo';
import Socket from 'socket.io-client';

window.io = Socket
   
window.Echo = new Echo({
    broadcaster: 'socket.io',
    host:window.location.hostname +':6001'
});
