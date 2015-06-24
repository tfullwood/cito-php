#Cito PHP - A Lightweight PHP MVC Framework

##Intro

Cito PHP is a lightweight and flexible PHP MVC framework. Most PHP frameworks are overkill. Cito PHP is a barebones framework that is under 20kb for the entire project.

##Documentation

###Getting Started

To get started open index.php at the root of the project. Find the two lines below and change to reflect your development environment.

```
define('HTTP_SERVER', 'www.example.com');
define('DIR_ROOT', '/var/www/html/example/');
```

If you intend to use a database you will need to define the database constants and uncomment the following line.

```
//$db = new Db(DB_HOSTNAME, DB_USERNAME, DB_PASSWORD, DB_DATABASE);
```

###Structure

####MVC

MVC - Model, View, Controller. The model represents the application core (the data), the view displays the data, and the controller handles the business logic. If you're not familiar with MVC Google it there are plenty of useful articles on the subject.

####Index

The index.php document at the root of the project isn't a typical index page. It is use to define classes and get the data to display all pages. Different pages are called via the route parameter. For example, www.example.com/index.php?route=directory/page.

####Route Parameter

The route parameter can contain two or three arguments. The first is the directory; this is looking for a subdirectory in the controller directory. The second argument will look for a specific document within the stated directory. The thrid and optional argument is for a specific method. If this is left blank it will call the index method by default.

####Example:

```
<form action="index.php?route=common/home/form">
```

Above example will call the form method in the /controller/common/home.php controller document.

To create a new page duplicate the example.php in the /controller/example directory and name the new document. Create a new directory and move the file to this directory. Your route parameter will be the directory followed by a forward slash and the file name (without the file extension).

```
route=directory/file
```

Change the name of the class ControllerExamplePage. This follows the same structure as the route parameter. Each directory or page is camelcase. If you have a directory with two words only capitalize the first. For example, if your directory is named your-directory and the page is named example your class name would be ControllerYourdirectoryExample.

You will also change the view. Locate the following line:

```
if (file_exists(DIR_ROOT . '/view/template/example/page.php')) {
```

Change the "example" directory and the file name.

Once you've finished these changes to the controller navigate to the view and duplicate one of the view files. Create a directory and rename the file, and make sure this path and file match the path and file saved in the controller above. This page should now be functional.

####Errors

Errors are logged in the error.txt document at the root of the project.

```
<?php  $log->write($log->getPage(), 'Error Message Goes Here');   ?>
```

####Model

To begin open index.php at the root of the project. Change DB_DRIVER, DB_HOSTNAME, DB_USERNAME, DB_PASSWORD, DB_DATABASE and uncomment the following line.

```
$db = new Db(DB_HOSTNAME, DB_USERNAME, DB_PASSWORD, DB_DATABASE);
```

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

There is always on method required for a page

```
public function index() {
```

The default function will always be index. As a result index.php?route=common/home is the same as index.php?route=common/home/index.

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

The last line of the index method is most likely to render the page.

```
return $this->render();
```

If you have created another method you could also return the data rather than render the page. This could be to validate a form or provide additional data for a user.

####Contributions

Most of the work in this project isn't original. I have utilized several popular frameworks, removed unnecessary bloat, and modified the project as necessary.
















