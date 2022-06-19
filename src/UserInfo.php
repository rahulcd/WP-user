<?php

class UserInfo{
    protected $apiUrl = 'https://jsonplaceholder.typicode.com/';

    public function __construct()
    {
    }

    public  function getUsers($id='')
    {         
        if(isset($id) && !empty($id)){
            $json = wp_remote_get($this->apiUrl . 'users/'.$id);
        }else{
            $json = wp_remote_get($this->apiUrl . 'users');
        }
        
        
        $userArray = json_decode($json['body']);
        
        //$shots = $array->shots;
         
        return $userArray;
    }

    public function user_listing($atts) {
        $usersList = $this->getUsers();        
        $Content = "<table class='table'>";
        $Content .= "<thead class='thead-light'>";
        $Content .= "<tr>";
        $Content .= "<th>User Name</th>";
        $Content .= "<th>User Id</th>";
        $Content .= "<th>Email</th>";
        $Content .= "</tr>";
        $Content .= "</thead>";
        foreach($usersList as $user){
            $Content .= "<tr>";
            $Content .= "<td><a class='get-user-details' userid='".$user->id."'>".$user->id."</a>   </td>";
            $Content .= "<td><a class='get-user-details' userid='".$user->id."'>".$user->username."</a></td>";
            $Content .= "<td><a class='get-user-details' userid='".$user->id."'>".$user->email."</a></td>";
            $Content .= "</tr>";
        }
        $Content .= "</table>";
        
        // add model content for loading the user details
        $Content .=  '<div id="myModal" class="custom-modal">
        <div class="custom-modal-content">
            <span class="custom-modal-close">&times;</span>
            <div class="userdetails-content-area"></div>
        </div>
        </div>';
        echo $Content;
    }

    public function userdetails() {
        ob_clean();
        
        $id = intval( $_POST['id'] );
        $usersDetails = $this->getUsers($id);

        $Content = "<div class='row'>";
        $Content .= "<div class='column'>";
        $Content .= "<h1>User Details</h1>";
        $Content .= "<h5><b>User id :</b> ".$usersDetails->id.'</h5>';
        $Content .= "<h5><b>User Name :</b> ".$usersDetails->username.'</h5>';
        $Content .= "<h5><b>Email :</b> ".$usersDetails->email.'</h5>';
        $Content .= "<h5><b>Phone :</b> ".$usersDetails->phone.'</h5>';
        $Content .= "<h5><b>Website :</b> ".$usersDetails->website.'</h5>';
        $Content .= "</div>";
        $Content .= "<div class='column'>";
        $Content .= "<h1>Address</h1>";
        $Content .= "<h5><b>Street :</b> ".$usersDetails->address->street.'</h5>';
        $Content .= "<h5><b>Suite :</b> ".$usersDetails->address->suite.'</h5>';
        $Content .= "<h5><b>City :</b> ".$usersDetails->address->city.'</h5>';
        $Content .= "<h5><b>Zipcode :</b> ".$usersDetails->address->zipcode.'</h5>';
        $Content .= "<h5><b>Latitude :</b> ".$usersDetails->address->geo->lat.'</h5>';
        $Content .= "<h5><b>Longitude :</b> ".$usersDetails->address->geo->lng.'</h5>';
        $Content .= "</div></div>";
        $Content .= "<div class='row'><div class='column'>";
        $Content .= "<h1>Company</h1>";
        $Content .= "<h5><b>Name :</b> ".$usersDetails->company->name.'</h5>';
        $Content .= "<h5><b>CatchPhrase :</b> ".$usersDetails->company->catchPhrase.'</h5>';
        $Content .= "<h5><b>Bs :</b> ".$usersDetails->company->bs.'</h5>';
        $Content .= "</div></div>";
        
        echo $Content;
        wp_die(); // this is required to terminate immediately and return a proper response 
    }

}
?>