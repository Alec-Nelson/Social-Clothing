<?php

include_once '../global.php';

// get the identifier for the page we want to load
$action = $_GET['action'];

// instantiate a SiteController and route it
$sc = new SiteController();
$sc->route($action);

class SiteController {

	// route us to the appropriate class method for this action
	public function route($action) {
		switch($action) {
			case 'home':
				$this->home();
				break;

			case 'signup':
				$this->signup();
				break;

			case 'about':
				$this->about();
				break;
			case 'login':
				$this->login();
				break;

			case 'logout':
				$this->logout();
				break;

			case 'signupUser':
				$this->signupUser();
				break;

			case 'settings':
				$this->settings();
				break;

			case 'settingsChange':
				$this->settingsChange();
				break;

			case 'settingsDelete':
				$this->settingsDelete();
				break;

			case 'settingsConfirm':
				$this->settingsConfirm();
				break;



      case 'signupCheck':
        $this->signupCheck();
        break;


      case 'addclothes':
        $this->addclothes();
        break;

      case 'getclothing':
      	$this->getClothing();
      	break;

      case 'ban':
        $this->ban();
        break;

      case 'addclothesSubmit':
        $this->addclothesSubmit();
        break;

      case 'posts':
        $this->posts();
        break;

      case 'postsSubmit':
        $this->postsSubmit();
        break;

				case 'profileJson':
                $user_id = $_GET['user_id'];
					$this->profileJson($user_id);
					break;

        case 'clothes':
        $user_id = $_GET['user_id'];
        $this->clothes($user_id);
        break;

        case 'deleteClothesSubmit':
				$this->deleteClothing();
				break;
		case 'updateClothesSubmit':
			$this->updateClothing();
			break;
        }

	}


