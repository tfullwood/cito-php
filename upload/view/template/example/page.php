<?php echo $common_header; ?>
<h1>Cito PHP - A lightweight PHP MVC Framework</h1>

<h2>Example Page</h2>
<p>This page is used to outline the route parameter.</p>

<h3>Route Parameter</h3>
<p>To create a new page duplicate the example.php in the /controller/example directory and name the new document. Create a new directory and move the file to this directory. Your route parameter will be the directory followed by a forward slash and the file name (without the file extension).</p>

<pre style="background-color:#EBEBEB;padding: 15px 5px;">
route=directory/file
</pre>

<p>Change the name of the class ControllerExamplePage. This follows the same structure as the route parameter. Each directory or page is camelcase. If you have a directory with two words only capitalize the first. For example, if your directory is named your-directory and the page is named example your class name would be ControllerYourdirectoryExample.</p>

<p>You will also change the view. Locate the following line:</p>

<pre style="background-color:#EBEBEB;padding: 15px 5px;">
if (file_exists(DIR_ROOT . '/view/template/example/page.php')) {
</pre>

<p>Change the "example" directory and the file name.</p>

<p>Once you've finished these changes to the controller navigate to the view and duplicate one of the view files. Create a directory and rename the file, and make sure this path and file match the path and file saved in the controller above. This page should now be functional.</p>


<?php echo $common_footer; ?>