# Mailchimp PHP API #

## Why this class ##

I was searching for a good PHP5 class, one without PHP4 support. One that use cURL.
With this API I wanted to give users the chance to decide in wich format they want their results and support some basic methods and
the more advanced are possible with the custom query.

## How to use ##

### Setting API-key and default return format ###

    <?php
	    include('mailchimp.php');
	    
	    // set the API-key
	    Mailchimp::setApikey('API-key'); // change 'API-key' with yours
	    
	    // set the default return format
	    // default is set to Mailchimp::JSON
	    Mailchimp::setFormat(Mailchimp::PHP);
	    	    
	    $params = array(
            'method' => 'listSubscribe',
            'id' => '*******',
            'email_address' => 'example@example.com',
            'merge_vars' => array(
                'FIRSTNAME' => 'My firstname',
                'LASTNAME' => 'My lastname',
            ),
            'updating_existing' => TRUE,
	    );
	    
	    $results = Mailchimp::makeCall($params);
	?>
	
### Setting it all together in one request ###

    <?php
	    include('flickr.php');
	    
	    $result = Mailchimp::makeCall(array(
						'method' => 'listSubscribe',
						'id' => 'a65f016aa1',
						'email_address' => $params['email'],
						'merge_vars' => array(
							'FIRSTNAME' => $params['firstname'],
							'LASTNAME' => $params['lastname'],
						),
						'updating_existing' => TRUE,
					));
	    $params = array(
	        'apikey' => 'API-key',
	        'output' => Mailchimp::XML,
	        'method' => 'listSubscribe',
            'id' => '*********',
            'email_address' => 'myemail@example.com',
            'merge_vars' => array(
                'FIRSTNAME' => 'my firstname',
                'LASTNAME' => 'my lastname',
            ),
            'updating_existing' => TRUE,
	    );
	    
	    $results = Mailchimp::makeCall($params);
	?>

## Issues/Bugs ##

If you find one, please inform us with the issue tracker on [github](http://github.com/glamorous/Mailchimp-PHP-API/issues).

## Changelog ##

**Mailchimp 0.5.1 - 02/05/2010**

- [bug] deleted CURLOPT_FOLLOWLOCATION that causes errors on shared webhosting

**Mailchimp 0.5 - 13/04/2010**

- Initial version of the PHP-wrapper without documentation 

## Feature Requests / To come ##

If you want something to add on this plugin, feel free to fork the project on [github](http://github.com/glamorous/Mailchimp-PHP-API) or add an [issue](http://github.com/glamorous/Mailchimp-PHP-API/issues) as a feature request.

## License ##

This plugin has a [BSD License](http://www.opensource.org/licenses/bsd-license.php). You can find the license in license.txt that is included with class-package