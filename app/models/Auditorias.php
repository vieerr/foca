<?php
class Auditorias extends Model
{
    public static $table="Auditorias";

    public function getAuditorias(){
        return self::select($this->table);
    }
}
?>