	//takes user to log in page
    public function home() {
    	$pageTitle = 'Log in';
    	if( isset($_SESSION['username']) && $_SESSION['username'] != '')
		{
    	$posts = Posts::getAllPosts();
    	$authors = [];
    	$clothingString = [];
    	foreach($posts as $post){
    		array_push($authors, AppUser::loadById($post->get('author_id')));
    		$string = "Shirt: ";
    		$shirtID = ($post->get('shirt_id'));
    		$pantsID = ($post->get('pants_id'));
    		$shoesID = ($post->get('shoes_id'));
    		$hatID = ($post->get('hat_id'));
    		$jacketID = ($post->get('jacket_id'));
    		$location = ($post->get('location'));
    		if ($shirtID == 0){
    			$string .= "None";
    		}
    		else{
    			$string .= "<span style='font-weight: bold;text-shadow: 0 1px 0 #000, 1px 0 0 #000, -1px 0 0 #000, 0 -1px 0 #000; color: white; background-color:";
    			$string .= Clothing::loadById($post->get('shirt_id'))->get('clothingcolor');
    			$string .= ";'>";
    		$string .= Clothing::loadById($post->get('shirt_id'))->get('clothingname');
    			$string .= "</span>";
    		}
    		$string .= "| Pants: ";
    		if ($pantsID == 0){
    			$string .= "None";
    		}
    		else{
    			$string .= "<span style='font-weight: bold;text-shadow: 0 1px 0 #000, 1px 0 0 #000, -1px 0 0 #000, 0 -1px 0 #000; color: white; background-color:";
    			$string .= Clothing::loadById($post->get('pants_id'))->get('clothingcolor');
    			$string .= ";'>";
    		$string .= Clothing::loadById($post->get('pants_id'))->get('clothingname');
    			$string .= "</span>";
    		}
    		$string .= "| Shoes: ";
    		if ($shoesID == 0){
    			$string .= "None";
    		}
   			else{
    			$string .= "<span style='font-weight: bold;text-shadow: 0 1px 0 #000, 1px 0 0 #000, -1px 0 0 #000, 0 -1px 0 #000; color: white; background-color:";
    			$string .= Clothing::loadById($post->get('shoes_id'))->get('clothingcolor');
    			$string .= ";'>";
    		$string .= Clothing::loadById($post->get('shoes_id'))->get('clothingname');
    			$string .= "</span>";
    		}
    		if($post->get('hat_id') != 0){
    			$string .= "| Hat: ";
    			$string .= "<span style='font-weight: bold;text-shadow: 0 1px 0 #000, 1px 0 0 #000, -1px 0 0 #000, 0 -1px 0 #000; color: white; background-color:";
    			$string .= Clothing::loadById($post->get('hat_id'))->get('clothingcolor');
    			$string .= ";'>";
    			$string .= Clothing::loadById($post->get('hat_id'))->get('clothingname');
    			$string .= "</span>";
    		}
    		if($post->get('jacket_id') != 0){
    			$string .= "| Jacket: ";
    			$string .= "<span style='font-weight: bold;text-shadow: 0 1px 0 #000, 1px 0 0 #000, -1px 0 0 #000, 0 -1px 0 #000; color: white; background-color:";
    			$string .= Clothing::loadById($post->get('jacket_id'))->get('clothingcolor');
    			$string .= ";'>";
    			$string .= Clothing::loadById($post->get('jacket_id'))->get('clothingname');
    			$string .= "</span>";
    		}
    		array_push($clothingString, $string);
    	}

    		$user = AppUser::loadByUsername($_SESSION['username']);
    		$userId = $user->get('id');;
    		$followingIds = $user->getAllFollowing();
    		$followingPosts = [];
    		if(!empty($followingIds)){
	    		foreach($followingIds as $followingId){
	    			$ids = Posts::getUserPosts($followingId);
	    			foreach($ids as $id){
	    				array_push($followingPosts, $id);
	    			}
	    		}
	    		$followingAuthors = [];
		    	$followingClothingString = [];
		    	if(!empty($followingPosts)){
			    	foreach($followingPosts as $post){
			    		array_push($followingAuthors, AppUser::loadById($post->get('author_id')));
			    		$shirtID = ($post->get('shirt_id'));
    					$pantsID = ($post->get('pants_id'));
    					$shoesID = ($post->get('shoes_id'));
    					$hatID = ($post->get('hat_id'));
    					$jacketID = ($post->get('jacket_id'));
			    		$string = "Shirt: ";
			    		if ($shirtID == 0){
    						$string .= "None";
    					}
    					else{
			    			$string .= "<span style='font-weight: bold;text-shadow: 0 1px 0 #000, 1px 0 0 #000, -1px 0 0 #000, 0 -1px 0 #000; color: white; background-color:";
			    			$string .= Clothing::loadById($post->get('shirt_id'))->get('clothingcolor');
			    			$string .= ";'>";
			    		$string .= Clothing::loadById($post->get('shirt_id'))->get('clothingname');
			    			$string .= "</span>";
			    		}
			    		$string .= "| Pants: ";
			    		if ($pantsID == 0){
    						$string .= "None";
    					}
    					else{
			    			$string .= "<span style='font-weight: bold;text-shadow: 0 1px 0 #000, 1px 0 0 #000, -1px 0 0 #000, 0 -1px 0 #000; color: white; background-color:";
			    			$string .= Clothing::loadById($post->get('pants_id'))->get('clothingcolor');
			    			$string .= ";'>";
			    		$string .= Clothing::loadById($post->get('pants_id'))->get('clothingname');
			    			$string .= "</span>";
			    		}
			    		$string .= "| Shoes: ";
			    		if ($shoesID == 0){
    						$string .= "None";
    					}
    					else{
			    			$string .= "<span style='font-weight: bold;text-shadow: 0 1px 0 #000, 1px 0 0 #000, -1px 0 0 #000, 0 -1px 0 #000; color: white; background-color:";
			    			$string .= Clothing::loadById($post->get('shoes_id'))->get('clothingcolor');
			    			$string .= ";'>";
			    		$string .= Clothing::loadById($post->get('shoes_id'))->get('clothingname');
			    			$string .= "</span>";
			    		}
			    		if($post->get('hat_id') != 0){
			    			$string .= "| Hat: ";
			    			$string .= "<span style='font-weight: bold;text-shadow: 0 1px 0 #000, 1px 0 0 #000, -1px 0 0 #000, 0 -1px 0 #000; color: white; background-color:";
			    			$string .= Clothing::loadById($post->get('hat_id'))->get('clothingcolor');
			    			$string .= ";'>";
			    			$string .= Clothing::loadById($post->get('hat_id'))->get('clothingname');
			    			$string .= "</span>";
			    		}
			    		if($post->get('jacket_id') != 0){
			    			$string .= "| Jacket: ";
			    			$string .= "<span style='font-weight: bold;text-shadow: 0 1px 0 #000, 1px 0 0 #000, -1px 0 0 #000, 0 -1px 0 #000; color: white; background-color:";
			    			$string .= Clothing::loadById($post->get('jacket_id'))->get('clothingcolor');
			    			$string .= ";'>";
			    			$string .= Clothing::loadById($post->get('jacket_id'))->get('clothingname');
			    			$string .= "</span>";
			    		}
			    		array_push($followingClothingString, $string);
			    	}
		    	}
	    	}
		}
		include_once SYSTEM_PATH.'/view/LogIn.tpl';
    }

