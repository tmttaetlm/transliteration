<?php

error_reporting(E_ALL);
ini_set('display_errors', 'On');

require_once 'vendor/phpoffice/phpspreadsheet/src/Bootstrap.php';

use PhpOffice\PhpSpreadsheet\IOFactory;
use PhpOffice\PhpSpreadsheet\Spreadsheet;

function transliterator($val) {
    $res = '';
    $rus_kaz = [
        'А' => 'A', 'Б' => 'B', 'В' => 'V', 'Г' => 'G', 'Д' => 'D', 'Е' => 'E', 'Ё' => 'E', 'Ж' => 'Zh', 'З' => 'Z', 'И' => 'I', 'Й' => 'I', 'К' => 'K', 'Л' => 'L', 'М' => 'M', 'Н' => 'N', 'О' => 'O', 
        'П' => 'P', 'Р' => 'R', 'С' => 'S', 'Т' => 'T', 'У' => 'U', 'Ф' => 'F', 'Х' => 'Kh', 'Ц' => 'Ts', 'Ч' => 'Ch', 'Ш' => 'Sh', 'Щ' => 'Chsh', 'Ь' => '', 'Ы' => 'Y', 'Ъ' => '', 'Э' => 'E',
        'Ю' => 'Yu', 'Я' => 'Ya', 'Ә' => 'A', 'І' => 'I', 'Ң' => 'N', 'Ғ' => 'G', 'Ү' => 'U', 'Ұ' => 'U', 'Қ' => 'Q', 'Ө' => 'O', 'Һ' => 'H',
        'а' => 'a', 'б' => 'b', 'в' => 'v', 'г' => 'g', 'д' => 'd', 'е' => 'e', 'ё' => 'e', 'ж' => 'zh', 'з' => 'z', 'и' => 'i', 'й' => 'i', 'к' => 'k', 'л' => 'l', 'м' => 'm', 'н' => 'n', 'о' => 'o',
        'п' => 'p', 'р' => 'r', 'с' => 's', 'т' => 't', 'у' => 'u', 'ф' => 'f', 'х' => 'kh', 'ц' => 'ts', 'ч' => 'ch', 'ш' => 'sh', 'щ' => 'chsh', 'ь' => '', 'ы' => 'y', 'ъ' => '', 'э' => 'e',
        'ю' => 'yu', 'я' => 'ya', 'ә' => 'a', 'і' => 'i', 'ң' => 'n', 'ғ' => 'g', 'ү' => 'u', 'ұ' => 'u', 'қ' => 'q', 'ө' => 'o', 'һ' => 'h','-' => '-'
    ];
    $s_arr = ['са','се','сё','си','со','су','сы','сэ','сю','ся','сә','сі','сү','сұ','сө',
            'Са','Се','Сё','Си','Со','Су','Сы','Сэ','Сю','Ся','Сә','Сі','Сү','Сұ','Сө',
            'СА','СЕ','СЁ','СИ','СО','СУ','СЫ','СЭ','СЮ','СЯ','СӘ','СІ','СҮ','СҰ','СӨ'];
    $eng = 'ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz';
    $vowels = 'АЕЁИОУЫЭЮЯаеёиоуыэюя';
    
    if (mb_substr_count($val, 'дж') > 0) { $val = str_replace('дж', 'j', $val); };
    if (mb_substr_count($val, 'Дж') > 0) { $val = str_replace('Дж', 'J', $val); };
    if (mb_substr_count($val, 'ДЖ') > 0) { $val = str_replace('ДЖ', 'J', $val); };

    if (mb_substr_count($val, 'кс') > 0) { $val = str_replace('кс', 'x', $val); };
    if (mb_substr_count($val, 'Кс') > 0) { $val = str_replace('Кс', 'X', $val); };
    if (mb_substr_count($val, 'КС') > 0) { $val = str_replace('КС', 'X', $val); };

    if (mb_substr_count($val, 'аё') > 0) { $val = str_replace('аё', 'aye', $val); };
    if (mb_substr_count($val, 'её') > 0) { $val = str_replace('её', 'eye', $val); };
    if (mb_substr_count($val, 'ёё') > 0) { $val = str_replace('ёё', 'eye', $val); };
    if (mb_substr_count($val, 'иё') > 0) { $val = str_replace('иё', 'iye', $val); };
    if (mb_substr_count($val, 'оё') > 0) { $val = str_replace('оё', 'oye', $val); };
    if (mb_substr_count($val, 'уё') > 0) { $val = str_replace('уё', 'uye', $val); };
    if (mb_substr_count($val, 'эё') > 0) { $val = str_replace('эё', 'eye', $val); };
    if (mb_substr_count($val, 'ыё') > 0) { $val = str_replace('ыё', 'yye', $val); };
    if (mb_substr_count($val, 'ьё') > 0) { $val = str_replace('ьё', 'ye', $val); };
    if (mb_substr_count($val, 'ъё') > 0) { $val = str_replace('ъё', 'ye', $val); };

    if (mb_substr_count($val, 'ае') > 0) { $val = str_replace('ае', 'aye', $val); };
    if (mb_substr_count($val, 'ее') > 0) { $val = str_replace('ее', 'eye', $val); };
    if (mb_substr_count($val, 'ёе') > 0) { $val = str_replace('ёе', 'eye', $val); };
    if (mb_substr_count($val, 'ие') > 0) { $val = str_replace('ие', 'iye', $val); };
    if (mb_substr_count($val, 'ое') > 0) { $val = str_replace('ое', 'oye', $val); };
    if (mb_substr_count($val, 'уе') > 0) { $val = str_replace('уе', 'uye', $val); };
    if (mb_substr_count($val, 'эе') > 0) { $val = str_replace('эе', 'eye', $val); };
    if (mb_substr_count($val, 'ые') > 0) { $val = str_replace('ые', 'yye', $val); };
    if (mb_substr_count($val, 'ье') > 0) { $val = str_replace('ье', 'ye', $val); };
    if (mb_substr_count($val, 'ъе') > 0) { $val = str_replace('ъе', 'ye', $val); };

    if (mb_substr_count($val, 'ий') > 0) { $val = str_replace('ий', 'y', $val); };
    if (mb_substr_count($val, 'ый') > 0) { $val = str_replace('ый', 'y', $val); };
    if (mb_substr_count($val, 'яя') > 0) { $val = str_replace('яя', 'aya', $val); };

    if (mb_substr($val, -1) == 'й') { $val = mb_substr($val, 0, mb_strlen($val)-1).'y'; };
    if (mb_substr($val, mb_strpos($val, ' ')-1, 1) == 'й') { $val = mb_substr($val, 0, mb_strpos($val, ' ')-1).'y '.mb_substr($val, mb_strpos($val, ' ')+1, mb_strlen($val)); };
    
    for ($i = 0; $i <= mb_strlen($val)-1; $i++) {
        $ch = mb_substr(mb_strtolower($val),$i,1);
        if ($ch == 'е') {
            if ($i == 0) {
                if (mb_substr($val, $i, 1) == 'Е') { $val = 'Ye'.mb_substr($val, 1, mb_strlen($val)-1); }
                if (mb_substr($val, $i, 1) == 'е') { $val = 'ye'.mb_substr($val, 1, mb_strlen($val)-1); }
            } else {
                if (mb_substr($val, $i-1, 1) == ' ') {
                    if (mb_substr($val, $i, 1) == 'Е') { $val = mb_substr($val, 0, $i).'Ye'.mb_substr($val, $i+1, mb_strlen($val)-1); }
                    if (mb_substr($val, $i, 1) == 'е') { $val = mb_substr($val, 0, $i).'ye'.mb_substr($val, $i+1, mb_strlen($val)-1); }
                }
            }
        }
    }
    
    foreach ($s_arr as $value) {
        $ss_pos = mb_substr_count($val, $value);
        for ($i = 1; $i <= $ss_pos; $i++) {
            if (mb_strpos($val, $value) != 0 && mb_substr($val, mb_strpos($val, $value)+1, 3) != 'ұлы' && mb_substr($val, mb_strpos($val, $value)+1, 3) != 'улы') {
                $pre_pos = mb_substr($val, mb_strpos($val, $value)-1, 1);
                if (mb_strpos($vowels, $pre_pos) !== false && $pre_pos != ' ') {
                    if (mb_strpos($vowels, mb_substr($value,1,1)) <= 9) { $r = 'SS'; }
                    else if (mb_substr($value,0,1) == 'с') { $r = 'ss'; }
                    else if (mb_substr($value,0,1) == 'С') { $r = 'Ss'; };
                    $val = mb_substr($val, 0, mb_strpos($val, $value)).$r.mb_substr($val, mb_strpos($val, $value)+1);
                };
            };
        };
    };
    
    for ($i = 0; $i <= mb_strlen($val)-1; $i++) {
        $ch = mb_substr($val,$i,1);
        if ($ch != ' ') {
            if (strpos($eng, $ch) === false) { $res .= $rus_kaz[$ch]; }
            else { $res .= $ch; };
        } else { $res .= ' '; };
    };
    return $res;
}

