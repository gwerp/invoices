<?php
 
define('_JEXEC', 1);
 
require_once '../libraries/import.php';
 
jimport('joomla.application.cli');
 
class GWRequest extends JCli
{
 
	//Get Latest Tweet
	function getGWData( $domain, $pass )
	{
    	$url = $domain."/index.php?option=com_gwerp&view=invoices&format=json&secretkey=".$pass;
 
    	if(file_get_contents($url) == false) {
		$this->out('error');
		return;
	}
	else {
		$arr = json_decode(file_get_contents($url),true);
		foreach($arr as $item) {
   			$invoices .= "title: ". utf8_decode($item['name']) ."\n"; 
    			$invoices .= "customer: ". $item['customer'] ."\n";
    			$invoices .= "number: ". $item['number'] ."\n";
    			$invoices .= "date: ". $item['cretedate'] ."\n";
    			$invoices .= "expire: ". $item['expiredate'] ."\n";
    			$invoices .= "taxes: ". $item['taxes'] ."\n";
    			$invoices .= "subtotal: ". $item['subtotal'] ."\n";
    			$invoices .= "total: ". $item['total'] ."\n";
    			$invoices .= "status: ". $item['status'] ."\n\n";
		}
 	}
 	
    		return $invoices;
 	}
 
 
	public function execute()
	{
 
    	$this->out( 'What is your GWErp domain?' );
    	$domain = $this->in( );
 
    	$this->out( 'Which is your secret key on this domain?' );
    	$pass = $this->in( );
 
    	$invoices = $this->getGWData( $domain, $pass );
    	$this->out( $invoices );
	}
}
 
JCli::getInstance('GWRequest')->execute();
