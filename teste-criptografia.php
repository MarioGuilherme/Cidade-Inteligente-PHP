<?php
    $senha = '1234567';
    $senha = password_hash($senha, PASSWORD_BCRYPT);
    $crps = crypt('$2y$10$dmh6luaNV.xqT7VG4XPDBu1IzPGGTsRzUhV8mzJ9irGXeG7PriRny', $senha);
    echo($senha);
 //   echo('<br>');
 //   echo($senha2);
    echo('<br>');
    echo($crps);