function exportCSV($params) {
    $uploadfile = 'upload/'.$_FILES['userfile']['name'];
    if (move_uploaded_file($_FILES['userfile']['tmp_name'], $uploadfile)) {
        $accounts = [];

        $loader = IOFactory::load($uploadfile);
        $sheet = $loader->getActiveSheet();
        
        $list[0] = array('UserPrincipalName','GivenName','Surname','sAMAccountName','Name','DisplayName','EmailAddress','AccountPassword','Title','Company','City','MobilePhone','StreetAddress','Class','Altemail','IIN');
        
        for ($row = 3; $row <= $sheet->getHighestRow('B'); $row++){
            $data = [];
            $fio = preg_replace('/\s+/', ' ', trim($sheet->getCell('B'.($row))->getValue()));
            if ($fio != '') {
                $first_space = mb_strpos($fio, ' ');
                $second_space = mb_strpos($fio, ' ', $first_space+1) === false ? strlen($fio)+1 : mb_strpos($fio, ' ', $first_space+1);
                $surname = mb_substr($fio, 0, $first_space);
                $name = mb_substr($fio, $first_space+1, $second_space-$first_space-1);
                array_key_exists('midnames', $params) ? $midname = '' : $midname = ' '.mb_substr($fio, $second_space+1, strlen($fio));
                if (mb_strtolower(mb_substr($name,0,2)) == 'дж' || mb_strtolower(mb_substr($name,0,2)) == 'кс') { 
                    $name_latin = transliterator(mb_substr($name,0,2));
                } else { 
                    $name_latin = transliterator(mb_substr($name,0,1));
                };
                $iin = $sheet->getCell('C'.($row))->getValue();
                $login = ucfirst(transliterator($surname)).'_'.$name_latin.substr($iin,10,2);
                $school = $sheet->getCell('D'.($row))->getValue();
                $grade = $sheet->getCell('F'.($row))->getValue();
                $phone = $sheet->getCell('G'.($row))->getValue();
                $phone = $phone == '' ? 'none' : $phone;
                $mail = $sheet->getCell('H'.($row))->getValue();
                $mail = $mail == '' ? 'none' : $mail;
                $address = $sheet->getCell('I'.($row))->getValue();
                $address = $address == '' ? 'none' : $address;
                $city = $sheet->getCell('J'.($row))->getValue();
                $city = $city == '' ? 'none' : $city;

                $part1 = mt_rand(1,99);
                if ($part1 < 10) { $part1 = '0'.$part1; }
                $permitted_chars = 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
                $part2 = substr(str_shuffle($permitted_chars), 0, 2);

                array_push($data, $login.$params['domen']);
                array_push($data, $name);
                array_push($data, $surname);
                array_push($data, $iin);
                array_push($data, $name.' '.$surname);
                array_push($data, $surname.' '.$name.$midname);
                array_push($data, $login.$params['domen']);
                array_push($data, 'Pass#'.$part1.$part2);
                array_push($data, 'Ученик '.$grade);
                array_push($data, $school);
                array_push($data, $city);
                array_push($data, $phone);
                array_push($data, $address);
                array_push($data, $grade);
                array_push($data, $mail);
                array_push($data, $iin);
                $list[$row-2] = $data;

                array_push($accounts, [$iin, $surname.' '.$name.$midname, $login.$params['domen'], 'Pass#'.$part1.$part2]);
            } else {
                echo 'Ошибка! В таблице есть пустые строки!';
                return;
            }
        };

        ob_start();

        header('Content-Type: application/csv;');
        header('Content-Disposition: attachment; filename="Translit-output.csv";');

        $output = fopen("php://output", "w+");
        foreach ($list as $line) { fputcsv($output, $line); }
        fclose($output);
        
        ob_flush(); ob_end_clean();

        $temp = fopen("files/temp.csv", "w+");
        foreach ($accounts as $acc) { fputcsv($temp, $acc); }
        fclose($temp);
    } else {
        echo 'Ошибка! Не удалось загрузить файл на сервер!';
    };
}

