
/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

require('./bootstrap');
require('./clean-blog.min');

window.Vue = require('vue');

/**
 * Next, we will create a fresh Vue application instance and attach it to
 * the page. Then, you may begin adding components to this application
 * or customize the JavaScript scaffolding to fit your unique needs.
 */

Vue.component('example-component', require('./components/ExampleComponent.vue'));

const app = new Vue({
    el: '#app'
});


// Enable pusher logging - don't include this in production
Pusher.logToConsole = true;

var pusher = new Pusher(process.env.MIX_PUSHER_APP_KEY, {
    cluster: process.env.MIX_PUSHER_CLUSTER,
    encrypted: true
});

var channel = pusher.subscribe(quizConf.channelId || 'default');
channel.bind('team-progress', function(data) {
    if(data.answer.team_id != team_id)
    {
        alert(data.message);
        updateProgress(data)
    }
});

function updateProgress(data)
{
    //@TODO go build this
}