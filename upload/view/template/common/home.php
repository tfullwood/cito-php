<?php echo $common_header; ?>
<h1>Cito PHP - A lightweight PHP MVC Framework</h1>

<h2>Intro</h2>
<p>Cito PHP is a lightweight and flexible PHP MVC framework. Most PHP frameworks are overkill. Cito PHP is a barebones framework that is just over 30kb for the entire project.</p>

<h2>Documentation</h2>

<h3>Getting Started</h3>
<p>To get started open index.php at the root of the project. Find the two lines below and change to reflect your development environment. HTTP_SERVER is the location of your website, for local testing use http://localhost. The REWRITE_BASE is used if your project is in a subdirectory. For example, example.com/citophp or localhost/citophp. Finally the DIR_ROOT is the path to the project directory.</p>

<pre style="background-color:#EBEBEB;padding: 15px 5px;">
define('HTTP_SERVER', 'www.example.com');
define('REWRITE_BASE', '');
define('DIR_ROOT', '/var/www/html/example/');
</pre>

<p>If you intend to use a database you will need to provide your database information on the following lines.</p>

<pre style="background-color:#EBEBEB;padding: 15px 5px;">
//define('DB_DRIVER', 'mysqli');
//define('DB_HOSTNAME', 'localhost');
//define('DB_USERNAME', 'admin');
//define('DB_PASSWORD', 'password');
//define('DB_DATABASE', 'database');
</pre>

<h3>Structure</h3>

<h4>MVC</h4>
<p>MVC - Model, View, Controller. The model represents the application core (the data), the view displays the data, and the controller handles the business logic. If you're not familiar with MVC, Google it there are plenty of useful articles on the subject.</p>

<h4>Index</h4>
<p>The index.php document at the root of the project isn't a typical index page. It is use to define classes and get the data to display all pages. Different pages are called via the route parameter. For example, www.example.com/index.php?route=directory/page.</p>

<h4>Route Parameter</h4>
<p>The route parameter can contain two or three arguments. The first is the directory; this is looking for a subdirectory in the controller directory. The second argument will look for a specific document within the stated directory. The thrid and optional argument is for a specific method. If this is left blank it will call the index method by default.</p>

<p><b>Example:</b></p>
<pre style="background-color:#EBEBEB;padding: 15px 5px;">
&lt;form action=&quot;index.php?route=common/home/form&quot;&gt;
</pre>

<p>Above example will call the form method in the /controller/common/home.php controller document. More information about the route parameter and documentation for creating new pages can be <a href="<?php echo $example_link; ?>">found here</a>.</p>

<h3>SEO URLs</h3>

<p>Cito PHP has the option to enable SEO friendly URLs. SEO friendly URLs will replace the route parameter in the url with whatever you choose. To enable this you will need to have your database configured and add an additional table to hold the keywords. Steps to enable can be found <a href="<?php echo $seo_link; ?>">here</a>.</p>

<h3>Errors</h3>
<p>Errors are logged in the error.txt document at the root of the project.</p>

<pre style="background-color:#EBEBEB;padding: 15px 5px;">
&lt;?php &nbsp;$log->write($log->getPage(), 'Error Message Goes Here'); &nbsp; ?&gt;
</pre>

<h3>Model</h3>
<p>To begin open index.php at the root of the project. Change DB_DRIVER, DB_HOSTNAME, DB_USERNAME, DB_PASSWORD, DB_DATABASE to reflect your environment.</p>

<p>On the controller you need to load the model then make the call to the method.</p>

<pre style="background-color:#EBEBEB;padding: 15px 5px;">
//Load the model
$model = $this->document->loadModel('example/page');

//Call method
$data = $model->getData();

//Prepare data for view
foreach ($data->rows as $row) {
    $this->data['yourdata'][$row['a_id']] = $row['example'];
}
</pre>

<p>The data is looped and added to a data array. $this->data represents the information being passed to the view. In this example you will have a variable $yourdata available on the view.</p>

<h3>View</h3>
<p>The view is the often the most simple document. If you have included the header and footer as children in the controller you simple echo these at the top and bottom of your view.</p>

<pre style="background-color:#EBEBEB;padding: 15px 5px;">
&lt;?php echo $common_header; ?&gt;
Your info here.
&lt;?php echo $common_footer; ?&gt;
</pre>


<h3>Controller</h3>
<p>The controller is often the most complex document you'll work with. From the controller you will call the model, handle the logical operations, set the view and render the page.</p>

<p>The class of the controller must be named after the directory and file name. For example:</p>

<pre style="background-color:#EBEBEB;padding: 15px 5px;">
class ControllerCommonHome extends Controller {
</pre>

<p>This is the class name for the home.php in /controller/common directory.</p>

<p>There is always a method required for a page.</p>

<pre style="background-color:#EBEBEB;padding: 15px 5px;">
public function index() {
</pre>

<p>The default method will always be index.</p>

<p>To call another method from the uri simply add a third parameter to the route. For example, index.php?route=example/page/testing. This would call the testing method on the /controller/example/page.php document. Because the default method is index this page index.php?route=common/home is the same as index.php?route=common/home/index.</p>

<h4>Children</h4>
<p>You will likely be passing data between your controller and the children. You'll likely pass the title, meta description, meta keywords, etc...</p>

<pre style="background-color:#EBEBEB;padding: 15px 5px;">
//Pass variables to children
$this->child_data = array();

//Set up all the data to pass to the header
$header_data = array();
$header_data['title'] = 'Cito PHP | Lightweight PHP MVC Framework';

//Push the header data to pass to the child controller classes
$this->child_data['common/header'] = $header_data;
</pre>

<h4>Variables</h4>

<pre style="background-color:#EBEBEB;padding: 15px 5px;">
$this->data['example'] = 'Text';
</pre>

<p>This will be available as $example on the view.</p>

<pre style="background-color:#EBEBEB;padding: 15px 5px;">
echo $example;
</pre>

<h4>Template and Render</h4>

<pre style="background-color:#EBEBEB;padding: 15px 5px;">
if (file_exists(DIR_ROOT . '/view/template/common/home.php')) {
    $this->template = 'common/home.php';
} else {
    $this->template = 'error/error.php';
}
</pre>

<p>This section checks and sets the view. You likely won't have any need to modify anything in this section aside from the last directory and the filename.</p>

<pre style="background-color:#EBEBEB;padding: 15px 5px;">
$this->children = array(
    'common/header',
    'common/footer'
);
</pre>

<p>If you would like the header, footer, and any other children available. You will need to declare them in this section. The forward slash is replaced by an underscore on the view.</p>

<pre style="background-color:#EBEBEB;padding: 15px 5px;">
&lt;?php  echo $common_header;  ?&gt;
</pre>

<p>The last line of the index method is most likely to render the page.</p>

<pre style="background-color:#EBEBEB;padding: 15px 5px;">
return $this->render();
</pre>

<p>If you have created another method you could also return the data rather than render the page. This could be to validate a form or provide additional data for a user.</p>

<h3>Contributions</h3>

<p>Parts of this project are not unique and can be found among other popular php frameworks. I have utilized several popular frameworks, removed unnecessary bloat, and modified the project as necessary.</p>

<?php echo $common_footer; ?>