<?php
class DB
{
protected $link=null;
public $status=1;
public function  __construct()
{
$this->link=mysql_connect("localhost","root","");
$res=mysql_select_db("oAuth",$this->link);
if(!$this->link || !$res)
{
$this->status=null;
die("Mysql Connection Eror ".mysql_error());
}

}

public function __destruct()
{
//mysql_close($this->link);
}

}

?>
