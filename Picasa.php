<?php
	/**
	 * 
	 * SWX Picasa API
	 *
	 * @copyright	2008 BayInteractive. All Rights Reserved. 
	 * @link 	http://BayInteractive.com 
	 * 
	**/
	
	// Require base service class
	require_once("SWXml.php");

	/**
	 * SWX Picasa API using SWXml service.
	**/
	
	class Picasa extends SWXml
	{
		//////////////////////////////////////////////////////////////////////////////////////////
		//
		// Official Picasa API methods: These implement the official Picasa API.
		// See http://http://code.google.com/apis/picasaweb
		// for the full official documentation.
		//
		//////////////////////////////////////////////////////////////////////////////////////////
		
		//
		// List of non authentication methods.
		//
		
		/**
		* User-based feed http://picasaweb.google.com/data/feed/projection/user/userID/?kind=kinds
		* The user-based feed represents data associated with a particular user. A user-based feed can contain either album, or tag or photo kinds, which you can request using the kind parameter.
		*
		* @param	picasa username.
		* @param	contain either album, or tag or photo kinds.
		* @param	thumbnail size, valid values are 200, 288, 320, 400, 512, 576, 640, 720, 800.
		* 
		**/
		
		function getUserBasedFeed($userID, $kinds, $thumbsize)
		{
			$url = "http://picasaweb.google.com/data/feed/base/user/".$userID."/?kind=".$kinds."&thumbsize=".$thumbsize."&alt=rss";
			
			$response = $this->parseXML($url,"url");
			
			return $response;
		}
		
		/**
		* Contacts-based feed http://picasaweb.google.com/data/feed/projection/user/userID/contacts?kind=user
		* The contacts-based feed represents data associated with a particular user's contacts. A contacts-based feed can currently contain only entries of the kind user. It is a read-only feed.
		*
		* @param	picasa username.
		**/
		
		function getContactBasedFeed($userID)
		{
			$url = "http://picasaweb.google.com/data/feed/base/user/".$userID."/contacts?kind=user&alt=rss";
			
			$response = $this->parseXML($url,"url");
			
			return $response;
		}
		
		/**
		* Album-based feed http://picasaweb.google.com/data/feed/projection/user/userID/album/albumName?kind=kinds
		* The album-based feed represents an album and any kinds associated with the album. An album-based feed can contain either photo or tag kinds, which you can request using the kind parameter.
		*
		* @param	picasa username.
		* @param	album name.
		* @param	contain either photo or tag kinds.
		* @param	thumbnail size, valid values are 200, 288, 320, 400, 512, 576, 640, 720, 800.
		**/
		
		function getAlbumBasedFeed($userID, $albumName, $kinds,  $thumbsize)
		{
			$url = "http://picasaweb.google.com/data/feed/base/user/".$userID."/album/".$albumName."?kind=".$kinds."&thumbsize=".$thumbsize."&alt=rss";
			
			$response = $this->parseXML($url,"url");
			
			return $response;
		}
		
		/**
		* Community search feed http://picasaweb.google.com/data/feed/projection/all?q=searchTerm
		* The community search feed allows for searching all public, searchable photos. The feed is similar to that of an album-based feed.
		*
		* @param	search keyword.
		* @param	thumbnail size, valid values are 200, 288, 320, 400, 512, 576, 640, 720, 800.
		* @param	(optional)  limit the number of photos returned. Default is 20.
		* @param	(optional)  photo's tag.
		**/
		
		function getCommunitySearchFeed($searchTerm, $thumbsize, $limit = NULL, $tag = NULL)
		{	
			if($limit == NULL) $limit = 20;
			
			if($tag != NULL)
			{
				$url = "http://picasaweb.google.com/data/feed/base/all?q=".$searchTerm."&tag=".$tag."&max-results=".$limit."&thumbsize=".$thumbsize."&alt=rss";
			} else {
				$url = "http://picasaweb.google.com/data/feed/base/all?q=".$searchTerm."&max-results=".$limit."&thumbsize=".$thumbsize."&alt=rss";
			}
			
			$response = $this->parseXML($url,"url");
			
			return $response;
		}
		
		/**
		* Featured photos feed http://picasaweb.google.com/data/feed/projection/featured
		* The featured photos feed allows you to retrieve a feed of the currently featured photos on Picasa Web Albums.
		*
		* @param	thumbnail size, valid values are 200, 288, 320, 400, 512, 576, 640, 720, 800.
		* @param	(optional)  limit the number of photos returned. Default is 20.
		**/
		
		function getFeaturedPhotosFeed($thumbsize, $limit = NULL)
		{	
			if($limit == NULL) $limit = 20;
			
			$url = "http://picasaweb.google.com/data/feed/base/featured?max-results=".$limit."&thumbsize=".$thumbsize."&alt=rss";
			
			$response = $this->parseXML($url,"url");
			
			return $response;
		}
		
		/**
		* Get list of albums
		* Feed includes some or all of the albums the specified user has in their gallery. Which albums are returned depends on the visibility value specified.
		* @param	picasa username.
		* @param	thumbnail size, valid values are 200, 288, 320, 400, 512, 576, 640, 720, 800.
		* 
		**/
		
		function getAlbums($userID, $thumbsize)
		{	
			$kinds = "album";
			
			$url = "http://picasaweb.google.com/data/feed/base/user/".$userID."?kind=".$kinds."&thumbsize=".$thumbsize."&alt=rss";
			
			$response = $this->parseXML($url,"url");
			
			return $response;
		}
		
		/**
		* Get list of photos
		* Feed includes the photos in an album (album-based), recent photos uploaded by a user (user-based) or photos uploaded by all users (community search).
		* @param	picasa username.
		* @param	thumbnail size, valid values are 200, 288, 320, 400, 512, 576, 640, 720, 800.
		* @param	(optional)  limit the number of photos returned. Default is 20.
		**/
		
		function getPhotos($userID, $thumbsize, $limit = NULL)
		{
			if($limit == NULL) $limit = 20;
			
			$kinds = "photo";
			
			$url = "http://picasaweb.google.com/data/feed/base/user/".$userID."?kind=".$kinds."&max-results=".$limit."&thumbsize=".$thumbsize."&alt=rss";
			
			$response = $this->parseXML($url,"url");
			
			return $response;
		}
		
		/**
		* Get list of photos by comments
		* Feed includes the comments that have been made on a photo.
		* @param	picasa username.
		* @param	thumbnail size, valid values are 200, 288, 320, 400, 512, 576, 640, 720, 800.
		* @param	(optional)  limit the number of photos returned. Default is 20.
		**/
	
		function getComments($userID, $thumbsize, $limit = NULL)
		{
			if($limit == NULL) $limit = 20;
			
			$kinds = "comment";
			
			$url = "http://picasaweb.google.com/data/feed/base/user/".$userID."?kind=".$kinds."&max-results=".$limit."&thumbsize=".$thumbsize."&alt=rss";
			
			$response = $this->parseXML($url,"url");
			
			return $response;
		}
		
		/**
		* Get list of photo by tags
		* Includes all tags associated with the specified user, album, or photo. For user-based and album-based feeds, the tags include a weight value indicating how often they occurred.
		* @param	picasa username.
		* @param	(optional)  limit the number of photos returned. Default is 20.
		**/
		
		function getTags($userID, $limit = NULL)
		{
			if($limit == NULL) $limit = 20;
			
			$kinds = "tag";
			
			$url = "http://picasaweb.google.com/data/feed/base/user/".$userID."?kind=".$kinds."&max-results=".$limit."&alt=rss";
			
			$response = $this->parseXML($url,"url");
			
			return $response;
		}
		
		/**
		* Get authentication token
		* Your application must reference this token in each request to the Google service for this user.
		* @param	user email
		* @param	user password.
		* 
		**/
		
		function getAuthentication($email, $passwd)
		{
			$ch = curl_init();  
  
  			$url = "https://www.google.com/accounts/ClientLogin";
			curl_setopt($ch, CURLOPT_URL, $url);  
			curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);  
  
			$data = array('accountType' => 'GOOGLE',  
					  'Email' => $email,  
					  'Passwd' => $passwd,
					  'service'=>'lh2',  
					  'source'=>'Bayinteractive-PicasaProxy-1.0');  
      
			curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0); 
			curl_setopt($ch, CURLOPT_POST, true);  
			curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);  
			curl_setopt($ch, CURLOPT_POSTFIELDS, $data);  
			  
			$result = curl_exec($ch);
			curl_close($ch); 
			
			$vars =  explode("\n", $result);
			
			if($vars[0] == "Error=BadAuthentication")
			{
			
				$xml = "<token>Username or password is not recognized</token>";
				
			} else if($vars[0] == "Error=NotVerified")
			{
			
				$xml = "<token>The account email address has not been verified</token>";
				
			} else if($vars[0] == "Error=TermsNotAgreed")
			{
				
				$xml = "<token>User has not agreed to terms</token>";
				
			} else if($vars[0] == "Error=AccountDeleted")
			{
				
				$xml = "<token>User account has been deleted</token>";
				
			} else if($vars[0] == "Error=AccountDisabled")
			{
				
				$xml = "<token>User account has been disabled.</token>";
				
			} else if($vars[0] == "Error=ServiceDisabled")
			{
				
				$xml = "<token>User's access to the specified service has been disabled</token>";
				
			} else if($vars[0] == "Error=ServiceUnavailable")
			{
				
				$xml = "<token>The service is not available; try again later.</token>";
				
			} else if($vars[2] == "Error=CaptchaRequired")
			{
				
				$xml = "<captcha>";
				
				$captchaToken = explode("CaptchaToken=", $vars[0]);
				$xml .= "<CaptchaToken><![CDATA[".$captchaToken[1]."]]></CaptchaToken>";
				
				$captchaUrl = explode("CaptchaUrl=", $vars[1]);
				$xml .= "<CaptchaUrl><![CDATA[".$captchaUrl[1]."]]></CaptchaUrl>";
				
				$uri = explode("Url=", $vars[3]);
				$xml .= "<Url><![CDATA[".$uri[1]."]]></Url>";
				
				$xml .= "</captcha>";
				
			} else {
				
				$token = explode("Auth=", $vars[2]);
			
				$xml = "<token>".$token[1]."</token>";
			}
			
			$response = $this->parseXML($xml,"string");
			
			return $response;
		}
		
		//
		// List of authentication methods.
		//
		
		/**
		* User-based feed http://picasaweb.google.com/data/feed/projection/user/userID/?kind=kinds
		* The user-based feed represents data associated with a particular user. A user-based feed can contain either album, or tag or photo kinds, which you can request using the kind parameter.
		*
		* @param	picasa username.
		* @param	authentication token.
		* @param	contain either album, or tag or photo kinds.
		* @param	thumbnail size, valid values are 200, 288, 320, 400, 512, 576, 640, 720, 800.
		**/
		
		function getUserBasedFeedAuth($userID, $token, $kinds, $thumbsize)
		{			
			$url = "http://picasaweb.google.com/data/feed/api/user/".$userID."/?kind=".$kinds."&thumbsize=".$thumbsize."&alt=rss";
			
			$header[] = "Authorization: GoogleLogin auth=".$token;

			$ch = curl_init();  
			curl_setopt($ch, CURLOPT_HTTPHEADER, $header);  
			curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);  
			curl_setopt($ch, CURLOPT_HEADER, false);
			curl_setopt($ch, CURLOPT_URL, $url);   
			  
			$result = curl_exec($ch);  
			curl_close($ch);

			$response = $this->parseXML($result,"string");
			
			return $response;
		}
		
		/**
		* Get list of albums
		* Feed includes some or all of the albums the specified user has in their gallery. Which albums are returned depends on the visibility value specified.
		* @param	picasa username.
		* @param	authentication token.
		* @param	thumbnail size, valid values are 200, 288, 320, 400, 512, 576, 640, 720, 800.
		**/
		
		function getAlbumsAuth($userID, $token, $thumbsize)
		{	
			$kinds = "album";
			
			$url = "http://picasaweb.google.com/data/feed/api/user/".$userID."?kind=".$kinds."&thumbsize=".$thumbsize."&alt=rss&Auth=".$token;
			
			$header[] = "Authorization: GoogleLogin auth=".$token;

			$ch = curl_init();  
			curl_setopt($ch, CURLOPT_HTTPHEADER, $header);  
			curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);  
			curl_setopt($ch, CURLOPT_HEADER, false);
			curl_setopt($ch, CURLOPT_URL, $url);   
			  
			$result = curl_exec($ch);  
			curl_close($ch);

			$response = $this->parseXML($result,"string");
			
			return $response;
		}
		
		/**
		* Get list of photos
		* Feed includes the photos in an album (album-based), recent photos uploaded by a user (user-based) or photos uploaded by all users (community search).
		* @param	picasa username.
		* @param	authentication token.
		* @param	thumbnail size, valid values are 200, 288, 320, 400, 512, 576, 640, 720, 800.
		* @param	(optional)  limit the number of photos returned. Default is 20.
		* @param	(optional)  base projection always read-only and an api projection for read/write if authenticated user is owner of the content. Default value is base.
		* 
		**/
		
		function getPhotosAuth($userID, $token, $thumbsize, $limit = NULL)
		{
			if($limit == NULL) $limit = 20;
			
			$kinds = "photo";
			
			$url = "http://picasaweb.google.com/data/feed/api/user/".$userID."?kind=".$kinds."&max-results=".$limit."&thumbsize=".$thumbsize."&alt=rss";
	
			$header[] = "Authorization: GoogleLogin auth=".$token;

			$ch = curl_init();  
			curl_setopt($ch, CURLOPT_HTTPHEADER, $header);  
			curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);  
			curl_setopt($ch, CURLOPT_HEADER, false);
			curl_setopt($ch, CURLOPT_URL, $url);   
			  
			$result = curl_exec($ch);  
			curl_close($ch);

			$response = $this->parseXML($result,"string");
			
			return $response;
		}
		
		/**
		* Get list of photos by comments
		* Feed includes the comments that have been made on a photo.
		* @param	picasa username.
		* @param	authentication token.
		* @param	thumbnail size, valid values are 200, 288, 320, 400, 512, 576, 640, 720, 800.
		* @param	(optional)  limit the number of photos returned. Default is 20.
		**/
	
		function getCommentsAuth($userID, $token, $thumbsize, $limit = NULL)
		{
			if($limit == NULL) $limit = 20;
			
			$kinds = "comment";
			
			$url = "http://picasaweb.google.com/data/feed/api/user/".$userID."?kind=".$kinds."&max-results=".$limit."&thumbsize=".$thumbsize."&alt=rss";
			
			$header[] = "Authorization: GoogleLogin auth=".$token;

			$ch = curl_init();  
			curl_setopt($ch, CURLOPT_HTTPHEADER, $header);  
			curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);  
			curl_setopt($ch, CURLOPT_HEADER, false);
			curl_setopt($ch, CURLOPT_URL, $url);   
			  
			$result = curl_exec($ch);  
			curl_close($ch);

			$response = $this->parseXML($result,"string");
			
			return $response;
		}
		
		
		/**
		* Get list of shared albums
		* Feed includes some or all of the albums the specified user has in their gallery. Which albums are returned depends on the visibility value specified.
		* @param	picasa username.
		* @param	authentication key.
		* @param	thumbnail size, valid values are 200, 288, 320, 400, 512, 576, 640, 720, 800.
		**/
		
		function getAlbumsAuthkey($userID, $authkey, $thumbsize)
		{	
			$kinds = "album";
			
			$url = "http://picasaweb.google.com/data/feed/api/user/".$userID."?kind=".$kinds."&thumbsize=".$thumbsize."&alt=rss&authkey=".$authkey;
			
			/*$header[] = "";

			$ch = curl_init();  
			curl_setopt($ch, CURLOPT_HTTPHEADER, $header);  
			curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);  
			curl_setopt($ch, CURLOPT_HEADER, false);
			curl_setopt($ch, CURLOPT_URL, $url);   
			  
			$result = curl_exec($ch);  
			curl_close($ch);

			$response = $this->parseXML($result,"string");*/
			$response = $this->parseXML($url,"url");
			
			return $response;
		}
		
		/**
		* Get list of shared photos
		* Feed includes the photos in an album (album-based), recent photos uploaded by a user (user-based) or photos uploaded by all users (community search).
		* @param	picasa username.
		* @param	album id.
		* @param	authentication key.
		* @param	thumbnail size, valid values are 200, 288, 320, 400, 512, 576, 640, 720, 800.
		* @param	(optional)  base projection always read-only and an api projection for read/write if authenticated user is owner of the content. Default value is base.
		* 
		**/
		
		function getPhotosAuthkey($userID, $albumID, $authkey, $thumbsize)
		{
			//if($limit == NULL) $limit = 20;
			
			$kinds = "photo";
			
			$url = "http://picasaweb.google.com/data/feed/base/user/".$userID."/albumid/".$albumID."?kind=".$kinds."&thumbsize=".$thumbsize."&alt=rss&authkey=".$authkey;
			
			/*$header[] = "";

			$ch = curl_init();  
			curl_setopt($ch, CURLOPT_HTTPHEADER, $header);  
			curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);  
			curl_setopt($ch, CURLOPT_HEADER, false);
			curl_setopt($ch, CURLOPT_URL, $url);   
			  
			$result = curl_exec($ch);  
			curl_close($ch);
			$response = $this->parseXML($result,"string");*/

			$response = $this->parseXML($url,"url");
			
			return $response;
		}
		
		/**
		* Get list of shared photos by comments
		* Feed includes the comments that have been made on a photo.
		* @param	picasa username.
		* @param	authentication key.
		* @param	thumbnail size, valid values are 200, 288, 320, 400, 512, 576, 640, 720, 800.
		* @param	(optional)  limit the number of photos returned. Default is 20.
		**/
	
		function getCommentsAuthkey($userID, $authkey, $thumbsize, $limit = NULL)
		{
			if($limit == NULL) $limit = 20;
			
			$kinds = "comment";
			
			$url = "http://picasaweb.google.com/data/feed/api/user/".$userID."?kind=".$kinds."&max-results=".$limit."&thumbsize=".$thumbsize."&alt=rss&authkey=".$authkey;
			
			/*$header[] = "";

			$ch = curl_init();  
			curl_setopt($ch, CURLOPT_HTTPHEADER, $header);  
			curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);  
			curl_setopt($ch, CURLOPT_HEADER, false);
			curl_setopt($ch, CURLOPT_URL, $url);   
			  
			$result = curl_exec($ch);  
			curl_close($ch);

			$response = $this->parseXML($result,"string");*/
			$response = $this->parseXML($url,"url");
			
			return $response;
		}
		
		
		/**
		* Parse Invitation Email from Picasa
		**/
		
		function getEmail()
		{
			// Require DB & Email Config
			require_once("../lib/picasa/receivemail.class.php");
			require_once("../lib/picasa/config.php");
	
			// Create an instance of ADO connection object
			$conn = new COM ("ADODB.Connection") or die("Cannot start ADO");

			// Define connection string, specify database driver
			$connStr = "PROVIDER=SQLOLEDB;SERVER=".$server.";UID=".$username.";PWD=".$passwd.";DATABASE=".$db; 
			$conn->open($connStr); //Open the connection to the database

			// Create Object For reciveMail Class
			$obj= new receiveMail($uemail,$pemail,$email,$eserver,$etype,$eport);
			//Connect to the Mail Box
			$obj->connect();
			// Get Total Number of Unread Email in mail box
			$total = $obj->getTotalMails(); //Total Mails in Inbox Return integer value
			
			$emailArray = array();	
			
			for($i=1;$i<=$total;$i++)
			{
				$content = $obj->getBody($i);
				$lines = preg_split("/\r?\n|\r/", $content); // turn the content into rows
				$links_regex = '#<a[^/>]*'.'href=["|\']([^javascript:].*)["|\']#Ui'; //regular expression to extract url from html links
				$searchString = $lines[31]; // check if line number 31 contains a link.
				$findString   = "<a href";
				$pos = strpos($searchString, $findString);
				
				if ($pos === false)
				{
					preg_match_all($links_regex, $lines[35], $out, PREG_PATTERN_ORDER); //if line 31 did not contains link than use line 35 to process regex
				} else {
					preg_match_all($links_regex, $lines[31], $out, PREG_PATTERN_ORDER); //use line 31 to process regex
				}
				
				$emailItem = array();
				$vars = explode("?", $out[1][0]);
				$splitVars = explode("&", $vars[1]);
				
				for($j=0;$j<4;$j++)
				{
					array_push($emailItem, $this->_getVal($splitVars[$j]));
				}
	
				array_push($emailArray, $emailItem);
				//declare the SQL statement that will query the database
				$query = "INSERT INTO tbl_picasa ( username, type, type_id, authkey ) 
								VALUES ( '".$this->_getVal($splitVars[0])."', '".$this->_getVal($splitVars[1])."', '".$this->_getVal($splitVars[2])."', '".$this->_getVal($splitVars[3])."' )";
				//print_r($query);
			
				//execute the SQL statement and return records
				$rs = $conn->execute($query);
				
				$obj->deleteMails($i); // Delete Mail from Mail box
			}
			$obj->close_mailbox();   //Close Mail Box
			if($total > 0)
			{			
				return $emailArray;
			} else {
				return $total;
			}
		}
		
		
		/**
		* Get Invitation List from database
		**/
		
		function getInvitationList()
		{
			// Require DB Config
			require_once("../lib/picasa/config.php");
	
			// Records Array
			$allRec = array();
			// Create an instance of ADO connection object
			$conn = new COM ("ADODB.Connection") or die("Cannot start ADO");

			// Define connection string, specify database driver
			$connStr = "PROVIDER=SQLOLEDB;SERVER=".$server.";UID=".$username.";PWD=".$passwd.";DATABASE=".$db; 
			$conn->open($connStr); //Open the connection to the database

			//SQL statement that will query the database
			$query = "SELECT * FROM tbl_picasa";
			
			//execute SQL statement and return records
			$rs = $conn->execute($query);
			
			$num_columns = $rs->Fields->Count();  
			
			for ($i=0; $i < $num_columns; $i++) {
				$fld[$i] = $rs->Fields($i);
			}
			
			while (!$rs->EOF)  //looping through while there are records
			{
				$rec = array();
				for ($i=0; $i < $num_columns; $i++) 
				{
					array_push($rec, $fld[$i]->value);
				}
				array_push($allRec, $rec);
				$rs->MoveNext(); //move on to the next record
			}
			
			//close the connection and recordset objects freeing up resources 
			$rs->Close();
			$conn->Close();
			
			$rs = null;
			$conn = null;
			
			return $allRec;
		}
		
		
		/**
	 	* (private function) _getVal
	 	*
	 	* @param	string
	 	* 
	 	* @return 
		 **/
		
		function _getVal($str)
		{
			$val = explode("=", $str);
			return $val[1];
		}
	}
?>