    public function ban(){
    	$id = $_POST['id'];
    	$user = AppUser::loadById($id);
    	$user->delete();
    	Posts::deletePosts($id);
    	$this->home();
    }
    public function signup() {
    	$pageTitle = 'Sign Up';
		include_once SYSTEM_PATH.'/view/SignUp.tpl';
    }

    public function about() {
    	$pageTitle = 'About';
		include_once SYSTEM_PATH.'/view/About.tpl';
    }

	public function addclothes() {
		//checks if user  is logged in
		// if not redirects to sign up page
		if( !isset($_SESSION['username']) || $_SESSION['username'] == '')
		{
			$_SESSION['error'] = "Account Required";
			header('Location: '.BASE_URL.'/signup');
		}
		else
		{
			$user = AppUser::loadByUsername($_SESSION['username']);
			$username = $user->get('username');
            $firstname = "Your";
			// $clothes = Clothing::getAllClothes();
			$clothes = Clothing::getClothingById($user->get('id'));
		}
		include_once SYSTEM_PATH.'/view/AddClothes.tpl';
    }

		public function login()
		{
			$un = $_POST['uname'];
				$pw = $_POST['pass'];
				$user = AppUser::loadByUsername($un);
				if($user == null) {
					// username not found
					$_SESSION['error'] = "Username not found";
					header('Location: '.BASE_URL);
				} // incorrect password
				elseif($user->get('pw') != $pw)
				{
					$_SESSION['error'] = "Incorrect Password";

				}
				else
				{
					$_SESSION['username'] = $un;
					$_SESSION['error'] = "You are logged in as ".$un.".";
					$_SESSION['admin'] = $user->get('admin');
				}

				// redirect to home page
				header('Location: '.BASE_URL);
		}

		// logs the user out
		// ends session
		public function logout() {
				// erase the session
				unset($_SESSION['username']);
				session_destroy(); // for good measure

				// redirect to home page
				header('Location: '.BASE_URL);
		}

		//creates users then
		//adds the user to the database
		public function signupUser()
		{
			//variables from page textbox
			$em = $_POST['email'];
			$un = $_POST['uname'];
			$pw = $_POST['pass'];
			$pw2 = $_POST['pass2'];
			$fn = $_POST['fname'];
			$ln = $_POST['lname'];
			//all fields must be entered
			if($un == null || $pw == null || $pw2 == null || $em == null)
			{
				$_SESSION['error'] = "Enter all fields";
				header('Location: '.BASE_URL.'/signup');
			}
			elseif($pw != $pw2)
			{
				$_SESSION['error'] = "Passwords Do Not Match";
			}
			else //creates new user with given fields
			{
				$user = new AppUser();
				$user->set('email', $em);
				$user->set('username', $un);
				$user->set('pw', $pw);
				$user->set('first_name', $fn);
				$user->set('last_name', $ln);
				$user->save();
				$_SESSION['error'] = "Account Creation Successful";
				header('Location: '.BASE_URL);

			}
		}

		//takes user to settings pages
		public function settings()
		{
			//checks if user  is logged in
			// if not redirects to sign up page
			if( !isset($_SESSION['username']) || $_SESSION['username'] == '')
			{
				$_SESSION['error'] = "Account Required";
				header('Location: '.BASE_URL.'/signup');
			}
			else
			{
				$user = AppUser::loadByUsername($_SESSION['username']);
				$email = $user->get('email');
				$userName = $user->get('username');
				$firstName = $user->get('first_name');
				$lastName = $user->get('last_name');
				$pageTitle = 'Settings';
    			$pageContent = 'Some introductory text would go here.';
			}
			include_once SYSTEM_PATH.'/view/Settings.tpl';
		}

