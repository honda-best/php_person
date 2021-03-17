<?php
$example_persons_array = [
    [
        'fullname' => 'Иванов Иван Иванович',
        'job' => 'tester',
    ],
    [
        'fullname' => 'Степанова Наталья Степановна',
        'job' => 'frontend-developer',
    ],
    [
        'fullname' => 'Пащенко Владимир Александрович',
        'job' => 'analyst',
    ],
    [
        'fullname' => 'Громов Александр Иванович',
        'job' => 'fullstack-developer',
    ],
    [
        'fullname' => 'Славин Семён Сергеевич',
        'job' => 'analyst',
    ],
    [
        'fullname' => 'Цой Владимир Антонович',
        'job' => 'frontend-developer',
    ],
    [
        'fullname' => 'Быстрая Юлия Сергеевна',
        'job' => 'PR-manager',
    ],
    [
        'fullname' => 'Шматко Антонина Сергеевна',
        'job' => 'HR-manager',
    ],
    [
        'fullname' => 'аль-Хорезми Мухаммад ибн-Муса',
        'job' => 'analyst',
    ],
    [
        'fullname' => 'Бардо Жаклин Фёдоровна',
        'job' => 'android-developer',
    ],
    [
        'fullname' => 'Шварцнегер Арнольд Густавович',
        'job' => 'babysitter',
    ],
];

// getFullnameFromParts принимает как аргумент три строки — фамилию, имя и отчество. Возвращает как результат их же, но склеенные через пробел
function getFullnameFromParts($s_name, $n_name, $p_name)
{
    return $s_name . ' ' . $n_name . ' ' . $p_name;
}


// getPartsFromFullname принимает как аргумент одну строку — склеенное ФИО. Возвращает как результат массив из трёх элементов с ключами ‘name’, ‘surname’ и ‘patronomyc’
function getPartsFromFullname($s)
{

    $r = explode(" ", $s);
    $p = ['surname' => $r[0], 'name' => $r[1], 'patronomyc' => $r[2]];
    return $p;
}

// getShortName, принимает как аргумент строку, содержащую ФИО вида «Иванов Иван Иванович» и возвращающую строку вида «Иван И.»
function getShortName($s)
{
    $tmp = getPartsFromFullname($s);
    $res = $tmp['surname'] . " " . mb_substr($tmp['name'], 0, 1) . ".";
    return $res;
}


// getGenderFromName, принимает как аргумент строку, содержащую ФИО (вида «Иванов Иван Иванович»).
// после проверок всех признаков, если «суммарный признак пола» больше нуля — возвращаем 1 (мужской пол);
// после проверок всех признаков, если «суммарный признак пола» меньше нуля — возвращаем -1 (женский пол);
// после проверок всех признаков, если «суммарный признак пола» равен 0 — возвращаем 0 (неопределенный пол).

function getGenderFromName($s)
{
    $indicator = 0;
    $tmp = getPartsFromFullname($s);
    //отчество
    $tmp_man = $tmp['patronomyc'];
    if (mb_substr($tmp_man, mb_strlen($tmp_man) - 2, 2) == 'ич') {
        $indicator += 1;
    }
    if (mb_substr($tmp_man, mb_strlen($tmp_man) - 3, 3) == 'вна') {
        $indicator -= 1;
    }

    //имя    
    $tmp_man = $tmp['name'];
    if ((mb_substr($tmp_man, mb_strlen($tmp_man) - 1, 1) == 'й') || (mb_substr($tmp_man, mb_strlen($tmp_man) - 1, 1) == 'н')) {
        $indicator += 1;
    }
    if ((mb_substr($tmp_man, mb_strlen($tmp_man) - 1, 1) == 'а') || (mb_substr($tmp_man, mb_strlen($tmp_man) - 1, 1) == 'я')) {
        $indicator -= 1;
    }

    //фамилия
    $tmp_man = $tmp['surname'];
    if ((mb_substr($tmp_man, mb_strlen($tmp_man) - 1, 1) == 'в') || (mb_substr($tmp_man, mb_strlen($tmp_man) - 1, 1) == 'н')) {
        $indicator += 1;
    }
    if ((mb_substr($tmp_man, mb_strlen($tmp_man) - 2, 2) == 'ва') || (mb_substr($tmp_man, mb_strlen($tmp_man) - 2, 2) == 'ая')) {
        $indicator -= 1;
    }


    if ($indicator > 0) {
        return 'мужской пол';
    } elseif ($indicator < 0) {
        return 'женский пол';
    } else {
        return 'неопределенный пол';
    }
};


// Определение возрастно-полового состава
function getGenderDescription($a)
{
    $tmp_man = 0;
    $tmp_woman = 0;

    foreach ($a as $key => $value) {
        if (getGenderFromName($value['fullname']) == 'мужской пол') {
            $tmp_man += 1;
        } elseif (getGenderFromName($value['fullname']) == 'женский пол') {
            $tmp_woman += 1;
        }
    }
    $tmp_man = round($tmp_man/count($a)*100);
    $tmp_woman = round($tmp_woman/count($a)*100);
    echo "Мужской пол = $tmp_man".' %';
    echo "<br/>Женский пол = $tmp_woman".' %';
    echo "<br/>Не удалось определить = ".round(100-$tmp_man-$tmp_woman).' %';
}


// случайным образом выбираем любого человека в массиве
// проверяем с помощью getGenderFromName, что выбранное из Массива ФИО - противоположного пола
// Процент совместимости «Идеально на ...» — случайное число от 50% до 100% с точностью два знака после запятой.

function getPerfectPartner($name1,$name2,$name3,$a)
{
    $name1 = mb_convert_case($name1, MB_CASE_TITLE, "UTF-8");
    $name2 = mb_convert_case($name2, MB_CASE_TITLE, "UTF-8");
    $name3 = mb_convert_case($name3, MB_CASE_TITLE, "UTF-8");
  
    $test_name = getFullnameFromParts($name1,$name2,$name3);

    $rand_key = array_rand($a, 1);

    $test_name2 = $a[$rand_key]['fullname'];

    $test_name_gender = getGenderFromName($test_name2);


    while ($test_name_gender != 'женский пол')
    {
        $rand_key = array_rand($a, 1);
        $test_name2 = $a[$rand_key]['fullname'];
        $test_name_gender = getGenderFromName($test_name2);
    }

    echo getShortName($test_name)." + ".getShortName($test_name2)." = ";
    $rand = round(rand(5000,10000)/100,2);
    echo "♡♡♡ Идеально на $rand % ♡♡♡";

    
    
}


