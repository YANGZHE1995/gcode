<html>

/**
* 用于修改数据库的字符集
*/


    ALTER DATABASE {{env('DB_DATABASE','')}} CHARACTER SET `utf8mb4` COLLATE `utf8mb4_general_ci`;

@foreach($table_names as $table_name)
    ALTER TABLE `{{$table_name}}` CONVERT TO CHARACTER SET `utf8mb4` COLLATE `utf8mb4_general_ci`;
@endforeach

@foreach($table_names as $table_name)
    ALTER TABLE `{{$table_name}}` AUTO_INCREMENT=100000000;
@endforeach

</html>