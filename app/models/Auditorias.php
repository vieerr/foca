<?php
class Auditorias extends Model
{
    public static $table = "auditoria";

    public function getAuditorias()
    {
        return self::select(self::$table);
    }
}
?>