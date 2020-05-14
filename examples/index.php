<?php

require_once(__DIR__.'/../src/YudhaSubki/Paginator.php');

use YudhaSubki\Paginator;

$con = mysqli_connect('localhost', 'root', 'test123', 'box_amal');

if($con) {
    echo 'connected';
} else {
    echo 'not connected';
}

$query = 'SELECT * FROM campaign_images';
$result = $con->query($query);

$totalPage = ceil($result->num_rows) / 12;

echo $totalPage;

/**
  * Example For Default Template
  * default is <li class="page-item %s"><a class="page-link" href="%s">%s</a></li>
  * @var int | Total Page
  * @var string | base url
  * @var string | current Page
  * @var array | Optional in URL Query
  * @var int | set how many need previous current number ex : current number 5 - 3, will be shown 2,3,4,5. default is 2
  * @var int | set how many need after current number ex : current number 5 - 4, will be shown 5,6,7,8,9. default is 2
 */
$paginator = new Paginator($totalPage, 'www.baseurl.com', '8', ['page'=>'1', 'order'=>'asc'], 3 , 4);
echo $paginator->render();

/**
 * Example with Custom List of Template 
 * Set Custom Template with Chaining Method
 */
$paginator = new Paginator($totalPage, 'www.baseurl.com', '2', ['page'=>'2', 'order'=>'asc']);
echo $paginator->setCustomTemplate('<li class="page-item some-new-class new-class %s"><a class="page-link" href="%s">%s</a></li>')->render();



