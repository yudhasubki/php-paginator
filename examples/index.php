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
 */
$paginator = new Paginator($totalPage, 'www.baseurl.com', '2', ['page'=>'2', 'order'=>'asc']);
print_r($paginator->render());

/**
 * Example with Custom List of Template 
 * Set Custom Template with Chaining Method
 */
$paginator = new Paginator($totalPage, 'www.baseurl.com', '2', ['page'=>'2', 'order'=>'asc']);
print_r($paginator->setCustomTemplate('<li class="page-item some-new-class new-class %s"><a class="page-link" href="%s">%s</a></li>')->render());


// (
//     [0] => <li class="page-item some-new-class new-class "><a class="page-link" href="www.baseurl.com?page=1&order=asc">Previous</a></li>
//     [1] => <li class="page-item some-new-class new-class "><a class="page-link" href="www.baseurl.com?page=1&order=asc">1</a></li>
//     [2] => <li class="page-item some-new-class new-class active disabled"><a class="page-link" href="www.baseurl.com?page=2&order=asc">2</a></li>
//     [3] => <li class="page-item some-new-class new-class "><a class="page-link" href="www.baseurl.com?page=3&order=asc">3</a></li>
//     [4] => <li class="page-item some-new-class new-class "><a class="page-link" href="www.baseurl.com?page=4&order=asc">4</a></li>
//     [5] => <li class="page-item some-new-class new-class "><a class="page-link" href="www.baseurl.com?page=3&order=asc">Next</a></li>
// )

