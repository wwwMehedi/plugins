QTags.addButton('qtsd-btn-one','U','<u>','</u>');
QTags.addButton('qtsd-btn-two','JS',qtsd_button_two);
QTags.addButton('qtsd-btn-three','JS',qtsd_button_three);
function qtsd_button_two(){
	var name=prompt("what is ur name?");
	var text="Hello"+name;
	QTags.insertContent(text);
}

function qtsd_button_three(){
	tb_show("Fontawesome",qtsd.preview);
}