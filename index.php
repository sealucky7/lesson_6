<?php

session_start();

$location_id = array(641780 => 'Новосибирск', 641490 => 'Барабинск', 641510=>'Бердск', 641600=>'Искитим', 641630=>'Колывань', 641680=>'Краснообск', 641710=>'Куйбышев', 641760=>'Мошково', 641790=>'Обь', 641800=>'Ордынское', 641970=>'Черепаново');
$categories = array(
    'Транспорт'=> array(9 => 'Автомобили с пробегом', 109 => 'Новые автомобили', 14 => 'Мотоциклы и мототехника', 81 => 'Грузовики и спецтехника', 11 => 'Водный транспорт', 10 => 'Запчасти и аксессуары' ),
    'Недвижимость'=> array(24 => 'Квартиры', 23 => 'Комнаты', 25 => 'Дома, дачи, коттеджи', 26 => 'Земельные участки', 85 => 'Гаражи и машиноместа', 42 => 'Коммерческая недвижимость', 86 => 'Недвижимость за рубежом'),
    'Работа'=> array( 111 => 'Вакансии (поиск сотрудников)', 112 => 'Резюме (поиск работы)'),
    'Услуги'=> array( 114 => 'Предложения услуг', 115 => 'Запросы на услуги'),
    'Личные вещи'=> array( 27 => 'Одежда, обувь, аксессуары', 29 => 'Детская одежда и обувь', 30 => 'Товары для детей и игрушки', 28 => 'Часы и украшения', 88 => 'Красота и здоровье'),
    'Для дома и дачи'=> array( 21 => 'Бытовая техника', 20 => 'Мебель и интерьер', 87 => 'Посуда и товары для кухни', 82 => 'Продукты питания', 19 => 'Ремонт и строительство', 106 => 'Растения' ),
    'Бытовая электроника'=> array( 32 => 'Аудио и видео', 97 => 'Игры, приставки и программы', 31 => 'Настольные компьютеры', 98 => 'Ноутбуки', 99 => 'Оргтехника и расходники', 96 => 'Планшеты и электронные книги', 84 => 'Телефоны', 101 => 'Товары для компьютера', 105 => 'Фототехника' ),
    'Хобби и отдых'=> array( 33 => 'Билеты и путешествия', 34 => 'Велосипеды', 83 => 'Книги и журналы', 36 => 'Коллекционирование', 38 => 'Музыкальные инструменты', 102 => 'Охота и рыбалка', 39 => 'Спорт и отдых', 103 => 'Знакомства' ),
    'Животные'=> array( 89 => 'Собаки', 90 => 'Кошки', 91 => 'Птицы', 92 => 'Аквариум', 93 => 'Другие животные', 94 => 'Товары для животных' ),
    'Для бизнеса'=> array( 116 => 'Готовый бизнес', 40 => 'Оборудование для бизнеса')
);?>
<?php
// Переносим данные из $_POST в $_SESSION	
if (!isset($_SESSION['id_ad'])){
	$_SESSION['id_ad'] = 0;
}
if (isset($_POST['main_form_submit'])) { 
	$submit=$_POST['main_form_submit'];
		switch ($submit) { 
			case 'Подать объявление' :
				$id = $_SESSION['id_ad']; 
				$_SESSION['id_ad']++;
					$_SESSION['bd'][$id]['date'] = date('d.m.Y H:i:s'); 
			break;
			case 'Сохранить' :
				$id = $_SESSION['change_id']; 
				unset($_SESSION['change_id'], $_SESSION['bd'][$id]['no_mails']);
			break;
		}
		
			foreach ($_POST as $key => $value) {
				if ($key=='main_form_submit'){
					continue;
				}
			$_SESSION['bd'][$id][$key] = trim($value);
			}
		
	header("Location: index.php");
		exit;
}


// Обработка команд на просмотр объявления и на удаление
if (isset($_GET['show'])){
    $_SESSION['show']=$_GET['show'];
    header("Location: index.php");
exit;
}
if (isset($_GET['delete'])) {
    $del = $_GET['delete'];
   unset($_SESSION['bd'][$del]);
    header("Location: index.php");
exit;
}			
// Функция удаления объявления
//function delete_item($get_value) {
//	unset($_SESSION['bd'][$get_value]);
//}

