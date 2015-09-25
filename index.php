<?php
session_start();

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
				unset($_SESSION['change_id']);
			break;
		}
		
			foreach ($_POST as $key => $value) {
				if ($key=='main_form_submit'){
					continue;
				}
			$_SESSION['bd'][$id][$key] = trim(htmlspecialchars($value));
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
    delete_item($_GET['delete']);
    header("Location: index.php");
exit;
}			
// Функция удаления объявления
function delete_item($get_value) {
	unset($_SESSION['bd'][$get_value]);
}

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
				<td><input type="checkbox" <?php echo isset($changeAd['no_mails']) ? 'checked=""' : '';?> value="1" name="no_mails" >Я не хочу получать вопросы по объявлению по e-mail</td>
    
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
						<option <?php echo (isset($change_id) && $changeAd['location_id']==641780) ? 'selected=""' : '';?> data-coords=",," value="641780">Новосибирск</option>   
						<option <?php echo (isset($change_id) && $changeAd['location_id']==641490) ? 'selected=""' : '';?> data-coords=",," value="641490">Барабинск</option>   
						<option <?php echo (isset($change_id) && $changeAd['location_id']==641510) ? 'selected=""' : '';?> data-coords=",," value="641510">Бердск</option>   
						<option <?php echo (isset($change_id) && $changeAd['location_id']==641600) ? 'selected=""' : '';?> data-coords=",," value="641600">Искитим</option>   
						<option <?php echo (isset($change_id) && $changeAd['location_id']==641630) ? 'selected=""' : '';?> data-coords=",," value="641630">Колывань</option>   
						<option <?php echo (isset($change_id) && $changeAd['location_id']==641680) ? 'selected=""' : '';?> data-coords=",," value="641680">Краснообск</option>   
						<option <?php echo (isset($change_id) && $changeAd['location_id']==641710) ? 'selected=""' : '';?> data-coords=",," value="641710">Куйбышев</option>   
						<option <?php echo (isset($change_id) && $changeAd['location_id']==641760) ? 'selected=""' : '';?> data-coords=",," value="641760">Мошково</option>   
						<option <?php echo (isset($change_id) && $changeAd['location_id']==641790) ? 'selected=""' : '';?> data-coords=",," value="641790">Обь</option>   
						<option <?php echo (isset($change_id) && $changeAd['location_id']==641800) ? 'selected=""' : '';?> data-coords=",," value="641800">Ордынское</option>   
						<option <?php echo (isset($change_id) && $changeAd['location_id']==641970) ? 'selected=""' : '';?> data-coords=",," value="641970">Черепаново</option>   
						<option value="999999">Выбрать другой...</option> 
					</select>
				</td>
      
			</tr>
			<tr>
				<td>Категория</td>
				<td>
					<select title="Выберите категорию объявления" name="category_id"  required>
						<option value="">-- Выберите категорию --</option>
							<optgroup label="Транспорт">	
								<option <?php echo (isset($change_id) && $changeAd['category_id']==9) ? 'selected=""' : '';?> value="9">Автомобили с пробегом</option>
								<option <?php echo (isset($change_id) && $changeAd['category_id']==109) ? 'selected=""' : '';?> value="109">Новые автомобили</option>
								<option <?php echo (isset($change_id) && $changeAd['category_id']==14) ? 'selected=""' : '';?> value="14">Мотоциклы и мототехника</option>
								<option <?php echo (isset($change_id) && $changeAd['category_id']==81) ? 'selected=""' : '';?> value="81">Грузовики и спецтехника</option>
								<option <?php echo (isset($change_id) && $changeAd['category_id']==11) ? 'selected=""' : '';?> value="11">Водный транспорт</option>
								<option <?php echo (isset($change_id) && $changeAd['category_id']==10) ? 'selected=""' : '';?> value="10">Запчасти и аксессуары</option>
							</optgroup>
							<optgroup label="Недвижимость">
								<option <?php echo (isset($change_id) && $changeAd['category_id']==24) ? 'selected=""' : '';?> value="24">Квартиры</option>
								<option <?php echo (isset($change_id) && $changeAd['category_id']==23) ? 'selected=""' : '';?> value="23">Комнаты</option>
								<option <?php echo (isset($change_id) && $changeAd['category_id']==25) ? 'selected=""' : '';?> value="25">Дома, дачи, коттеджи</option>
								<option <?php echo (isset($change_id) && $changeAd['category_id']==26) ? 'selected=""' : '';?> value="26">Земельные участки</option>
								<option <?php echo (isset($change_id) && $changeAd['category_id']==85) ? 'selected=""' : '';?> value="85">Гаражи и машиноместа</option>
								<option <?php echo (isset($change_id) && $changeAd['category_id']==42) ? 'selected=""' : '';?> value="42">Коммерческая недвижимость</option>
								<option <?php echo (isset($change_id) && $changeAd['category_id']==86) ? 'selected=""' : '';?> value="86">Недвижимость за рубежом</option>
							</optgroup>
							<optgroup label="Работа">
								<option <?php echo (isset($change_id) && $changeAd['category_id']==111) ? 'selected=""' : '';?> value="111">Вакансии (поиск сотрудников)</option>
								<option <?php echo (isset($change_id) && $changeAd['category_id']==112) ? 'selected=""' : '';?> value="112">Резюме (поиск работы)</option>
							</optgroup>
							<optgroup label="Услуги">
								<option <?php echo (isset($change_id) && $changeAd['category_id']==114) ? 'selected=""' : '';?> value="114">Предложения услуг</option>
								<option <?php echo (isset($change_id) && $changeAd['category_id']==115) ? 'selected=""' : '';?> value="115">Запросы на услуги</option>
							</optgroup>
							<optgroup label="Личные вещи">
								<option <?php echo (isset($change_id) && $changeAd['category_id']==27) ? 'selected=""' : '';?> value="27">Одежда, обувь, аксессуары</option>
								<option <?php echo (isset($change_id) && $changeAd['category_id']==29) ? 'selected=""' : '';?> value="29">Детская одежда и обувь</option>
								<option <?php echo (isset($change_id) && $changeAd['category_id']==30) ? 'selected=""' : '';?> value="30">Товары для детей и игрушки</option>
								<option <?php echo (isset($change_id) && $changeAd['category_id']==28) ? 'selected=""' : '';?> value="28">Часы и украшения</option>
								<option <?php echo (isset($change_id) && $changeAd['category_id']==88) ? 'selected=""' : '';?> value="88">Красота и здоровье</option>
							</optgroup>
							<optgroup label="Для дома и дачи">
								<option <?php echo (isset($change_id) && $changeAd['category_id']==21) ? 'selected=""' : '';?> value="21">Бытовая техника</option>
								<option <?php echo (isset($change_id) && $changeAd['category_id']==20) ? 'selected=""' : '';?> value="20">Мебель и интерьер</option>
								<option <?php echo (isset($change_id) && $changeAd['category_id']==87) ? 'selected=""' : '';?> value="87">Посуда и товары для кухни</option>
								<option <?php echo (isset($change_id) && $changeAd['category_id']==82) ? 'selected=""' : '';?> value="82">Продукты питания</option>
								<option <?php echo (isset($change_id) && $changeAd['category_id']==19) ? 'selected=""' : '';?> value="19">Ремонт и строительство</option>
								<option <?php echo (isset($change_id) && $changeAd['category_id']==106) ? 'selected=""' : '';?> value="106">Растения</option>
							</optgroup>
							<optgroup label="Бытовая электроника">
								<option <?php echo (isset($change_id) && $changeAd['category_id']==32) ? 'selected=""' : '';?> value="32">Аудио и видео</option>
								<option <?php echo (isset($change_id) && $changeAd['category_id']==97) ? 'selected=""' : '';?> value="97">Игры, приставки и программы</option>
								<option <?php echo (isset($change_id) && $changeAd['category_id']==31) ? 'selected=""' : '';?> value="31">Настольные компьютеры</option>
								<option <?php echo (isset($change_id) && $changeAd['category_id']==98) ? 'selected=""' : '';?> value="98">Ноутбуки</option>
								<option <?php echo (isset($change_id) && $changeAd['category_id']==99) ? 'selected=""' : '';?> value="99">Оргтехника и расходники</option>
								<option <?php echo (isset($change_id) && $changeAd['category_id']==96) ? 'selected=""' : '';?> value="96">Планшеты и электронные книги</option>
								<option <?php echo (isset($change_id) && $changeAd['category_id']==84) ? 'selected=""' : '';?> value="84">Телефоны</option>
								<option <?php echo (isset($change_id) && $changeAd['category_id']==101) ? 'selected=""' : '';?> value="101">Товары для компьютера</option>
								<option <?php echo (isset($change_id) && $changeAd['category_id']==105) ? 'selected=""' : '';?> value="105">Фототехника</option>
							</optgroup>
							<optgroup label="Хобби и отдых">
								<option <?php echo (isset($change_id) && $changeAd['category_id']==33) ? 'selected=""' : '';?> value="33">Билеты и путешествия</option>
								<option <?php echo (isset($change_id) && $changeAd['category_id']==34) ? 'selected=""' : '';?> value="34">Велосипеды</option>
								<option <?php echo (isset($change_id) && $changeAd['category_id']==83) ? 'selected=""' : '';?> value="83">Книги и журналы</option>
								<option <?php echo (isset($change_id) && $changeAd['category_id']==36) ? 'selected=""' : '';?> value="36">Коллекционирование</option>
								<option <?php echo (isset($change_id) && $changeAd['category_id']==38) ? 'selected=""' : '';?> value="38">Музыкальные инструменты</option>
								<option <?php echo (isset($change_id) && $changeAd['category_id']==102) ? 'selected=""' : '';?> value="102">Охота и рыбалка</option>
								<option <?php echo (isset($change_id) && $changeAd['category_id']==39) ? 'selected=""' : '';?> value="39">Спорт и отдых</option>
								<option <?php echo (isset($change_id) && $changeAd['category_id']==103) ? 'selected=""' : '';?> value="103">Знакомства</option>
							</optgroup>
							<optgroup label="Животные">
								<option <?php echo (isset($change_id) && $changeAd['category_id']==89) ? 'selected=""' : '';?> value="89">Собаки</option>
								<option <?php echo (isset($change_id) && $changeAd['category_id']==90) ? 'selected=""' : '';?> value="90">Кошки</option>
								<option <?php echo (isset($change_id) && $changeAd['category_id']==91) ? 'selected=""' : '';?> value="91">Птицы</option>
								<option <?php echo (isset($change_id) && $changeAd['category_id']==92) ? 'selected=""' : '';?> value="92">Аквариум</option>
								<option <?php echo (isset($change_id) && $changeAd['category_id']==93) ? 'selected=""' : '';?> value="93">Другие животные</option>
								<option <?php echo (isset($change_id) && $changeAd['category_id']==94) ? 'selected=""' : '';?> value="94">Товары для животных</option>
							</optgroup>
							<optgroup label="Для бизнеса">
								<option <?php echo (isset($change_id) && $changeAd['category_id']==116) ? 'selected=""' : '';?> value="116">Готовый бизнес</option>
								<option <?php echo (isset($change_id) && $changeAd['category_id']==40) ? 'selected=""' : '';?> value="40">Оборудование для бизнеса</option>
							</optgroup>
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
		echo '<table border="1" cellspacing="0" cellpadding="5"><tr><td>' . $item['date'] .' </td><td> ' . '<a href="index.php?show=' . $id . '">' . $item['title'] . '</a></td>' .' <td> ' . number_format($item['price'], 2, '.', '') . ' руб.' . ' </td><td> ' . $item['firstname'] .' </td><td> ' . '<a href="index.php?delete=' . $id . '">Удалить</a>' . "</td></tr></table>\n\r";
	}
}
?>