		//checks if any field have  new values
		//replaces those fields
		public function settingsChange()
		{
			$user = AppUser::loadByUsername($_SESSION['username']);
			if ($_POST['newEmail'] != null)
			{
				$user->set('email', $_POST['newEmail']);
			}
			if ($_POST['newPass'] != null)
			{
				$user->set('pw', $_POST['newPass']);
			}
			if ($_POST['newFirst'] != null)
			{
				$user->set('first_name', $_POST['newFirst']);
			}
			if ($_POST['newLast'] != null)
			{
				$user->set('last_name', $_POST['newLast']);
			}
			$user->save();
			header('Location: '.BASE_URL.'/settings');

		}

		//makes sure user wants to delete account
		public function settingsConfirm()
		{
			$_SESSION['error'] = "Are you sure you want to permantly delete your account?";
			$_SESSION['confirm'] = "true";
			header('Location: '.BASE_URL.'/settings');

		}

		//deletes user account
		//ends  session
		public function settingsDelete()
		{
			$user = AppUser::loadByUsername($_SESSION['username']);
			Posts::deletePosts($user->get('id'));
			$user->delete();
			$_SESSION['confirm'] = null;
			$_SESSION['username'] = null;
			header('Location: '.BASE_URL);

		}

    public function signupCheck() {
    header('Content-Type: application/json'); // set the header to hint the response type (JSON) for JQuery's Ajax method
    $username = $_GET['username']; // get the username data

    // make sure it's a real username
    if(is_null($username) || $username == '') {
      echo json_encode(array('error' => 'Invalid username.'));
    } else {
      // okay, it's a real username. Is it available?
      $user = AppUser::loadByUsername($username);
      if(is_null($user)) {
        // $user is null, so username is available!
        echo json_encode(array(
          'success' => 'success',
          'check' => 'available'
        ));
      } else {
        echo json_encode(array(
          'success' => 'success',
          'check' => 'unavailable'
        ));
      }
    }


}

	public function addclothesSubmit()
	{
		$user = AppUser::loadByUsername($_SESSION['username']);
		header('Content-Type: application/json'); // set the header to hint the response type (JSON) for JQuery's Ajax method
		$clothingName = $_POST['clothingname']; // get the clothings name
		$clothingType = $_POST['clothingtype'];
        $clothingColor = $_POST['clothingcolor'];
		$author_id = $user->get('id');
		if ($clothingName == '')
		{
			echo json_encode(array(
						'success' => 'fail',
						'error' => 'Not All Entries filled'
					));
		}
		else
		{
			$clothing = new Clothing();
			$clothing->set('author_id', $author_id);
			$clothing->set('clothingname', $clothingName);
			$clothing->set('clothingtype', $clothingType);
            $clothing->set('clothingcolor', $clothingColor);
			$clothing->save();
			echo json_encode(array(
						'success' => 'success',
						'check' => 'available',
						'name' => $clothingName,
						'type' => $clothingType,
                        'color' => $clothingColor
					));
		}



	}

	public function getClothing(){
		header('Content-Type: application/json'); // set the header to hint the response type (JSON) for JQuery's Ajax method
	    $clothingid = $_GET['clothingid']; // get the username data

	    // make sure it's a real username
	    if(is_null($clothingid) || $clothingid == '') {
	      echo json_encode(array('error' => 'Missing clothing.'));
	    }
	    else {
	      // okay, it's a real username. Is it available?
	      $clothing = Clothing::loadById($clothingid);
	      // $user is null, so username is available!
	        echo json_encode(array(
	          'success' => 'success',
	          'clothingname' => $clothing->get('clothingname'),
	          'clothingtype' => $clothing->get('clothingtype'),
              'clothingcolor' => $clothing->get('clothingcolor')
	        ));
	    }
	}

	public function deleteClothing()
	{
		$clothing = Clothing::loadById($_POST['clothingid']);
		if ($clothing != null) {
			$clothing->delete();
		}
	}

