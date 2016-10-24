<?php

include_once '../global.php';


// get the identifier for the page we want to load
$action = $_GET['action'];

// instantiate a SiteController and route it
$pc = new ProfileController();
$pc->route($action);

class ProfileController {

    // route us to the appropriate class method for this action
    public function route($action) {
        switch($action) {
            case 'viewProfile':
                $user_id = $_GET['user_id'];
                $this->viewProfile($user_id);
                break;
            case 'follow':
                $this->follow();
                break;
            case 'unfollow':
                $this->unfollow();
                break;
            case 'graphic':
                $user_id = $_GET['user_id'];
                $this->graphic($user_id);
                break;

        }
    }

    public function viewProfile($user_id)
    {
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
        else
        {
            $signup = true;
            $firstname = "";
            $lastname = "";
            $username = "Sign Up";
            $pageTitle = 'Log in';
            include_once SYSTEM_PATH.'/view/LogIn.tpl';
            return;
        }
        if($user != null)
        {
            $firstname = $user->get('first_name');
            $lastname = $user->get('last_name');
            $username = $user->get('username');
        }
        else if(!$signup)
        {
            $firstname = "";
            $lastname = "";
            $username = "User Not Found";
        }
        $posts = Posts::getUserPosts($user->get('id'));
        $authors = [];
        $clothingString = [];
        if(count($posts) > 0)
        {
            foreach($posts as $post){
                array_push($authors, AppUser::loadById($post->get('author_id')));
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
                array_push($clothingString, $string);
            }
        }
        include_once SYSTEM_PATH.'/view/Profile.tpl';
    }

    public function follow()
    {

        $user = AppUser::loadByUsername($_SESSION['username']);
        header('Content-Type: application/json'); // set the header to hint the response type (JSON) for JQuery's Ajax method     
        $targetId = $_POST['followee_id'];
            if ($user->follow($targetId))
            {
                echo json_encode(array(
                            'success' => 'success',
                            'follower' => $user->get('id'),
                            'followee' => $targetId
                            
                        ));
            }
            else
            {
                echo json_encode(array(
                            'success' => 'fail'));
            }
    }

    public function unfollow()
    {

        $user = AppUser::loadByUsername($_SESSION['username']);
        header('Content-Type: application/json'); // set the header to hint the response type (JSON) for JQuery's Ajax method     
        $targetId = $_POST['followee_id'];
        if ($user->unfollow($targetId))
        {
            echo json_encode(array(
                        'success' => 'success',
                        'follower' => $user->get('id'),
                        'followee' => $targetId
                        
                    ));
        }
        else
        {
            echo json_encode(array(
                        'success' => 'fail'));
        }
    }
    public function graphic($user_id)
    {
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
        else
        {
            $signup = true;
            $firstname = "";
            $lastname = "";
            $username = "Sign Up";
            $pageTitle = 'Log in';
            include_once SYSTEM_PATH.'/view/LogIn.tpl';
            return;
        }
        if($user != null)
        {
            $firstname = $user->get('first_name');
            $lastname = $user->get('last_name');
            $username = $user->get('username');
        }
        else if(!$signup)
        {
            $firstname = "";
            $lastname = "";
            $username = "User Not Found";
        }
        include_once SYSTEM_PATH.'/view/Graphic.tpl';
    }

}