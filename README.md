#Cito PHP - A lightweight PHP MVC Framework

##Intro

Cito PHP is a lightweight and flexible PHP MVC framework. Most PHP frameworks are overkill. Cito PHP is a barebones framework that is just over 30kb for the entire project.

##Documentation

###Getting Started

To get started open index.php at the root of the project. Find the two lines below and change to reflect your development environment. HTTP_SERVER is the location of your website, for local testing use http://localhost. The REWRITE_BASE is used if your project is in a subdirectory. For example, example.com/citophp or localhost/citophp. Finally the DIR_ROOT is the path to the project directory.

```
define('HTTP_SERVER', 'www.example.com');
define('REWRITE_BASE', '');
define('DIR_ROOT', '/var/www/html/example/');
```

If you intend to use a database you will need to provide your database information on the following lines.

```
//define('DB_DRIVER', 'mysqli');
//define('DB_HOSTNAME', 'localhost');
//define('DB_USERNAME', 'admin');
//define('DB_PASSWORD', 'password');
//define('DB_DATABASE', 'database');
```

###Structure

####MVC

MVC - Model, View, Controller. The model represents the application core (the data), the view displays the data, and the controller handles the business logic. If you're not familiar with MVC, Google it there are plenty of useful articles on the subject.

####Index

The index.php document at the root of the project isn't a typical index page. It is use to define classes and get the data to display all pages. Different pages are called via the route parameter. For example, www.example.com/index.php?route=directory/page.

####Route Parameter

The route parameter can contain two or three arguments. The first is the directory; this is looking for a subdirectory in the controller directory. The second argument will look for a specific document within the stated directory. The thrid and optional argument is for a specific method. If this is left blank it will call the index method by default.

####Example:

```
<form action="index.php?route=common/home/form">
```

Above example will call the form method in the /controller/common/home.php controller document. More information about the route parameter and documentation for creating new pages can be found here.

###SEO URLs

####Functionality

Cito PHP will replace the index.php?route=some/page with whatever url you choose (e.g. example.com/your_page_here). This is done by matching the route parameter with a specific keyword in the database. You can reference the same route multiple times by adding a parameter (page id). This page id is stored in the Document object. It's purpose is to manage dynamic pages (e.g. a blog page). As an example the pid (page id) would reference the primary key of the blog table in your database. As the controller loads for the blog page you could access the page id via $this->document->url_id.

####Enable SEO Friendly URLs

To enable SEO friendly URLs you will set the following contstant to 1 on index.php in the root of your project. Then follow the remaining steps below.

```
define('URL_ALIAS', '0');
```

####.HTACCESS

You will need to remove the # on the following lines in the .HTACCESS file. If your project is in a subdirectory you will need to modify the RewriteBase to reflect your development environment. For example, if you were developing at localhost/cito-php your RewriteBase would be /cito-php/. If you were at example.com/another-example your RewriteBase would be /another-example/.

```
#Turn Rewrite Engine On
#RewriteEngine on

#RewriteBase /
#RewriteCond %{REQUEST_FILENAME} !-f
#RewriteCond %{REQUEST_FILENAME} !-d
#RewriteCond %{REQUEST_URI} !.*\.(ico|gif|jpg|jpeg|png|js|css)
#RewriteRule ^([^?]*) index.php?_route_=$1 [L,QSA]
```

####PHP

Aside from setting the URL_ALIAS constant to 1 there isn't anything else you need to do to enable SEO friendly URLs. However, there is some additional work as you use them.

To use SEO friendly URLs you will need to call get_url method to match the route to a specific keyword. You will call this method in the controller of the page with a link to another internal page. The line below was used on the homepage to link to this page.

```
$this->data['seo_link'] = $this->get_url('example/seo');
```

