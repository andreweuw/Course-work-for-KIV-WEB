<?php

class userModel extends baseModel
{

    public function LoadAllUsers()
    {
        //$table_name = TABLE_KNIHA; //idealne z konstanty z konfigurace
        $table_name = "knihy"; //idealne z konstanty z konfigurace

        $where_array = array();

        //ukazka
        $where_array[] = array("column" => "Jmeno_autora", "symbol" => "=", "value" => "Ondrej");

        $knihy = $this->DBSelectAll($table_name, "*", $where_array);
        printr($knihy);
        return $knihy;
    }
}