<?php echo $common_header; ?>
<h1>Cito PHP - SEO Friendly URLs</h1>

<h2>Functionality</h2>

<p>Cito PHP will replace the index.php?route=some/page with whatever url you choose (e.g. example.com/your_page_here). This is done by matching the route parameter with a specific keyword in the database. You can reference the same route multiple times by adding a parameter (page id). This page id is stored in the Document object. It's purpose is to manage dynamic pages (e.g. a blog page). As an example the pid (page id) would reference the primary key of the blog table in your database. As the controller loads for the blog page you could access the page id via $this->document->url_id.</p>

<h2>Enable SEO Friendly URLs</h2>

<p>To enable SEO friendly URLs you will set the following contstant to 1 on index.php in the root of your project. Then follow the remaining steps below.</p>

<pre style="background-color:#EBEBEB;padding: 15px 5px;">
define('URL_ALIAS', '0');
</pre>

<h3>.HTACCESS</h3>

<p>You will need to remove the # on the following lines in the .HTACCESS file. If your project is in a subdirectory you will need to modify the RewriteBase to reflect your development environment. For example, if you were developing at localhost/cito-php your RewriteBase would be /cito-php/. If you were at example.com/another-example your RewriteBase would be /another-example/.</p>

<pre style="background-color:#EBEBEB;padding: 15px 5px;">
#Turn Rewrite Engine On
#RewriteEngine on

#RewriteBase /
#RewriteCond %{REQUEST_FILENAME} !-f
#RewriteCond %{REQUEST_FILENAME} !-d
#RewriteCond %{REQUEST_URI} !.*\.(ico|gif|jpg|jpeg|png|js|css)
#RewriteRule ^([^?]*) index.php?_route_=$1 [L,QSA]
</pre>

<h3>PHP</h3>

<p>Aside from setting the URL_ALIAS constant to 1 there isn't anything else you need to do to enable SEO friendly URLs. However, there is some additional work as you use them.</p>

<p>To use SEO friendly URLs you will need to call get_url method to match the route to a specific keyword. You will call this method in the controller of the page with a link to another internal page. The line below was used on the homepage to link to this page.</p>

<pre style="background-color:#EBEBEB;padding: 15px 5px;">
$this->data['seo_link'] = $this->get_url('example/seo');
</pre>

<p>This link is available on the view via echo $seo_link. It will display a fully qualified link (http://www.example.com/seo_friendly_urls). You can also use getUrl to display links that are not seo friendly. If the URL_ALIAS constant is set to 0 this would return http://www.example.com/index.php?route=example/seo.</p>

<p>If you are building a dynamic page, like a blog you'll also include the page id as a parameter. The example below would link to blog.php in controller/blog. It would also set the page id to 123. On the blog controller you could then access this page id via $this->document->url_id.</p>

<pre style="background-color:#EBEBEB;padding: 15px 5px;">
$this->data['seo_link'] = $this->get_url('blog/blog', '123');
</pre>

<p>Additional parameters can be passed via a third argument.</p>

<pre style="background-color:#EBEBEB;padding: 15px 5px;">
$args = Array(
    "foo" => "bar",
    "bar" => "foo",
);

$this->data['seo_link'] = $this->get_url('blog/blog', '123', '$args');
</pre>

<p>Additional parameters can be added via an associative array or a string ("?foo=bar&amp;bar=foo").</p>

<h3>MySQL</h3>

<p>SEO URLs are dependent on a url_alias database table. This table is used to match the route parameter to the seo friendly keyword. The url_alias table structure can be found below. Copy the section below to upload the url_alias table and some sample links.</p>

<pre style="background-color:#EBEBEB;padding: 15px 5px;">
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
</pre>

<?php echo $common_footer; ?>