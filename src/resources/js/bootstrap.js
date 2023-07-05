/**
 * We'll load the axios HTTP library which allows us to easily issue requests
 * to our Laravel back-end. This library automatically handles sending the
 * CSRF token as a header based on the value of the "XSRF" token cookie.
 */

import axios from 'axios';
import toastr from 'toastr';
import Echo from 'laravel-echo';

window.axios = axios;

window.axios.defaults.headers.common['X-Requested-With'] = 'XMLHttpRequest';

window.Echo = new Echo({
    broadcaster: 'socket.io',
    host: `${window.location.protocol}//${window.location.hostname}:6001`,
});

window.Echo.channel(`laravel_database_post.${userId}`)
    .listen('.like-post', (e) => {
        console.log(e);
        toastr.info(e.user.name + ' liked your post', { timeOut: 4000 })
        $("#likes_count_" + e.post.id).text(e.post.like_counter.count + ' like(s)');
    });

toastr.options =
{
    "progressBar": true,
    "newestOnTop": true,
}