	public function updateClothing()
	{
		header('Content-Type: application/json');
		$clothing = Clothing::loadById($_POST['clothingid']);
		$user = AppUser::loadByUsername($_SESSION['username']);
		$clothingName = $_POST['clothingname']; // get the clothings name
		$clothingType = $_POST['clothingtype'];
        $clothingColor = $_POST['clothingcolor'];
		$author_id = $user->get('id');
		if ($clothingName == '')
		{
			echo json_encode(array(
						'success' => 'fail',
						'error' => 'Not All Entries filled'
					));
		}
		else {
			$clothing->set('author_id', $author_id);
			$clothing->set('clothingname', $clothingName);
			$clothing->set('clothingtype', $clothingType);
            $clothing->set('clothingcolor', $clothingColor);
			$clothing->save();
			echo json_encode(array(
						'success' => 'success',
						'error' => ''
					));
		}

	}

	public function posts() {
	//checks if user  is logged in
	// if not redirects to sign up page
	if( !isset($_SESSION['username']) || $_SESSION['username'] == '')
	{
		$_SESSION['error'] = "Account Required";
		header('Location: '.BASE_URL.'/signup');
	}
	else
	{
		$user = AppUser::loadByUsername($_SESSION['username']);
		$userName = $user->get('username');
		// $clothes = Clothing::getAllClothes();
		$clothes = Clothing::getClothingById($user->get('id'));
		// $jackets = Clothing::getClothingByType($user->get('id'), 'jacket');
	}
	include_once SYSTEM_PATH.'/view/Post.tpl';
}

	public function postsSubmit()
{
	//variables from page textbox
	$shirtID = $_POST['chosenShirt'];
	$jacketID = $_POST['chosenJacket'];
	$pantsID = $_POST['chosenPants'];
	$shoesID = $_POST['chosenShoes'];
	$hatID = $_POST['chosenHat'];
    $message = $_POST['message'];
    $location = $_POST['location'];
	//all fields must be entered
	if($shirtName == 'Shirt' || $jacketName == 'Jacket' || $pantsName == 'Pants' || $shoesName == 'Shoes')
	{
		$_SESSION['error'] = "Enter all fields";
		header('Location: '.BASE_URL.'/posts');
	}
	else //creates new user with given fields
	{

		$user = AppUser::loadByUsername($_SESSION['username']);
		$author_id = $user->get('id');
		// if ($shirtName == 0){
		// 	$shirtID = 0;
		// }
		// else{
		// $shirt = Clothing::loadById($shirtName);
		// $shirtID = $shirt->get('id');
		// }
		// if ($jacketName == 0){
		// 	$jacketID = 0;
		// }
		// else{
		// 	$jacket = Clothing::loadById($jacketName);
		// $jacketID = $jacket->get('id');
		// }
		// if ($pantsName == 0)
		// {
		// 	$pantsID = 0;
		// }
		// else{
		// 	$pants = Clothing::loadById($pantsName);
		// $pantsID = $pants->get('id');
		// }
		// if ($shoesName == 0){
		// 	$shoesID = 0;
		// }
		// else{
		// 	$shoes = Clothing::loadByClothingName($shoesName);
		// $shoesID = $shoes->get('id');
		// }
		// if ($hatName == 0){
		// 	$hatID = 0;
		// }
		// else{
		// 	$hat = Clothing::loadByClothingName($hatName);
		// $hatID = $hat->get('id');
		// }


		$post = new Posts();
		$post->set('author_id', $author_id);
        if($jacketID != 0)
        {
		  $post->set('jacket_id', $jacketID);
        }
        if($pantsID != 0)
        {
    		$post->set('pants_id', $pantsID);
        }
        if($shirtID != 0)
        {
    		$post->set('shirt_id', $shirtID);
        }
        if($shoesID != 0)
        {
    		$post->set('shoes_id', $shoesID);
        }
        if($hatID != 0)
        {
    		$post->set('hat_id', $hatID);
        }
        $post->set('message', $message);
        if($location != ''){
        	$post->set('location', $location);
        }

		$post->save();

		$_SESSION['error'] = "Post Successful";
		header('Location: '.BASE_URL.'/posts');

	}
}
    public function clothes($user_id)
    {
        // if( !isset($_SESSION['username']) || $_SESSION['username'] == '')
        // {
        //     $_SESSION['error'] = "Account Required";
        //     header('Location: '.BASE_URL.'/signup');
        // }
        // else
        {
            $user = AppUser::loadById($user_id);
            $username = $user->get('username');
            $firstname = $user->get('first_name').'\'s';
            // $clothes = Clothing::getAllClothes();
            $clothes = Clothing::getClothingById($user->get('id'));
        }
        include_once SYSTEM_PATH.'/view/AddClothes.tpl';
    }


