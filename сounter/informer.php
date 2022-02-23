<?php

require_once __DIR__.'/db.php';

class informer {
    public $db;
    public function count() {
        $this->db = Components\Db::getDb();
        $date = getdate();
        if ($date['hours'] < 8) { $date = date("Y-m-d 08:00:00", strtotime("-1 day")); } else { $date = date("Y-m-d 08:00:00"); }
        return $this->db->selectQuery("SELECT views, hosts FROM isdb.counter_visits WHERE date='$date' AND whatIS = 'translit'");
    }
}

$inf = new informer();
$visits = $inf->count();

//echo '<p>Уникальных посетителей: ' . $visits[0]['hosts'] . '<br />';
//echo 'Просмотров: ' . $visits[0]['views'] . '</p>';
?>

<div class="informer" style="display: flex">
    <div style="display: flex">
        <img src="/images/eye.png" alt="">
        <a style="font: 16px Roboto; margin: auto 0"><?php echo $visits[0]['views']?></a>
    </div>
    <div style="display: flex; margin-left: 10px">
        <img src="/images/user.png" alt="">
        <a style="font: 16px Roboto; margin: auto 0"><?php echo $visits[0]['hosts']?></a>
    </div>
</div>