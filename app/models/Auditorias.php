<?php
class Auditorias extends Model
{
    public static $table="auditorias";

    public function getAuditorias(){
        return self::select($this->table);
    }
}
?>