function exportXLS() {
    if (!file_exists("files/temp.csv")) { echo '<script type="text/javascript">alert("Не создана CSV-таблица для скрипта")</script>'; exit; }
    $temp = fopen("files/temp.csv", "r");
    if (!$temp) { echo '<script type="text/javascript">alert("Не создана CSV-таблица для скрипта")</script>'; exit; }
    if (count(file("files/temp.csv")) == 0) { echo '<script type="text/javascript">alert("Не создана CSV-таблица для скрипта")</script>'; exit; }

    $spreadsheet = new Spreadsheet();
    
    $styleHeader = ['alignment' => ['horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER],
                    'borders' => ['allBorders' => ['borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN]],
                    'font' => ['bold' => true]];
    $styleData = ['borders' => ['allBorders' => ['borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN]]];

    $spreadsheet->getActiveSheet()->getColumnDimension('A')->setWidth(5);
    $spreadsheet->getActiveSheet()->getColumnDimension('B')->setWidth(20);
    $spreadsheet->getActiveSheet()->getColumnDimension('C')->setWidth(30);
    $spreadsheet->getActiveSheet()->getColumnDimension('D')->setWidth(30);
    $spreadsheet->getActiveSheet()->getColumnDimension('E')->setWidth(15);

    $spreadsheet->getActiveSheet()->setCellValue('A1', '№');
    $spreadsheet->getActiveSheet()->setCellValue('B1', 'ИИН');
    $spreadsheet->getActiveSheet()->setCellValue('C1', 'ФИО');
    $spreadsheet->getActiveSheet()->setCellValue('D1', 'Логин');
    $spreadsheet->getActiveSheet()->setCellValue('E1', 'Пароль');
    
    $i = 1;
    while (!feof($temp)) {
        $i++;
        $line = explode(',', fgets($temp));
        if (count($line) < 4) continue;
        $spreadsheet->getActiveSheet()->setCellValue('A'.($i), $i);
        $spreadsheet->getActiveSheet()->setCellValue('B'.($i), $line[0]);
        $spreadsheet->getActiveSheet()->setCellValue('C'.($i), str_replace('"', '', $line[1]));
        $spreadsheet->getActiveSheet()->setCellValue('D'.($i), $line[2]);
        $spreadsheet->getActiveSheet()->setCellValue('E'.($i), $line[3]);
    }
    
    $spreadsheet->getActiveSheet()->getStyle('A1:E1')->applyFromArray($styleHeader);
    $spreadsheet->getActiveSheet()->getStyle('A2:E'.($i+1))->applyFromArray($styleData);

    unlink("files/temp.csv");

    ob_start();

    header('Content-Type: application/xlsx');
    header('Content-Disposition: attachment;filename="Учетные записи АД.xlsx"');

    $writer = IOFactory::createWriter($spreadsheet, 'Xlsx');
    $writer->save('php://output');

    ob_flush();
    ob_end_clean();
}

function exportScript($post) {
    !array_key_exists('pne', $post) ? $post['pne'] = '$False' : $post['pne'] = '$True';
    !array_key_exists('cpl', $post) ? $post['cpl'] = '$False' : $post['cpl'] = '$True';
    !array_key_exists('en', $post) ? $post['en'] = '$False' : $post['en'] = '$True';
    !array_key_exists('ccp', $post) ? $post['ccp'] = '$False' : $post['ccp'] = '$True';
    $content = file_get_contents("files/import_students.ps1");
    $content = str_replace('%ou%', $post['ou'], $content);
    $content = str_replace('%ip%', $post['ip'], $content);
    $content = str_replace('%pne%', $post['pne'], $content);
    $content = str_replace('%cpl%', $post['cpl'], $content);
    $content = str_replace('%en%', $post['en'], $content);
    $content = str_replace('%ccp%', $post['ccp'], $content);

    header('Content-Type: application/ps1');
    header('Content-Disposition: attachment; filename="import_students.ps1";');
    
    $output = fopen("php://output", "wb");
    fputs($output, $content);
    fclose($output);
}


if ($_POST['mode'] == 'local') {
    echo transliterator($_POST['fio']);
} else if ($_POST['mode'] == 'csv') {
    exportCSV($_POST);
} else if ($_POST['mode'] == 'script') {
    exportScript($_POST);
} else if ($_POST['mode'] == 'xls') {
    exportXLS();
}