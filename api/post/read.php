<?php 
  // Headers
  header('Access-Control-Allow-Origin: *');
  header('Content-Type: application/json');

  include_once '../../config/Database.php';
  include_once '../../models/Post.php';

  //Instantiate DB and Conenct
  $database = new Database();
  $db = $database->connect();

  //Instantiate Blog Post Object
  $post = new Post($db);

  //Blog Post Query; 
  $result = $post->read();
  //Get row count
  $num = $result->rowCount();

  //Check for posts
  if($num > 0) {
    //Initalize Posts Array
    $posts_arr = array();
    //$posts_arr['data'] = array();

    while($row = $result->fetch(PDO::FETCH_ASSOC)) {
        extract($row);

        $post_item = array(
            'id' => $id,
            'title' => $title,
            'body' => html_entity_decode($body),
            'author' => $author,
            'category_id' => $category_id,
            'category_name' => $categoty_name
        );

        //Push data to main array
        array_push($posts_arr, $post_item);
        //array_push($posts_arr['data'], $post_item);
    }

    //Turn it into JSON & output
    echo json_encode($posts_arr);

  } else {
    //No Posts
    echo jason_encode(
        array('message' => 'No Posts Found')
    );
  }
