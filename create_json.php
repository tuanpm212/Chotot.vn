<?php
	if (!isset($_POST['image'])) {
		return;
	}
	include "simple_html_dom.php";

	// Create DOM from URL or file
	

	// Find all images 
	function create_json() {
		$html = file_get_html("http://www.chotot.vn/tp_ho_chi_minh#");
		$array = array();
		$id = 0;
		$i = 0;
		foreach($html->find("img.thumbnail") as $element) {
			if ($i < 5) {
				$array[$id] = ($element->src);
				$id++;
				$i++;
			} else {
				return $array;
			}
		};
	};

	echo json_encode(create_json());
?>