		public function profileJson($user_id) {
			header('Content-Type: application/json');

			// first let's deal with nodes, then links
			// two types of nodes: posts and users

			$sizeOfBubbles = 7000;
            $user = null;
            $signup = false;
            if($user_id != 0)
            {

                $user = AppUser::loadById($user_id);
            }
            else if(isset($_SESSION['username']) && $_SESSION['username'] != '')
            {
                $user = AppUser::loadByUsername($_SESSION['username']);
            }

			// echo $user->get('username');
			// get all blog posts
			$clothes = Clothing::getClothingById($user->get('id'));

			$jsonClothes = array(); // array to hold json clothes
			$jsonShirts = array(); // array of shirts
			$jsonJackets = array(); // array of jackets
			$jsonPants = array(); // array of pants
			$jsonShoes = array(); // array of shoes
			$jsonHats = array(); // array of hats

			//iterates through clothes and places individual
			//articles of clothing in different appropirate
			//arrays.

			foreach($clothes as $article) {
				if ($article->get('clothingtype') == 'Shirt')
				{
					$jsonShirt = array(
						'name' => $article->get('clothingname'),
						'size' => $sizeOfBubbles,
						'id' => $article->get('id'),
                        'color' => $article->get('clothingcolor')
					);
					array_push($jsonShirts, $jsonShirt);
				}
				else if ($article->get('clothingtype') == 'Jacket')
				{
					$jsonJacket = array(
						'name' => $article->get('clothingname'),
						'size' => $sizeOfBubbles,
						'id' => $article->get('id'),
                        'color' => $article->get('clothingcolor')
					);
					array_push($jsonJackets, $jsonJacket);
				}
				else if ($article->get('clothingtype') == 'Pants')
				{
					$jsonPant = array(
						'name' => $article->get('clothingname'),
						'size' => $sizeOfBubbles,
						'id' => $article->get('id'),
                        'color' => $article->get('clothingcolor')
					);
					array_push($jsonPants, $jsonPant);
				}
				else if ($article->get('clothingtype') == 'Shoes')
				{
					$jsonShoe = array(
						'name' => $article->get('clothingname'),
						'size' => $sizeOfBubbles,
						'id' => $article->get('id'),
                        'color' => $article->get('clothingcolor')
					);
					array_push($jsonShoes, $jsonShoe);
				}
				else if ($article->get('clothingtype') == 'Hat')
				{
					$jsonHat = array(
						'name' => $article->get('clothingname'),
						'size' => $sizeOfBubbles,
						'id' => $article->get('id'),
                        'color' => $article->get('clothingcolor')

					);
					array_push($jsonHats, $jsonHat);
				}
			}
				//json array of shirts
				$shirts = array(
					'name' => 'Shirts',
					'children' => $jsonShirts
				);
				//json array of pants
				$pants = array(
					'name' => 'Pants',
					'children' => $jsonPants
				);
				//json array of jackets
				$jackets = array(
					'name' => 'Jackets',
					'children' => $jsonJackets
				);
				//json array of shoes
				$shoes = array(
					'name' => 'Shoes',
					'children' => $jsonShoes
				);
				//json array of hats
				$hats = array(
					'name' => 'Hats',
					'children' => $jsonHats
				);

				//adds all arrays to clothing array
				array_push($jsonClothes, $shirts);
				array_push($jsonClothes, $jackets);
				array_push($jsonClothes, $pants);
				array_push($jsonClothes, $shoes);
				array_push($jsonClothes, $hats);


			// remove array keys (indexes) because d3 doesn't expect them
			$jsonClothes = array_values($jsonClothes);

			// finally, the json root object
			$json = array(
				'name' => 'Clothes',
				'children' => $jsonClothes
			);

			echo json_encode($json);
		}



}
