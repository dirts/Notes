PDO
========================

		$db = new PDO('mysql:host=192.168.128.18;dbname=im', 'dolphin', 'dolphin');

		$st = $db->prepare("insert into im_test (`name`, `age`) value ( :name, :age )");

		$st->bindValue(':name', 'lishouyan_ceshi', PDO::PARAM_STR );
		$st->bindValue(':age', '30', PDO::PARAM_INT );
		$st->execute();
		$st = $db->prepare("select * from im_test");
		$st->execute();
		$res = $st->fetchAll();
