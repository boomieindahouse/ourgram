<?php
require_once 'vendor/autoload.php';
$router = new AltoRouter();

//front-end
$router->map('GET', '/', function () {
    require __DIR__ . '/views/homepage.php';
});
$router->map('GET', '/signin', function () {
    require __DIR__ . '/views/sign_in.php';
});
$router->map('GET', '/signup', function () {
    require __DIR__ . '/views/sign_up.php';
});
$router->map('GET', '/profile/[:username]', function ($username) {
    require __DIR__ . '/views/profile.php';
});
$router->map('GET', '/acounts/edit', function(){
    require __DIR__ . '/views/edit_profile.php';
});
$router->map('GET', '/admin/dashboard', function(){
    require __DIR__ . '/views/admin/dashboard.php';
});
$router->map('GET', '/admin/users', function(){
    require __DIR__ . '/views/admin/tb_users.php';
});
$router->map('GET', '/admin/posts', function(){
    require __DIR__ . '/views/admin/tb_posts.php';
});
$router->map('GET', '/admin/posts/post/[:post]', function ($post) {
    require __DIR__ . '/views/admin/post.php';
});

//back-end
$router->map('POST', '/signup_db', function () {
    require __DIR__ . '/controller/signup_db.php';
});
$router->map('POST', '/signin_db', function () {
    require __DIR__ . '/controller/signin_db.php';
});
$router->map('POST', '/addpost_db', function () {
    require __DIR__ . '/controller/add_post_db.php';
});
$router->map('POST', '/addcomment_db', function () {
    require __DIR__ . '/controller/add_comment_db.php';
});
$router->map('POST', '/follow_db', function(){
    require __DIR__ . '/controller/follow_db.php';
});
$router->map('POST', '/like_db', function(){
    require __DIR__ . '/controller/like_db.php';
});
$router->map('POST', '/editprofile_db', function(){
    require __DIR__ . '/controller/edit_profile_db.php';
});
$router->map('POST', '/delAccount_db', function(){
    require __DIR__ . '/controller/del_account_db.php';
});
$router->map('POST', '/search_db', function(){
    require __DIR__ . '/controller/search_db.php';
});
$router->map('POST', '/admin_db', function(){
    require __DIR__ . '/controller/admin_db.php';
});
$router->map('POST', '/tb_users', function(){
    require __DIR__ . '/controller/tb_users.php';
});
$router->map('POST', '/tb_posts', function(){
    require __DIR__ . '/controller/tb_posts.php';
});
$router->map('GET', '/logout', function () {
    require __DIR__ . '/controller/logout_db.php';
});

$match = $router->match();

// Here comes the new part, taken straight from the docs:

// call closure or throw 404 status
if ($match && is_callable($match['target'])) {
    call_user_func_array($match['target'], $match['params']);
} else {
    // no route was matched
    header($_SERVER["SERVER_PROTOCOL"] . ' 404 Not Found');
    require __DIR__ . '/views/404page.php';
}
