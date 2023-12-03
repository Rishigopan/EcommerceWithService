<?php


    date_default_timezone_set('Asia/Kolkata');
   
    // class Connection{

    //     private $Host;
    //     private $Port;
    //     private $Socket;
    //     private $User;
    //     private $Password;
    //     private $Database;
        

    //     public function Connect(){

    //         $this->Host = 'localhost';
    //         $this->Port = '3306';
    //         $this->Socket = '';
    //         $this->User = 'root';
    //         $this->Password = 'Techstas@123';
    //         $this->Database = 'nazeem_connect';

    //         $ConnectionString = new mysqli($this->Host, $this->User, $this->Password, $this->Database, $this->Port, $this->Socket) 
    //         or die ('Could not connect to the database server' . mysqli_connect_error());

    //         return $ConnectionString;
    //     }

    // }


    // $Connection = new Connection;
    // $con = $Connection->Connect();



    $Host = 'localhost';
    $Port = '3306';
    $Socket = '';
    $User = 'root';
    $Password = 'Techstas@123';
    $Database = 'nazeem_connect';

    $con = new mysqli($Host, $User, $Password, $Database, $Port, $Socket) 
            or die ('Could not connect to the database server' . mysqli_connect_error());



    