This link is available on the view via echo $seo_link. It will display a fully qualified link (http://www.example.com/seo_friendly_urls). You can also use getUrl to display links that are not seo friendly. If the URL_ALIAS constant is set to 0 this would return http://www.example.com/index.php?route=example/seo.

If you are building a dynamic page, like a blog you'll also include the page id as a parameter. The example below would link to blog.php in controller/blog. It would also set the page id to 123. On the blog controller you could then access this page id via $this->document->url_id.

```
$this->data['seo_link'] = $this->get_url('blog/blog', '123');
```

Additional parameters can be passed via a third argument.

```
$args = Array(
    "foo" => "bar",
    "bar" => "foo",
);

$this->data['seo_link'] = $this->get_url('blog/blog', '123', '$args');
```

Additional parameters can be added via an associative array or a string ("?foo=bar&bar=foo").

####MySQL

SEO URLs are dependent on a url_alias database table. This table is used to match the route parameter to the seo friendly keyword. The url_alias table structure can be found below. Copy the section below to upload the url_alias table and some sample links.

```
--
-- Table structure for table `url_alias`
--

CREATE TABLE IF NOT EXISTS `url_alias` (
  `url_alias_id` bigint(20) NOT NULL AUTO_INCREMENT,
  `query` varchar(255) NOT NULL,
  `parameter` varchar(255) NOT NULL,
  `keyword` varchar(255) NOT NULL,
  PRIMARY KEY (`url_alias_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=9 ;

--
-- Dumping data for table `url_alias`
--

INSERT INTO `url_alias` (`url_alias_id`, `query`, `parameter`, `keyword`) VALUES
(1, 'example/page', '', 'example'),
(2, 'common/home', '', ''),
(3, 'error/error', '', 'error'),
(4, 'example/seo', '', 'seo_friendly_urls');
```

####Errors

Errors are logged in the error.txt document at the root of the project.

```
<?php  $log->write($log->getPage(), 'Error Message Goes Here');   ?>
```

####Model

To begin open index.php at the root of the project. Change DB_DRIVER, DB_HOSTNAME, DB_USERNAME, DB_PASSWORD, DB_DATABASE to reflect your environment.

On the controller you need to load the model then make the call to the method.

```
//Load the model
$model = $this->document->loadModel('example/page');

//Call method
$data = $model->getData();

//Prepare data for view
foreach ($data->rows as $row) {
    $this->data['yourdata'][$row['a_id']] = $row['example'];
}
```

The data is looped and added to a data array. $this->data represents the information being passed to the view. In this example you will have a variable $yourdata available on the view.

####View

The view is the often the most simple document. If you have included the header and footer as children in the controller you simple echo these at the top and bottom of your view.

```
<?php echo $common_header; ?>
Your info here.
<?php echo $common_footer; ?>
```

####Controller

The controller is often the most complex document you'll work with. From the controller you will call the model, handle the logical operations, set the view and render the page.

The class of the controller must be named after the directory and file name. For example:

```
class ControllerCommonHome extends Controller {
```

This is the class name for the home.php in /controller/common directory.

There is always a method required for a page.

```
public function index() {
```

The default method will always be index.

To call another method from the uri simply add a third parameter to the route. For example, index.php?route=example/page/testing. This would call the testing method on the /controller/example/page.php document. Because the default method is index this page index.php?route=common/home is the same as index.php?route=common/home/index.

####Children

You will likely be passing data between your controller and the children. You'll likely pass the title, meta description, meta keywords, etc...

```
//Pass variables to children
$this->child_data = array();

//Set up all the data to pass to the header
$header_data = array();
$header_data['title'] = 'Cito PHP | Lightweight PHP MVC Framework';

//Push the header data to pass to the child controller classes
$this->child_data['common/header'] = $header_data;
```

####Variables

```
$this->data['example'] = 'Text';
```

This will be available as $example on the view.

```
echo $example;
```

####Template and Render

```
if (file_exists(DIR_ROOT . '/view/template/common/home.php')) {
    $this->template = 'common/home.php';
} else {
    $this->template = 'error/error.php';
}
```

This section checks and sets the view. You likely won't have any need to modify anything in this section aside from the last directory and the filename.

```
$this->children = array(
    'common/header',
    'common/footer'
);
```

If you would like the header, footer, and any other children available. You will need to declare them in this section. The forward slash is replaced by an underscore on the view.

```
<?php  echo $common_header;  ?>
```

The last line of the index method is to render the page.

```
return $this->render();
```

If you have created another method you could also return the data rather than render the page. This could be to validate a form or provide additional data for a user.

####Contributions

Parts of this project are not unique and can be found among other popular php frameworks. I have utilized several popular frameworks, removed unnecessary bloat, and modified the project as necessary.