// Вывод объявления
if (isset($_SESSION['show'])){
	$change_id=$_SESSION['show'];
	$changeAd=$_SESSION['bd'][$change_id];
		unset($_SESSION['show']);
}
//print_r($_SESSION);
?>
<form  method="post"  >
    <table>
			<tr>
				<td></td>
				<td><input type="radio" <?php echo (!isset($change_id) || $changeAd['private']==1) ? 'checked=""' : '';?> value="1" name="private">Частное лицо 
				    <input type="radio" <?php echo (isset($change_id) && $changeAd['private']==0) ? 'checked=""' : '';?> value="0" name="private">Компания
				</td>
			</tr>
			<tr>
				<td>Ваше имя</td>    
				<td><input type="text" maxlength="40" value="<?php echo (isset($change_id)) ? $changeAd['firstname'] : '';?>" name="firstname" required ></td>
			</tr>
			<tr>
				<td>Электронная почта</td>
				<td><input type="email" value="<?php echo (isset($change_id)) ? $changeAd['email'] : '';?>" name="email" required></td>
        	</tr>
			<tr>
				<td></td>
				<td><input type="checkbox" <?php echo isset($changeAd['no_mails']) ? 'checked=""' : '';?> value="" name="no_mails" >Я не хочу получать вопросы по объявлению по e-mail</td>
    
			</tr>
			<tr>
				<td>Номер телефона</td>
				<td><input type="tel"  value="<?php echo (isset($change_id)) ? $changeAd['phone'] : '';?>" name="phone" required></td>
     
			</tr>
			<tr>
				<td>Город</td>
				<td>
					<select title="Выберите Ваш город" name="location_id" > 
						<option value="">-- Выберите город --</option>
						<option disabled="disabled">-- Города --</option>
						<?php
							$location_sel=641780;
							foreach ($location_id as $id => $location) {
								if (!isset($change_id) && $id ==$location_sel ){ ?>
									<option <?php echo 'selected=""';?> data-coords=",," value="<?php echo $id;?>"><?php echo $location;?></option>
								<?php
								}
								else {?>
									<option <?php echo (isset($change_id) && $changeAd['location_id']==$id) ? 'selected=""' : '';?> data-coords=",," value="<?php echo $id;?>"><?php echo $location;?></option>   
						
								<?php
								}
							}	
								?>
					</select>
				</td>
      
			</tr>
			<tr>
				<td>Категория</td>
				<td>
					<select title="Выберите категорию объявления" name="category_id"  required>
						<option value="">-- Выберите категорию --</option>
						<?php
								foreach ($categories as $id => $category) {
                                                                ?>	
                                                <optgroup label="<?=$id?>">
							<?php foreach ($category as $key => $value){
                                                            ?>
                                                    <option <?php echo (isset($change_id) && $changeAd['category_id']==$key) ? 'selected=""' : '';?> value="<?php echo $key;?>">  
                                                                <?php echo $value;?>
                                                    </option>
								<?php }?>
							</optgroup>
                                                        <?php
								}
								?>

					</select>
				</td>	
			</tr>
			<tr>
				<td>Название объявления</td>
				<td><input type="text" maxlength="50"  value="<?php echo (isset($change_id)) ? $changeAd['title'] : '';?>" name="title" required></td>
    		</tr>
			<tr>
				<td>Описание объявления</td>
				<td><textarea maxlength="3000"  name="description" required><?php echo (isset($change_id)) ? $changeAd['description'] : '';?></textarea></td>
      		</tr>
			<tr>
				<td>Цена</td>
				<td><input type="text" maxlength="9" value="<?php echo (isset($change_id)) ? $changeAd['price'] : '0';?>" name="price" >&nbsp;руб.</td>
      		</tr>
			<tr>
				<td></td>
				<td><input type="submit" value="<?php if(!isset($change_id)) {echo 'Подать объявление';}
													  else { echo 'Сохранить'; $_SESSION['change_id']=$change_id;} ?>" name="main_form_submit" >
				</td>
			</tr>
	</table>
</form>

<div style="border-bottom: 2px solid #000; width: 500px; height: 2px; display: block; margin-bottom: 20px;"></div>

<?php
// Вывод списка 
if (isset($_SESSION['bd'])){
	foreach ($_SESSION['bd'] as $id => $item){
            
		echo '<p>'. $item['date'] .' | ' . '<a href="index.php?show=' . $id . '">' . $item['title'] . '</a>' .' | ' . number_format($item['price'], 2, '.', '') . ' руб.' . ' | ' . $item['firstname'] .' | ' . '<a href="index.php?delete=' . $id . '">Удалить</a>' . "</p>\n\r";
             
	}
}

?>
