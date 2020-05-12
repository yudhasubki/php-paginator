# PHP Paginator
Simple and lightweight PHP Pagination to render customizable Pagination thourgh instantiable class.

## Usage
```php
<?php

require_once(__DIR__.'/../src/YudhaSubki/Paginator.php');

use YudhaSubki\Paginator;

$con = mysqli_connect('localhost', 'root', 'db_password', 'database');

if($con) {
    echo 'connected \n';
} else {
    echo 'not connected \n';
}

$query = 'SELECT * FROM tables';
$result = $con->query($query);
$totalPage = ceil($result->num_rows) / 12;

/**
  * Example For Default Template
  * default is <li class="page-item %s"><a class="page-link" href="%s">%s</a></li>
  * @var int | Total Page
  * @var string | base url
  * @var string | current Page
  * @var array | Optional in URL Query. this used to build query in pagination list anchor link, ex : www.baseurl.com?page=2&order=asc
  * @var int | set how many need previous current number. ex : current number 5 - 3, will be shown 2,3,4,5. default is 2
  * @var int | set how many need after current number. ex : current number 5 - 4, will be shown 5,6,7,8,9. defualt is 2
 */
$paginator = new Paginator($totalPage, 'www.baseurl.com', '2', ['page'=>'2', 'order'=>'asc'], 3 , 4);
echo $paginator->render();

// string : <li class="page-item "><a class="page-link" href="www.baseurl.com?page=1&order=asc">Previous</a></li><li class="page-item "><a class="page-link" href="www.baseurl.com?page=1&order=asc">1</a></li><li class="page-item active disabled"><a class="page-link" href="www.baseurl.com?page=2&order=asc">2</a></li><li class="page-item "><a class="page-link" href="www.baseurl.com?page=3&order=asc">3</a></li><li class="page-item "><a class="page-link" href="www.baseurl.com?page=4&order=asc">4</a></li><li class="page-item "><a class="page-link" href="www.baseurl.com?page=3&order=asc">Next</a></li>

/**
 * Example with Custom List of Template 
 * Set Custom Template with Chaining Method
 */
$paginator = new Paginator($totalPage, 'www.baseurl.com', '2', ['page'=>'2', 'order'=>'asc']);
echo $paginator->setCustomTemplate('<li class="page-item some-new-class new-class %s"><a class="page-link" href="%s">%s</a></li>')->render();

// string : <li class="page-item some-new-class new-class "><a class="page-link" href="www.baseurl.com?page=1&order=asc">Previous</a></li><li class="page-item some-new-class new-class "><a class="page-link" href="www.baseurl.com?page=1&order=asc">1</a></li><li class="page-item some-new-class new-class active disabled"><a class="page-link" href="www.baseurl.com?page=2&order=asc">2</a></li><li class="page-item some-new-class new-class "><a class="page-link" href="www.baseurl.com?page=3&order=asc">3</a></li><li class="page-item some-new-class new-class "><a class="page-link" href="www.baseurl.com?page=4&order=asc">4</a></li><li class="page-item some-new-class new-class "><a class="page-link" href="www.baseurl.com?page=3&order=asc">Next</a></li>

```