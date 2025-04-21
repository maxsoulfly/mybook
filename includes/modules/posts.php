<?php include_once __DIR__ . '/../functions.php'; ?>

<?php
$posts = [
    [
        'username' => 'Boris Gee',
        'avatar' => '/assets/img/user1.jpg',
        'date' => 'April 18, 2025',
        'content' => 'Just finished building the profile layout!'
    ],
    [
        'username' => 'John Doe',
        'avatar' => '/assets/img/user2.jpg',
        'date' => 'April 17, 2025',
        'content' => 'Loving this new view from the mountain. 🌄'
    ],
    [
        'username' => 'Mika Strong',
        'avatar' => '/assets/img/user3.jpg',
        'date' => 'April 16, 2025',
        'content' => 'Is it too early to say this might be the best coffee I\'ve ever had?'
    ],
];

foreach ($posts as $post) {
    renderPost($post['username'], $post['avatar'], $post['date'], $post['content']);
}

?>
